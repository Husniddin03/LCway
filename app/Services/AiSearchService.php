<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Advanced AI Search Enhancement Layer
 *
 * Converts user search queries into structured filters AND semantic understanding.
 * Supports Uzbek, Russian, English with mixed queries and smart intent detection.
 *
 * Configuration (via .env):
 *   AI_SEARCH_ENABLED=true           # Set false to disable entirely
 *   AI_SEARCH_URL=https://...        # AI API endpoint (OpenAI-compatible)
 *   AI_SEARCH_KEY=sk-...             # API key
 *   AI_SEARCH_MODEL=gpt-4o-mini      # Model to use
 *   AI_SEARCH_TIMEOUT=4              # Request timeout in seconds
 *
 * Returned filter keys (always include all fields):
 *   - searchText   : refined/expanded search string (string|null)
 *   - type         : center type (string|null)
 *   - subject_name : standardized subject name (string|null)
 *   - needTeachers : teacher vacancy filter (string|null)
 *   - min_price    : minimum price in UZS (float|null)
 *   - max_price    : maximum price in UZS (float|null)
 *   - latitude     : user location lat (float|null)
 *   - longitude    : user location lng (float|null)
 *   - radius       : search radius in km (int|null)
 *   - sort         : sort field (string|null)
 *   - order        : sort order (asc|desc|null)
 */
class AiSearchService
{
    /**
     * Advanced system prompt for intelligent query parsing
     */
    private const SYSTEM_PROMPT = <<<PROMPT
You are an intelligent search filter extractor for an Uzbekistan learning center directory.

The user may write in Uzbek (latin or cyrillic), Russian, or English, with mixed and incomplete phrases.
You must detect intent and extract structured filters.

SUBJECT SYNONYM MAPPING:
- "matematika", "math", "математика", "матем" → subject_name: "Mathematics"
- "ingliz", "english", "ingiliz", "английский", "til" → subject_name: "English"
- "rus", "ruskiy", "ruscha", "русский" → subject_name: "Russian"
- "it", "dasturlash", "programming", "программирование", "coder" → subject_name: "Programming"
- "fizika", "physics", "физика" → subject_name: "Physics"
- "kimyo", "chemistry", "химия" → subject_name: "Chemistry"
- "biologiya", "biology", "биология" → subject_name: "Biology"
- "tarix", "history", "история" → subject_name: "History"
- "geografiya", "geography", "география" → subject_name: "Geography"
- "ielts", "ielts prep" → subject_name: "IELTS"
- "sat", "sat prep" → subject_name: "SAT"

PRICE INTENT:
- "arzon", "cheap", "qimmat emas", "дешево" → max_price: 200000
- "200 ming", "200000 so'm", "200k" → max_price: 200000
- "500 ming gacha", "500000 so'mgacha" → max_price: 500000
- "qimmat", "premium", "elite", "дорого" → sort: "rating", order: "desc"

QUALITY SIGNALS:
- "eng yaxshi", "top", "best", "best courses", "лучший" → sort: "rating", order: "desc"
- "yangi", "new", "newest", "новый" → sort: "created", order: "desc"
- "arzon", "cheap" → sort: "name" (price inferred via max_price)

TYPE DETECTION:
- "kurs", "course", "kurslari" → type: "Course"
- "til markaz", "language center", "til kursi" → type: "Language"
- "maktab", "school", "школа" → type: "School"
- "universitet", "university", "университет" → type: "University"
- "repetitor", "tutor", "tutoring", "репетитор" → type: "Tutor"
- "lisey", "lyceum", "лицей" → type: "Lyceum"
- "kollej", "college", "колледж" → type: "College"

LOCATION & PROXIMITY:
- "toshkent", "tashkent", "ташкент" → searchText includes "Toshkent"
- "samarkand", "samarqand", "самарканд" → searchText includes "Samarkand"
- "yaqinimda", "near me", "nearby", "рядом", "близко" → radius: 10

OUTPUT FORMAT (STRICT JSON - include ALL fields):
{
  "searchText": "refined keywords or null",
  "type": "detected type or null",
  "subject_name": "standardized subject or null",
  "needTeachers": "subject name if looking for teacher vacancy, else null",
  "min_price": null or number,
  "max_price": null or number,
  "latitude": null,
  "longitude": null,
  "radius": null or 10 for "near me",
  "sort": "name|rating|created|distance or null",
  "order": "asc|desc or null"
}

EXAMPLES:

Input: "eng yaxshi it kurslar yaqinimda"
Output:
{
  "searchText": "it kurs",
  "type": "Course",
  "subject_name": "Programming",
  "needTeachers": null,
  "min_price": null,
  "max_price": null,
  "latitude": null,
  "longitude": null,
  "radius": 10,
  "sort": "rating",
  "order": "desc"
}

Input: "arzon ingliz tili 200 minggacha"
Output:
{
  "searchText": "ingliz tili",
  "type": null,
  "subject_name": "English",
  "needTeachers": null,
  "min_price": null,
  "max_price": 200000,
  "latitude": null,
  "longitude": null,
  "radius": null,
  "sort": null,
  "order": null
}

Input: "math repetitor samarkand"
Output:
{
  "searchText": "Samarkand",
  "type": "Tutor",
  "subject_name": "Mathematics",
  "needTeachers": null,
  "min_price": null,
  "max_price": null,
  "latitude": null,
  "longitude": null,
  "radius": null,
  "sort": null,
  "order": null
}

Input: "top programming courses"
Output:
{
  "searchText": "programming courses",
  "type": "Course",
  "subject_name": "Programming",
  "needTeachers": null,
  "min_price": null,
  "max_price": null,
  "latitude": null,
  "longitude": null,
  "radius": null,
  "sort": "rating",
  "order": "desc"
}

RULES:
1. Return ONLY valid JSON. No explanation, no markdown, no comments.
2. ALWAYS include ALL fields (set to null if not detected).
3. Standardize subject names using the mapping above.
4. Never hallucinate - if unsure, put value into searchText.
5. Combine location into searchText if detected.
6. Extract numeric prices from phrases like "200 ming", "300k", "500000".
PROMPT;

    /**
     * Parse a free-form search query into structured filters.
     *
     * This method is always safe to call — it returns [] on any failure:
     * - AI disabled in config
     * - Missing API key
     * - Network timeout
     * - Malformed JSON response
     * - Any exception
     *
     * @param  string $query Raw user search input
     * @return array<string, mixed> Extracted filters (empty if AI unavailable/failed)
     */
    public function parse(string $query): array
    {
        // Quick guard: disabled or no key configured
        if (!$this->isEnabled()) {
            return [];
        }

        $query = trim($query);
        if (empty($query)) {
            return [];
        }

        try {
            return $this->callAiApi($query);
        } catch (\Throwable $e) {
            Log::warning('[AiSearchService] Parse failed — falling back to normal search.', [
                'query' => $query,
                'error' => $e->getMessage(),
            ]);
            return [];
        }
    }

    /**
     * Send the query to the AI API and parse the response.
     *
     * @throws \Throwable On any network/parse error (caller handles this)
     */
    private function callAiApi(string $query): array
    {
        $url     = config('services.ai_search.url', '');
        $apiKey  = config('services.ai_search.key', '');
        $model   = config('services.ai_search.model', 'gpt-4o-mini');
        $timeout = (int) config('services.ai_search.timeout', 4);

        if (empty($url) || empty($apiKey)) {
            return [];
        }

        $response = Http::withToken($apiKey)
            ->timeout($timeout)
            ->post($url, [
                'model'    => $model,
                'messages' => [
                    ['role' => 'system', 'content' => self::SYSTEM_PROMPT],
                    ['role' => 'user',   'content' => $query],
                ],
                'response_format' => ['type' => 'json_object'],
                'max_tokens'      => 256,
                'temperature'     => 0.1,
            ]);

        if (!$response->successful()) {
            Log::warning('[AiSearchService] API returned non-2xx.', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return [];
        }

        $content = $response->json('choices.0.message.content', '');

        if (empty($content)) {
            return [];
        }

        $filters = json_decode($content, true);

        if (!is_array($filters)) {
            return [];
        }

        return $this->sanitizeFilters($filters);
    }

    /**
     * Sanitize and validate AI-returned filters.
     * Only allow known safe keys — prevents AI from injecting unexpected fields.
     */
    private function sanitizeFilters(array $raw): array
    {
        $allowed = ['searchText', 'region', 'type', 'min_price', 'max_price', 'needTeachers'];
        $clean   = [];

        foreach ($allowed as $key) {
            if (!isset($raw[$key])) {
                continue;
            }

            $value = $raw[$key];

            // Numeric fields must be numeric
            if (in_array($key, ['min_price', 'max_price'], true)) {
                if (is_numeric($value)) {
                    $clean[$key] = (float) $value;
                }
                continue;
            }

            // String fields: cast and limit length
            if (is_string($value) || is_numeric($value)) {
                $str = substr(trim((string) $value), 0, 255);
                if ($str !== '') {
                    $clean[$key] = $str;
                }
            }
        }

        return $clean;
    }

    /**
     * Check if AI search is enabled and properly configured.
     */
    private function isEnabled(): bool
    {
        if (!config('services.ai_search.enabled', false)) {
            return false;
        }

        $key = config('services.ai_search.key', '');
        $url = config('services.ai_search.url', '');

        return !empty($key) && !empty($url);
    }
}

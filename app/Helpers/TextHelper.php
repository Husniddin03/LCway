<?php

declare(strict_types=1);

namespace App\Helpers;

/**
 * Advanced Text Helper for NLP-powered search
 * Provides: transliteration, tokenization, stemming, fuzzy matching, synonym mapping
 */
final class TextHelper
{
    /** Latin to Cyrillic mapping */
    private const LATIN_TO_CYRILLIC = [
        'sh' => 'ш', 'ch' => 'ч', "g'" => 'ғ', "o'" => 'ў', 'ng' => 'нг',
        'a' => 'а', 'b' => 'б', 'd' => 'д', 'e' => 'е', 'f' => 'ф',
        'g' => 'г', 'h' => 'ҳ', 'i' => 'и', 'j' => 'ж', 'k' => 'к',
        'l' => 'л', 'm' => 'м', 'n' => 'н', 'o' => 'о', 'p' => 'п',
        'q' => 'қ', 'r' => 'р', 's' => 'с', 't' => 'т', 'u' => 'у',
        'v' => 'в', 'x' => 'х', 'y' => 'й', 'z' => 'з',
        'oʻ' => 'ў', 'gʻ' => 'ғ',
    ];

    /** Uzbek suffixes to strip during stemming */
    private const UZBEK_SUFFIXES = [
        // Location suffixes
        'dagi', 'dagi', 'dagi', 'dagi',
        'da', 'de', 'dan', 'den', 'ga', 'ge', 'qa', 'qe',
        // Plural suffixes
        'lar', 'lar', 'lari', 'lari',
        // Possessive/case suffixes
        'ni', 'ning', 'ni', 'ning', 'ga', 'ga', 'ga',
        // Other common suffixes
        'ch', 'chi', 'ch', 'chi', 'lik', 'lik',
    ];

    /** Stop words to remove from search queries */
    private const STOP_WORDS = [
        // Uzbek
        'va', 'ham', 'bilan', 'uchun', 'bo\'yicha', 'bo\'lsa', 'bilan',
        'eng', 'yaxshi', 'yaxshisi', 'eng yaxshi', 'arzon', 'qimmat',
        'o\'quv', 'markaz', 'markazi', 'kurs', 'kursi', 'kurslar',
        'xon', 'xona', 'dars', 'darslik', 'o\'qish', 'o\'qitish',
        'top', 'tashkil', 'etilgan', 'bor', 'joylashgan', 'joy',
        // Russian
        'и', 'с', 'для', 'на', 'в', 'самый', 'лучший', 'хороший',
        // English
        'and', 'or', 'the', 'a', 'an', 'for', 'with', 'in', 'at',
        'best', 'top', 'good', 'cheap', 'expensive', 'course', 'center',
    ];

    /** Query modifiers that change search behavior */
    private const QUERY_MODIFIERS = [
        'arzon' => ['sort' => 'price', 'order' => 'asc'],
        'cheap' => ['sort' => 'price', 'order' => 'asc'],
        'qimmat' => ['sort' => 'rating', 'order' => 'desc'],
        'expensive' => ['sort' => 'rating', 'order' => 'desc'],
        'yaqin' => ['radius' => 5000],
        'near' => ['radius' => 5000],
        'eng yaxshi' => ['sort' => 'rating', 'order' => 'desc'],
        'best' => ['sort' => 'rating', 'order' => 'desc'],
    ];

    /** Type detection keywords */
    private const TYPE_KEYWORDS = [
        'it' => 'IT',
        'programming' => 'IT',
        'dasturlash' => 'IT',
        'til' => 'Til kurslari',
        'language' => 'Til kurslari',
        'ingliz' => 'Til kurslari',
        'english' => 'Til kurslari',
        'matematika' => 'Matematika',
        'math' => 'Matematika',
    ];

    /** Enhanced synonym mapping */
    private const SYNONYM_MAP = [
        // English variants
        'ingliz' => 'english', 'ingiliz' => 'english', 'ingliz tili' => 'english',
        'английский' => 'english', 'английский язык' => 'english',
        'english' => 'english', 'ielts' => 'english', 'ielts' => 'english',
        'aylts' => 'english', 'toefl' => 'english',

        // Math variants
        'matematika' => 'math', 'mathematics' => 'math', 'математика' => 'math',
        'algebra' => 'math', 'geometry' => 'math', 'calculus' => 'math',
        'алгебра' => 'math', 'геометрия' => 'math',

        // IT/Programming variants
        'it' => 'programming', 'dasturlash' => 'programming', 'coding' => 'programming',
        'programming' => 'programming', 'dasturchi' => 'programming',
        'программирование' => 'programming', 'kodlash' => 'programming',
        'kompyuter' => 'programming', 'computer' => 'programming',
        'web' => 'programming', 'frontend' => 'programming', 'backend' => 'programming',

        // Russian
        'rus' => 'russian', 'ruscha' => 'russian', 'rus tili' => 'russian',
        'русский' => 'russian', 'русский язык' => 'russian',

        // Uzbek
        'o\'zbek' => 'uzbek', 'o\'zbek tili' => 'uzbek', 'uzbek' => 'uzbek',
        'ўзбек' => 'uzbek', 'ўзбек тили' => 'uzbek',

        // Physics
        'fizika' => 'physics', 'fizik' => 'physics', 'физика' => 'physics',

        // Chemistry
        'kimyo' => 'chemistry', 'kimya' => 'chemistry', 'химия' => 'chemistry',

        // Biology
        'biologiya' => 'biology', 'bio' => 'biology', 'биология' => 'biology',

        // History
        'tarix' => 'history', 'история' => 'history',

        // Geography
        'geografiya' => 'geography', 'geo' => 'geography', 'география' => 'geography',

        // SAT
        'sat' => 'sat',

        // SAT variants for Uzbek students
        'sat' => 'sat', 'sats' => 'sat',
    ];

    /** Region/province list for fuzzy matching */
    private const REGIONS = [
        'toshkent', 'samarqand', 'buxoro', 'andijon', 'farg\'ona',
        'namangan', 'sirdaryo', 'jizzax', 'qashqadaryo', 'surxondaryo',
        'navoiy', 'xorazm', 'qoraqalpog\'iston', 'toshkent viloyati',
        'ташкент', 'самарканд', 'бухара', 'андижан', 'фергана',
        'наманган', 'самаркандская', 'бухарская',
    ];

    /** Subject list for fuzzy matching */
    private const SUBJECTS = [
        'english', 'matematika', 'math', 'fizika', 'kimyo', 'biologiya',
        'tarix', 'geografiya', 'dasturlash', 'it', 'rus tili', 'o\'zbek',
        'ielts', 'sat', 'ingliz', 'ingiliz', 'algebra', 'geometry',
    ];

    /**
     * ============================================================
     * PART 1: TEXT PROCESSING PIPELINE
     * ============================================================
     */

    /**
     * Main processing pipeline: text → clean tokens
     * Steps: lowercase → normalize apostrophes → tokenize → strip suffixes → remove stop words → filter
     * @return array<string>
     */
    public static function processQuery(string $text): array
    {
        $text = self::normalize($text);
        $tokens = self::tokenize($text);
        $tokens = self::stripSuffixes($tokens);
        $tokens = self::removeStopWords($tokens);
        $tokens = self::filterTokens($tokens);
        $tokens = array_slice($tokens, 0, 5); // Max 5 tokens
        return $tokens;
    }

    /**
     * Normalize text: lowercase, clean apostrophes, remove extra spaces
     */
    public static function normalize(string $text): string
    {
        $text = mb_strtolower(trim($text));
        
        // Normalize apostrophe variants (o', oʻ, o`) → o'
        $text = preg_replace('/[ʻʼ\']/u', "'", $text);
        
        // Remove extra whitespace
        $text = preg_replace('/\s+/', ' ', $text);
        
        return $text;
    }

    /**
     * Tokenize text into array of words
     * @return array<string>
     */
    public static function tokenize(string $text): array
    {
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text); // Keep only letters, numbers, spaces
        $tokens = explode(' ', $text);
        return array_values(array_filter($tokens, function ($t) {
            return !empty(trim($t));
        }));
    }

    /**
     * Strip Uzbek suffixes from tokens (stemming)
     * @param array<string> $tokens
     * @return array<string>
     */
    public static function stripSuffixes(array $tokens): array
    {
        return array_map(function ($token) {
            $word = $token;
            
            // Try stripping suffixes longest to shortest
            $suffixes = self::UZBEK_SUFFIXES;
            usort($suffixes, function ($a, $b) {
                return strlen($b) <=> strlen($a);
            });
            
            foreach ($suffixes as $suffix) {
                if (strlen($word) > strlen($suffix) + 2) { // Keep at least 2 chars root
                    if (str_ends_with($word, $suffix)) {
                        $word = substr($word, 0, -strlen($suffix));
                        break; // Strip one suffix at a time
                    }
                }
            }
            
            return $word;
        }, $tokens);
    }

    /**
     * Remove stop words from tokens
     * @param array<string> $tokens
     * @return array<string>
     */
    public static function removeStopWords(array $tokens): array
    {
        return array_filter($tokens, function ($token) {
            return !in_array($token, self::STOP_WORDS, true);
        });
    }

    /**
     * Filter tokens: min 2 chars, max 20 chars
     * @param array<string> $tokens
     * @return array<string>
     */
    public static function filterTokens(array $tokens): array
    {
        return array_filter($tokens, function ($token) {
            $len = mb_strlen($token);
            return $len >= 2 && $len <= 20;
        });
    }

    /**
     * ============================================================
     * PART 2: FUZZY MATCHING (TYPO CORRECTION)
     * ============================================================
     */

    /**
     * Find best fuzzy match for a token against known terms
     * @param array<string> $dictionary List of valid terms
     * @param int $maxDistance Maximum Levenshtein distance (default 2)
     * @return string|null Best match or null if no good match
     */
    public static function fuzzyMatch(string $token, array $dictionary, int $maxDistance = 2): ?string
    {
        $token = mb_strtolower($token);
        $bestMatch = null;
        $bestDistance = $maxDistance + 1;

        foreach ($dictionary as $term) {
            $term = mb_strtolower($term);
            
            // Quick check for exact or starts with
            if ($token === $term || str_starts_with($term, $token)) {
                return $term;
            }
            
            $distance = levenshtein($token, $term);
            if ($distance < $bestDistance && $distance <= $maxDistance) {
                $bestDistance = $distance;
                $bestMatch = $term;
            }
        }

        return $bestMatch;
    }

    /**
     * Auto-correct tokens using fuzzy matching
     * @return array<string>
     */
    public static function autoCorrect(array $tokens): array
    {
        $dictionary = array_merge(self::REGIONS, self::SUBJECTS, array_keys(self::SYNONYM_MAP));
        
        return array_map(function ($token) use ($dictionary) {
            $corrected = self::fuzzyMatch($token, $dictionary, 2);
            return $corrected ?? $token;
        }, $tokens);
    }

    /**
     * Get typo suggestion for display to user
     */
    public static function getTypoSuggestion(string $query): ?string
    {
        $tokens = self::tokenize(self::normalize($query));
        $suggestions = [];
        $dictionary = array_merge(self::REGIONS, self::SUBJECTS);
        
        foreach ($tokens as $token) {
            if (strlen($token) < 4) continue; // Skip short words
            
            // Check if token exists in dictionary
            $exists = false;
            foreach ($dictionary as $term) {
                if (levenshtein($token, $term) <= 1) {
                    $exists = true;
                    break;
                }
            }
            
            if (!$exists) {
                $suggestion = self::fuzzyMatch($token, $dictionary, 2);
                if ($suggestion && $suggestion !== $token) {
                    $suggestions[$token] = $suggestion;
                }
            }
        }
        
        if (empty($suggestions)) {
            return null;
        }
        
        return strtr($query, $suggestions);
    }

    /**
     * ============================================================
     * PART 3: SYNONYM & TRANSLITERATION SYSTEM
     * ============================================================
     */

    /**
     * Normalize token to canonical form using synonym map
     */
    public static function normalizeToken(string $token): string
    {
        $token = mb_strtolower(trim($token));
        return self::SYNONYM_MAP[$token] ?? $token;
    }

    /**
     * Get all possible variants for a token (synonyms + transliterations)
     * @return array<string>
     */
    public static function getTokenVariants(string $token): array
    {
        $token = mb_strtolower(trim($token));
        $variants = [$token];
        
        // Add canonical form if it's a synonym
        $canonical = self::normalizeToken($token);
        if ($canonical !== $token) {
            $variants[] = $canonical;
        }
        
        // Add transliterated versions
        $trans = self::transliterate($token);
        if ($trans !== $token) {
            $variants[] = $trans;
        }
        
        return array_unique($variants);
    }

    /**
     * Get all search variants for multiple tokens
     * @param array<string> $tokens
     * @return array<array<string>> Array of variant arrays per token
     */
    public static function getAllVariants(array $tokens): array
    {
        return array_map(fn($token) => self::getTokenVariants($token), $tokens);
    }

    /**
     * Transliterate between Latin and Cyrillic
     */
    public static function transliterate(string $text): string
    {
        $text = mb_strtolower(trim($text));
        
        // Detect script direction
        if (preg_match('/[а-яёўқҳғ]/u', $text)) {
            // Cyrillic to Latin
            return self::cyrillicToLatin($text);
        }
        
        // Latin to Cyrillic
        return self::latinToCyrillic($text);
    }

    /**
     * ============================================================
     * PART 4: QUERY MODIFIERS & INTENT DETECTION
     * ============================================================
     */

    /**
     * Detect query modifiers (sort, radius hints)
     * @return array<string, mixed>
     */
    public static function detectModifiers(string $query): array
    {
        $modifiers = [];
        $query = self::normalize($query);
        
        foreach (self::QUERY_MODIFIERS as $keyword => $settings) {
            if (str_contains($query, $keyword)) {
                $modifiers = array_merge($modifiers, $settings);
            }
        }
        
        return $modifiers;
    }

    /**
     * Detect center type from query
     */
    public static function detectType(string $query): ?string
    {
        $query = self::normalize($query);
        
        foreach (self::TYPE_KEYWORDS as $keyword => $type) {
            if (str_contains($query, $keyword)) {
                return $type;
            }
        }
        
        return null;
    }

    /**
     * ============================================================
     * PART 5: RANKING & SCORING
     * ============================================================
     */

    /**
     * Calculate relevance score for field matching
     * @param array<string> $searchTokens
     */
    public static function calculateFieldScore(array $searchTokens, ?string $fieldValue, string $fieldType = 'name'): int
    {
        if (empty($fieldValue)) {
            return 0;
        }

        $fieldValue = mb_strtolower(trim($fieldValue));
        $score = 0;
        
        foreach ($searchTokens as $token) {
            // Exact match
            if ($fieldValue === $token) {
                $score += ($fieldType === 'name') ? 20 : 10;
                continue;
            }
            
            // Starts with
            if (str_starts_with($fieldValue, $token)) {
                $score += ($fieldType === 'name') ? 15 : 8;
                continue;
            }
            
            // Contains as whole word
            if (preg_match('/\b' . preg_quote($token, '/') . '\b/', $fieldValue)) {
                $score += ($fieldType === 'name') ? 10 : 5;
                continue;
            }
            
            // Contains anywhere
            if (str_contains($fieldValue, $token)) {
                $score += ($fieldType === 'name') ? 5 : 3;
            }
        }
        
        return $score;
    }

    /**
     * Build SQL for relevance scoring
     * @param array<string> $tokens
     */
    public static function buildRelevanceSql(array $tokens): string
    {
        $conditions = [];
        
        foreach ($tokens as $token) {
            $escaped = addslashes($token);
            
            // Name exact match (highest weight)
            $conditions[] = "CASE WHEN LOWER(name) = '{$escaped}' THEN 20 ELSE 0 END";
            
            // Name starts with
            $conditions[] = "CASE WHEN LOWER(name) LIKE '{$escaped}%' THEN 15 ELSE 0 END";
            
            // Name contains
            $conditions[] = "CASE WHEN LOWER(name) LIKE '%{$escaped}%' THEN 10 ELSE 0 END";
            
            // Subject match
            $conditions[] = "CASE WHEN EXISTS (SELECT 1 FROM subjects_of_learning_centers WHERE learning_centers_id = learning_centers.id AND LOWER(subject_name) LIKE '%{$escaped}%') THEN 8 ELSE 0 END";
            
            // Location match
            $conditions[] = "CASE WHEN LOWER(region) LIKE '%{$escaped}%' OR LOWER(province) LIKE '%{$escaped}%' OR LOWER(address) LIKE '%{$escaped}%' THEN 5 ELSE 0 END";
        }
        
        return '(' . implode(' + ', $conditions) . ')';
    }

    /**
     * ============================================================
     * PRIVATE HELPERS
     * ============================================================
     */

    private static function latinToCyrillic(string $text): string
    {
        $map = self::LATIN_TO_CYRILLIC;
        uksort($map, fn($a, $b) => strlen($b) <=> strlen($a));
        foreach ($map as $latin => $cyrillic) {
            $text = str_replace($latin, $cyrillic, $text);
        }
        return $text;
    }

    private static function cyrillicToLatin(string $text): string
    {
        $map = array_flip(self::LATIN_TO_CYRILLIC);
        uksort($map, fn($a, $b) => strlen($b) <=> strlen($a));
        foreach ($map as $cyrillic => $latin) {
            $text = str_replace($cyrillic, $latin, $text);
        }
        return $text;
    }
}

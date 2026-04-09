<?php

declare(strict_types=1);

namespace App\Helpers;

/**
 * Text Helper for search-related text transformations
 * Provides transliteration and synonym mapping for Uzbek/Latin/Cyrillic support
 */
final class TextHelper
{
    /**
     * Latin to Cyrillic mapping for Uzbek language
     */
    private const LATIN_TO_CYRILLIC = [
        'a' => 'а', 'b' => 'б', 'd' => 'д', 'e' => 'е', 'f' => 'ф',
        'g' => 'г', 'h' => 'ҳ', 'i' => 'и', 'j' => 'ж', 'k' => 'к',
        'l' => 'л', 'm' => 'м', 'n' => 'н', 'o' => 'о', 'p' => 'п',
        'q' => 'қ', 'r' => 'р', 's' => 'с', 't' => 'т', 'u' => 'у',
        'v' => 'в', 'x' => 'х', 'y' => 'й', 'z' => 'з',
        "o'" => 'ў', "g'" => 'ғ', 'sh' => 'ш', 'ch' => 'ч', 'ng' => 'нг',
        // Additional variants
        'oʻ' => 'ў', 'oʻ' => 'ў', 'gʻ' => 'ғ', 'gʻ' => 'ғ',
    ];

    /**
     * Subject synonym mapping for search normalization
     * Maps various terms to standardized subject names
     */
    private const SUBJECT_SYNONYMS = [
        // Mathematics
        'matematika' => ['math', 'mathematics', 'математика', 'матем', 'algebra', 'geometry', 'calculus', 'algebra', 'геометрия'],
        // English
        'english' => ['ingliz', 'ingiliz', 'ingliz tili', 'английский', 'английский язык', 'til'],
        // Russian
        'russian' => ['rus', 'ruskiy', 'ruscha', 'rus tili', 'русский', 'русский язык'],
        // Programming/IT
        'programming' => ['it', 'dasturlash', 'coding', 'coder', 'programming', 'программирование', 'дasturlash', 'kompyuter', 'computer science', 'informatics'],
        // Physics
        'physics' => ['fizika', 'fizik', 'физика'],
        // Chemistry
        'chemistry' => ['kimyo', 'kimya', 'химия'],
        // Biology
        'biology' => ['biologiya', 'bio', 'биология'],
        // History
        'history' => ['tarix', 'tarixdan', 'история'],
        // Geography
        'geography' => ['geografiya', 'geo', 'география'],
        // IELTS
        'ielts' => ['ielts', 'ielts prep', 'ielts preparation', 'aylts'],
        // SAT
        'sat' => ['sat', 'sat prep', 'sat preparation'],
        // Uzbek language
        'uzbek' => ['uzbek', 'uzbek tili', 'o\'zbek', 'o\'zbek tili', 'ўзбек', 'ўзбек тили'],
    ];

    /**
     * Transliterate text between Latin and Cyrillic Uzbek scripts
     */
    public static function transliterate(string $text): string
    {
        $text = mb_strtolower(trim($text));

        // Check if text contains Latin characters
        if (preg_match('/[a-zA-Z]/', $text)) {
            return self::latinToCyrillic($text);
        }

        // Otherwise convert Cyrillic to Latin
        return self::cyrillicToLatin($text);
    }

    /**
     * Get both original and transliterated versions of a search term
     * @return array{original: string, transliterated: string}
     */
    public static function getSearchVariants(string $text): array
    {
        $original = mb_strtolower(trim($text));
        $transliterated = self::transliterate($original);

        return [
            'original' => $original,
            'transliterated' => $transliterated,
        ];
    }

    /**
     * Get all synonym variations for a subject search term
     * @return array<string>
     */
    public static function getSubjectSynonyms(string $term): array
    {
        $term = mb_strtolower(trim($term));
        $variants = [$term];

        // Check if term matches any known subject or its synonyms
        foreach (self::SUBJECT_SYNONYMS as $canonical => $synonyms) {
            $allTerms = array_merge([$canonical], $synonyms);
            
            foreach ($allTerms as $synonym) {
                if (similar_text($term, mb_strtolower($synonym)) / max(strlen($term), strlen($synonym)) > 0.7) {
                    $variants = array_merge($variants, $allTerms);
                    break 2;
                }
            }
        }

        // Add transliterated versions
        $transliterated = self::transliterate($term);
        $variants[] = $transliterated;

        return array_unique($variants);
    }

    /**
     * Get the canonical subject name from a search term
     */
    public static function getCanonicalSubject(string $term): ?string
    {
        $term = mb_strtolower(trim($term));

        foreach (self::SUBJECT_SYNONYMS as $canonical => $synonyms) {
            $allTerms = array_merge([mb_strtolower($canonical)], array_map('mb_strtolower', $synonyms));
            
            foreach ($allTerms as $checkTerm) {
                if ($term === $checkTerm || strpos($checkTerm, $term) !== false || strpos($term, $checkTerm) !== false) {
                    return $canonical;
                }
            }
        }

        return null;
    }

    /**
     * Calculate relevance score based on match quality
     * Higher score = better match
     */
    public static function calculateRelevanceScore(string $searchTerm, ?string $fieldValue): int
    {
        if (empty($fieldValue)) {
            return 0;
        }

        $searchTerm = mb_strtolower(trim($searchTerm));
        $fieldValue = mb_strtolower(trim($fieldValue));

        // Exact match - highest score
        if ($searchTerm === $fieldValue) {
            return 100;
        }

        // Starts with search term - high score
        if (str_starts_with($fieldValue, $searchTerm)) {
            return 80;
        }

        // Contains search term as whole word - medium-high score
        if (preg_match('/\b' . preg_quote($searchTerm, '/') . '\b/', $fieldValue)) {
            return 60;
        }

        // Contains search term anywhere - medium score
        if (strpos($fieldValue, $searchTerm) !== false) {
            return 40;
        }

        // Contains similar term (fuzzy match) - low score
        similar_text($searchTerm, $fieldValue, $percent);
        if ($percent > 60) {
            return 20;
        }

        return 0;
    }

    /**
     * Normalize search text for consistent processing
     */
    public static function normalize(string $text): string
    {
        $text = mb_strtolower(trim($text));
        // Remove extra whitespace
        $text = preg_replace('/\s+/', ' ', $text);
        return $text;
    }

    /**
     * Tokenize search text into words
     * @return array<string>
     */
    public static function tokenize(string $text): array
    {
        $normalized = self::normalize($text);
        return array_values(array_filter(explode(' ', $normalized)));
    }

    /**
     * Convert Latin to Cyrillic
     */
    private static function latinToCyrillic(string $text): string
    {
        $map = self::LATIN_TO_CYRILLIC;
        
        // Sort by length descending to handle multi-char sequences first
        uksort($map, fn($a, $b) => strlen($b) <=> strlen($a));

        foreach ($map as $latin => $cyrillic) {
            $text = str_replace($latin, $cyrillic, $text);
        }

        return $text;
    }

    /**
     * Convert Cyrillic to Latin
     */
    private static function cyrillicToLatin(string $text): string
    {
        $map = array_flip(self::LATIN_TO_CYRILLIC);
        
        // Sort by length descending
        uksort($map, fn($a, $b) => strlen($b) <=> strlen($a));

        foreach ($map as $cyrillic => $latin) {
            $text = str_replace($cyrillic, $latin, $text);
        }

        return $text;
    }
}

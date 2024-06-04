<?php

namespace App\Traits;

trait SlugTrait {

    public function generateSlug(string $text, string $divider = '-'): string {

        // Replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // Transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // Remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // Trim
        $text = trim($text, $divider);

        // Remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // Lowercase
        $text = strtolower($text);

        // Check if the text is empty
        if (empty($text)) {
            return 'n-a';
        }

        return $text;

    }
}

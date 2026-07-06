<?php

use Stevebauman\Purify\Facades\Purify;

if (! function_exists('clean_html_fast')) {
    /**
     * Fast-path HTML sanitization to avoid expensive Purify::clean() calls for plain text.
     */
    function clean_html_fast(?string $html): string
    {
        if (empty($html)) {
            return '';
        }

        if ($html === strip_tags($html)) {
            return $html;
        }

        return Purify::clean($html);
    }
}

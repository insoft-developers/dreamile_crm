<?php

if (!function_exists('makeLinksClickable')) {

    function makeLinksClickable($text)
    {
        // Escape HTML dulu
        $text = e($text);

        // URL
        $text = preg_replace(
            '/(https?:\/\/[^\s]+)/',
            '<a href="$1" target="_blank" class="text-primary">$1</a>',
            $text
        );

        // WWW tanpa http
        $text = preg_replace(
            '/(^|[^\/])(www\.[\S]+(\b|$))/im',
            '$1<a href="http://$2" target="_blank" class="text-primary">$2</a>',
            $text
        );

        // Email
        $text = preg_replace(
            '/([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6})/',
            '<a href="mailto:$1">$1</a>',
            $text
        );

        return nl2br($text);
    }
}
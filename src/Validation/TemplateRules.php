<?php

namespace Eddieodira\Messager\Validation;


class TemplateRules
{
     /**
     * Validate placeholders in template content.
     * Allowed formats: {key} or {key:default}
     */
    public function validPlaceholders(string $str, string &$error = null): bool
    {
        // Match valid placeholders
        preg_match_all('/\{[a-zA-Z_]\w*(?::[^}]+)?\}/', $str, $validMatches);

        // Match all {...} occurrences
        preg_match_all('/\{.*?\}/', $str, $allMatches);

        if (count($validMatches[0]) !== count($allMatches[0])) {
            $error = 'Invalid placeholder format. Use {key} or {key:default}.';
            return false;
        }

        return true;
    }
}

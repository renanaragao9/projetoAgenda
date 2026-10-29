<?php

namespace App;

/**
 * Funções utilitárias puras (sem dependência de banco),
 * fáceis de testar com PHPUnit.
 */
class Helpers
{
    public static function escape($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    public static function sanitizeInput($value): string
    {
        return trim((string) ($value ?? ''));
    }
}

<?php

namespace Tests;

use App\Helpers;
use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    public function testEscapeConvertsScriptTags(): void
    {
        $input = '<script>alert(1)</script>';
        $expected = '&lt;script&gt;alert(1)&lt;/script&gt;';

        $this->assertSame($expected, Helpers::escape($input));
    }

    public function testEscapeHandlesQuotes(): void
    {
        $this->assertSame('&quot;aspas&quot;', Helpers::escape('"aspas"'));
    }

    public function testEscapeLeavesPlainTextUnchanged(): void
    {
        $this->assertSame('Joao Silva', Helpers::escape('Joao Silva'));
    }

    public function testSanitizeInputTrimsWhitespace(): void
    {
        $this->assertSame('texto', Helpers::sanitizeInput('  texto  '));
    }

    public function testSanitizeInputConvertsNullToEmptyString(): void
    {
        $this->assertSame('', Helpers::sanitizeInput(null));
    }
}

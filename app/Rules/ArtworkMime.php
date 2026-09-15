<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

/**
 * Validates that an uploaded artwork's real content matches its extension.
 *
 * Laravel's `mimes:` rule only inspects the extension/MIME reported by the
 * client, so a PHP script renamed to `evil.pdf` would pass it. This rule reads
 * the file's magic bytes instead, which is the server-side check required by
 * PRD NFR #4.
 */
class ArtworkMime implements ValidationRule
{
    /**
     * Magic-byte signatures accepted for each extension.
     *
     * Values are the leading bytes a file must start with. Extensions mapping to
     * several signatures accept any of them (proprietary formats vary).
     *
     * @var array<string, list<string>>
     */
    private const SIGNATURES = [
        'pdf' => ["\x25\x50\x44\x46"],                             // %PDF
        'tiff' => ["\x49\x49\x2A\x00", "\x4D\x4D\x00\x2A"],        // II*\0 | MM\0*
        'tif' => ["\x49\x49\x2A\x00", "\x4D\x4D\x00\x2A"],         // II*\0 | MM\0*
        'png' => ["\x89\x50\x4E\x47"],                             // \x89PNG
        'jpg' => ["\xFF\xD8\xFF"],                                 // \xFF\xD8\xFF
        'jpeg' => ["\xFF\xD8\xFF"],                                // \xFF\xD8\xFF
        'zip' => ["\x50\x4B\x03\x04"],                             // PK\x03\x04
        'rar' => ["\x52\x61\x72\x21"],                             // Rar!
        'psd' => ["\x38\x42\x50\x53"],                             // 8BPS
        // CorelDRAW ships as a RIFF container or a ZIP container.
        'cdr' => ["\x52\x49\x46\x46", "\x50\x4B\x03\x04"],         // RIFF | PK\x03\x04
        // Illustrator may be a ZIP container, a PDF, or legacy PostScript.
        'ai' => ["\x50\x4B\x03\x04", "\x25\x50\x44\x46", "\x25\x21\x50\x53"], // PK\x03\x04 | %PDF | %!PS
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile) {
            $fail('File artwork tidak valid atau rusak (MIME tidak sesuai ekstensi).');

            return;
        }

        $extension = strtolower($value->getClientOriginalExtension());

        if (! isset(self::SIGNATURES[$extension])) {
            $fail('File artwork tidak valid atau rusak (MIME tidak sesuai ekstensi).');

            return;
        }

        $header = $this->readHeader($value->getRealPath());

        if ($header === null) {
            $fail('File artwork tidak valid atau rusak (MIME tidak sesuai ekstensi).');

            return;
        }

        foreach (self::SIGNATURES[$extension] as $signature) {
            if (str_starts_with($header, $signature)) {
                return;
            }
        }

        $fail('File artwork tidak valid atau rusak (MIME tidak sesuai ekstensi).');
    }

    /**
     * Read the first 12 bytes of the file, or null when it cannot be read.
     */
    private function readHeader(string $path): ?string
    {
        if ($path === '' || ! is_readable($path)) {
            return null;
        }

        $handle = @fopen($path, 'rb');

        if ($handle === false) {
            return null;
        }

        try {
            $header = fread($handle, 12);
        } finally {
            fclose($handle);
        }

        return is_string($header) && $header !== '' ? $header : null;
    }
}

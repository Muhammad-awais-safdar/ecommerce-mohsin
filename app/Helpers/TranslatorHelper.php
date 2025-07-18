<?php

// app/Helpers/TranslatorHelper.php

namespace App\Helpers;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Log;

class TranslatorHelper
{
    public static function translateToEnglish(string $text): ?string
    {
        try {
            $tr = new GoogleTranslate('en');
            $tr->setSource(); // auto-detect
            return $tr->translate($text);
        } catch (\Exception $e) {
            Log::warning("Translation failed: " . $e->getMessage());
            return null;
        }
    }
}

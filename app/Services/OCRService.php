<?php

namespace App\Services;

use thiagoalessio\TesseractOCR\TesseractOCR;

class OCRService
{
    public function extractTextToImage(string $path)
    {
        return (new TesseractOCR($path)
            ->lang('ind+eng')
            ->run()
        );
    }
}

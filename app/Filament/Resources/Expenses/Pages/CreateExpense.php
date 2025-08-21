<?php

namespace App\Filament\Resources\Expenses\Pages;

use App\Filament\Resources\Expenses\ExpenseResource;
use App\Services\AIParserService;
use App\Services\OCRService;
use Filament\Resources\Pages\CreateRecord;

class CreateExpense extends CreateRecord
{
    protected static string $resource = ExpenseResource::class;

    protected function afterCreate()
    {
        try {
            $record = $this->record;

            if ($record->receipt_image) {
                $path = storage_path("app/public/{$record->receipt_image}");

                $ocr = new OCRService();
                $text = $ocr->extractTextToImage($path);

                $ai = new AIParserService();
                $parsed = $ai->parseWithAI($text);
                $record->note = $text;
                $record->date_shopping = $parsed['date'] ?? null;
                $record->amount = $parsed['total'] ?? 0;
                $record->items = $parsed['items'] ?? [];
                $record->save();

                foreach ($parsed['items'] ?? [] as $item) {
                    $record->items()->create($item);
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

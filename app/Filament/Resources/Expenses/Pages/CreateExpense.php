<?php

namespace App\Filament\Resources\Expenses\Pages;

use App\Filament\Resources\Expenses\ExpenseResource;
use App\Services\AIParserService;
use App\Services\Helper;
use App\Services\OCRService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateExpense extends CreateRecord
{
    private $helper;
    protected static string $resource = ExpenseResource::class;

    protected function afterCreate()
    {
        $this->helper = app(Helper::class);

        try {
            $record = $this->record;

            if ($record->receipt_image) {
                $path = Storage::disk('public')->path($record->receipt_image);

                $ocr = new OCRService();
                $text = $ocr->extractTextToImage($path);

                $ai = new AIParserService();
                $parsed = $ai->parseWithAI($text);
                $record->note = $text;
                $record->date_shopping = $parsed['date'] ?? null;
                $record->amount = $parsed['total'] ?? 0;
                $record->parsed_data = $parsed['items'] ?? [];

                $dataClean = $this->helper->extractSpecialFieldsAndCleanItems($parsed['items'] ?? []);
                $record->change = $dataClean['extractedFields']['kembalian'] ?? 0;
                $record->save();

                foreach ($dataClean['cleanedItems'] ?? [] as $item) {
                    $record->items()->create($item);
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

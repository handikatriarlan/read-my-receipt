<?php

namespace App\Filament\Resources\Expenses\Pages;

use App\Filament\Resources\Expenses\ExpenseResource;
use App\Services\OCRService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateExpense extends CreateRecord
{
    protected static string $resource = ExpenseResource::class;

    protected function afterCreate()
    {
        try {
            $record = $this->record;

            if ($record->receipt_image) {
                $path = Storage::disk('public')->path($record->receipt_image);

                $ocr = new OCRService();
                $text = $ocr->extractTextToImage($path);

                $record->note = $text;
                $record->save();

                dispatch(new \App\Jobs\AIParserJob($record));
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

<?php

namespace App\Filament\Resources\Expenses\Pages;

use App\Filament\Resources\Expenses\ExpenseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExpense extends CreateRecord
{
    protected static string $resource = ExpenseResource::class;

    protected function afterCreate()
    {
        try {
            $record = $this->record;

            if ($record->receipt_image) {
                $path = \storage_path("app/public/{$record->receipt_image}");
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make("title")
                    ->label("Judul")
                    ->required(),
                FileUpload::make("receipt_image")
                    ->image()
                    ->disk('public')
                    ->directory("receipt")
                    ->openable()
                    ->downloadable()
                    ->preserveFilenames()
                    ->label("Foto Struk")
                    ->required(),
            ]);
    }
}

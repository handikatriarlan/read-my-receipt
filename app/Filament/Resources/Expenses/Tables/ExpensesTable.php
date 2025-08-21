<?php

namespace App\Filament\Resources\Expenses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("title")
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date_shopping')
                    ->label('Tanggal Belanja')
                    ->date()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('total')
                    ->money('idr'),
                ImageColumn::make('receipt_image'),
                TextColumn::make('items_count')
                    ->counts('items')
                    ->label('Jumlah Item')
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

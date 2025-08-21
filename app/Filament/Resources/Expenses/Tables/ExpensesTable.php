<?php

namespace App\Filament\Resources\Expenses\Tables;

use Filament\Actions\Action;
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
                    ->label('Total')
                    ->money('idr'),
                ImageColumn::make('receipt_image')
                    ->disk('public'),
                TextColumn::make('items_count')
                    ->counts('items')
                    ->label('Jumlah Item')
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('Lihat Items')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Detail Items')
                    ->modalSubmitAction(false)
                    ->color('info')
                    ->modalCancelActionLabel('Tutup')
                    ->action(fn() => null)
                    ->modalContent(function ($record) {
                        return view('filament.components.items-list', [
                            'items' => $record->items
                        ]);
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

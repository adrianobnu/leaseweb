<?php

namespace App\Filament\Resources\AssetResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class MemoryRelationManager extends RelationManager
{
    protected static string $relationship = 'memories';

    protected static ?string $recordTitleAttribute = 'size';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('size')
                    ->label('Size in GB')
                    ->required(),
                Forms\Components\TextInput::make('quantity')
                    ->label('Quantity of slots')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('size')
            ->columns([
                Tables\Columns\TextColumn::make('size')->suffix(' GB'),
                Tables\Columns\TextColumn::make('quantity')->label('Quantity of slots'),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Add memory'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('size');
    }
}

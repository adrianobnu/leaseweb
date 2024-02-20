<?php

namespace App\Filament\Resources\AssetResource\RelationManagers;

use App\Enums\DiskType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DiskRelationManager extends RelationManager
{
    protected static string $relationship = 'disks';

    protected static ?string $recordTitleAttribute = 'size';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('size')
                    ->label('Size in GB')
                    ->required(),
                Forms\Components\Select::make('type')
                    ->options(collect(DiskType::cases())->pluck('value', 'name')->toArray())
                    ->label('Type')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('size')
            ->columns([
                Tables\Columns\TextColumn::make('size')->suffix(' GB'),
                Tables\Columns\TextColumn::make('type'),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(collect(DiskType::cases())->pluck('value', 'name')->toArray()),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Add disk'),
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

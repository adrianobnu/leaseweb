<?php

namespace App\Filament\Resources;

use App\Enums\DiskType;
use App\Filament\Resources\AssetResource\Pages;
use App\Models\Asset;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->prefix('$')
                    ->rules([
                        'min:1',
                    ]),
                Forms\Components\Select::make('brand_id')
                    ->required()
                    ->preload()
                    ->relationship(name: 'brand', titleAttribute: 'name', modifyQueryUsing: fn (Builder $query) => $query->orderBy('name'))
                    ->native(false)
                    ->createOptionModalHeading('Create Brand')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                    ])
                    ->editOptionModalHeading('Edit Brand')
                    ->editOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                    ])
                    ->columnSpanFull(),
                Repeater::make('memories')
                    ->label('RAM Memories')
                    ->relationship()
                    ->orderColumn('size')
                    ->schema([
                        Forms\Components\TextInput::make('size')
                            ->label('Size in GB')
                            ->required(),
                        Forms\Components\TextInput::make('quantity')
                            ->label('Quantity of slots')
                            ->required(),
                    ])
                    ->grid(2)
                    ->itemLabel(fn (array $state): ?string => $state['size'] ? $state['quantity'].'x'.$state['size'].'GB' : 'New memory')
                    ->deleteAction(
                        fn (Action $action) => $action->requiresConfirmation(),
                    )
                    ->reorderable(false)
                    ->collapsible()
                    ->cloneable()
                    ->minItems(1)
                    ->columnSpanFull()
                    ->addActionLabel('Add memory'),
                Repeater::make('disks')
                    ->label('Disks')
                    ->relationship()
                    ->orderColumn('size')
                    ->schema([
                        Forms\Components\TextInput::make('size')
                            ->label('Size in GB')
                            ->required(),
                        Forms\Components\Select::make('type')
                            ->options(collect(DiskType::cases())->pluck('value', 'name')->toArray())
                            ->label('Type')
                            ->required(),
                    ])
                    ->grid(2)
                    ->itemLabel(fn (array $state): ?string => $state['size'] ? $state['size'].'GB - '.$state['type'] : 'New disk')
                    ->deleteAction(
                        fn (Action $action) => $action->requiresConfirmation(),
                    )
                    ->reorderable(false)
                    ->collapsible()
                    ->cloneable()
                    ->minItems(1)
                    ->columnSpanFull()
                    ->addActionLabel('Add disk'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Brand')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                TableAction::make('json')
                    ->label('See JSON')
                    ->color('success')
                    ->url(fn (Model $record): string => route('api.assets.show', $record))
                    ->icon('heroicon-m-arrow-down-on-square-stack')
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('code', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAssets::route('/'),
        ];
    }
}

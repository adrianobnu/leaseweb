<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetResource\Pages;
use App\Filament\Resources\AssetResource\RelationManagers\DiskRelationManager;
use App\Filament\Resources\AssetResource\RelationManagers\MemoryRelationManager;
use App\Models\Asset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

use function Filament\Support\format_money;

class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;

    protected static ?string $navigationGroup = 'Servers';

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['code', 'name', 'brand.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Code' => $record->code,
            'Brand' => $record->brand->name,
            'Price' => format_money($record->price, 'USD'),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->unique(ignoreRecord: true)
                    ->numeric(),
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
                    ->searchable()
                    ->description(fn (Model $record): string => $record->memories->sum('size').' GB Memory | '.$record->disks->sum('size').' GB Disk'),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Brand')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('brand_id')
                    ->label('Brand')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->multiple()
                    ->preload(),
            ])
            ->actions([
                TableAction::make('json')
                    ->label('See JSON')
                    ->color('success')
                    ->url(fn (Model $record): string => route('api.assets.show', $record))
                    ->icon('heroicon-m-arrow-down-on-square-stack')
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAssets::route('/'),
            'create' => Pages\CreateAsset::route('/create'),
            'edit' => Pages\EditAsset::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            MemoryRelationManager::class,
            DiskRelationManager::class,
        ];
    }
}

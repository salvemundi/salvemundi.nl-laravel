<?php

namespace App\Filament\Resources;

use App\Enums\MerchType;
use App\Filament\Resources\MerchResource\Pages;
use App\Filament\Resources\MerchResource\RelationManagers;
use App\Models\Merch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MerchResource extends Resource
{
    protected static ?string $model = Merch::class;
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Merch';
    protected static ?string $label = 'Merch';
    protected static ?string $pluralLabel = 'Merch';
    protected static ?string $modelLabel = 'Merch';
    protected static ?string $pluralModelLabel = 'Merch';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->prefix('€')
                    ->numeric()
                    ->step('0.01'),
                Forms\Components\FileUpload::make('imgPath')
                    ->label('Image')
                    ->directory('merch')
                    ->image()
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->rows(10),
                Forms\Components\Group::make([
                    Forms\Components\Toggle::make('isPreOrder')
                        ->default(true)->reactive(),
                    Forms\Components\Toggle::make('preOrderNeedsPayment')
                        ->default(true),
                ]),
                Forms\Components\Select::make('type')
                    ->options(MerchType::asSelectArray())
                    ->required(),
                Forms\Components\Toggle::make('canSetNote')
                    ->label('Customer can add a note')
                    ->default(false),
                Forms\Components\TextInput::make('amountPreOrdersBeforeNotification')
                    ->numeric()
                    ->default(10)
                    ->required()
                    ->visible(fn ($get) => $get('isPreOrder')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imgPath')
                    ->label('Image')
                    ->circular()
                    ->getStateUsing(function (Merch $record){
                        $path = $record->imgPath ?? 'salvemundi.png';
                        $p = str_replace('merch/', '',$path);
                        $p = rawurlencode($p);
                        return $record->imgPath ? asset('storage/merch/'.$p) : asset('images/salvemundi.png');
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->prefix('€')
                    ->label('Price')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('isPreOrder')
                    ->boolean()
                    ->label('Pre-order')
                    ->sortable(),
                Tables\Columns\IconColumn::make('canSetNote')
                    ->boolean()
                    ->label('Note')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->getStateUsing(function ($record) {
                        return MerchType::fromValue($record->type)->description;
                    })
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMerches::route('/'),
            'create' => Pages\CreateMerch::route('/create'),
            'edit' => Pages\EditMerch::route('/{record}/edit'),
        ];
    }
}

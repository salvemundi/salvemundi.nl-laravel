<?php

namespace App\Filament\Resources;

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
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

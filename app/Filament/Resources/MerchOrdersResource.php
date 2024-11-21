<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MerchOrdersResource\Pages;
use App\Filament\Resources\MerchOrdersResource\RelationManagers;
use App\Models\UserMerchTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MerchOrdersResource extends Resource
{
    protected static ?string $model = UserMerchTransaction::class;
    protected static ?string $navigationParentItem = 'Merch';

    protected static ?string $navigationLabel = 'Orders';
    protected static ?string $label = 'Orders';

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

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMerchOrders::route('/'),
            'create' => Pages\CreateMerchOrders::route('/create'),
            'edit' => Pages\EditMerchOrders::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\ActivityResource\RelationManagers;

use App\Enums\paymentStatus;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Svg\Tag\Text;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';
    protected static ?string $title = 'Non Members';
    protected static ?string $label = 'Non Members';
    protected static ?string $pluralLabel = 'Non Members';
    protected static ?string $modelLabel = 'Non Members';
    protected static ?string $pluralModelLabel = 'Non Members';
    public static function canViewForRecord(Product|Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->amount_non_member > 0;
    }

    public function filterTableQuery(Builder $query): Builder
    {
        return $query->where('paymentStatus', paymentStatus::paid)->where('email', '!=', '');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('transactionId')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('transactionId')
            ->columns([
                Tables\Columns\TextColumn::make('transactionId'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('paymentStatus')->getStateUsing(function ($record){
                    return ucfirst(paymentStatus::coerce($record->paymentStatus)->key);
                }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

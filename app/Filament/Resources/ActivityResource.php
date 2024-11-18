<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Filament\Resources\ActivityResource\RelationManagers;
use App\Models\Product;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $title = 'Activity';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $label = 'Activity';
    protected static ?string $pluralLabel = 'Activities';
    protected static ?string $modelLabel = 'Activity';
    protected static ?string $pluralModelLabel = 'Activities';
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        // Get the base query for the resource's model
        return parent::getEloquentQuery()->whereNull('index');
    }

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
                ImageColumn::make('profile_photo_path')
                    ->label('Photo')
                    ->getStateUsing(function (Product $record) {
                        $files = glob(storage_path('app/public/activities/' . $record->name . '.*'));
                        if (!empty($files)) {
                            $filePath = str_replace(storage_path('app/public'), '', $files[0]);
                            return asset('storage' . $filePath);
                        }
                        return asset('images/salvemundi.png');
                    })
                    ->circular(),
                Tables\Columns\TextColumn::class::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::class::make('Signup Count')
                    ->getStateUsing(function (Product $record) {
                        if($record->limit == 0) {
                            $limit = '∞';
                        } else {
                            $limit = $record->limit;
                        }
                        return $record->countSignups() . ' / ' . $limit;
                    }),
                Tables\Columns\TextColumn::make('amount')
                    ->prefix('€')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount_non_member')
                    ->prefix('€')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                // where column index is null


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
            'members' => RelationManagers\MembersRelationManager::class,
            'nonMembers' => RelationManagers\NonMembersRelationManager::class,
            'transactions' => RelationManagers\TransactionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}

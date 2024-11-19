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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereNull('index')->orderBy('created_at', 'desc');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description'),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('€')
                    ->inputMode('decimal')
                    ->step('0.01'),
                Forms\Components\TextInput::make('amount_non_member')
                    ->required()
                    ->numeric()
                    ->prefix('€')
                    ->inputMode('decimal')
                    ->step('0.01'),
                Forms\Components\DateTimePicker::make('startDate')
                    ->required(),
                Forms\Components\DateTimePicker::make('endDate')
                    ->required(),
                Forms\Components\FileUpload::make('imgPath')
                    ->image()
                    ->directory('activities')
                    ->label('Image')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_photo_path')
                    ->label('Photo')
                    ->getStateUsing(function (Product $record){
                        $path = $record->imgPath ?? 'salvemundi.png';
                        $p = str_replace('activities/', '',$path);
                        $p = rawurlencode($p);
                        return $record->imgPath ? asset('storage/activities/'.$p) : asset('images/salvemundi.png');
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

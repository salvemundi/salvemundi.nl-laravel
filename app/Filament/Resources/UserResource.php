<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $recordTitleAttribute = 'DisplayName';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('DisplayName')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('FirstName')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('LastName')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('PhoneNumber')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('birthday'),
                Forms\Components\Toggle::make('visibility')
                    ->default(false),
                Forms\Components\TextInput::make('minecraftUsername')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_photo_path')
                    ->label('Photo')
                    ->getStateUsing(function (User $record){
                        $path = $record->ImgPath ?? 'salvemundi.png';
                        $p = str_replace('users/', '',$path);
                        $p = rawurlencode($p);
                        return str_contains($record->ImgPath,'.svg') ? asset('storage/images/SalveMundi-Vector.svg') : asset('storage/users/'.$p);
                    })
                    ->circular(),
                TextColumn::make('DisplayName')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('PhoneNumber')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('birthday'),
                TextColumn::make('Membership status')
                    ->getStateUsing(fn (User $record): string => $record->hasActiveSubscription() ? 'Active' : 'Expired')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Active' => 'success',
                        'Expired' => 'danger',
                    })
                    ->icon(fn (string $state): ?string => match ($state) {
                        'Active' => 'heroicon-o-check-circle',
                        'Expired' => 'heroicon-o-x-circle',
                    }),
                IconColumn::make('visibility')->label('Public visibility')
                    ->boolean()
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
            RelationManagers\CommissionRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\Commissie;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommissionRelationManager extends RelationManager
{
    protected static string $relationship = 'commission';

    protected static ?string $title = 'Committees';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('DisplayName')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('DisplayName')
            ->columns([
                Tables\Columns\TextColumn::make('DisplayName')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make('Add to committee')
                    ->modalHeading('Add to committee')
                    ->label('Add to committee')
                    ->preloadRecordSelect()
                    ->successNotificationTitle('User added to committee')
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->successNotificationTitle('User removed from committee')->label('Remove from committee')->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ])
            ->inverseRelationship('users');
    }
}

<?php

namespace App\Filament\Resources\ActivityResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

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
                Tables\Columns\TextColumn::make('DisplayName')->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->modalHeading('Add member')
                    ->label('Add member')
                    ->icon('heroicon-o-plus')
                    ->successNotificationTitle('User added to activity'),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()->button()
                    ->modalHeading('Remove from activity')
                    ->label('Remove from activity'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->inverseRelationship('activities');
    }
}

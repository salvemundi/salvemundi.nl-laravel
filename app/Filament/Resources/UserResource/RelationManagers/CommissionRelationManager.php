<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Http\Controllers\AzureController;
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
    protected static ?string $label = 'Committees';
    protected static ?string $pluralLabel = 'Committees';
    protected static ?string $modelLabel = 'Committee';
    protected static ?string $pluralModelLabel = 'Committees';


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
            ->emptyStateHeading('No committees')
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
                    ->icon('heroicon-o-plus')
                    ->preloadRecordSelect()
                    ->successNotificationTitle('User added to committee')
                    ->after(function ($record) {
                        $user =  User::find($this->getOwnerRecord()->id);
                        $commissie = $record;
                        $graph = new AzureController();
                        $graph->addUserToGroup($user, $commissie);
                    }),
                Tables\Actions\Action::make('Sync groups from Azure')
                    ->successNotificationTitle('Synced groups')
                    ->icon('heroicon-o-arrow-path')
                    ->action(function ($record) {
                        $user =  User::find($this->getOwnerRecord()->id);
                        $graph = new AzureController();
                        $graph->syncUserGroupsFromAzure($user);
                    }),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->successNotificationTitle('User removed from committee')->label('Remove from committee')->button()
                    ->after(function ($record) {
                        $user = User::find($this->getOwnerRecord()->id);
                        $commissie = $record;
                        $graph = new AzureController();
                        $graph->removeUserFromGroup($user, $commissie);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ])
            ->inverseRelationship('users');
    }
}

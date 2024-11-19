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
use Illuminate\Support\Facades\Log;
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
        $search = $this->table->getLivewire()->tableSearch; // Retrieves the search term from the table
        if($this->getOwnerRecord()->isGroupSignup) {
            return $query
                ->where('paymentStatus', paymentStatus::paid)
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('email', 'like', "%{$search}%")
                            ->orWhereHas('nonMembers', function ($query) use ($search) {
                                $query->where('name', 'like', "%{$search}%");
                            });
                    });
                });
        } else {
            return $query
                ->where('paymentStatus', paymentStatus::paid)->where('email', '!=', '')
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('email', 'like', "%{$search}%")
                            ->orWhereHas('nonMembers', function ($query) use ($search) {
                                $query->where('name', 'like', "%{$search}%");
                            });
                    });
                });
        }

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
            ->columns([
                Tables\Columns\TextColumn::make('Who')->getStateUsing(function ($record) {
                    if($this->getOwnerRecord()->isGroupSignup) {
                        $names = $record->nonMembers->pluck('name')->toArray();
                        return implode(', ', $names);
                    }
                    return $record->email;
                })->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

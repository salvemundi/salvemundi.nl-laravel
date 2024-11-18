<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Http\Controllers\AzureController;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\IconPosition;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    // Customize the "Save" button
    protected function getSaveFormAction(): Actions\Action
    {
        return parent::getSaveFormAction()
            ->label('Update User')
            ->icon('heroicon-o-archive-box-arrow-down')
            ->iconPosition(IconPosition::Before);
//            ->color('success');
    }

    // Customize the "Cancel" button
    protected function getCancelFormAction(): Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('Go Back')
            ->icon('heroicon-o-arrow-left')
            ->color('gray');
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $graph = new AzureController();
        $user = User::find($this->record->id);
        $user->fill($data);
        $graph->updateUserToAzure($user);
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }
}

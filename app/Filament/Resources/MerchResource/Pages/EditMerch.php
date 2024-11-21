<?php

namespace App\Filament\Resources\MerchResource\Pages;

use App\Filament\Resources\MerchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMerch extends EditRecord
{
    protected static string $resource = MerchResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['imgPath'] = str_replace('public/','',$this->record->imgPath);
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

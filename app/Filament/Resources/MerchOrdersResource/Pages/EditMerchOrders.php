<?php

namespace App\Filament\Resources\MerchOrdersResource\Pages;

use App\Filament\Resources\MerchOrdersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMerchOrders extends EditRecord
{
    protected static string $resource = MerchOrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

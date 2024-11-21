<?php

namespace App\Filament\Resources\MerchOrdersResource\Pages;

use App\Filament\Resources\MerchOrdersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMerchOrders extends ListRecords
{
    protected static string $resource = MerchOrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\MerchResource\Pages;

use App\Filament\Resources\MerchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMerches extends ListRecords
{
    protected static string $resource = MerchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

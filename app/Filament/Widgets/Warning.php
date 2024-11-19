<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class Warning extends Widget
{
    protected static string $view = 'filament.widgets.warning';

    protected function getViewData(): array
    {
        return [
            'warningText' => "This dashboard is new and under development. \n READY to use: Users & Activities.\n NOT ready to use: Merch",
        ];
    }
}

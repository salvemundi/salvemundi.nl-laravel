<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class Warning extends Widget
{
    protected static string $view = 'filament.widgets.warning';

    protected function getViewData(): array
    {
        return [
            'warningText' => "This dashboard is new and under development. \n DO NOT use this dashboard for changes. \n P.S. It is now safe to use the Users page(s).",
        ];
    }
}

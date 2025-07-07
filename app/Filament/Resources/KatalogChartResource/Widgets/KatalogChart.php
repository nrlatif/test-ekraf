<?php

namespace App\Filament\Resources\KatalogChartResource\Widgets;

use Filament\Widgets\ChartWidget;

class KatalogChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

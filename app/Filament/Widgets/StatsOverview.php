<?php

namespace App\Filament\Widgets;

use App\Models\Person;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total de Cadastros', Person::count())
                ->description('Total de pessoas cadastradas no sistema')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
                
            Stat::make('Novos Hoje', Person::whereDate('created_at', today())->count())
                ->description('Cadastros realizados hoje')
                ->color('success'),
        ];
    }
}
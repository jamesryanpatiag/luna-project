<?php
 
namespace App\Filament\Pages;
 
use Filament\Pages\Dashboard as BaseDashboard;
 
class Dashboard extends BaseDashboard
{
    public function getWeidgets(): array
    {
        return Filament::getWidgets();
    }
}
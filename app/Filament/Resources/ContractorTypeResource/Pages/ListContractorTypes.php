<?php

namespace App\Filament\Resources\ContractorTypeResource\Pages;

use App\Filament\Resources\ContractorTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContractorTypes extends ListRecords
{
    protected static string $resource = ContractorTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

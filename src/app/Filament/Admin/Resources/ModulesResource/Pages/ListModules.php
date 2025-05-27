<?php

namespace App\Filament\Admin\Resources\ModulesResource\Pages;

use App\Filament\Admin\Resources\ModulesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListModules extends ListRecords
{
    protected static string $resource = ModulesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

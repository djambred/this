<?php

namespace App\Filament\Admin\Resources\JargonResource\Pages;

use App\Filament\Admin\Resources\JargonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJargons extends ListRecords
{
    protected static string $resource = JargonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

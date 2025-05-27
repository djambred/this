<?php

namespace App\Filament\Admin\Resources\BootcampResource\Pages;

use App\Filament\Admin\Resources\BootcampResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBootcamps extends ListRecords
{
    protected static string $resource = BootcampResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

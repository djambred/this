<?php

namespace App\Filament\Admin\Resources\BootcampResource\Pages;

use App\Filament\Admin\Resources\BootcampResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBootcamp extends EditRecord
{
    protected static string $resource = BootcampResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

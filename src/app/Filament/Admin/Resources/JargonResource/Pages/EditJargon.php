<?php

namespace App\Filament\Admin\Resources\JargonResource\Pages;

use App\Filament\Admin\Resources\JargonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJargon extends EditRecord
{
    protected static string $resource = JargonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

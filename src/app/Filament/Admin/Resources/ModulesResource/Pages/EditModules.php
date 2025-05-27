<?php

namespace App\Filament\Admin\Resources\ModulesResource\Pages;

use App\Filament\Admin\Resources\ModulesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditModules extends EditRecord
{
    protected static string $resource = ModulesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function canEdit($record): bool
    {
        if (auth()->user()->hasRole('instructor')) {
            return $record->instructor_id === auth()->id();
        }
        return true; // admin can edit all
    }
}

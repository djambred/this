<?php

namespace App\Filament\Admin\Resources\FooterLinkResource\Pages;

use App\Filament\Admin\Resources\FooterLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFooterLink extends EditRecord
{
    protected static string $resource = FooterLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

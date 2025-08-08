<?php

namespace App\Filament\Admin\Resources\ScratchCardResource\Pages;

use App\Filament\Admin\Resources\ScratchCardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditScratchCard extends EditRecord
{
    protected static string $resource = ScratchCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

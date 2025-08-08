<?php

namespace App\Filament\Admin\Resources\ScratchCardPrizeResource\Pages;

use App\Filament\Admin\Resources\ScratchCardPrizeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditScratchCardPrize extends EditRecord
{
    protected static string $resource = ScratchCardPrizeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

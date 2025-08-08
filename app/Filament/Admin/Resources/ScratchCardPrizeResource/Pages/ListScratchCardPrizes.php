<?php

namespace App\Filament\Admin\Resources\ScratchCardPrizeResource\Pages;

use App\Filament\Admin\Resources\ScratchCardPrizeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListScratchCardPrizes extends ListRecords
{
    protected static string $resource = ScratchCardPrizeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

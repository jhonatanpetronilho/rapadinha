<?php

namespace App\Filament\Admin\Resources\ScratchCardResource\Pages;

use App\Filament\Admin\Resources\ScratchCardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListScratchCards extends ListRecords
{
    protected static string $resource = ScratchCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

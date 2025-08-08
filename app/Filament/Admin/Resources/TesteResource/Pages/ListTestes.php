<?php

namespace App\Filament\Admin\Resources\TesteResource\Pages;

use App\Filament\Admin\Resources\TesteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTestes extends ListRecords
{
    protected static string $resource = TesteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

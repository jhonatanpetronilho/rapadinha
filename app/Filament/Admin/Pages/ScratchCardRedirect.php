<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;

class ScratchCardRedirect extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Raspadinhas';
    protected static ?string $title = 'Raspadinhas';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Meus Jogos'; // Ou troque pelo grupo que preferir

    protected static string $view = 'filament.pages.scratch-card-redirect';

    public function mount()
    {
        return redirect('/pgfull/scratch-cards'); // URL do seu Resource
    }
}

<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ScratchCardResource\Pages;
use App\Models\ScratchCard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Table;

class ScratchCardResource extends Resource
{
    protected static ?string $model = ScratchCard::class;

    // === AJUSTES PARA O MENU LATERAL ===
    protected static ?string $navigationLabel = 'Raspadinhas';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack'; // Altere o ícone se quiser
    protected static ?string $navigationGroup = 'Meus Jogos'; // Mesmo grupo dos outros jogos
    protected static ?int $navigationSort = 4; // Mude o número para ajustar a ordem no grupo

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome da Raspadinha')
                    ->required(),
                Textarea::make('description')
                    ->label('Descrição'),
                FileUpload::make('banner')
                    ->label('Banner (horizontal)')
                    ->image()
                    ->directory('scratch/banners'),
                FileUpload::make('image')
                    ->label('Imagem (card)')
                    ->image()
                    ->directory('scratch/images'),
                TextInput::make('price')
                    ->label('Valor para jogar (R$)')
                    ->numeric()
                    ->required(),
                TextInput::make('max_prize')
                    ->label('Prêmio Máximo (R$)')
                    ->required(),
                TextInput::make('rtp')
                    ->label('% RTP')
                    ->numeric()
                    ->default(30)
                    ->required(),
                Toggle::make('active')
                    ->label('Ativo')
                    ->default(true),

                // HasManyRepeater dos prêmios — aqui dentro do form!
                Forms\Components\HasManyRepeater::make('prizes')
                    ->relationship('prizes')
                    ->schema([
                        Forms\Components\TextInput::make('name')->label('Nome do prêmio')->required(),
                        Forms\Components\TextInput::make('value')->label('Valor')->numeric()->required(),
                        Forms\Components\FileUpload::make('image')->label('Imagem')->directory('scratch/prizes')->image(),
                        Forms\Components\TextInput::make('quantity')->label('Quantidade')->numeric()->required(),
                    ])
                    ->label('Prêmios da raspadinha')
                    ->minItems(1)
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->label('Nome'),
                TextColumn::make('price')->label('Valor'),
                TextColumn::make('max_prize')->label('Prêmio Máximo'),
                TextColumn::make('rtp')->label('RTP (%)'),
                BooleanColumn::make('active')->label('Ativo'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canViewAny(): bool
    {
        return true; // Liberar acesso para teste
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListScratchCards::route('/'),
            'create' => Pages\CreateScratchCard::route('/create'),
            'edit' => Pages\EditScratchCard::route('/{record}/edit'),
        ];
    }
}

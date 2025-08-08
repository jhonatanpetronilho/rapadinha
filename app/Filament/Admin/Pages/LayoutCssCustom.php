<?php

namespace App\Filament\Admin\Pages;

use App\Models\CustomLayout;
use Creagia\FilamentCodeField\CodeField;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\Cache;

class LayoutCssCustom extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.layout-css-custom';

    protected static ?string $navigationLabel = 'Customização Layout';

    protected static ?string $modelLabel = 'Customização Layout';

    protected static ?string $title = 'Customização Layout';

    protected static ?string $slug = 'custom-layout';

    public ?array $data = [];
    public CustomLayout $custom;

    /**
     * @dev @victormsalatiel
     * @return bool
     */
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * @return void
     */
    public function mount(): void
    {
        $this->custom = CustomLayout::first();
        $this->form->fill($this->custom->toArray());
    }

    /**
     * @param array $data
     * @return array
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {

        return $data;
    }

    /**
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('CONFIGURAR LINKS DA CASA')
                ->description('Coloque os links desejados em cada categoria personalizada.')
                ->collapsible()
                ->collapsed(true)
                ->schema([
                    TextInput::make('instagram')
                        ->label('Instagram')
                        ->placeholder('Digite a URL do seu Instagram')
                        ->url()
                        ->maxLength(191),
                    TextInput::make('facebook')
                        ->label('Facebook')
                        ->placeholder('Digite a URL do seu Facebook')
                        ->url()
                        ->maxLength(191),
                    TextInput::make('telegram')
                        ->label('Telegram')
                        ->placeholder('Digite a URL do seu Telegram')
                        ->url()
                        ->maxLength(191),
                    TextInput::make('twitter')
                        ->label('Twitter')
                        ->placeholder('Digite a URL do seu Twitter')
                        ->url()
                        ->maxLength(191),
                    TextInput::make('whastapp')
                        ->label('Whastapp')
                        ->placeholder('Digite a URL do seu Whastapp')
                        ->url()
                        ->maxLength(191),
                    TextInput::make('youtube')
                        ->label('Youtube')
                        ->placeholder('Digite a URL do seu Youtube')
                        ->url()
                        ->maxLength(191),
                        TextInput::make('Suporte')
                        ->label('Suporte')
                        ->placeholder('Digite a sua URL de Suporte')
                        ->url()
                        ->maxLength(191),
                        TextInput::make('esportes')
                        ->label('Esportes')
                        ->placeholder('Digite a sua URL do seu game de Esportes.')
                        ->url()
                        ->maxLength(191),
                        TextInput::make('apostasaovivo')
                        ->label('Apostas Ao vivo')
                        ->placeholder('Digite a sua URL das apostas ao vivo.')
                        ->url()
                        ->maxLength(191),
                        TextInput::make('cassino')
                        ->label('Cassino')
                        ->placeholder('Digite a sua URL de Todos Games de Cassino.')
                        ->url()
                        ->maxLength(191),
                        TextInput::make('cassinoaovivo')
                        ->label('Cassino Ao vivo')
                        ->placeholder('Digite a sua URL dos Cassinos Ao vivo.')
                        ->url()
                        ->maxLength(191),
                        TextInput::make('ajuda')
                        ->label('Link de Ajuda')
                        ->placeholder('Digite a sua URL de Ajuda da sua casa.')
                        ->url()
                        ->maxLength(191),
                ])->columns(3)
            ,
                Section::make()
                    ->label('Background')
                    ->schema([
                        ColorPicker::make('background_base')
                            ->label('Background Principal')
                            ->required(),
                        ColorPicker::make('background_base_dark')
                            ->label('Background Principal (Dark)')
                            ->required(),
                        ColorPicker::make('carousel_banners')
                            ->label('Carousel Banners')
                            ->required(),
                        ColorPicker::make('carousel_banners_dark')
                            ->label('Carousel Banners (Dark)')
                            ->required(),
                    ])->columns(4)
                ,
                Section::make('Sidebar & Navbar & Footer')
                    ->description('Personalize a aparência do seu site, conferindo-lhe uma identidade única.')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        ColorPicker::make('sidebar_color')
                            ->label('Sidebar')
                            ->required(),

                        ColorPicker::make('sidebar_color_dark')
                            ->label('Sidebar (Dark)')
                            ->required(),

                        ColorPicker::make('navtop_color')
                            ->label('Navtop')
                            ->required(),

                        ColorPicker::make('navtop_color_dark')
                            ->label('Navtop (Dark)')
                            ->required(),

                        ColorPicker::make('side_menu')
                            ->label('Side Menu Box')
                            ->required(),

                        ColorPicker::make('side_menu_dark')
                            ->label('Side Menu Box (Dark)')
                            ->required(),

                        ColorPicker::make('footer_color')
                            ->label('Footer Color')
                            ->required(),

                        ColorPicker::make('footer_color_dark')
                            ->label('Footer Color (Dark)')
                            ->required(),
                    ])->columns(4)
                ,
                Section::make('Customização')
                    ->description('Personalize a aparência do seu site, conferindo-lhe uma identidade única.')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        ColorPicker::make('gray_medium_color')
                        ->label('Cor Primária do Degradê NAVBAR E FOOTER')
                        ->required(),
                        ColorPicker::make('gray_over_color')
                        ->label('Cor Secundária do Degradê NAVBAR E FOOTER')
                        ->required(),
                        ColorPicker::make('gray_dark_color')
                        ->label('Cor Primária Degradê SIDEBAR')
                        ->required(),
                        ColorPicker::make('card_color_dark')
                        ->label('Cor Secundária Degradê SIDEBAR')
                        ->required(),
                       
                        ColorPicker::make('primary_color')
                            ->label('Primary Color')
                            ->required(),
                        ColorPicker::make('primary_opacity_color')
                            ->label('Primary Opacity Color')
                            ->required(),

                        ColorPicker::make('input_primary')
                            ->label('Input Primary')
                            ->required(),
                        ColorPicker::make('input_primary_dark')
                            ->label('Input Primary (Dark)')
                            ->required(),

                        ColorPicker::make('card_color')
                            ->label('Card Primary')
                            ->required(),
                   

                        ColorPicker::make('secundary_color')
                            ->label('Secundary Color')
                            ->required(),
                       
                        ColorPicker::make('gray_light_color')
                            ->label('Gray Light Color')
                            ->required(),
                        ColorPicker::make('title_color')
                            ->label('Title Color')
                            ->required(),
                        ColorPicker::make('text_color')
                            ->label('Text Color')
                            ->required(),
                        ColorPicker::make('sub_text_color')
                            ->label('Sub Text Color')
                            ->required(),
                        ColorPicker::make('placeholder_color')
                            ->label('Placeholder Color')
                            ->required(),
                        ColorPicker::make('background_color')
                            ->label('Background Color')
                            ->required(),
                        TextInput::make('border_radius')
                            ->label('Border Radius')
                            ->required(),
                    ])->columns(4)
                ,
                Section::make('Customização no Código HTML BASE')
                    ->description('Customize seu css, js, ou adicione conteúdo no corpo da sua página')
                    ->collapsible()
                    ->collapsed(true)
                     ->schema([
                         CodeField::make('custom_css')
                             ->label('Customização do CSS')
                             ->setLanguage(CodeField::CSS)
                             ->withLineNumbers()
                             ->minHeight(400),
                         CodeField::make('custom_js')
                             ->label('Customização do JS')
                             ->setLanguage(CodeField::JS)
                             ->withLineNumbers()
                             ->minHeight(400),
                         CodeField::make('custom_header')
                             ->label('Customização do Header')
                             ->setLanguage(CodeField::HTML)
                             ->withLineNumbers()
                             ->minHeight(400),
                         CodeField::make('custom_body')
                             ->label('Customização do Body')
                             ->setLanguage(CodeField::HTML)
                             ->withLineNumbers()
                             ->minHeight(400),
                     ])
                
             
            ])
            ->statePath('data');
    }

    /**
     * @return void
     */
    public function submit(): void
    {
        try {
            if(env('APP_DEMO')) {
                Notification::make()
                    ->title('Atenção')
                    ->body('Você não pode realizar está alteração na versão demo')
                    ->danger()
                    ->send();
                return;
            }

            $custom = CustomLayout::first();

            if(!empty($custom)) {
                if($custom->update($this->data)) {

                    Cache::put('custom', $custom);

                    Notification::make()
                        ->title('Dados alterados')
                        ->body('Dados alterados com sucesso!')
                        ->success()
                        ->send();
                }
            }


        } catch (Halt $exception) {
            Notification::make()
                ->title('Erro ao alterar dados!')
                ->body('Erro ao alterar dados!')
                ->danger()
                ->send();
        }
    }
}

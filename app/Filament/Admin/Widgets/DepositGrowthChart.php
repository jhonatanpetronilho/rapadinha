<?php

namespace App\Filament\Admin\Widgets;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Filament\Widgets\BarChartWidget;

class DepositGrowthChart extends BarChartWidget
{
   protected static ?string $heading = 'Distribuição de Depósitos 💰';

    protected function getData(): array
    {
        $data = $this->getDepositStatusData();
        $generatedDeposits = $data['generatedDeposits'];
        $paidDeposits = $data['paidDeposits'];

        return [
            'datasets' => [
                [
                    'label' => 'Depósitos Gerados vs Pagos',
                    'data' => [$generatedDeposits, $paidDeposits],
                    'backgroundColor' => [
                        'rgb(0, 123, 255)',  // Azul para usuários com depósito
                        'rgb(255, 69, 0)',   // Vermelho para usuários sem depósito
                    ],
                    'hoverBackgroundColor' => [
                        'rgb(0, 102, 204)',  // Azul escuro ao passar o mouse
                        'rgb(204, 55, 0)',   // Vermelho escuro ao passar o mouse
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Depósitos Gerados', 'Depósitos Pagos'],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
                'plugins' => [
                    'legend' => [
                        'display' => true,
                        'position' => 'top',
                        'labels' => [
                            'color' => '#ddd',
                        ],
                    ],
                    'tooltip' => [
                        'callbacks' => [
                            'label' => function($tooltipItem) {
                                return $tooltipItem.label . ': ' . $tooltipItem.raw . ' depósitos';
                            }
                        ],
                        'backgroundColor' => 'rgba(0, 0, 0, 0.7)',
                        'titleColor' => '#fff',
                        'bodyColor' => '#fff',
                        'displayColors' => false,
                    ],
                ],
                'cutout' => '50%',  // Ajuste do buraco no centro do gráfico
                'animation' => [
                    'duration' => 1000,
                    'easing' => 'easeInOutQuart',
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    private function getDepositStatusData(): array
    {
        $now = Carbon::now();

        $generatedDeposits = DB::table('deposits')
            ->whereMonth('created_at', $now->month)
            ->count();

        $paidDeposits = DB::table('deposits')
            ->whereMonth('created_at', $now->month)
            ->where('status', 1)
            ->count();

        return [
            'generatedDeposits' => $generatedDeposits,
            'paidDeposits' => $paidDeposits,
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->hasRole('admin');
    }
}
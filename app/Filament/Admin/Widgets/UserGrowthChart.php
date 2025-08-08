<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use App\Models\Deposit;
use Carbon\Carbon;
use Filament\Widgets\DoughnutChartWidget;

class UserGrowthChart extends DoughnutChartWidget
{
    protected static ?string $heading = 'Distribuição de Jogadores 🔥';

    protected function getData(): array
    {
        $data = $this->getUserDepositData();
        $usersWithDeposits = $data['usersWithDeposits'];
        $usersWithoutDeposits = $data['usersWithoutDeposits'];

        return [
            'datasets' => [
                [
                    'data' => [$usersWithDeposits, $usersWithoutDeposits],
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
            'labels' => ['Usuários com Depósito', 'Usuários sem Depósito'],
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
                                return $tooltipItem.label . ': ' . $tooltipItem.raw . ' usuários';
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

    private function getUserDepositData(): array
    {
        $now = Carbon::now();
        
        // Usuários que fizeram depósito no mês atual
        $usersWithDeposits = Deposit::whereMonth('created_at', $now->month)
            ->distinct('user_id')
            ->count('user_id');

        // Total de usuários registrados no mês atual
        $totalUsers = User::whereMonth('created_at', $now->month)->count();

        // Usuários que não fizeram depósito
        $usersWithoutDeposits = $totalUsers - $usersWithDeposits;

        return [
            'usersWithDeposits' => $usersWithDeposits,
            'usersWithoutDeposits' => $usersWithoutDeposits,
        ];
    }

    /*** @return bool */
    public static function canView(): bool
    {
        return auth()->user()->hasRole('admin');
    }
}

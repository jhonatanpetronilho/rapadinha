<?php

namespace App\Livewire;

use App\Models\AffiliateHistory;
use App\Models\Deposit;
use App\Models\Withdrawal;
use App\Models\GamesKey;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use App\Traits\Providers\PlayConnectTrait;

class WalletOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    use InteractsWithPageFilters;

    /**
     * @return array|Stat[]
     */
    protected function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        $setting = \Helper::getSetting();
        $dataAtual = Carbon::now();
        $depositQuery = Deposit::query();
        $withdrawalQuery = Withdrawal::query();

        if(empty($startDate) && empty($endDate)) {
            $depositQuery->whereMonth('created_at', Carbon::now()->month);
        }else{
            $depositQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Executa a consulta para obter a soma dos depósitos para o mês atual
        $sumDepositMonth = $depositQuery
            ->where('status', 1)
            ->sum('amount');

        $withdrawalQuery->where('status', 1);

        if(empty($startDate) && empty($endDate)) {
            $withdrawalQuery->whereMonth('created_at', Carbon::now()->month);
        }else{
            $withdrawalQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        $sumWithdrawalMonth = $withdrawalQuery->sum('amount');
        $revshare = AffiliateHistory::where('commission_type', 'revshare')->sum('commission_paid');


        $stats = [
       
        ];

        $gateway = GamesKey::first();
if (!empty($gateway->playconnect_token)) {
 // Removido: integração com PlayConnect (Playigaming) desativada




   $stat = Stat::make('Saldo do Agente na API', \Helper::amountFormatDecimal(0))
        ->description('Saldo disponível na API Games Slot')
        ->descriptionIcon('heroicon-m-arrow-trending-up')
        ->color('primary');

    array_push($stats, $stat);
}

return $stats;

    }

    /**
     * @return bool
     */
    public static function canView(): bool
    {
        return auth()->user()->hasRole('admin');
    }
}

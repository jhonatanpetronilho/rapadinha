<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;

class UserController extends Controller
{
    public function downloadCsv()
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Acesso não autorizado.');
        }

        // Não precisamos mais carregar a relação 'wallet' se não vamos usá-la
        // $users = User::with('wallet')->get();
        $users = User::all(); // Basta pegar todos os usuários sem a relação wallet

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="users_' . date('Y-m-d_H-i-s') . '.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');

            fputs($file, "\xEF\xBB\xBF"); // BOM para UTF-8

            $delimiter = ';';

            // --- CABEÇALHO DO CSV: REMOVIDAS AS COLUNAS ---
            fputcsv($file, [
                'ID',
                'Nome',
                'E-mail',
                'CPF',
                'Telefone',
            ], $delimiter);

            // Dados dos usuários
            foreach ($users as $user) {
                // As variáveis $walletBalance, $vipLevel, $vipPoints, $emailVerifiedAtFormatted, $createdAtFormatted
                // não são mais necessárias aqui, pois as colunas foram removidas.

                // --- DADOS DO CSV: REMOVIDAS AS COLUNAS ---
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->cpf,
                    $user->phone,
                ], $delimiter);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
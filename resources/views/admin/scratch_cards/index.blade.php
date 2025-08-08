@extends('admin.layouts.app') {{-- Use o seu layout base admin, ou remova se não usar --}}

@section('content')
<div class="container py-4">
    <h1>Raspadinhas</h1>
    <a href="{{ route('admin.scratch-cards.create') }}" class="btn btn-primary mb-3">Nova Raspadinha</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Preço</th>
                <th>Prêmio Máximo</th>
                <th>Ativa</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cards as $card)
            <tr>
                <td>{{ $card->name }}</td>
                <td>R$ {{ number_format($card->price, 2, ',', '.') }}</td>
                <td>R$ {{ $card->max_prize }}</td>
                <td>{{ $card->active ? 'Sim' : 'Não' }}</td>
                <td>
                    <a href="{{ route('admin.scratch-cards.edit', $card->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('admin.scratch-cards.destroy', $card->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Desativar esta raspadinha?')">Desativar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $cards->links() }}
</div>
@endsection

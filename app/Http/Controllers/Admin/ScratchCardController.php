<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScratchCard;

class ScratchCardController extends Controller
{
    // Listar todas as raspadinhas
    public function index()
    {
        $cards = ScratchCard::orderBy('id', 'desc')->paginate(20);
        return view('admin.scratch_cards.index', compact('cards'));
    }

    // Formulário de nova raspadinha
    public function create()
    {
        return view('admin.scratch_cards.create');
    }

    // Salvar nova raspadinha
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:255',
            'banner' => 'nullable|image',
            'image' => 'nullable|image',
            'price' => 'required|numeric|min:0',
            'max_prize' => 'required|max:255',
            'rtp' => 'required|numeric|min:0|max:100',
            'active' => 'boolean'
        ]);

        // Uploads
        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('scratch/banners', 'public');
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('scratch/images', 'public');
        }

        ScratchCard::create($data);

        return redirect()->route('admin.scratch_cards.index')->with('success', 'Raspadinha criada com sucesso!');
    }

    // Formulário de edição
    public function edit($id)
    {
        $card = ScratchCard::findOrFail($id);
        return view('admin.scratch_cards.edit', compact('card'));
    }

    // Atualizar raspadinha
    public function update(Request $request, $id)
    {
        $card = ScratchCard::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:255',
            'banner' => 'nullable|image',
            'image' => 'nullable|image',
            'price' => 'required|numeric|min:0',
            'max_prize' => 'required|max:255',
            'rtp' => 'required|numeric|min:0|max:100',
            'active' => 'boolean'
        ]);

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('scratch/banners', 'public');
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('scratch/images', 'public');
        }

        $card->update($data);

        return redirect()->route('admin.scratch_cards.index')->with('success', 'Raspadinha atualizada!');
    }

    // Desativar/Deletar raspadinha (soft delete)
    public function destroy($id)
    {
        $card = ScratchCard::findOrFail($id);
        $card->active = false;
        $card->save();

        return redirect()->route('admin.scratch_cards.index')->with('success', 'Raspadinha desativada!');
    }
}

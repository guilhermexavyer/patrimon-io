<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Método de listagem
    public function index(Request $request)
    {
        $query = Usuario::query()
            ->where('nr_sequencia', '!=', 1); // <-- Exclui o usuário com ID 1

        if ($request->filled('search')) {
            $term = $request->input('search');
            $query->where(function ($q) use ($term) {
                $q->where('ds_nome', 'LIKE', "%{$term}%")
                ->orWhere('ds_usuario', 'LIKE', "%{$term}%");
            });
        }

        $usuarios = $query->orderBy('nr_sequencia')->get();

        return view('usuarios.index', compact('usuarios'));
    }

    // Método de exibição da tela de cadastro
    public function create()
    {
        return view('usuarios.create');
    }

    // Método de cadastro
    public function store(Request $request)
    {
        $request->validate([
            'ds_nome' => 'required|string|max:255',
            'ds_usuario' => 'required|string|email|max:255|unique:usuarios,ds_usuario',
            'ds_senha' => 'required|string|min:6|confirmed',
            'ie_acesso' => 'required|in:A,P',
            'ie_status' => 'required|in:A,I',
            'ds_observacao' => 'nullable|string|max:1000',
        ]);

        $data = $request->only([
            'ds_nome',
            'ds_usuario',
            'ie_acesso',
            'ie_status',
            'ds_observacao',
        ]);

        $data['ds_senha'] = Hash::make($request->ds_senha);

        Usuario::create($data);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário criado com sucesso.');
    }

    // Método de exibição de detalhes
    public function show($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }

    // Método de exibição da tela de atualização
    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    // Método de atualização
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'ds_nome' => 'required|string|max:255',
            'ds_usuario' => 'required|string|email|max:255|unique:usuarios,ds_usuario,' . $usuario->nr_sequencia . ',nr_sequencia',
            'ds_senha' => 'nullable|string|min:6|confirmed',
            'ie_acesso' => 'required|in:A,P',
            'ie_status' => 'required|in:A,I',
            'ds_observacao' => 'nullable|string|max:1000',
        ]);

        $data = $request->only([
            'ds_nome',
            'ds_usuario',
            'ie_acesso',
            'ie_status',
            'ds_observacao',
        ]);

        if ($request->filled('ds_senha')) {
            $data['ds_senha'] = Hash::make($request->ds_senha);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário atualizado com sucesso.');
    }

    // Método de exclusão
    public function destroy($id)
    {
        Usuario::destroy($id);
        return redirect()->route('usuarios.index')->with('success', 'Usuário removido!');
    }
}
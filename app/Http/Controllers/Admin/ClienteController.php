<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::orderBy('fecha_registro', 'desc')->paginate(10);
        return view('admin.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('admin.clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|unique:clientes,email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'activo' => 'boolean',
        ]);

        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'password_hash' => Hash::make($request->password),
            'activo' => $request->activo ?? true,
        ]);

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente creado correctamente');
    }

    public function show(Cliente $cliente)
    {
        return view('admin.clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('admin.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('clientes')->ignore($cliente->cliente_id, 'cliente_id'),
            ],
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'activo' => 'boolean',
        ]);

        $updateData = [
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'activo' => $request->activo,
        ];

        if ($request->filled('password')) {
            $updateData['password_hash'] = Hash::make($request->password);
        }

        $cliente->update($updateData);

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente actualizado correctamente');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('admin.clientes.index')->with('success', 'Cliente eliminado correctamente');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContatoController extends Controller
{
    /**
     * Exibe o formulário de contato
     */
    public function index()
    {
        return view('contato.index'); // ajuste se seu formulário estiver em outro arquivo
    }

    /**
     * Envia o email de contato
     */
    public function enviar(Request $request)
    {
        // Validação dos dados
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'mensagem' => 'required|string|min:10',
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'sobrenome.required' => 'O campo sobrenome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'mensagem.required' => 'Por favor, escreva uma mensagem.',
            'mensagem.min' => 'A mensagem deve ter no mínimo 10 caracteres.',
        ]);

        // Dados para o email
        $dados = [
            'nome_completo' => $validated['nome'] . ' ' . $validated['sobrenome'],
            'email' => $validated['email'],
            'telefone' => $validated['telefone'] ?? 'Não informado',
            'mensagem' => $validated['mensagem'],
        ];

        try {
            // Envia o email usando a view Blade HTML
            Mail::send('contato.contato', $dados, function($message) use ($dados) {
                $message->to('eletrodescartebh@gmail.com')
                        ->subject('Nova Mensagem de Contato - Eletro Descarte')
                        ->replyTo($dados['email'], $dados['nome_completo']);
            });

            return back()->with('success', '✅ Mensagem enviada com sucesso! Entraremos em contato em breve.');

        } catch (\Exception $e) {
            return back()->with('error', '❌ Erro ao enviar mensagem. Por favor, tente novamente ou entre em contato diretamente pelo email.');
        }
    }
}

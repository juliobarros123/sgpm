<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Grupo;
use App\Models\Material;
use App\Models\Pedido;
use App\Models\PedidoHasMaterial;
use App\Models\Solicitante;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Criar Usuários reais (Solicitantes e Aprovadores)
        $solicitantes = collect([
            ['name' => 'João Silva', 'email' => 'joao.silva@example.com'],
            ['name' => 'Maria Oliveira', 'email' => 'maria.oliveira@example.com'],
            ['name' => 'Carlos Santos', 'email' => 'carlos.santos@example.com'],
            ['name' => 'Ana Souza', 'email' => 'ana.souza@example.com'],
            ['name' => 'Pedro Lima', 'email' => 'pedro.lima@example.com']
        ]);

        $aprovadores = collect([
            ['name' => 'Fernanda Costa', 'email' => 'fernanda.costa@example.com'],
            ['name' => 'Ricardo Mendes', 'email' => 'ricardo.mendes@example.com'],
            ['name' => 'Sofia Martins', 'email' => 'sofia.martins@example.com'],
            ['name' => 'André Ferreira', 'email' => 'andre.ferreira@example.com'],
            ['name' => 'Luciana Rocha', 'email' => 'luciana.rocha@example.com']
        ]);

        $solicitantes = $solicitantes->map(fn($user) => User::create(array_merge($user, [
            'password' => Hash::make('senha123'),
            'perfil' => 'solicitante'
        ])));

        $aprovadores = $aprovadores->map(fn($user) => User::create(array_merge($user, [
            'password' => Hash::make('senha123'),
            'perfil' => 'aprovador'
        ])));

        // Criar Grupos
        $grupos = collect([
            'Administração', 'Recursos Humanos', 'TI', 'Engenharia', 'Logística',
            'Compras', 'Vendas', 'Financeiro', 'Marketing', 'Jurídico'
        ])->map(fn($nome) => Grupo::create([
            'nome' => $nome,
            'saldo_permitido' => rand(50000, 100000),
            'aprovador_id' => $aprovadores->random()->id
        ]));

        // Associar Solicitantes aos Grupos
        $solicitantes->each(function ($solicitante) use ($grupos) {
            Solicitante::create([
                'usuario_id' => $solicitante->id,
                'grupo_id' => $grupos->random()->id
            ]);
        });

        // Criar Materiais reais
        $materiais = collect([
            ['nome' => 'Notebook Dell', 'preco' => 3500],
            ['nome' => 'Monitor LG 24"', 'preco' => 1200],
            ['nome' => 'Teclado Mecânico', 'preco' => 350],
            ['nome' => 'Mouse Sem Fio Logitech', 'preco' => 250],
            ['nome' => 'Cadeira Ergonômica', 'preco' => 900],
            ['nome' => 'Mesa de Escritório', 'preco' => 1500],
            ['nome' => 'Projetor Epson', 'preco' => 2800],
            ['nome' => 'Papel A4 (500 folhas)', 'preco' => 50],
            ['nome' => 'Toner HP', 'preco' => 400],
            ['nome' => 'Fone de Ouvido JBL', 'preco' => 500]
        ])->map(fn($material) => Material::create($material));

        // Criar Pedidos
        $statusOpcoes = ['novo', 'em_revisao', 'alteracoes_solicitadas', 'aprovado', 'rejeitado'];
        $pedidos = collect(range(1, 10))->map(fn() => Pedido::create([
            'total' => rand(100, 10000),
            'status' => $statusOpcoes[array_rand($statusOpcoes)],
            'solicitante_id' => $solicitantes->random()->id,
            'grupo_id' => $grupos->random()->id
        ]));

        // Associar Materiais aos Pedidos e Atualizar Saldo do Grupo
        foreach ($pedidos as $pedido) {
            $materiaisAssociados = $materiais->random(2);
            $totalPedido = 0;
            foreach ($materiaisAssociados as $material) {
                $quantidade = rand(1, 5);
                $subtotal = $material->preco * $quantidade;
                $totalPedido += $subtotal;

                PedidoHasMaterial::create([
                    'pedido_id' => $pedido->id,
                    'material_id' => $material->id,
                    'quantidade' => $quantidade,
                    'subtotal' => $subtotal
                ]);
            }

            // Atualizar saldo do grupo
            $grupo = Grupo::find($pedido->grupo_id);
            $novoSaldo = $grupo->saldo_permitido - $totalPedido;
            $grupo->update(['saldo_permitido' => $novoSaldo]);
        }
    }
}

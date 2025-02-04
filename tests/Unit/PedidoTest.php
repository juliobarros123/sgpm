<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Pedido;
use App\Models\Material;
use App\Models\User;
use App\Models\Grupo;
use App\Models\PedidoHasMaterial;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class PedidoTest extends TestCase
{
    // use RefreshDatabase;

    /** @test */
    public function novo_pedido()
    {
        
        DB::beginTransaction();
     
    
        try {
           
            $aprovador = User::create([
                'name' => 'Maria Oliveira',
                'email' => 'maria.oliveira@empresa.com',
                'password' => bcrypt('senhaReal123'),
                'perfil' => 'aprovador',
            ]);
    
            
            $solicitante = User::create([
                'name' => 'João Silva',
                'email' => 'joao.silva@empresa.com',
                'password' => bcrypt('senhaReal123'),
                'perfil' => 'solicitante',
            ]);
    
           
            $this->assertNotNull($aprovador->id);
            $this->assertNotNull($solicitante->id);
    
            // Criando grupo
            $grupo = Grupo::create([
                'nome' => 'Grupo A - Engenharia',
                'saldo_permitido' => 20000,
                'aprovador_id' => $aprovador->id
            ]);
    
         
            $material1 = Material::create(['nome' => 'Cimento 50kg', 'preco' => 25.50]);
            $material2 = Material::create(['nome' => 'Areia 1m³', 'preco' => 150.00]);
    
        
            $this->assertNotNull($material1->id);
            $this->assertNotNull($material2->id);
    
            $this->actingAs($solicitante);
    
        
            $pedido = Pedido::create([
                'solicitante_id' => $solicitante->id,
                'grupo_id' => $grupo->id,
                'total' => ($material1->preco * 2) + ($material2->preco * 3),
                'status' => 'novo',
            ]);
    
           
            PedidoHasMaterial::create([
                'pedido_id' => $pedido->id,
                'material_id' => $material1->id,
                'quantidade' => 2,
                'subtotal' => $material1->preco * 2,
            ]);
    
            PedidoHasMaterial::create([
                'pedido_id' => $pedido->id,
                'material_id' => $material2->id,
                'quantidade' => 3,
                'subtotal' => $material2->preco * 3,
            ]);
    
            $this->assertEquals(501.00, $pedido->total);
            $this->assertEquals('novo', $pedido->status);
    
      
    
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }
    
}

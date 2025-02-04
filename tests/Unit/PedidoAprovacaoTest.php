<?php


use App\Models\Pedido;
use Tests\TestCase;

class PedidoAprovacaoTest extends TestCase
{

    /** @test */
    public function aprovacao_pedido()
    {
        $this->withoutMiddleware();
        $pedido = Pedido::first();


        $this->assertNotNull($pedido);

        $pedido->status = 'aprovado';
        $pedido->save();


        $this->assertEquals($pedido->status, 'aprovado');
    }
}

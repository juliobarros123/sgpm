<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class DashboardComponent extends Component
{
    public $qtp_aprovados, $qt_pedidos, $qtp_rejeitados,$qtp_revisao,$novo;
    public function render()
    {
        $this->qt_pedidos = fhna_pedidos()->count();
        $this->qtp_aprovados = fhna_pedidos()->where('pedidos.status', 'aprovado')->count();
        $this->qtp_rejeitados = fhna_pedidos()->where('pedidos.status', 'rejeitado')->count();
        $this->qtp_revisao = fhna_pedidos()->where('pedidos.status', 'em_revisao')->count();
        $this->novo = fhna_pedidos()->where('pedidos.status', 'novo')->count();
        return view(view: 'livewire.admin.dashboard-component');
        
    }
}

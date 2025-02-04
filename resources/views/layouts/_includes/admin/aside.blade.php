<div class="sidebar-wrapper">
    <div class="logo">
        <a href="" class="simple-text">
            GESTÃO DE PEDIDOS
        </a>
    </div>

    <ul class="nav">
        @if (Auth::user()->perfil == 'aprovador')
            <li class="active">
                <a href="{{ url('dashboard') }}">
                    <i class="ti-dashboard"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li>
                <a href="{{ route('usuarios.index') }}">
                    <i class="ti-user"></i>
                    <p>Usuários</p>
                </a>
            </li>
            <li>
                <a href="{{ route('materiais.index') }}">
                    <i class="ti-package"></i>
                    <p>Materiais</p>
                </a>
            </li>
            <li>
                <a href="{{ route('grupos.index') }}">
                    <i class="ti-gift"></i>
                    <p>Grupos</p>
                </a>
            </li>
        @endif
        <li>
            <a href="{{ route('pedidos.index') }}">
                <i class="ti-bag"></i>
                <p>Pedidos</p>
            </a>
        </li>

        <li class="active-pro active">

            <a lass="dropdown-item"  href="#" 
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="ti-power-off"></i> <p>TERMINAR SESSÃO</p>
         </a>
         
         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
             @csrf
         </form>
       
        </li>

    </ul>
</div>

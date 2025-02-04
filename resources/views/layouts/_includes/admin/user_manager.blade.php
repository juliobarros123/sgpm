<div class="collapse navbar-collapse">
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="display: flex; align-items: center;">
                <div class="avatar-circle" style="margin-right: 10px;">
                    <span class="initials">
                        @auth
                            <?php
                                $nameParts = explode(' ', Auth::user()->name);
                                $firstInitial = strtoupper(substr($nameParts[0], 0, 1)); // Inicial do primeiro nome
                                $lastInitial = strtoupper(substr(end($nameParts), 0, 1)); // Inicial do último nome
                                echo $firstInitial . $lastInitial;
                            ?>
                        @endauth
                    </span>
                </div>
                <p style="margin: 0;">
                    @auth
                        {{ Auth::user()->name }}
                    @endauth
                </p>
            </a>
        </li>
       
{{-- 
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="ti-settings"></i>
                <p>Definições</p>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <li>
                    <a href="#">
                        <i class="ti-settings"></i> Configurações
                    </a>
                </li> 

                <li>
                 
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a href="{{ route('logout') }}"  class="dropdown-item" onclick="event.preventDefault();
                        this.closest('form').submit();"><i class="ti-power-off"></i>
                        Terminar Sessão
                    </a>
                    </form>
        
                </li>

            </ul>
        </li> --}}

    </ul>

</div>

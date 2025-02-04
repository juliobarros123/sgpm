<!doctype html>
<html lang="en">

@include('layouts._includes.admin.head')

<body>
    <div class="wrapper">
        <div class="sidebar" data-background-color="white" data-active-color="danger">
            @include('layouts._includes.admin.aside')
        </div>

        <div class="main-panel">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar bar1"></span>
                            <span class="icon-bar bar2"></span>
                            <span class="icon-bar bar3"></span>
                        </button>
                        <a class="navbar-brand" href="#">Dashboard</a>
                    </div>

                    @include('layouts._includes.admin.user_manager')
                </div>
            </nav>
            @yield('conteudo')

            @include('layouts._includes.admin.footer')

        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            demo.initChartist();

           
        });
    </script>



    @livewireScripts
    {{-- @stack('scripts') --}}
</body>

</html>

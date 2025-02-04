<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Painel de Controle</title>
    
    <link rel="stylesheet" href="{{asset('assets/auth/tailwind.min.css')}}" />

    <style>
        .login-container {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        }
        .glass-effect {
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(209, 213, 219, 0.3);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .dark .glass-effect {
            background-color: rgba(17, 24, 39, 0.98);
        }
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>

<body class="antialiased">
    <div class="login-container min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo Container -->
            <div class="floating text-center">
                <div class="bg-white dark:bg-gray-800 rounded-full p-3 inline-block shadow-md">
                    <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>

            <!-- Login Form Container -->
            <div class="glass-effect rounded-2xl px-8 py-10">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                        Seja bem-vindo
                    </h1>
                    <p class="mt-3 text-gray-600 dark:text-gray-400">
                        Faça login para acessar sua conta
                    </p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            E-mail
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input
                                class="block w-full pl-10 pr-4 py-3 border-gray-300 rounded-lg focus:ring-blue-400 focus:border-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-colors"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                placeholder="seu@email.com"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Senha
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input
                                class="block w-full pl-10 pr-4 py-3 border-gray-300 rounded-lg focus:ring-blue-400 focus:border-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-colors"
                                type="password"
                                name="password"
                                required
                                placeholder="••••••••"
                            />
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                class="h-4 w-4 text-blue-400 focus:ring-blue-400 border-gray-300 rounded cursor-pointer"
                                id="remember_me"
                                name="remember"
                            />
                            <label for="remember_me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                                Lembrar-me
                            </label>
                        </div>

                        {{-- <a href="#" class="text-sm font-medium text-blue-500 hover:text-blue-400 dark:text-blue-400">
                            Esqueceu a senha?
                        </a> --}}
                    </div>

                    <button
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 transition-colors"
                    >
                        Entrar
                    </button>
                </form>

                {{-- <div class="mt-6 text-center text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Ainda não tem uma conta?</span>
                    <a href="#" class="font-medium text-blue-500 hover:text-blue-400 dark:text-blue-400 ml-1">
                        Cadastre-se
                    </a>
                </div> --}}
            </div>
        </div>
    </div>

    <script src="assets/js/sweetalert2.all.min.js"></script>
    
    @if (old('email'))
    <script>
        Swal.fire({
                title: 'Credenciais Inválidas',
                text: 'Por favor, verifique suas informações e tente novamente.',
                icon: 'error',
                confirmButtonColor: '#60A5FA'
            });
    </script>
@endif
</body>
</html>
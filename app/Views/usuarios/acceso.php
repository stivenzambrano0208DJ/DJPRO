<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<section class="min-h-[calc(100vh-80px)] flex items-center justify-center p-4">
    <div class="max-w-5xl w-full bg-djpro-surface rounded-3xl border border-djpro-border overflow-hidden shadow-2xl flex flex-col md:row h-full md:h-[700px] md:flex-row">
        
        <!-- Panel Izquierdo (Visual) -->
        <div class="hidden md:flex md:w-2/5 relative overflow-hidden group">
            <img src="https://images.unsplash.com/photo-1516280440614-37939bbacd81?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                 class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="Login Visual">
            <div class="absolute inset-0 bg-gradient-to-t from-djpro-bg via-djpro-bg/40 to-transparent"></div>
            
            <div class="absolute inset-0 p-12 flex flex-col justify-end">
                <div class="mb-6">
                    <div class="w-12 h-12 bg-djpro-accent rounded-lg flex items-center justify-center mb-4">
                        <i class="bi bi-headphones text-white text-2xl"></i>
                    </div>
                    <h2 class="text-5xl font-bebas text-white tracking-wider leading-none">ÚNETE A LA <br><span class="text-djpro-accent text-6xl">ELITE</span></h2>
                </div>
                <p class="text-djpro-muted font-light tracking-wide italic">"La música es el lenguaje universal de la humanidad."</p>
            </div>
        </div>

        <!-- Panel Derecho (Formularios) -->
        <div class="w-full md:w-3/5 p-8 md:p-16 overflow-y-auto custom-scrollbar">
            
            <!-- Tabs / Selector de Modo -->
            <div class="flex bg-djpro-surface-2 p-1 rounded-2xl mb-10">
                <button id="tab-login" class="flex-1 py-3 rounded-xl font-bold transition-all bg-djpro-accent text-white shadow-lg shadow-orange-500/20">Iniciar Sesión</button>
                <button id="tab-register" class="flex-1 py-3 rounded-xl font-bold transition-all text-djpro-muted hover:text-white">Registrarse</button>
            </div>

            <!-- Formulario Login -->
            <div id="form-login" class="space-y-6">
                <div>
                    <h3 class="text-3xl font-bebas text-white mb-2">Bienvenido de nuevo</h3>
                    <p class="text-djpro-muted text-sm">Ingresa tus credenciales para continuar.</p>
                </div>

                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-djpro-text uppercase tracking-widest ml-1">Email</label>
                        <div class="relative">
                            <i class="bi bi-envelope absolute left-4 top-1/2 -translate-y-1/2 text-djpro-muted"></i>
                            <input type="email" placeholder="ejemplo@djpro.com" class="input-djpro w-full pl-12" maxlength="30">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center px-1">
                            <label class="text-sm font-bold text-djpro-text uppercase tracking-widest">Contraseña</label>
                            <a href="#" class="text-xs text-djpro-accent font-bold hover:underline">¿Olvidaste tu contraseña?</a>
                        </div>
                        <div class="relative">
                            <i class="bi bi-lock absolute left-4 top-1/2 -translate-y-1/2 text-djpro-muted"></i>
                            <input type="password" placeholder="••••••••" class="input-djpro w-full pl-12" maxlength="30">
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 ml-1">
                    <input type="checkbox" id="remember" class="w-5 h-5 rounded border-djpro-border bg-djpro-surface-2 text-djpro-accent focus:ring-djpro-accent focus:ring-offset-djpro-surface">
                    <label for="remember" class="text-sm text-djpro-muted font-medium cursor-pointer">Recordarme en este equipo</label>
                </div>

                <button class="btn-djpro-primary w-full py-4 text-lg">ENTRAR AHORA</button>

                <div class="relative py-4">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-djpro-border"></div></div>
                    <div class="relative flex justify-center text-xs uppercase"><span class="bg-djpro-surface px-4 text-djpro-muted font-bold tracking-widest">O continúa con</span></div>
                </div>

                <button class="w-full py-4 bg-white text-black font-bold rounded-2xl flex items-center justify-center gap-3 hover:bg-gray-100 transition-all">
                    <i class="bi bi-google text-xl"></i>
                    Google Account
                </button>
            </div>

            <!-- Formulario Registro (Oculto por defecto) -->
            <div id="form-register" class="hidden space-y-6">
                <div>
                    <h3 class="text-3xl font-bebas text-white mb-2">Crea tu cuenta</h3>
                    <p class="text-djpro-muted text-sm">Únete a la plataforma musical más grande del Caquetá.</p>
                </div>

                <!-- Selector de Rol -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <label class="cursor-pointer group">
                        <input type="radio" name="rol" value="cliente" class="hidden peer" checked>
                        <div class="p-4 border-2 border-djpro-border rounded-2xl bg-djpro-surface-2 text-center group-hover:border-djpro-accent/50 peer-checked:border-djpro-accent peer-checked:bg-djpro-accent/10 transition-all">
                            <i class="bi bi-person-heart text-2xl text-djpro-muted peer-checked:text-djpro-accent mb-2 block"></i>
                            <span class="font-bold text-sm block">SOY CLIENTE</span>
                        </div>
                    </label>
                    <label class="cursor-pointer group">
                        <input type="radio" name="rol" value="dj" class="hidden peer">
                        <div class="p-4 border-2 border-djpro-border rounded-2xl bg-djpro-surface-2 text-center group-hover:border-djpro-accent/50 peer-checked:border-djpro-accent peer-checked:bg-djpro-accent/10 transition-all">
                            <i class="bi bi-headphones text-2xl text-djpro-muted peer-checked:text-djpro-accent mb-2 block"></i>
                            <span class="font-bold text-sm block">SOY DJ</span>
                        </div>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-djpro-text uppercase tracking-widest ml-1">Nombre</label>
                        <input type="text" placeholder="Juan Pérez" class="input-djpro w-full" maxlength="30">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-djpro-text uppercase tracking-widest ml-1">Email</label>
                        <input type="email" placeholder="juan@ejemplo.com" class="input-djpro w-full" maxlength="30">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-djpro-text uppercase tracking-widest ml-1">Contraseña</label>
                        <input type="password" placeholder="••••••••" class="input-djpro w-full" maxlength="30">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-djpro-text uppercase tracking-widest ml-1">Confirmar</label>
                        <input type="password" placeholder="••••••••" class="input-djpro w-full" maxlength="30">
                    </div>
                </div>

                <button class="btn-djpro-primary w-full py-4 text-lg">CREAR MI CUENTA</button>
            </div>

        </div>
    </div>
</section>

<script>
    const tabLogin = document.getElementById('tab-login');
    const tabRegister = document.getElementById('tab-register');
    const formLogin = document.getElementById('form-login');
    const formRegister = document.getElementById('form-register');

    tabLogin.addEventListener('click', () => {
        tabLogin.classList.add('bg-djpro-accent', 'text-white', 'shadow-lg', 'shadow-orange-500/20');
        tabLogin.classList.remove('text-djpro-muted');
        tabRegister.classList.remove('bg-djpro-accent', 'text-white', 'shadow-lg', 'shadow-orange-500/20');
        tabRegister.classList.add('text-djpro-muted');
        formLogin.classList.remove('hidden');
        formRegister.classList.add('hidden');
    });

    tabRegister.addEventListener('click', () => {
        tabRegister.classList.add('bg-djpro-accent', 'text-white', 'shadow-lg', 'shadow-orange-500/20');
        tabRegister.classList.remove('text-djpro-muted');
        tabLogin.classList.remove('bg-djpro-accent', 'text-white', 'shadow-lg', 'shadow-orange-500/20');
        tabLogin.classList.add('text-djpro-muted');
        formRegister.classList.remove('hidden');
        formLogin.classList.add('hidden');
    });
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

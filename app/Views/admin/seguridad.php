<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<div class="flex">
    <?php 
        $activePage = 'seguridad';
        require APPROOT . '/app/Views/inc/admin_sidebar.php'; 
    ?>

    <!-- Main Content -->
    <div class="flex-1 p-8 overflow-y-auto custom-scrollbar h-[calc(100vh-80px)] bg-djpro-bg">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
                <div>
                    <h1 class="text-4xl font-bebas text-white tracking-widest uppercase">SEGURIDAD <span class="text-djpro-accent">& CREDENCIALES</span></h1>
                    <p class="text-djpro-muted text-xs font-bold uppercase tracking-widest mt-2">Control Maestro de Acceso para DJs</p>
                </div>
                <div class="bg-red-500/10 border border-red-500/20 px-6 py-4 rounded-2xl flex items-center gap-4">
                    <i class="bi bi-shield-lock-fill text-red-500 text-2xl"></i>
                    <div>
                        <span class="block text-white text-[10px] font-bold uppercase tracking-widest">Zona de Alto Privilegio</span>
                        <span class="text-red-500 text-[9px] uppercase font-bold tracking-tighter italic">Cualquier cambio es inmediato y permanente</span>
                    </div>
                </div>
            </div>

            <!-- Grid de Tarjetas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach($data['djs'] as $dj): ?>
                <div class="bg-djpro-surface rounded-3xl border border-djpro-border p-8 shadow-2xl relative group overflow-hidden">
                    <!-- Glow effect -->
                    <div class="absolute -top-10 -right-10 w-24 h-24 bg-djpro-accent/5 blur-3xl group-hover:bg-djpro-accent/15 transition-all"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-djpro-accent/10 border border-djpro-accent/20 rounded-xl flex items-center justify-center text-djpro-accent font-bebas text-xl">
                                <?php echo strtoupper(substr($dj->nombre, 0, 1)); ?>
                            </div>
                            <div>
                                <h3 class="text-white font-bold uppercase tracking-wider text-sm"><?php echo $dj->nombre; ?></h3>
                                <span class="text-[9px] text-djpro-muted font-bold tracking-widest">DJ ID: #<?php echo $dj->id; ?></span>
                            </div>
                        </div>

                        <form action="<?php echo URL_ROOT; ?>/admin/actualizar_credenciales" method="POST" class="space-y-5">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="usuario_id" value="<?php echo $dj->id; ?>">
                            
                            <!-- Username -->
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-bold text-djpro-muted uppercase tracking-widest ml-1">Username Público</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-djpro-accent font-bold">@</span>
                                    <input type="text" name="username" maxlength="30" value="<?php echo $dj->username; ?>" 
                                           class="w-full bg-djpro-bg border border-djpro-border rounded-xl pl-8 pr-4 py-3 text-xs text-white focus:border-djpro-accent outline-none transition-all" required>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-bold text-djpro-muted uppercase tracking-widest ml-1">Correo Electrónico</label>
                                <input type="email" name="correo" maxlength="30" value="<?php echo $dj->correo; ?>" 
                                       class="w-full bg-djpro-bg border border-djpro-border rounded-xl px-4 py-3 text-xs text-white focus:border-djpro-accent outline-none transition-all" required>
                            </div>

                            <!-- Password -->
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-bold text-djpro-muted uppercase tracking-widest ml-1 flex justify-between">
                                    Nueva Contraseña
                                    <button type="button" onclick="generatePass('pass-<?php echo $dj->id; ?>')" class="text-djpro-accent hover:text-white transition-colors lowercase italic font-normal">[ Generar clave ]</button>
                                </label>
                                <div class="relative">
                                    <input type="password" id="pass-<?php echo $dj->id; ?>" name="password" placeholder="••••••••"
                                           class="w-full bg-djpro-bg border border-djpro-border rounded-xl px-4 py-3 text-xs text-white focus:border-djpro-accent outline-none transition-all">
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 flex gap-2">
                                        <button type="button" onclick="copyToClipboard('pass-<?php echo $dj->id; ?>')" class="text-djpro-muted hover:text-white transition-colors p-1" title="Copiar">
                                            <i class="bi bi-clipboard"></i>
                                        </button>
                                        <button type="button" onclick="togglePass('pass-<?php echo $dj->id; ?>')" class="text-djpro-muted hover:text-white transition-colors p-1" title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="text-[8px] text-djpro-muted italic">* Dejar en blanco para mantener la actual</span>
                            </div>

                            <button type="submit" class="w-full bg-djpro-surface-2 border border-djpro-border hover:border-djpro-accent hover:text-white text-djpro-muted py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all mt-4">
                                Actualizar Credenciales
                            </button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
function togglePass(id) {
    const input = document.getElementById(id);
    const icon = input.nextElementSibling.querySelector('.bi-eye, .bi-eye-slash');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

function generatePass(id) {
    const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
    let pass = "";
    for (let i = 0; i < 10; i++) {
        pass += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    const input = document.getElementById(id);
    input.value = pass;
    input.type = "text"; // Mostrarla al generar
}

function copyToClipboard(id) {
    const input = document.getElementById(id);
    if (!input.value) return;
    input.select();
    document.execCommand("copy");
    
    // Feedback visual
    const btn = input.nextElementSibling.querySelector('.bi-clipboard');
    btn.classList.replace('bi-clipboard', 'bi-check-lg');
    setTimeout(() => btn.classList.replace('bi-check-lg', 'bi-clipboard'), 2000);
}
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

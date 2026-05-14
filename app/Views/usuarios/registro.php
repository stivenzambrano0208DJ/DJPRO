<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<section class="min-h-[calc(100vh-80px)] flex items-center justify-center p-4">
    <div class="max-w-5xl w-full bg-djpro-surface rounded-3xl border border-djpro-border overflow-hidden shadow-2xl flex flex-col md:row h-full md:h-[700px] md:flex-row">
        
        <!-- Lado Visual -->
        <div class="hidden md:flex w-1/2 relative bg-gradient-to-br from-djpro-purple/20 to-djpro-accent/20 items-center justify-center p-12 order-last md:order-none">
            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
            <div class="relative z-10 text-center">
                <div class="w-24 h-24 bg-djpro-purple rounded-2xl flex items-center justify-center mx-auto mb-8 -rotate-12 shadow-[0_0_50px_rgba(124,58,237,0.4)]">
                    <i class="bi bi-stars text-5xl text-white"></i>
                </div>
                <h2 class="text-5xl font-bebas text-white tracking-widest mb-4">ÚNETE A <span class="text-djpro-purple">DJPRO</span></h2>
                <p class="text-djpro-muted font-medium text-lg leading-relaxed">Crea tu cuenta en segundos y empieza a vibrar con la mejor música.</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <div class="mb-8 text-center md:text-left">
                <h3 class="text-4xl font-bebas text-white tracking-wider mb-2 uppercase">Crear Cuenta</h3>
                <p class="text-djpro-muted font-bold tracking-widest text-[10px] uppercase">Tu acceso VIP al entretenimiento nocturno.</p>
            </div>

            <?php if(!empty($data['error'])): ?>
                <div class="bg-red-500/10 border border-red-500/20 text-red-500 p-4 rounded-xl mb-6 flex items-center gap-3">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span class="text-xs font-bold uppercase tracking-wide"><?php echo $data['error']; ?></span>
                </div>
            <?php endif; ?>

            <form action="<?php echo URL_ROOT; ?>/usuarios/registro" method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Nombre Completo</label>
                        <input type="text" name="nombre" value="<?php echo $data['nombre']; ?>" placeholder="Ej: Steven Mix" class="input-djpro w-full" required>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-djpro-accent uppercase tracking-widest ml-1">Username (ID Público)</label>
                        <input type="text" name="username" value="<?php echo $data['username']; ?>" placeholder="stiven_mix_2026" class="input-djpro w-full border-djpro-accent/30" required pattern="[a-zA-Z0-9_]+" title="Solo letras, números y guiones bajos (sin espacios ni emojis)">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Correo Electrónico</label>
                    <input type="email" name="correo" value="<?php echo $data['correo']; ?>" placeholder="tu@ejemplo.com" class="input-djpro w-full" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Contraseña</label>
                        <input type="password" name="password" placeholder="••••••••" class="input-djpro w-full" required>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Confirmar</label>
                        <input type="password" name="confirm_password" placeholder="••••••••" class="input-djpro w-full" required>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">¿Qué perfil buscas?</label>
                    <div class="flex gap-4">
                        <label class="flex-1 cursor-pointer group">
                            <input type="radio" name="rol" value="cliente" class="hidden peer" <?php echo $data['rol'] == 'cliente' ? 'checked' : ''; ?>>
                            <div class="p-4 border border-djpro-border rounded-xl text-center peer-checked:bg-djpro-purple/10 peer-checked:border-djpro-purple transition-all">
                                <i class="bi bi-person-heart text-2xl text-djpro-muted group-hover:text-djpro-purple peer-checked:text-djpro-purple block mb-1"></i>
                                <span class="text-[9px] font-bold text-djpro-muted peer-checked:text-white uppercase tracking-widest">Soy Cliente</span>
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer group">
                            <input type="radio" name="rol" value="dj" class="hidden peer" <?php echo $data['rol'] == 'dj' ? 'checked' : ''; ?>>
                            <div class="p-4 border border-djpro-border rounded-xl text-center peer-checked:bg-djpro-accent/10 peer-checked:border-djpro-accent transition-all">
                                <i class="bi bi-headphones text-2xl text-djpro-muted group-hover:text-djpro-accent peer-checked:text-djpro-accent block mb-1"></i>
                                <span class="text-[9px] font-bold text-djpro-muted peer-checked:text-white uppercase tracking-widest">Soy DJ</span>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-djpro-primary w-full py-4 text-xl tracking-widest mt-6">
                    REGISTRARME <i class="bi bi-person-plus-fill ml-1"></i>
                </button>
            </form>

            <div class="mt-8 text-center border-t border-djpro-border pt-6">
                <p class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest">
                    ¿Ya tienes una cuenta? 
                    <a href="<?php echo URL_ROOT; ?>/usuarios/login" class="text-djpro-accent hover:underline ml-2">INICIAR SESIÓN</a>
                </p>
            </div>
        </div>
    </div>
</section>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

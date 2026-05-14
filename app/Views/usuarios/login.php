<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<section class="min-h-[calc(100vh-80px)] flex items-center justify-center p-4">
    <div class="max-w-5xl w-full bg-djpro-surface rounded-3xl border border-djpro-border overflow-hidden shadow-2xl flex flex-col md:row h-full md:h-[600px] md:flex-row">
        
        <!-- Lado Visual -->
        <div class="hidden md:flex w-1/2 relative bg-gradient-to-br from-djpro-accent/20 to-djpro-purple/20 items-center justify-center p-12">
            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
            <div class="relative z-10 text-center">
                <div class="w-24 h-24 bg-djpro-accent rounded-2xl flex items-center justify-center mx-auto mb-8 rotate-12 shadow-[0_0_50px_rgba(249,115,22,0.4)]">
                    <i class="bi bi-headset text-5xl text-white"></i>
                </div>
                <h2 class="text-5xl font-bebas text-white tracking-widest mb-4">ENTRA AL <span class="text-djpro-accent">BEAT</span></h2>
                <p class="text-djpro-muted font-medium text-lg leading-relaxed">Accede a la plataforma líder para contratar DJs en el Caquetá.</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="w-full md:w-1/2 p-8 md:p-16 flex flex-col justify-center">
            <div class="mb-10 text-center md:text-left">
                <h3 class="text-4xl font-bebas text-white tracking-wider mb-2 uppercase">Iniciar Sesión</h3>
                <p class="text-djpro-muted font-bold tracking-widest text-[10px] uppercase">¡Bienvenido de nuevo a la energía!</p>
            </div>

            <?php if(!empty($data['error'])): ?>
                <div class="bg-red-500/10 border border-red-500/20 text-red-500 p-4 rounded-xl mb-6 flex items-center gap-3">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span class="text-xs font-bold uppercase tracking-wide"><?php echo $data['error']; ?></span>
                </div>
            <?php endif; ?>

            <form action="<?php echo URL_ROOT; ?>/usuarios/login" method="POST" class="space-y-6">
                <input type="hidden" name="redirect" value="<?php echo $data['redirect']; ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Correo Electrónico</label>
                    <div class="relative">
                        <i class="bi bi-envelope absolute left-4 top-1/2 -translate-y-1/2 text-djpro-muted"></i>
                        <input type="email" name="correo" value="<?php echo $data['correo']; ?>" placeholder="tu@ejemplo.com" class="input-djpro w-full pl-12" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest">Contraseña</label>
                        <a href="<?php echo URL_ROOT; ?>/usuarios/recuperar" class="text-[9px] font-bold text-djpro-accent uppercase tracking-widest hover:underline">¿Olvidaste tu contraseña?</a>
                    </div>
                    <div class="relative">
                        <i class="bi bi-lock absolute left-4 top-1/2 -translate-y-1/2 text-djpro-muted"></i>
                        <input type="password" name="password" placeholder="••••••••" class="input-djpro w-full pl-12" required>
                    </div>
                </div>

                <button type="submit" class="btn-djpro-primary w-full py-4 text-xl tracking-widest mt-4">
                    ENTRAR <i class="bi bi-arrow-right-short ml-1"></i>
                </button>
            </form>

            <div class="mt-10 text-center border-t border-djpro-border pt-8">
                <p class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest">
                    ¿No tienes una cuenta? 
                    <a href="<?php echo URL_ROOT; ?>/usuarios/registro" class="text-djpro-accent hover:underline ml-2">REGÍSTRATE AQUÍ</a>
                </p>
            </div>
        </div>
    </div>
</section>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

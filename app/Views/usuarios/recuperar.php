<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<div class="min-h-[calc(100vh-80px)] flex items-center justify-center py-20 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
            <!-- Card -->
            <div class="bg-djpro-surface border border-djpro-border rounded-3xl p-8 md:p-12 shadow-2xl relative overflow-hidden group">
                <!-- Abstract Glow -->
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-djpro-accent/20 blur-3xl rounded-full group-hover:bg-djpro-accent/30 transition-all duration-700"></div>
                
                <div class="relative">
                    <!-- Header -->
                    <div class="text-center mb-10">
                        <div class="w-20 h-20 bg-djpro-accent/10 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-djpro-accent/20">
                            <i class="bi bi-shield-lock text-djpro-accent text-4xl"></i>
                        </div>
                        <h1 class="text-4xl font-bebas text-white tracking-widest mb-3 uppercase">RECUPERAR CUENTA</h1>
                        <p class="text-djpro-muted text-sm leading-relaxed">Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
                    </div>

                    <!-- Form -->
                    <form action="<?php echo URL_ROOT; ?>/usuarios/recuperar" method="POST" class="space-y-6">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-djpro-accent uppercase tracking-widest ml-1">Correo Electrónico</label>
                            <div class="relative">
                                <i class="bi bi-envelope absolute left-4 top-1/2 -translate-y-1/2 text-djpro-muted"></i>
                                <input type="email" name="correo" required placeholder="tu@email.com" 
                                    class="input-djpro w-full pl-12 py-4 text-sm border-djpro-accent/30" maxlength="100">
                            </div>
                        </div>

                        <button type="submit" class="btn-djpro-primary w-full py-4 rounded-xl flex items-center justify-center gap-3 group">
                            <span>ENVIAR ENLACE</span>
                            <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>

                    <!-- Footer Link -->
                    <div class="mt-10 text-center border-t border-djpro-border pt-8">
                        <p class="text-djpro-muted text-xs">
                            ¿Recordaste tu contraseña? 
                            <a href="<?php echo URL_ROOT; ?>/usuarios/login" class="text-djpro-accent font-bold hover:underline ml-1">VOLVER AL LOGIN</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

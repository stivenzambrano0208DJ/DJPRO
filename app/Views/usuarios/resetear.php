<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<div class="min-h-[calc(100vh-80px)] flex items-center justify-center py-20 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
            <!-- Card -->
            <div class="bg-djpro-surface border border-djpro-border rounded-3xl p-8 md:p-12 shadow-2xl relative overflow-hidden group">
                <!-- Abstract Glow -->
                <div class="absolute -top-24 -left-24 w-48 h-48 bg-djpro-accent/20 blur-3xl rounded-full group-hover:bg-djpro-accent/30 transition-all duration-700"></div>
                
                <div class="relative">
                    <!-- Header -->
                    <div class="text-center mb-10">
                        <div class="w-20 h-20 bg-djpro-accent/10 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-djpro-accent/20">
                            <i class="bi bi-key text-djpro-accent text-4xl"></i>
                        </div>
                        <h1 class="text-4xl font-bebas text-white tracking-widest mb-3 uppercase">NUEVA CONTRASEÑA</h1>
                        <p class="text-djpro-muted text-sm leading-relaxed">Crea una contraseña segura para proteger tu cuenta de DJPRO.</p>
                    </div>

                    <?php if(!empty($data['error'])): ?>
                        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-500 text-xs font-bold uppercase tracking-widest flex items-center gap-3">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <?php echo $data['error']; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form action="<?php echo URL_ROOT; ?>/usuarios/resetear/<?php echo $data['token']; ?>" method="POST" class="space-y-6">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-djpro-accent uppercase tracking-widest ml-1">Nueva Contraseña</label>
                            <div class="relative">
                                <i class="bi bi-lock absolute left-4 top-1/2 -translate-y-1/2 text-djpro-muted"></i>
                                <input type="password" name="password" required placeholder="Mínimo 8 caracteres" 
                                    class="input-djpro w-full pl-12 py-4 text-sm">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-djpro-accent uppercase tracking-widest ml-1">Confirmar Contraseña</label>
                            <div class="relative">
                                <i class="bi bi-lock-fill absolute left-4 top-1/2 -translate-y-1/2 text-djpro-muted"></i>
                                <input type="password" name="confirm_password" required placeholder="Repite tu contraseña" 
                                    class="input-djpro w-full pl-12 py-4 text-sm">
                            </div>
                        </div>

                        <button type="submit" class="btn-djpro-primary w-full py-4 rounded-xl flex items-center justify-center gap-3 group">
                            <span>CAMBIAR CONTRASEÑA</span>
                            <i class="bi bi-check-circle group-hover:scale-110 transition-transform"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

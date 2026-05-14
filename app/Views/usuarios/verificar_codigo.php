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
                            <i class="bi bi-shield-check text-djpro-accent text-4xl"></i>
                        </div>
                        <h1 class="text-4xl font-bebas text-white tracking-widest mb-3 uppercase">VERIFICAR CÓDIGO</h1>
                        <p class="text-djpro-muted text-sm leading-relaxed">Hemos enviado un código de 6 dígitos a <br><span class="text-white font-bold"><?php echo $_SESSION['recuperar_email']; ?></span></p>
                    </div>

                    <?php if(!empty($data['error'])): ?>
                        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-500 text-xs font-bold uppercase tracking-widest flex items-center gap-3">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <?php echo $data['error']; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form action="<?php echo URL_ROOT; ?>/usuarios/verificar_codigo" method="POST" class="space-y-8">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        
                        <!-- Inputs de Código -->
                        <div class="flex justify-between gap-2 md:gap-4">
                            <?php for($i=0; $i<6; $i++): ?>
                                <input type="text" name="codigo[]" maxlength="1" 
                                    class="code-input w-12 h-16 md:w-14 md:h-20 bg-djpro-surface-2 border-2 border-djpro-border rounded-xl text-center text-2xl font-bold text-white focus:border-djpro-accent focus:outline-none transition-all shadow-lg"
                                    required autocomplete="off">
                            <?php endfor; ?>
                        </div>

                        <button type="submit" class="btn-djpro-primary w-full py-4 rounded-xl flex items-center justify-center gap-3 group">
                            <span>VERIFICAR CÓDIGO</span>
                            <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>

                    <!-- Footer Link -->
                    <div class="mt-10 text-center border-t border-djpro-border pt-8">
                        <p class="text-djpro-muted text-xs">
                            ¿No recibiste el código? 
                            <a href="<?php echo URL_ROOT; ?>/usuarios/recuperar" class="text-djpro-accent font-bold hover:underline ml-1 uppercase">Reenviar</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Lógica para saltar entre inputs
    const inputs = document.querySelectorAll('.code-input');
    
    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (e.target.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                inputs[index - 1].focus();
            }
        });

        // Soporte para pegar el código completo
        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasteData = e.clipboardData.getData('text').slice(0, 6);
            if (!/^\d+$/.test(pasteData)) return;

            pasteData.split('').forEach((char, i) => {
                if (inputs[i]) {
                    inputs[i].value = char;
                    if (i < inputs.length - 1) inputs[i + 1].focus();
                }
            });
        });
    });

    // Auto-enfocar el primer input
    window.addEventListener('load', () => inputs[0].focus());
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

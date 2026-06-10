<!-- Sidebar Cliente -->
<aside id="sidebar" class="fixed left-0 top-20 bottom-0 w-64 bg-djpro-surface border-r border-djpro-border z-40 transition-all duration-300 transform lg:translate-x-0 -translate-x-full overflow-y-auto scrollbar-thin scrollbar-thumb-djpro-accent">
    <div class="p-6">
        <!-- User Profile Mini -->
        <div class="flex flex-col items-center mb-10 pb-10 border-b border-djpro-border">
            <div class="relative mb-4 group">
                <div class="w-20 h-20 rounded-full border-2 border-djpro-accent p-1 group-hover:shadow-[0_0_15px_rgba(249,115,22,0.3)] transition-all">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['usuario_nombre'] ?? 'Invitado'); ?>&background=1c1c2e&color=f97316" alt="Profile" class="w-full h-full rounded-full object-cover">
                </div>
            </div>
            <h3 class="text-xl font-bebas text-white tracking-wide"><?php echo explode(' ', $_SESSION['usuario_nombre'] ?? 'Invitado')[0]; ?></h3>
            <p class="text-xs text-djpro-muted font-semibold uppercase tracking-widest mt-1"><?php echo isset($_SESSION['usuario_rol']) ? 'Cliente VIP' : 'Visitante'; ?></p>
        </div>

        <!-- Menu Items -->
        <nav class="space-y-2">
            <a href="<?php echo URL_ROOT; ?>/clientes/dashboard" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all <?php echo (strpos($_GET['url'] ?? '', 'clientes/dashboard') !== false || strpos($_GET['url'] ?? '', 'clientes/panel') !== false) ? 'bg-djpro-accent/10 text-djpro-accent border-l-4 border-djpro-accent' : 'text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text'; ?>">
                <i class="bi bi-speedometer2 text-xl"></i>
                <span class="font-bold">Mi Panel</span>
            </a>

            <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all <?php echo (strpos($_GET['url'] ?? '', 'djs/explorar') !== false || strpos($_GET['url'] ?? '', 'clientes/explorar') !== false) ? 'bg-djpro-accent/10 text-djpro-accent border-l-4 border-djpro-accent' : 'text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text'; ?>">
                <i class="bi bi-search text-xl"></i>
                <span class="font-bold">Explorar DJs</span>
            </a>


            
            <a href="<?php echo URL_ROOT; ?>/chat" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all <?php echo (strpos($_GET['url'] ?? '', 'chat') !== false) ? 'bg-djpro-accent/10 text-djpro-accent border-l-4 border-djpro-accent' : 'text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text'; ?>">
                <i class="bi bi-chat-dots-fill text-xl"></i>
                <span class="font-bold">Mensajes</span>
            </a>

            <div class="pt-10">
                <a href="<?php echo URL_ROOT; ?>/usuarios/logout" class="flex items-center gap-4 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 transition-all">
                    <i class="bi bi-box-arrow-left text-xl"></i>
                    <span class="font-bold">Cerrar Sesión</span>
                </a>
            </div>
        </nav>
    </div>
</aside>


<!-- Sidebar DJ -->
<aside id="sidebar" class="fixed left-0 top-20 bottom-0 w-64 bg-djpro-surface border-r border-djpro-border z-40 transition-all duration-300 transform lg:translate-x-0 -translate-x-full">
    <div class="p-6">
        <!-- DJ Profile Mini -->
        <div class="flex flex-col items-center mb-10 pb-10 border-b border-djpro-border">
            <div class="relative mb-4 group">
                <div class="w-20 h-20 rounded-full border-2 border-djpro-accent p-1 group-hover:shadow-[0_0_15px_rgba(249,115,22,0.3)] transition-all">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['usuario_nombre']); ?>&background=12121a&color=f97316" alt="Profile" class="w-full h-full rounded-full object-cover">
                </div>
                <span class="absolute bottom-1 right-1 w-4 h-4 bg-green-500 border-2 border-djpro-surface rounded-full"></span>
            </div>
            <h3 class="text-xl font-bebas text-white tracking-wide"><?php echo explode(' ', $_SESSION['usuario_nombre'])[0]; ?></h3>
            <p class="text-xs text-djpro-muted font-semibold uppercase tracking-widest mt-1">DJ Profesional</p>
        </div>

        <!-- Menu Items -->
        <nav class="space-y-2">
            <a href="<?php echo URL_ROOT; ?>/djs/dashboard" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all <?php echo (strpos($_GET['url'] ?? '', 'djs/dashboard') !== false || strpos($_GET['url'] ?? '', 'djs/panel') !== false) ? 'bg-djpro-accent/10 text-djpro-accent border-l-4 border-djpro-accent' : 'text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text'; ?>">
                <i class="bi bi-grid-1x2-fill text-xl"></i>
                <span class="font-bold">Panel Control</span>
            </a>
            
            <a href="<?php echo URL_ROOT; ?>/djs/editar" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all <?php echo (strpos($_GET['url'], 'djs/editar') !== false) ? 'bg-djpro-accent/10 text-djpro-accent border-l-4 border-djpro-accent' : 'text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text'; ?>">
                <i class="bi bi-person-fill-gear text-xl"></i>
                <span class="font-bold">Editar Perfil</span>
            </a>

            <a href="<?php echo URL_ROOT; ?>/chat" class="flex items-center gap-4 px-4 py-3 rounded-xl text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text transition-all">
                <i class="bi bi-chat-dots-fill text-xl"></i>
                <span class="font-bold">Mensajería</span>
            </a>

            <a href="<?php echo URL_ROOT; ?>/djs/estadisticas" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all <?php echo (strpos($_GET['url'] ?? '', 'djs/estadisticas') !== false) ? 'bg-djpro-accent/10 text-djpro-accent border-l-4 border-djpro-accent' : 'text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text'; ?>">
                <i class="bi bi-graph-up-arrow text-xl"></i>
                <span class="font-bold">Estadísticas</span>
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


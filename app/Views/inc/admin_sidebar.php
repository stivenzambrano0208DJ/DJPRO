<!-- Sidebar Admin -->
<aside class="w-64 bg-djpro-surface border-r border-djpro-border h-[calc(100vh-80px)] hidden lg:block">
    <div class="p-6">
        <h2 class="text-xl font-bebas text-djpro-accent tracking-widest mb-10 uppercase">Admin Panel</h2>
        <nav class="space-y-4">
            <!-- Global KPI -->
            <a href="<?php echo URL_ROOT; ?>/admin/dashboard" 
               class="flex items-center gap-3 px-4 py-3 transition-all rounded-r-xl <?php echo ($activePage == 'dashboard') ? 'text-white font-bold bg-djpro-accent/10 border-l-4 border-djpro-accent' : 'text-djpro-muted hover:text-white'; ?>">
                <i class="bi bi-speedometer2"></i> Global KPI
            </a>
            
            <!-- Usuarios -->
            <a href="<?php echo URL_ROOT; ?>/admin/usuarios" 
               class="flex items-center gap-3 px-4 py-3 transition-all rounded-r-xl <?php echo ($activePage == 'usuarios') ? 'text-white font-bold bg-djpro-accent/10 border-l-4 border-djpro-accent' : 'text-djpro-muted hover:text-white'; ?>">
                <i class="bi bi-people"></i> Usuarios
            </a>
            
            <!-- Reservas -->
            <a href="<?php echo URL_ROOT; ?>/admin/reservas" 
               class="flex items-center gap-3 px-4 py-3 transition-all rounded-r-xl <?php echo ($activePage == 'reservas') ? 'text-white font-bold bg-djpro-accent/10 border-l-4 border-djpro-accent' : 'text-djpro-muted hover:text-white'; ?>">
                <i class="bi bi-calendar-check"></i> Reservas
            </a>
            
            <!-- Moderar Reseñas -->
            <a href="<?php echo URL_ROOT; ?>/admin/resenas" 
               class="flex items-center gap-3 px-4 py-3 transition-all rounded-r-xl <?php echo ($activePage == 'resenas') ? 'text-white font-bold bg-djpro-accent/10 border-l-4 border-djpro-accent' : 'text-djpro-muted hover:text-white'; ?>">
                <i class="bi bi-star"></i> Moderar Reseñas
            </a>
            
            <!-- Seguridad -->
            <a href="<?php echo URL_ROOT; ?>/admin/seguridad" 
               class="flex items-center gap-3 px-4 py-3 transition-all rounded-r-xl <?php echo ($activePage == 'seguridad') ? 'text-white font-bold bg-djpro-accent/10 border-l-4 border-djpro-accent' : 'text-djpro-muted hover:text-white'; ?>">
                <i class="bi bi-shield-lock"></i> Seguridad
            </a>
        </nav>
    </div>
</aside>

<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<div class="flex">
<?php 
    $activePage = 'dashboard';
    require APPROOT . '/app/Views/inc/admin_sidebar.php'; 
?>

    <!-- Main Content Area -->
    <div class="flex-1 p-8 overflow-y-auto custom-scrollbar h-[calc(100vh-80px)]">
        <div class="container mx-auto">
            
            <div class="flex justify-between items-center mb-10">
                <h1 class="text-4xl font-bebas text-white tracking-widest">CONTROL <span class="text-djpro-accent">GLOBAL</span></h1>
                <button class="btn-djpro-primary px-6 py-2.5 text-sm">REGISTRAR DJ MANUAL</button>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="bg-djpro-surface p-6 rounded-2xl border border-djpro-border">
                    <span class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest block mb-1">Total DJs</span>
                    <h3 id="admin-total-djs" class="text-4xl font-bebas text-white"><?php echo $data['total_djs']; ?></h3>
                </div>
                <div class="bg-djpro-surface p-6 rounded-2xl border border-djpro-border">
                    <span class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest block mb-1">Total Clientes</span>
                    <h3 id="admin-total-clientes" class="text-4xl font-bebas text-white"><?php echo $data['total_clientes']; ?></h3>
                </div>
                <div class="bg-djpro-surface p-6 rounded-2xl border border-djpro-border">
                    <span class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest block mb-1">Total Reservas</span>
                    <h3 id="admin-total-eventos" class="text-4xl font-bebas text-white"><?php echo $data['total_eventos']; ?></h3>
                </div>
                <div class="bg-djpro-surface p-6 rounded-2xl border border-djpro-border">
                    <span class="text-[10px] font-bold text-djpro-accent uppercase tracking-widest block mb-1">Volumen de Negocio</span>
                    <h3 class="text-4xl font-bebas text-white">$<?php echo number_format($data['volumen_negocio'], 0); ?></h3>
                </div>
                <div class="bg-djpro-surface p-6 rounded-2xl border border-djpro-border">
                    <span class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest block mb-1">Live Status</span>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-[9px] font-bold text-green-500 uppercase tracking-widest">Sincronizado</span>
                    </div>
                </div>
            </div>

            <!-- Tablas Globales -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Usuarios Recientes -->
                <div class="bg-djpro-surface rounded-2xl border border-djpro-border overflow-hidden">
                    <div class="p-6 border-b border-djpro-border bg-djpro-surface-2 flex justify-between items-center">
                        <h4 class="text-lg font-bebas text-white tracking-widest uppercase">Nuevos Usuarios</h4>
                        <span class="text-[9px] font-bold text-djpro-muted uppercase">Actualizado en tiempo real</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-djpro-bg/50">
                                <tr>
                                    <th class="px-6 py-3 text-[9px] font-bold text-djpro-muted uppercase tracking-widest">Usuario</th>
                                    <th class="px-6 py-3 text-[9px] font-bold text-djpro-muted uppercase tracking-widest">Rol</th>
                                    <th class="px-6 py-3 text-[9px] font-bold text-djpro-muted uppercase tracking-widest">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="recent-users-table" class="divide-y divide-djpro-border">
                                <?php foreach($data['usuarios_recientes'] as $user): ?>
                                <tr class="hover:bg-djpro-surface-2/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-djpro-surface-2 border border-djpro-border flex items-center justify-center text-[10px] font-bold text-djpro-accent">
                                                <?php echo strtoupper(substr($user->nombre, 0, 2)); ?>
                                            </div>
                                            <div>
                                                <span class="block text-xs font-bold text-white uppercase"><?php echo $user->nombre; ?></span>
                                                <span class="text-[9px] text-djpro-muted"><?php echo $user->correo; ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-[9px] font-bold px-2 py-1 rounded-md <?php echo $user->rol == 'dj' ? 'bg-orange-500/10 text-orange-500' : 'bg-purple-500/10 text-purple-500'; ?> uppercase tracking-widest">
                                            <?php echo $user->rol; ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <a href="<?php echo URL_ROOT; ?>/admin/editar_usuario/<?php echo $user->id; ?>" class="text-djpro-muted hover:text-white">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <?php if($user->id != $_SESSION['usuario_id']): ?>
                                            <form action="<?php echo URL_ROOT; ?>/admin/eliminar_usuario/<?php echo $user->id; ?>" method="POST" onsubmit="return confirm('¿Eliminar usuario?');">
                                                <button type="submit" class="text-red-500 hover:text-red-400">
                                                    <i class="bi bi-shield-slash"></i>
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Reservas Globales -->
                <div class="bg-djpro-surface rounded-2xl border border-djpro-border overflow-hidden">
                    <div class="p-6 border-b border-djpro-border bg-djpro-surface-2 flex justify-between items-center">
                        <h4 class="text-lg font-bebas text-white tracking-widest uppercase">Distribución de Eventos</h4>
                    </div>
                    <div class="p-8 space-y-6">
                        <?php foreach($data['metricas_estado'] as $metrica): ?>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-white uppercase tracking-widest"><?php echo $metrica->estado; ?></span>
                                <span class="text-xs font-bold text-djpro-accent"><?php echo $metrica->cantidad; ?></span>
                            </div>
                            <div class="w-full h-1.5 bg-djpro-surface-2 rounded-full overflow-hidden">
                                <div class="h-full bg-djpro-accent" style="width: <?php echo ($metrica->cantidad / max(1, $data['total_eventos'])) * 100; ?>%"></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateRecentUsers() {
        fetch('<?php echo URL_ROOT; ?>/admin/api_recent_users')
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('recent-users-table');
                tbody.innerHTML = '';
                
                data.usuarios.forEach(user => {
                    const initials = user.nombre.substring(0, 2).toUpperCase();
                    const rolClass = user.rol === 'dj' ? 'bg-orange-500/10 text-orange-500' : 'bg-purple-500/10 text-purple-500';
                    
                    const tr = `
                        <tr class="hover:bg-djpro-surface-2/50 transition-colors animate-fade-in">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg bg-djpro-surface-2 border border-djpro-border flex items-center justify-center text-[10px] font-bold text-djpro-accent">${initials}</div>
                                    <div>
                                        <span class="block text-xs font-bold text-white uppercase">${user.nombre}</span>
                                        <span class="text-[9px] text-djpro-muted">${user.correo}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-[9px] font-bold px-2 py-1 rounded-md ${rolClass} uppercase tracking-widest">${user.rol}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <button class="text-djpro-muted hover:text-white"><i class="bi bi-pencil-square"></i></button>
                                    <button class="text-red-500 hover:text-red-400"><i class="bi bi-shield-slash"></i></button>
                                </div>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += tr;
                });
            })
            .catch(error => console.error('Error fetching admin data:', error));
    }

    // Polling cada 15 segundos para el admin
    setInterval(updateRecentUsers, 15000);
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

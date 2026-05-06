<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<div class="flex">
    <!-- Sidebar Admin -->
    <aside class="w-64 bg-djpro-surface border-r border-djpro-border h-[calc(100vh-80px)] hidden lg:block">
        <div class="p-6">
            <h2 class="text-xl font-bebas text-djpro-accent tracking-widest mb-10 uppercase">Admin Panel</h2>
            <nav class="space-y-4">
                <a href="<?php echo URL_ROOT; ?>/admin/dashboard" class="flex items-center gap-3 text-djpro-muted hover:text-white px-4 py-3 transition-all">
                    <i class="bi bi-speedometer2"></i> Global KPI
                </a>
                <a href="<?php echo URL_ROOT; ?>/admin/usuarios" class="flex items-center gap-3 text-white font-bold px-4 py-3 bg-djpro-accent/10 border-l-4 border-djpro-accent rounded-r-xl">
                    <i class="bi bi-people"></i> Usuarios
                </a>
                <a href="<?php echo URL_ROOT; ?>/admin/reservas" class="flex items-center gap-3 text-djpro-muted hover:text-white px-4 py-3 transition-all">
                    <i class="bi bi-calendar-check"></i> Reservas
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto custom-scrollbar h-[calc(100vh-80px)]">
        <div class="container mx-auto">
            <h1 class="text-4xl font-bebas text-white tracking-widest mb-10">GESTIÓN DE <span class="text-djpro-accent">USUARIOS</span></h1>

            <div class="bg-djpro-surface rounded-2xl border border-djpro-border overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-djpro-surface-2">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-djpro-muted uppercase tracking-widest">Nombre</th>
                            <th class="px-6 py-4 text-xs font-bold text-djpro-muted uppercase tracking-widest">Correo</th>
                            <th class="px-6 py-4 text-xs font-bold text-djpro-muted uppercase tracking-widest">Rol</th>
                            <th class="px-6 py-4 text-xs font-bold text-djpro-muted uppercase tracking-widest">Registro</th>
                            <th class="px-6 py-4 text-xs font-bold text-djpro-muted uppercase tracking-widest text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-djpro-border">
                        <?php foreach($data['usuarios'] as $user): ?>
                        <tr class="hover:bg-djpro-surface-2/30 transition-colors">
                            <td class="px-6 py-4 font-bold text-white"><?php echo $user->nombre; ?></td>
                            <td class="px-6 py-4 text-djpro-muted"><?php echo $user->correo; ?></td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest <?php echo $user->rol == 'dj' ? 'bg-orange-500/10 text-orange-500' : 'bg-purple-500/10 text-purple-500'; ?>">
                                    <?php echo $user->rol; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-djpro-muted"><?php echo date('d M, Y', strtotime($user->fecha_registro)); ?></td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-3">
                                    <a href="<?php echo URL_ROOT; ?>/admin/editar_usuario/<?php echo $user->id; ?>" class="text-djpro-accent hover:text-orange-400">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <?php if($user->id != $_SESSION['usuario_id']): ?>
                                    <form action="<?php echo URL_ROOT; ?>/admin/eliminar_usuario/<?php echo $user->id; ?>" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                        <button type="submit" class="text-red-500 hover:text-red-400"><i class="bi bi-trash3"></i></button>
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
    </main>
</div>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

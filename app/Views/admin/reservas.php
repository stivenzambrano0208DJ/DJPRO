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
                <a href="<?php echo URL_ROOT; ?>/admin/usuarios" class="flex items-center gap-3 text-djpro-muted hover:text-white px-4 py-3 transition-all">
                    <i class="bi bi-people"></i> Usuarios
                </a>
                <a href="<?php echo URL_ROOT; ?>/admin/reservas" class="flex items-center gap-3 text-white font-bold px-4 py-3 bg-djpro-accent/10 border-l-4 border-djpro-accent rounded-r-xl">
                    <i class="bi bi-calendar-check"></i> Reservas
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto custom-scrollbar h-[calc(100vh-80px)]">
        <div class="container mx-auto">
            <h1 class="text-4xl font-bebas text-white tracking-widest mb-10">CONTROL DE <span class="text-djpro-accent">RESERVAS</span></h1>

            <div class="bg-djpro-surface rounded-2xl border border-djpro-border overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-djpro-surface-2">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-djpro-muted uppercase tracking-widest">Cliente</th>
                            <th class="px-6 py-4 text-xs font-bold text-djpro-muted uppercase tracking-widest">DJ</th>
                            <th class="px-6 py-4 text-xs font-bold text-djpro-muted uppercase tracking-widest">Evento</th>
                            <th class="px-6 py-4 text-xs font-bold text-djpro-muted uppercase tracking-widest">Fecha</th>
                            <th class="px-6 py-4 text-xs font-bold text-djpro-muted uppercase tracking-widest text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-djpro-border">
                        <?php foreach($data['reservas'] as $reserva): ?>
                        <tr class="hover:bg-djpro-surface-2/30 transition-colors">
                            <td class="px-6 py-4 font-bold text-white"><?php echo $reserva->cliente_nombre; ?></td>
                            <td class="px-6 py-4 text-djpro-accent font-semibold"><?php echo $reserva->dj_nombre; ?></td>
                            <td class="px-6 py-4 text-xs text-djpro-muted"><?php echo $reserva->tipo_evento; ?></td>
                            <td class="px-6 py-4 text-xs text-djpro-muted"><?php echo date('d M, Y', strtotime($reserva->fecha_evento)); ?></td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest 
                                    <?php 
                                        if($reserva->estado == 'confirmada') echo 'bg-green-500/10 text-green-500';
                                        elseif($reserva->estado == 'cancelada') echo 'bg-red-500/10 text-red-500';
                                        else echo 'bg-djpro-accent/10 text-djpro-accent';
                                    ?>">
                                    <?php echo $reserva->estado; ?>
                                </span>
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

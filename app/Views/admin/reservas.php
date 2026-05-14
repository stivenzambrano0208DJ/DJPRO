<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<div class="flex">
<?php 
    $activePage = 'reservas';
    require APPROOT . '/app/Views/inc/admin_sidebar.php'; 
?>

    <!-- Main Content -->
    <div class="flex-1 p-8 overflow-y-auto custom-scrollbar h-[calc(100vh-80px)]">
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
                            <th class="px-6 py-4 text-xs font-bold text-djpro-muted uppercase tracking-widest">Hora</th>
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
                            <td class="px-6 py-4">
                                <?php if(!empty($reserva->hora_inicio)): ?>
                                <span class="text-[9px] font-bold text-djpro-accent bg-djpro-accent/10 px-2 py-1 rounded-lg border border-djpro-accent/20">
                                    <i class="bi bi-clock-fill"></i> 
                                    <?php echo date('h:i A', strtotime($reserva->hora_inicio)); ?>
                                    <?php echo !empty($reserva->hora_fin) ? ' — ' . date('h:i A', strtotime($reserva->hora_fin)) : ''; ?>
                                </span>
                                <?php else: ?>
                                <span class="text-[10px] text-djpro-muted">—</span>
                                <?php endif; ?>
                            </td>
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
    </div>
</div>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

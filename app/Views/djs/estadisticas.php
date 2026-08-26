<?php
    $total       = $data['stats']['solicitudes'] ?? 0;
    $aceptadas   = $data['stats']['aceptadas'] ?? 0;
    $finalizados = $data['stats']['finalizados'] ?? 0;
    $ganancias   = $data['stats']['ganancias'] ?? 0;
    $resenas     = $data['stats']['resenas'] ?? 0;
    $rating      = $data['perfil']->calificacion_promedio ?? 0;
    $pendientes  = $data['pendientes'] ?? 0;
    $canceladas  = $data['canceladas'] ?? 0;
    $ticket_prom = $data['ticket_promedio'] ?? 0;
    $conversion  = $total > 0 ? round(($aceptadas / $total) * 100) : 0;
    $retencion   = $total > 0 ? round(($finalizados / $total) * 100) : 0;
    $__pageTitle = 'DJPRO | Estadísticas';
    require APPROOT . '/app/Views/inc/dj_shell_top.php';
?>

<!-- Header -->
<div class="mb-8">
    <h2 class="text-4xl font-bebas font-extrabold">Análisis de <span class="text-djpro-accent">Rendimiento</span></h2>
    <p class="text-djpro-muted font-medium mt-1 text-sm">Métricas reales de tu actividad en DJPRO.</p>
</div>

<!-- KPI Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-5">
    <div class="bento p-6 relative overflow-hidden group hover:border-djpro-success/40 transition-all">
        <div class="absolute top-2 right-2 opacity-5 group-hover:opacity-15 transition-opacity"><i class="bi bi-cash-stack text-6xl text-djpro-success"></i></div>
        <p class="text-[10px] font-bold text-djpro-success uppercase tracking-widest mb-2 flex items-center gap-1"><i class="bi bi-cash-stack"></i> Ingresos</p>
        <h3 class="text-3xl font-bebas font-extrabold">$<?php echo number_format($ganancias, 0); ?></h3>
        <p class="text-[11px] text-djpro-muted font-semibold mt-1">Total acumulado</p>
    </div>
    <div class="bento p-6 relative overflow-hidden group hover:border-djpro-accent/40 transition-all">
        <div class="absolute top-2 right-2 opacity-5 group-hover:opacity-15 transition-opacity"><i class="bi bi-receipt-cutoff text-6xl text-djpro-accent"></i></div>
        <p class="text-[10px] font-bold text-djpro-accent uppercase tracking-widest mb-2 flex items-center gap-1"><i class="bi bi-receipt-cutoff"></i> Ticket Promedio</p>
        <h3 class="text-3xl font-bebas font-extrabold">$<?php echo number_format($ticket_prom, 0); ?></h3>
        <p class="text-[11px] text-djpro-muted font-semibold mt-1">Por evento terminado</p>
    </div>
    <div class="bento p-6 relative overflow-hidden group hover:border-yellow-500/40 transition-all">
        <div class="absolute top-2 right-2 opacity-5 group-hover:opacity-15 transition-opacity"><i class="bi bi-star-fill text-6xl text-yellow-500"></i></div>
        <p class="text-[10px] font-bold text-yellow-500 uppercase tracking-widest mb-2 flex items-center gap-1"><i class="bi bi-star-fill"></i> Calificación</p>
        <h3 class="text-3xl font-bebas font-extrabold"><?php echo number_format($rating, 1); ?><span class="text-lg text-djpro-muted">/5</span></h3>
        <p class="text-[11px] text-djpro-muted font-semibold mt-1"><?php echo $resenas; ?> reseñas reales</p>
    </div>
    <div class="bento p-6 relative overflow-hidden group hover:border-djpro-purple/40 transition-all">
        <div class="absolute top-2 right-2 opacity-5 group-hover:opacity-15 transition-opacity"><i class="bi bi-graph-up-arrow text-6xl text-djpro-purple"></i></div>
        <p class="text-[10px] font-bold text-djpro-purple uppercase tracking-widest mb-2 flex items-center gap-1"><i class="bi bi-graph-up-arrow"></i> Conversión</p>
        <h3 class="text-3xl font-bebas font-extrabold"><?php echo $conversion; ?>%</h3>
        <p class="text-[11px] text-djpro-muted font-semibold mt-1">Solicitudes aceptadas</p>
    </div>
</div>

<!-- Counters -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-5 mb-5">
    <div class="bento p-4 text-center"><span class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest block mb-1">Total Solicitudes</span><span class="text-2xl font-bebas font-extrabold"><?php echo $total; ?></span></div>
    <div class="bento p-4 text-center" style="border-color:rgba(234,179,8,.25)"><span class="text-[10px] font-bold text-yellow-400 uppercase tracking-widest block mb-1">Pendientes</span><span class="text-2xl font-bebas font-extrabold text-yellow-400"><?php echo $pendientes; ?></span></div>
    <div class="bento p-4 text-center" style="border-color:rgba(124,77,255,.25)"><span class="text-[10px] font-bold text-djpro-purple uppercase tracking-widest block mb-1">Finalizados</span><span class="text-2xl font-bebas font-extrabold text-djpro-purple"><?php echo $finalizados; ?></span></div>
    <div class="bento p-4 text-center" style="border-color:rgba(239,68,68,.25)"><span class="text-[10px] font-bold text-red-400 uppercase tracking-widest block mb-1">Cancelados</span><span class="text-2xl font-bebas font-extrabold text-red-400"><?php echo $canceladas; ?></span></div>
</div>

<!-- Chart -->
<div class="bento p-6 mb-5 flex flex-col md:flex-row items-center gap-8">
    <div class="flex-shrink-0">
        <h4 class="text-lg font-bebas font-extrabold">Estado de Propuestas</h4>
        <p class="text-[10px] text-djpro-muted font-bold uppercase tracking-widest mb-4">Distribución actual</p>
        <div class="grid grid-cols-2 gap-3">
            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-djpro-purple flex-shrink-0"></span><span class="text-[10px] font-bold text-djpro-muted uppercase">Finalizados <span class="text-djpro-text"><?php echo $finalizados; ?></span></span></div>
            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-djpro-accent flex-shrink-0"></span><span class="text-[10px] font-bold text-djpro-muted uppercase">Aceptados <span class="text-djpro-text"><?php echo $aceptadas; ?></span></span></div>
            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-yellow-500 flex-shrink-0"></span><span class="text-[10px] font-bold text-djpro-muted uppercase">Pendientes <span class="text-djpro-text"><?php echo $pendientes; ?></span></span></div>
            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-500 flex-shrink-0"></span><span class="text-[10px] font-bold text-djpro-muted uppercase">Cancelados <span class="text-djpro-text"><?php echo $canceladas; ?></span></span></div>
        </div>
    </div>
    <div class="w-56 h-56 mx-auto"><canvas id="chartEstados"></canvas></div>
</div>

<!-- Progress breakdown -->
<div class="bento overflow-hidden">
    <div class="p-6 border-b border-djpro-border flex items-center gap-3">
        <div class="w-8 h-8 bg-djpro-accent/15 rounded-xl flex items-center justify-center text-djpro-accent"><i class="bi bi-bar-chart-line-fill"></i></div>
        <h4 class="text-xl font-bebas font-extrabold">Resumen de Métricas</h4>
    </div>
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php
            $metrics = [
                ['label' => 'Tasa de aceptación', 'value' => $conversion, 'suffix' => '%', 'color' => 'bg-djpro-success', 'icon' => 'bi-check2-circle', 'text' => 'text-djpro-success'],
                ['label' => 'Tasa de finalización', 'value' => $retencion, 'suffix' => '%', 'color' => 'bg-djpro-purple', 'icon' => 'bi-flag-fill', 'text' => 'text-djpro-purple'],
                ['label' => 'Eventos con Reseña', 'value' => $finalizados > 0 ? round(($resenas / $finalizados) * 100) : 0, 'suffix' => '%', 'color' => 'bg-yellow-500', 'icon' => 'bi-star-fill', 'text' => 'text-yellow-400'],
                ['label' => 'Solicitudes sin conflicto', 'value' => $total > 0 ? round((($total - $canceladas) / $total) * 100) : 0, 'suffix' => '%', 'color' => 'bg-djpro-accent', 'icon' => 'bi-shield-check', 'text' => 'text-djpro-accent'],
            ];
            foreach ($metrics as $m): $w = min(100, max(0, $m['value']));
        ?>
        <div class="space-y-2">
            <div class="flex justify-between items-center">
                <span class="flex items-center gap-2 text-[10px] font-bold text-djpro-muted uppercase tracking-wider"><i class="bi <?php echo $m['icon']; ?> <?php echo $m['text']; ?>"></i> <?php echo $m['label']; ?></span>
                <span class="text-base font-bebas font-extrabold <?php echo $m['text']; ?>"><?php echo $m['value']; ?><?php echo $m['suffix']; ?></span>
            </div>
            <div class="w-full h-2 bg-djpro-surface-2 rounded-full overflow-hidden">
                <div class="h-full <?php echo $m['color']; ?> rounded-full transition-all duration-700" style="width: <?php echo $w; ?>%"></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const donutData = [<?php echo $finalizados; ?>, <?php echo $aceptadas; ?>, <?php echo $pendientes; ?>, <?php echo $canceladas; ?>];
    const total = donutData.reduce((a, b) => a + b, 0);
    new Chart(document.getElementById('chartEstados'), {
        type: 'doughnut',
        data: {
            labels: ['Finalizados', 'Aceptados', 'Pendientes', 'Cancelados'],
            datasets: [{
                data: total > 0 ? donutData : [1, 0, 0, 0],
                backgroundColor: ['#7C4DFF', '#2E5BFF', '#eab308', '#ef4444'],
                borderWidth: 0, hoverOffset: 8
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { color: '#8b95b5', usePointStyle: true, padding: 12, font: { size: 10, weight: 'bold' } } } },
            cutout: '70%'
        }
    });
});
</script>

<?php require APPROOT . '/app/Views/inc/dj_shell_bottom.php'; ?>

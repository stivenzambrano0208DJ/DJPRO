<?php require APPROOT . '/app/Views/inc/header.php'; ?>
<?php require APPROOT . '/app/Views/inc/sidebar_dj.php'; ?>

<div class="lg:ml-64 p-8">
    <div class="container mx-auto">
        <!-- Header -->
        <div class="mb-10 reveal">
            <h2 class="text-4xl font-bebas text-white tracking-widest uppercase">Análisis de Rendimiento</h2>
            <p class="text-djpro-muted font-medium mt-2">Visualiza el crecimiento de tu carrera y las métricas de tus servicios.</p>
        </div>

        <!-- Main Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 reveal">
            <!-- Solicitudes -->
            <div class="bg-djpro-surface p-6 rounded-3xl border border-djpro-border shadow-xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i class="bi bi-lightning-charge text-6xl text-djpro-accent"></i>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-bold text-djpro-accent uppercase tracking-widest mb-1">Impacto Total</p>
                    <h3 class="text-4xl font-bebas text-white"><?php echo $data['stats']['solicitudes'] ?? 0; ?></h3>
                    <p class="text-xs text-djpro-muted font-semibold mt-1">Solicitudes recibidas</p>
                </div>
            </div>

            <!-- Ganancias -->
            <div class="bg-djpro-surface p-6 rounded-3xl border border-djpro-border shadow-xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i class="bi bi-cash-stack text-6xl text-green-500"></i>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-bold text-green-500 uppercase tracking-widest mb-1">Ingresos Reales</p>
                    <h3 class="text-4xl font-bebas text-white">$<?php echo number_format($data['stats']['ganancias'] ?? 0, 0); ?></h3>
                    <p class="text-xs text-djpro-muted font-semibold mt-1">Total acumulado</p>
                </div>
            </div>

            <!-- Rating -->
            <div class="bg-djpro-surface p-6 rounded-3xl border border-djpro-border shadow-xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i class="bi bi-star-fill text-6xl text-yellow-500"></i>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-bold text-yellow-500 uppercase tracking-widest mb-1">Reputación</p>
                    <h3 class="text-4xl font-bebas text-white"><?php echo number_format($data['perfil']->calificacion_promedio, 1); ?></h3>
                    <p class="text-xs text-djpro-muted font-semibold mt-1">Basado en <?php echo $data['stats']['resenas'] ?? 0; ?> reseñas</p>
                </div>
            </div>

            <!-- Conversión -->
            <div class="bg-djpro-surface p-6 rounded-3xl border border-djpro-border shadow-xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i class="bi bi-arrow-repeat text-6xl text-djpro-purple"></i>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-bold text-djpro-purple uppercase tracking-widest mb-1">Efectividad</p>
                    <?php 
                        $total = $data['stats']['solicitudes'] ?? 0;
                        $aceptadas = $data['stats']['aceptadas'] ?? 0;
                        $conversion = $total > 0 ? ($aceptadas / $total) * 100 : 0;
                    ?>
                    <h3 class="text-4xl font-bebas text-white"><?php echo number_format($conversion, 0); ?>%</h3>
                    <p class="text-xs text-djpro-muted font-semibold mt-1">Tasa de aceptación</p>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            <!-- Rendimiento Mensual -->
            <div class="bg-djpro-surface p-8 rounded-3xl border border-djpro-border shadow-2xl reveal">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h4 class="text-xl font-bebas text-white tracking-widest uppercase">Proyección de Servicios</h4>
                        <p class="text-[10px] text-djpro-muted font-bold uppercase tracking-widest">Últimos 6 meses</p>
                    </div>
                    <div class="flex gap-2">
                        <span class="flex items-center gap-1 text-[10px] font-bold text-djpro-accent"><span class="w-2 h-2 rounded-full bg-djpro-accent"></span> EVENTOS</span>
                    </div>
                </div>
                <div class="h-64 relative">
                    <canvas id="chartServicios"></canvas>
                </div>
            </div>

            <!-- Distribución de Estados -->
            <div class="bg-djpro-surface p-8 rounded-3xl border border-djpro-border shadow-2xl reveal">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h4 class="text-xl font-bebas text-white tracking-widest uppercase">Estado de Propuestas</h4>
                        <p class="text-[10px] text-djpro-muted font-bold uppercase tracking-widest">Distribución porcentual</p>
                    </div>
                </div>
                <div class="h-64 relative">
                    <canvas id="chartEstados"></canvas>
                </div>
            </div>
        </div>

        <!-- Detailed Breakdown -->
        <div class="bg-djpro-surface rounded-3xl border border-djpro-border overflow-hidden shadow-2xl reveal">
            <div class="p-8 border-b border-djpro-border bg-djpro-surface-2/30">
                <h4 class="text-2xl font-bebas text-white tracking-widest uppercase">Resumen por Categoría</h4>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-4">
                    <div class="flex justify-between items-end">
                        <span class="text-xs font-bold text-djpro-muted uppercase">Eventos Completados</span>
                        <span class="text-xl font-bebas text-white"><?php echo $data['stats']['finalizados'] ?? 0; ?></span>
                    </div>
                    <div class="w-full h-1.5 bg-djpro-border rounded-full overflow-hidden">
                        <div class="h-full bg-djpro-accent" style="width: 75%"></div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-end">
                        <span class="text-xs font-bold text-djpro-muted uppercase">Reseñas Positivas</span>
                        <span class="text-xl font-bebas text-white"><?php echo $data['stats']['resenas'] ?? 0; ?></span>
                    </div>
                    <div class="w-full h-1.5 bg-djpro-border rounded-full overflow-hidden">
                        <div class="h-full bg-yellow-500" style="width: 90%"></div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-end">
                        <span class="text-xs font-bold text-djpro-muted uppercase">Nivel de Perfil</span>
                        <span class="text-xl font-bebas text-white">PRO</span>
                    </div>
                    <div class="w-full h-1.5 bg-djpro-border rounded-full overflow-hidden">
                        <div class="h-full bg-djpro-purple" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart Servicios
        const ctxServicios = document.getElementById('chartServicios').getContext('2d');
        
        <?php 
            $labels = [];
            $counts = [];
            foreach($data['proyeccion'] as $p) {
                $labels[] = $p->mes;
                $counts[] = $p->total;
            }
            // Si no hay datos, mostrar ceros para los últimos meses
            if (empty($labels)) {
                $labels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'];
                $counts = [0, 0, 0, 0, 0, 0];
            }
        ?>

        new Chart(ctxServicios, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Servicios',
                    data: <?php echo json_encode($counts); ?>,
                    borderColor: '#f97316',
                    backgroundColor: 'rgba(249, 115, 22, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#f97316'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: { color: '#64748b', font: { size: 10 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', font: { size: 10 } }
                    }
                }
            }
        });

        // Chart Estados
        const ctxEstados = document.getElementById('chartEstados').getContext('2d');
        new Chart(ctxEstados, {
            type: 'doughnut',
            data: {
                labels: ['Finalizados', 'Aceptados', 'Pendientes'],
                datasets: [{
                    data: [
                        <?php echo $data['stats']['finalizados'] ?? 0; ?>, 
                        <?php echo $data['stats']['aceptadas'] ?? 0; ?>, 
                        <?php echo ($data['stats']['solicitudes'] ?? 0) - (($data['stats']['finalizados'] ?? 0) + ($data['stats']['aceptadas'] ?? 0)); ?>
                    ],
                    backgroundColor: ['#7c3aed', '#f97316', '#1e293b'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#64748b',
                            usePointStyle: true,
                            padding: 20,
                            font: { size: 11, weight: 'bold' }
                        }
                    }
                },
                cutout: '75%'
            }
        });
    });
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

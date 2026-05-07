<?php require APPROOT . '/app/Views/inc/header.php'; ?>
<?php require APPROOT . '/app/Views/inc/sidebar_dj.php'; ?>

<div class="lg:ml-64 p-8">
    <div class="container mx-auto">
        <!-- Alerta de Perfil Incompleto -->
        <?php if(empty($data['perfil']->biografia) || $data['perfil']->foto_perfil == 'default_dj.png' || empty($data['videos'])): ?>
        <div class="mb-10 bg-djpro-accent/10 border border-djpro-accent/20 p-6 rounded-3xl flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 bg-djpro-accent/20 rounded-2xl flex items-center justify-center text-djpro-accent shrink-0">
                    <i class="bi bi-exclamation-triangle-fill text-3xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-bebas text-white tracking-widest">¡TU PERFIL ESTÁ INCOMPLETO!</h4>
                    <p class="text-djpro-muted text-sm font-medium">Sube una foto, videos y una biografía para aparecer en los primeros resultados de búsqueda.</p>
                </div>
            </div>
            <a href="<?php echo URL_ROOT; ?>/djs/editar" class="btn-djpro-primary px-8 py-3 whitespace-nowrap">COMPLETAR AHORA</a>
        </div>
        <?php endif; ?>

        <!-- Header del Dashboard -->

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="bg-djpro-surface p-6 rounded-2xl border border-djpro-border group hover:border-djpro-accent transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-djpro-accent/10 rounded-xl flex items-center justify-center text-djpro-accent">
                        <i class="bi bi-calendar-check text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-4xl font-bebas text-white mb-1"><?php echo $data['stats']['solicitudes'] ?? 0; ?></h3>
                <p class="text-sm text-djpro-muted font-bold uppercase tracking-widest">Total Solicitudes</p>
            </div>

            <div class="bg-djpro-surface p-6 rounded-2xl border border-djpro-border group hover:border-djpro-accent transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-500/10 rounded-xl flex items-center justify-center text-yellow-500">
                        <i class="bi bi-check2-circle text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-4xl font-bebas text-white mb-1"><?php echo $data['stats']['aceptadas'] ?? 0; ?></h3>
                <p class="text-sm text-djpro-muted font-bold uppercase tracking-widest">Aceptadas</p>
            </div>

            <div class="bg-djpro-surface p-6 rounded-2xl border border-djpro-border group hover:border-djpro-accent transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-djpro-purple/10 rounded-xl flex items-center justify-center text-djpro-purple">
                        <i class="bi bi-star-fill text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-4xl font-bebas text-white mb-1"><?php echo number_format($data['perfil']->calificacion_promedio, 1); ?></h3>
                <p class="text-sm text-djpro-muted font-bold uppercase tracking-widest">Rating Promedio</p>
            </div>

            <div class="bg-djpro-surface p-6 rounded-2xl border border-djpro-border group hover:border-djpro-accent transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-500">
                        <i class="bi bi-chat-dots-fill text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-4xl font-bebas text-white mb-1"><?php echo $data['stats']['resenas'] ?? 0; ?></h3>
                <p class="text-sm text-djpro-muted font-bold uppercase tracking-widest">Reseñas</p>
            </div>
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 reveal">
            <div class="bg-djpro-surface p-6 rounded-3xl border border-djpro-border shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-500/10 rounded-2xl flex items-center justify-center text-green-500">
                        <i class="bi bi-cash-stack text-2xl"></i>
                    </div>
                    <span class="text-[10px] font-bold text-green-500 uppercase tracking-widest bg-green-500/10 px-2 py-1 rounded-lg">Ganancias</span>
                </div>
                <h3 class="text-3xl font-bebas text-white tracking-widest">$<?php echo number_format($data['stats']['ganancias'] ?? 0, 0); ?></h3>
                <p class="text-[10px] text-djpro-muted font-bold uppercase mt-1">Total acumulado</p>
            </div>

            <div class="bg-djpro-surface p-6 rounded-3xl border border-djpro-border shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-djpro-accent/10 rounded-2xl flex items-center justify-center text-djpro-accent">
                        <i class="bi bi-calendar-check text-2xl"></i>
                    </div>
                    <span class="text-[10px] font-bold text-djpro-accent uppercase tracking-widest bg-djpro-accent/10 px-2 py-1 rounded-lg">Eventos</span>
                </div>
                <h3 class="text-3xl font-bebas text-white tracking-widest"><?php echo $data['stats']['finalizados'] ?? 0; ?></h3>
                <p class="text-[10px] text-djpro-muted font-bold uppercase mt-1">Servicios finalizados</p>
            </div>

            <div class="bg-djpro-surface p-6 rounded-3xl border border-djpro-border shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-djpro-purple/10 rounded-2xl flex items-center justify-center text-djpro-purple">
                        <i class="bi bi-lightning-charge text-2xl"></i>
                    </div>
                    <span class="text-[10px] font-bold text-djpro-purple uppercase tracking-widest bg-djpro-purple/10 px-2 py-1 rounded-lg">Solicitudes</span>
                </div>
                <h3 class="text-3xl font-bebas text-white tracking-widest"><?php echo $data['stats']['solicitudes'] ?? 0; ?></h3>
                <p class="text-[10px] text-djpro-muted font-bold uppercase mt-1">Propuestas totales</p>
            </div>

            <div class="bg-djpro-surface p-6 rounded-3xl border border-djpro-border shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-500/10 rounded-2xl flex items-center justify-center text-yellow-500">
                        <i class="bi bi-star-fill text-2xl"></i>
                    </div>
                    <span class="text-[10px] font-bold text-yellow-500 uppercase tracking-widest bg-yellow-500/10 px-2 py-1 rounded-lg">Rating</span>
                </div>
                <h3 class="text-3xl font-bebas text-white tracking-widest"><?php echo number_format($data['perfil']->calificacion_promedio, 1); ?></h3>
                <p class="text-[10px] text-djpro-muted font-bold uppercase mt-1"><?php echo $data['stats']['resenas'] ?? 0; ?> reseñas reales</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Columna Izquierda: Reservas -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-djpro-surface rounded-3xl border border-djpro-border overflow-hidden shadow-xl">
                    <div class="p-8 border-b border-djpro-border flex justify-between items-center bg-djpro-surface-2/50">
                        <h4 class="text-2xl font-bebas text-white tracking-widest">Próximas Solicitudes</h4>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-djpro-surface-2">
                                    <th class="px-8 py-4 text-[10px] font-bold text-djpro-muted uppercase tracking-widest">Cliente</th>
                                    <th class="px-8 py-4 text-[10px] font-bold text-djpro-muted uppercase tracking-widest">Fecha</th>
                                    <th class="px-8 py-4 text-[10px] font-bold text-djpro-muted uppercase tracking-widest">Horas</th>
                                    <th class="px-8 py-4 text-[10px] font-bold text-djpro-muted uppercase tracking-widest">Precio</th>
                                    <th class="px-8 py-4 text-[10px] font-bold text-djpro-muted uppercase tracking-widest">Estado</th>
                                    <th class="px-8 py-4 text-[10px] font-bold text-djpro-muted uppercase tracking-widest text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-djpro-border">
                                <?php if(empty($data['contrataciones'])): ?>
                                    <tr>
                                        <td colspan="5" class="px-8 py-12 text-center text-djpro-muted italic font-medium">No tienes solicitudes pendientes en este momento.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($data['contrataciones'] as $con): ?>
                                    <tr class="hover:bg-djpro-surface-2 transition-colors">
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-3">
                                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($con->cliente_nombre); ?>&background=1c1c2e&color=f97316" class="w-8 h-8 rounded-lg">
                                                <span class="font-bold text-white text-sm"><?php echo $con->cliente_nombre; ?></span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 text-xs font-bold text-white"><?php echo date('d M, Y', strtotime($con->fecha_evento)); ?></td>
                                        <td class="px-8 py-6 text-xs font-bold text-white"><?php echo $con->horas; ?> h</td>
                                        <td class="px-8 py-6 text-sm font-bold text-djpro-accent">
                                            $<?php echo number_format($con->precio_total, 0); ?>
                                            <?php if($con->contra_oferta): ?>
                                                <div class="text-[9px] text-yellow-500 uppercase">Contra-oferta: $<?php echo number_format($con->contra_oferta, 0); ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-8 py-6">
                                            <?php 
                                                $statusClass = 'bg-yellow-500/15 text-yellow-400 border-yellow-500/20';
                                                if($con->estado == 'aceptada') $statusClass = 'bg-green-500/15 text-green-400 border-green-500/20';
                                                if($con->estado == 'rechazada' || $con->estado == 'cancelada') $statusClass = 'bg-red-500/15 text-red-400 border-red-500/20';
                                                if($con->estado == 'terminada' || $con->estado == 'completada') $statusClass = 'bg-djpro-purple/15 text-djpro-purple border-djpro-purple/20';
                                            ?>
                                            <span class="<?php echo $statusClass; ?> px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest border"><?php echo $con->estado; ?></span>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="flex justify-center gap-2">
                                                <?php if($con->estado == 'pendiente'): ?>
                                                    <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/aceptada" class="w-8 h-8 rounded-lg bg-green-500/20 text-green-500 hover:bg-green-500 hover:text-white transition-all flex items-center justify-center" title="Aceptar">
                                                        <i class="bi bi-check-lg"></i>
                                                    </a>
                                                    <button onclick="openContraOfertaModal(<?php echo $con->id; ?>, <?php echo $con->precio_total; ?>)" class="w-8 h-8 rounded-lg bg-yellow-500/20 text-yellow-500 hover:bg-yellow-500 hover:text-white transition-all flex items-center justify-center" title="Contra-oferta">
                                                        <i class="bi bi-currency-dollar"></i>
                                                    </button>
                                                    <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/rechazada" class="w-8 h-8 rounded-lg bg-red-500/20 text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center" title="Rechazar">
                                                        <i class="bi bi-x-lg"></i>
                                                    </a>
                                                <?php elseif($con->estado == 'aceptada'): ?>
                                                    <?php 
                                                        $fechaEvento = new DateTime($con->fecha_evento);
                                                        $hoy = new DateTime();
                                                        $puedoFinalizar = ($hoy > $fechaEvento && $hoy->diff($fechaEvento)->days >= 1);
                                                    ?>
                                                    <?php if($puedoFinalizar): ?>
                                                        <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/terminada" class="w-8 h-8 rounded-lg bg-djpro-purple/20 text-djpro-purple hover:bg-djpro-purple hover:text-white transition-all flex items-center justify-center" title="Marcar como Terminada">
                                                            <i class="bi bi-flag-fill"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <button class="w-8 h-8 rounded-lg bg-djpro-muted/10 text-djpro-muted opacity-50 cursor-not-allowed flex items-center justify-center" title="Podrás finalizar 24h después del evento">
                                                            <i class="bi bi-flag"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                    
                                                    <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/cancelada" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center" title="Cancelar Evento" onclick="return confirm('¿Estás seguro de cancelar este evento? Se notificará al cliente.')">
                                                        <i class="bi bi-x-circle"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-[9px] font-bold text-djpro-muted uppercase tracking-tighter">Cerrado</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Galería -->
            <div class="space-y-8">
                <div class="bg-djpro-surface rounded-3xl border border-djpro-border p-6 shadow-xl">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-xl font-bebas text-white tracking-widest uppercase">Mi Galería</h4>
                        <button class="bg-djpro-surface-2 hover:bg-djpro-accent text-white p-2 rounded-lg transition-all" onclick="openModal()">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <?php if(empty($data['videos'])): ?>
                            <div class="text-center py-8 border-2 border-dashed border-djpro-border rounded-2xl">
                                <i class="bi bi-play-circle text-3xl text-djpro-muted mb-2 block"></i>
                                <p class="text-[10px] text-djpro-muted font-bold uppercase tracking-widest">Sin videos aún</p>
                            </div>
                        <?php else: ?>
                            <?php foreach($data['videos'] as $video): ?>
                            <div class="group relative rounded-xl overflow-hidden border border-djpro-border">
                                <?php 
                                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video->url_video, $match);
                                    $youtube_id = $match[1] ?? '';
                                ?>
                                <img src="https://img.youtube.com/vi/<?php echo $youtube_id; ?>/mqdefault.jpg" class="w-full h-32 object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                    <i class="bi bi-play-fill text-4xl text-white"></i>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-djpro-surface/90 p-2 backdrop-blur-md border-t border-djpro-border flex justify-between items-center">
                                    <span class="text-[10px] font-bold text-white truncate w-4/5 uppercase tracking-widest"><?php echo $video->titulo; ?></span>
                                    <a href="<?php echo URL_ROOT; ?>/djs/eliminar_video/<?php echo $video->id; ?>" class="text-red-400 hover:text-red-500 transition-colors" onclick="return confirm('¿Eliminar video?')"><i class="bi bi-trash"></i></a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Añadir Video (Tailwind Style) -->
<div id="modalVideo" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-djpro-bg/80 backdrop-blur-sm hidden">
    <div class="bg-djpro-surface w-full max-w-md rounded-3xl border border-djpro-border shadow-2xl overflow-hidden">
        <div class="p-6 border-b border-djpro-border flex justify-between items-center bg-djpro-surface-2/50">
            <h5 class="text-xl font-bebas text-white tracking-widest uppercase">Añadir Video</h5>
            <button onclick="closeModal()" class="text-djpro-muted hover:text-white transition-all text-xl"><i class="bi bi-x-lg"></i></button>
        </div>
        <form action="<?php echo URL_ROOT; ?>/djs/agregar_video" method="POST" class="p-6 space-y-6">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Título del Video</label>
                <input type="text" name="titulo" placeholder="Ej: Festival Electrónica 2024" class="input-djpro w-full" required>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">URL de YouTube</label>
                <input type="url" name="url_video" placeholder="https://www.youtube.com/watch?v=..." class="input-djpro w-full" required>
                <p class="text-[9px] text-djpro-muted font-bold uppercase tracking-tighter">Copia el enlace completo del video.</p>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeModal()" class="flex-1 px-6 py-3 border border-djpro-border text-djpro-muted font-bold rounded-xl hover:text-white transition-all">CANCELAR</button>
                <button type="submit" class="flex-1 btn-djpro-primary">AGREGAR</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Contra-oferta -->
<div id="modalContraOferta" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-djpro-bg/80 backdrop-blur-sm hidden">
    <div class="bg-djpro-surface w-full max-w-md rounded-3xl border border-djpro-border shadow-2xl overflow-hidden">
        <div class="p-6 border-b border-djpro-border flex justify-between items-center bg-djpro-surface-2/50">
            <h5 class="text-xl font-bebas text-white tracking-widest uppercase">Enviar Contra-oferta</h5>
            <button onclick="closeContraOfertaModal()" class="text-djpro-muted hover:text-white transition-all text-xl"><i class="bi bi-x-lg"></i></button>
        </div>
        <form action="<?php echo URL_ROOT; ?>/contrataciones/contra_oferta" method="POST" class="p-6 space-y-6">
            <input type="hidden" name="contratacion_id" id="contra_contratacion_id">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Presupuesto del Cliente</label>
                <input type="text" id="cliente_budget" class="input-djpro w-full opacity-50" readonly>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Tu Contra-oferta ($)</label>
                <input type="number" name="monto_contra_oferta" placeholder="Ej: 600000" class="input-djpro w-full" required>
                <p class="text-[9px] text-djpro-muted font-bold uppercase tracking-tighter">Propón un nuevo precio total para este evento.</p>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeContraOfertaModal()" class="flex-1 px-6 py-3 border border-djpro-border text-djpro-muted font-bold rounded-xl hover:text-white transition-all">CANCELAR</button>
                <button type="submit" class="flex-1 btn-djpro-primary">ENVIAR</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modalVideo').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('modalVideo').classList.add('hidden');
    }

    function openContraOfertaModal(id, budget) {
        document.getElementById('contra_contratacion_id').value = id;
        document.getElementById('cliente_budget').value = '$' + new Intl.NumberFormat().format(budget);
        document.getElementById('modalContraOferta').classList.remove('hidden');
    }

    function closeContraOfertaModal() {
        document.getElementById('modalContraOferta').classList.add('hidden');
    }
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>


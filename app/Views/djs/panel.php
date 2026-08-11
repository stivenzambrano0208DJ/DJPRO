<?php require APPROOT . '/app/Views/inc/header.php'; ?>
<?php require APPROOT . '/app/Views/inc/sidebar_dj.php'; ?>

<div id="panel-dashboard-container" class="lg:ml-64 p-4 md:p-6">
    <div class="container mx-auto">
        <!-- Alerta de Perfil Incompleto -->
        <?php 
            $missing = [];
            if(empty($data['perfil']->biografia)) $missing[] = 'biografía';
            if($data['perfil']->foto_perfil == 'default_dj.png') $missing[] = 'foto';
            if(empty($data['videos'])) $missing[] = 'videos';
            if(empty($data['perfil']->precio_hora)) $missing[] = 'precio';
            if(empty($data['perfil']->ciudad)) $missing[] = 'ubicación';
            if(empty($data['perfil']->generos)) $missing[] = 'géneros';
            if(empty($data['perfil']->tipos_evento)) $missing[] = 'eventos';

            $perfilIncompleto = !empty($missing);
        ?>
        <?php if($perfilIncompleto): ?>
        <div class="mb-10 bg-djpro-accent/10 border border-djpro-accent/20 p-6 rounded-3xl flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 bg-djpro-accent/20 rounded-2xl flex items-center justify-center text-djpro-accent shrink-0">
                    <i class="bi bi-exclamation-triangle-fill text-3xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-bebas text-white tracking-widest uppercase">¡TU PERFIL ESTÁ INCOMPLETO!</h4>
                    <p class="text-djpro-muted text-sm font-medium">
                        Te falta: <span class="text-djpro-accent font-bold"><?php echo implode(', ', $missing); ?></span>. 
                        Completa esto para destacar en la plataforma.
                    </p>
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
                    <div class="p-6 border-b border-djpro-border flex justify-between items-center bg-djpro-surface-2/50">
                        <h4 class="text-2xl font-bebas text-white tracking-widest">Próximas Solicitudes</h4>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-djpro-surface-2">
                                    <th class="px-4 py-3 text-[10px] font-bold text-djpro-muted uppercase tracking-wider">Cliente</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-djpro-muted uppercase tracking-wider">Fecha</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-djpro-muted uppercase tracking-wider">Hora</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-djpro-muted uppercase tracking-wider">Horas</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-djpro-muted uppercase tracking-wider">Precio</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-djpro-muted uppercase tracking-wider">Estado</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-djpro-muted uppercase tracking-wider text-center">Acciones</th>
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
                                        <td class="px-4 py-4">
                                            <div class="flex items-center gap-2">
                                                <?php if(!empty($con->cliente_foto) && $con->cliente_foto != 'default_dj.png'): ?>
                                                    <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $con->cliente_foto; ?>" class="w-7 h-7 rounded-lg object-cover border border-djpro-border">
                                                <?php else: ?>
                                                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($con->cliente_nombre); ?>&background=1c1c2e&color=f97316" class="w-7 h-7 rounded-lg">
                                                <?php endif; ?>
                                                <span class="font-bold text-white text-sm whitespace-nowrap"><?php echo $con->cliente_nombre; ?></span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-xs font-bold text-white whitespace-nowrap">
                                            <?php echo date('d M, Y', strtotime($con->fecha_evento)); ?>
                                        </td>
                                        <td class="px-4 py-4">
                                            <?php if(!empty($con->hora_inicio)): ?>
                                            <span class="text-[10px] font-bold text-djpro-accent bg-djpro-accent/10 px-2 py-1 rounded-lg border border-djpro-accent/20 flex items-center gap-1 w-fit whitespace-nowrap">
                                                <i class="bi bi-clock-fill"></i>
                                                <?php echo date('h:i A', strtotime($con->hora_inicio)); ?>
                                            </span>
                                            <?php else: ?>
                                            <span class="text-[10px] text-djpro-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-4 text-xs font-bold text-white"><?php echo $con->horas; ?> h</td>
                                        <td class="px-4 py-4 text-sm font-bold text-djpro-accent">
                                            <div class="whitespace-nowrap">$<?php echo number_format($con->precio_total, 0); ?></div>
                                            
                                            <?php if($con->contra_oferta > 0): ?>
                                                <div class="text-[9px] <?php echo $con->quien_contraoferto == 'cliente' ? 'text-djpro-accent' : 'text-yellow-500'; ?> uppercase flex items-center gap-1 font-bold mt-1 whitespace-nowrap">
                                                    <i class="bi <?php echo $con->quien_contraoferto == 'cliente' ? 'bi-lightning-fill' : 'bi-hourglass-split'; ?>"></i>
                                                    <?php echo $con->quien_contraoferto == 'cliente' ? 'Propuesta: ' : 'Oferta: '; ?> 
                                                    $<?php echo number_format($con->contra_oferta, 0); ?>
                                                    <?php if($con->quien_contraoferto == 'dj'): ?>
                                                        <a href="<?php echo URL_ROOT; ?>/contrataciones/cancelar_contra_oferta/<?php echo $con->id; ?>" class="text-red-400 hover:text-red-500 transition-colors" title="Retirar">
                                                            <i class="bi bi-x-circle-fill"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            <?php elseif($con->precio_total > $con->presupuesto_estimado && $con->presupuesto_estimado > 0): ?>
                                                <div class="text-[9px] text-green-500 uppercase flex items-center gap-1 font-bold mt-1 whitespace-nowrap" title="Incremento negociado">
                                                    <i class="bi bi-graph-up-arrow"></i>
                                                    + $<?php echo number_format($con->precio_total - $con->presupuesto_estimado, 0); ?> EXTRA
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-4">
                                            <?php 
                                                $statusClass = 'bg-yellow-500/15 text-yellow-400 border-yellow-500/20';
                                                if($con->estado == 'aceptada') $statusClass = 'bg-yellow-500/15 text-yellow-400 border-yellow-500/20';
                                                if($con->estado == 'confirmada') $statusClass = 'bg-green-500/15 text-green-400 border-green-500/20';
                                                if($con->estado == 'confirmada_total') $statusClass = 'bg-emerald-500/15 text-emerald-400 border-emerald-500/20';
                                                if($con->estado == 'rechazada' || $con->estado == 'cancelada') $statusClass = 'bg-red-500/15 text-red-400 border-red-500/20';
                                                if($con->estado == 'terminada' || $con->estado == 'completada') $statusClass = 'bg-djpro-purple/15 text-djpro-purple border-djpro-purple/20';
                                                
                                                $estadoTexto = str_replace('_', ' ', $con->estado);
                                            ?>
                                            <span class="<?php echo $statusClass; ?> px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider border"><?php echo $estadoTexto; ?></span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex justify-center gap-2">
                                                <?php if($con->estado == 'pendiente'): ?>
                                                    <?php if($con->contra_oferta > 0 && $con->quien_contraoferto == 'cliente'): ?>
                                                        <a href="<?php echo URL_ROOT; ?>/contrataciones/aceptar_contra_oferta_dj/<?php echo $con->id; ?>" class="ajax-action-btn w-8 h-8 rounded-lg bg-djpro-accent/20 text-djpro-accent hover:bg-djpro-accent hover:text-white transition-all flex items-center justify-center" title="Aceptar Propuesta del Cliente">
                                                            <i class="bi bi-check-all"></i>
                                                        </a>
                                                        <a href="<?php echo URL_ROOT; ?>/contrataciones/rechazar_contra_oferta_dj/<?php echo $con->id; ?>" class="ajax-action-btn w-8 h-8 rounded-lg bg-red-500/20 text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center" title="Rechazar Propuesta">
                                                            <i class="bi bi-x-lg"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/aceptada" class="ajax-action-btn w-8 h-8 rounded-lg bg-green-500/20 text-green-500 hover:bg-green-500 hover:text-white transition-all flex items-center justify-center" title="Aceptar">
                                                            <i class="bi bi-check-lg"></i>
                                                        </a>
                                                        <button onclick="openContraOfertaModal(<?php echo $con->id; ?>, <?php echo $con->precio_total; ?>)" class="w-8 h-8 rounded-lg bg-yellow-500/20 text-yellow-500 hover:bg-yellow-500 hover:text-white transition-all flex items-center justify-center" title="Contra-oferta">
                                                            <i class="bi bi-currency-dollar"></i>
                                                        </button>
                                                        <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/rechazada" class="ajax-action-btn w-8 h-8 rounded-lg bg-red-500/20 text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center" title="Rechazar">
                                                            <i class="bi bi-x-lg"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                <?php elseif($con->estado == 'aceptada'): ?>
                                                    <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/confirmada" class="ajax-action-btn w-8 h-8 rounded-lg bg-green-500/20 text-green-500 hover:bg-green-500 hover:text-white transition-all flex items-center justify-center" title="Confirmar Adelanto (50%)">
                                                        <i class="bi bi-cash-coin"></i>
                                                    </a>
                                                    <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/confirmada_total" class="ajax-action-btn w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-500 hover:bg-emerald-500 hover:text-white transition-all flex items-center justify-center" title="Confirmar Pago Total (100%)">
                                                        <i class="bi bi-cash-stack"></i>
                                                    </a>
                                                    <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/cancelada" class="ajax-action-btn w-8 h-8 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center" title="Cancelar Evento" data-confirm="¿Estás seguro de cancelar este evento? Se notificará al cliente.">
                                                        <i class="bi bi-x-circle"></i>
                                                    </a>
                                                <?php elseif($con->estado == 'confirmada' || $con->estado == 'confirmada_total'): ?>
                                                    <?php 
                                                        $fechaEvento = new DateTime($con->fecha_evento);
                                                        $hoy = new DateTime();
                                                        // NOTA PARA PRESENTACIÓN: Se fuerza a true para permitir finalizar hoy mismo
                                                        $puedoFinalizar = true; // ($hoy > $fechaEvento && $hoy->diff($fechaEvento)->days >= 1);
                                                    ?>
                                                    <?php if($puedoFinalizar): ?>
                                                        <a href="javascript:void(0)" onclick="terminarEventoConCarga('<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/terminada')" class="w-8 h-8 rounded-lg bg-djpro-purple/20 text-djpro-purple hover:bg-djpro-purple hover:text-white transition-all flex items-center justify-center" title="Marcar como Terminada">
                                                            <i class="bi bi-flag-fill"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <button class="w-8 h-8 rounded-lg bg-djpro-muted/10 text-djpro-muted opacity-50 cursor-not-allowed flex items-center justify-center" title="Podrás finalizar 24h después del evento">
                                                            <i class="bi bi-flag"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                    
                                                    <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/cancelada" class="ajax-action-btn w-8 h-8 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center" title="Cancelar Evento" data-confirm="¿Estás seguro de cancelar este evento? Se notificará al cliente.">
                                                        <i class="bi bi-x-circle"></i>
                                                    </a>

                                                <?php else: ?>
                                                    <span class="text-[9px] font-bold text-djpro-muted uppercase tracking-tighter">Cerrado</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
<?php if($con->estado == 'confirmada' || $con->estado == 'confirmada_total'): ?>
<tr>
    <td colspan="7" class="px-4 pb-5 pt-2 border-none">
        <div class="bg-[#05140A] border border-green-600/40 p-4 rounded-2xl flex items-center gap-4 shadow-lg">
            <i class="bi <?php echo $con->estado == 'confirmada_total' ? 'bi-patch-check-fill text-emerald-500' : 'bi-check-circle-fill text-green-500'; ?> text-[28px]"></i>
            <div class="flex flex-col gap-0.5">
                <span class="<?php echo $con->estado == 'confirmada_total' ? 'text-emerald-500' : 'text-green-500'; ?> font-bold uppercase tracking-widest text-xs">
                    <?php echo $con->estado == 'confirmada_total' ? '¡Pago Total Confirmado por el DJ!' : '¡Pago Confirmado por el DJ!'; ?>
                </span>
                <span class="text-xs text-white/90 font-medium">
                    <?php echo $con->estado == 'confirmada_total' 
                        ? 'El evento está totalmente pagado. No hay saldo pendiente para cobrar en el evento.' 
                        : 'El resto del dinero se cancelará al momento de que el DJ llegue al evento.'; ?>
                </span>
            </div>
        </div>
    </td>
</tr>
<?php endif; ?>
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
                            <?php 
                                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video->url_video, $match);
                                $youtube_id = $match[1] ?? '';
                            ?>
                            <div class="group relative rounded-xl overflow-hidden border border-djpro-border cursor-pointer" onclick="openVideoModal('<?php echo $youtube_id; ?>', '<?php echo htmlspecialchars($video->titulo, ENT_QUOTES); ?>')">
                                <img src="https://img.youtube.com/vi/<?php echo $youtube_id; ?>/mqdefault.jpg" class="w-full h-32 object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                    <div class="w-12 h-12 bg-djpro-accent/90 rounded-full flex items-center justify-center shadow-lg shadow-orange-500/50">
                                        <i class="bi bi-play-fill text-2xl text-white ml-1"></i>
                                    </div>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-djpro-surface/90 p-2 backdrop-blur-md border-t border-djpro-border flex justify-between items-center">
                                    <span class="text-[10px] font-bold text-white truncate w-4/5 uppercase tracking-widest"><?php echo $video->titulo; ?></span>
                                    <form id="delete-video-form-<?php echo $video->id; ?>" action="<?php echo URL_ROOT; ?>/djs/eliminar_video/<?php echo $video->id; ?>" method="POST" class="inline" onclick="event.stopPropagation()">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <input type="hidden" name="from" value="panel">
                                        <button type="button" onclick="confirmDeleteForm('delete-video-form-<?php echo $video->id; ?>', '¿Quieres eliminar este video de tu portafolio?')" class="text-red-400 hover:text-red-500 transition-colors">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
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

<!-- Modal Reproductor de Video -->
<div id="modalVideo" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-djpro-bg/80 backdrop-blur-sm hidden overflow-y-auto py-10 custom-scrollbar">
    <div class="bg-djpro-surface w-full max-w-3xl rounded-3xl border border-djpro-border shadow-2xl overflow-hidden my-auto">
        <div class="p-4 border-b border-djpro-border flex justify-between items-center bg-djpro-surface-2/50">
            <h5 id="modalVideoTitle" class="text-lg font-bebas text-white tracking-widest uppercase"></h5>
            <button onclick="closeVideoModal()" class="text-djpro-muted hover:text-white transition-all text-xl"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="aspect-video bg-black">
            <iframe id="modalVideoFrame" src="" class="w-full h-full" frameborder="0" allowfullscreen allow="autoplay; encrypted-media"></iframe>
        </div>
    </div>
</div>

<!-- Modal Añadir Video (Tailwind Style) -->
<div id="modalAgregarVideo" class="fixed inset-0 z-[100] flex items-start md:items-center justify-center p-4 bg-djpro-bg/80 backdrop-blur-sm hidden overflow-y-auto py-10 custom-scrollbar">
    <div class="bg-djpro-surface w-full max-w-md rounded-3xl border border-djpro-border shadow-2xl overflow-hidden my-auto">
        <div class="p-6 border-b border-djpro-border flex justify-between items-center bg-djpro-surface-2/50">
            <h5 class="text-xl font-bebas text-white tracking-widest uppercase">Añadir Video</h5>
            <button onclick="closeModal()" class="text-djpro-muted hover:text-white transition-all text-xl"><i class="bi bi-x-lg"></i></button>
        </div>
        <form action="<?php echo URL_ROOT; ?>/djs/agregar_video" method="POST" class="p-6 space-y-6 max-h-[75vh] overflow-y-auto scrollbar-thin">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Título del Video</label>
                <input type="text" name="titulo" placeholder="Ej: Festival Electrónica 2024" class="input-djpro w-full border-djpro-accent/30" required maxlength="60">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">URL de YouTube</label>
                <input type="url" name="url_video" placeholder="https://www.youtube.com/watch?v=..." class="input-djpro w-full border-djpro-accent/30" required>
                <p class="text-[9px] text-djpro-muted font-bold uppercase tracking-tighter">Copia el enlace completo del video.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <button type="button" onclick="closeModal()" class="w-full sm:flex-1 px-6 py-3 border border-djpro-border text-djpro-muted font-bold rounded-xl hover:text-white transition-all order-2 sm:order-1">CANCELAR</button>
                <button type="submit" class="w-full sm:flex-1 btn-djpro-primary order-1 sm:order-2">AGREGAR</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Contra-oferta -->
<div id="modalContraOferta" class="fixed inset-0 z-[100] flex items-start md:items-center justify-center p-4 bg-djpro-bg/80 backdrop-blur-sm hidden overflow-y-auto py-10 custom-scrollbar">
    <div class="bg-djpro-surface w-full max-w-md rounded-3xl border border-djpro-border shadow-2xl overflow-hidden my-auto">
        <div class="p-6 border-b border-djpro-border flex justify-between items-center bg-djpro-surface-2/50">
            <h5 class="text-xl font-bebas text-white tracking-widest uppercase">Enviar Contra-oferta</h5>
            <button onclick="closeContraOfertaModal()" class="text-djpro-muted hover:text-white transition-all text-xl"><i class="bi bi-x-lg"></i></button>
        </div>
        <form id="formContraOferta" action="<?php echo URL_ROOT; ?>/contrataciones/contra_oferta" method="POST" class="ajax-form p-6 space-y-6 max-h-[75vh] overflow-y-auto scrollbar-thin">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="contratacion_id" id="contra_contratacion_id">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Presupuesto del Cliente</label>
                <input type="text" id="cliente_budget" class="input-djpro w-full opacity-50 border-djpro-accent/30" readonly maxlength="30">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Tu Contra-oferta ($)</label>
                <input type="number" name="monto_contra_oferta" placeholder="Ej: 600000" class="input-djpro w-full border-djpro-accent/30" required>
                <p class="text-[9px] text-djpro-muted font-bold uppercase tracking-tighter">Propón un nuevo precio total para este evento.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <button type="button" onclick="closeContraOfertaModal()" class="w-full sm:flex-1 px-6 py-3 border border-djpro-border text-djpro-muted font-bold rounded-xl hover:text-white transition-all order-2 sm:order-1">CANCELAR</button>
                <button type="submit" class="w-full sm:flex-1 btn-djpro-primary order-1 sm:order-2">ENVIAR</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modalAgregarVideo').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('modalAgregarVideo').classList.add('hidden');
    }

    function openVideoModal(youtubeId, title) {
        document.getElementById('modalVideoTitle').textContent = title;
        document.getElementById('modalVideoFrame').src = 'https://www.youtube.com/embed/' + youtubeId + '?autoplay=1';
        document.getElementById('modalVideo').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeVideoModal() {
        document.getElementById('modalVideo').classList.add('hidden');
        document.getElementById('modalVideoFrame').src = ''; // Detener el video
        document.body.style.overflow = '';
    }

    // Cerrar modal de video al hacer clic fuera
    document.getElementById('modalVideo').addEventListener('click', function(e) {
        if (e.target === this) closeVideoModal();
    });

    function openContraOfertaModal(id, budget) {
        document.getElementById('contra_contratacion_id').value = id;
        document.getElementById('cliente_budget').value = '$' + new Intl.NumberFormat().format(budget);
        document.getElementById('modalContraOferta').classList.remove('hidden');
    }

    function closeContraOfertaModal() {
        document.getElementById('modalContraOferta').classList.add('hidden');
    }

    function terminarEventoConCarga(url) {
        Swal.fire({
            title: '¿Finalizar Evento?',
            text: 'Se marcará como terminado y se notificará al cliente para que te califique.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#a855f7',
            cancelButtonColor: '#312e81',
            confirmButtonText: 'SÍ, FINALIZAR',
            cancelButtonText: 'CANCELAR',
            background: '#1c1c2e',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Procesando...',
                    text: 'Notificando al cliente...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    background: '#1c1c2e',
                    color: '#fff',
                    didOpen: () => {
                        Swal.showLoading();
                        // Instead of full redirect, use fetch for seamless update
                        const formData = new FormData();
                        formData.append('csrf_token', '<?php echo $data['csrf_token']; ?>');
                        fetch(url, {
                            method: 'POST',
                            body: formData
                        })
                            .then(res => res.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const newContainer = doc.getElementById('panel-dashboard-container');
                                if (newContainer) {
                                    document.getElementById('panel-dashboard-container').innerHTML = newContainer.innerHTML;
                                }
                                Swal.close();
                            });
                    }
                });
            }
        });
    }

    // AJAX Action Buttons interceptor
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.ajax-action-btn');
        if (btn) {
            e.preventDefault();
            const msg = btn.getAttribute('data-confirm');
            if (msg && !confirm(msg)) {
                return;
            }
            
            // Visual loading state
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-hourglass-split animate-spin"></i>';
            btn.style.pointerEvents = 'none';

            const formData = new FormData();
            formData.append('csrf_token', '<?php echo $data['csrf_token']; ?>');

            fetch(btn.href, {
                method: 'POST',
                body: formData
            })
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContainer = doc.getElementById('panel-dashboard-container');
                    if (newContainer) {
                        document.getElementById('panel-dashboard-container').innerHTML = newContainer.innerHTML;
                    }
                });
        }
    });

    // AJAX Form interceptor for Contra Oferta
    document.addEventListener('submit', function(e) {
        if (e.target.classList.contains('ajax-form')) {
            e.preventDefault();
            const form = e.target;
            const btn = form.querySelector('button[type="submit"]');
            const originalHtml = btn.innerHTML;
            btn.innerHTML = 'ENVIANDO... <i class="bi bi-hourglass-split animate-spin"></i>';
            btn.disabled = true;

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            })
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContainer = doc.getElementById('panel-dashboard-container');
                if (newContainer) {
                    document.getElementById('panel-dashboard-container').innerHTML = newContainer.innerHTML;
                }
                closeContraOfertaModal();
            });
        }
    });
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

<?php $__pageTitle = 'DJPRO | Mi Centro de Eventos'; require APPROOT . '/app/Views/inc/dj_shell_top.php'; ?>

<div>
    <div>
        <!-- Header -->
        <div class="flex flex-col md:row md:flex-row justify-between items-start md:items-center gap-4 mb-10">
            <div>
                <h1 class="text-4xl font-bebas text-white tracking-wider">MI <span class="text-djpro-accent">CENTRO DE EVENTOS</span></h1>
                <p class="text-djpro-muted tracking-wide font-medium">Gestiona tus reservas y descubre nuevos talentos.</p>
            </div>
            <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="btn-djpro-primary px-8 py-3 text-sm">
                BUSCAR DJS <i class="bi bi-search ml-2"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Listado de Reservas -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-djpro-surface rounded-3xl border border-djpro-border overflow-hidden shadow-xl">
                    <div class="p-8 border-b border-djpro-border flex justify-between items-center bg-djpro-surface-2/50">
                        <h4 class="text-2xl font-bebas text-white tracking-widest uppercase">Mis Contrataciones</h4>
                        <span class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest bg-djpro-surface-2 px-3 py-1 rounded-lg border border-djpro-border">
                            Total: <?php echo count($data['contrataciones']); ?>
                        </span>
                    </div>
                    
                    <?php if(empty($data['contrataciones'])): ?>
                        <div class="p-16 text-center">
                            <div class="w-20 h-20 bg-djpro-surface-2 rounded-full flex items-center justify-center mx-auto mb-6 border border-djpro-border shadow-inner">
                                <i class="bi bi-calendar-x text-3xl text-djpro-muted"></i>
                            </div>
                            <p class="text-djpro-muted font-bold uppercase tracking-widest mb-6 text-sm">Aún no tienes reservas activas</p>
                            <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="btn-djpro-primary px-8 py-3 text-xs inline-flex items-center gap-2">
                                ENCONTRAR UN DJ <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="p-6 space-y-6">
                            <?php foreach($data['contrataciones'] as $con): ?>
                                <?php 
                                    $statusConfig = [
                                        'pendiente' => ['bg' => 'bg-yellow-500/10', 'text' => 'text-yellow-500', 'border' => 'border-yellow-500/20', 'icon' => 'bi-clock-history'],
                                        'aceptada' => ['bg' => 'bg-green-500/10', 'text' => 'text-green-500', 'border' => 'border-green-500/20', 'icon' => 'bi-check-circle-fill'],
                                        'confirmada' => ['bg' => 'bg-green-500/10', 'text' => 'text-green-500', 'border' => 'border-green-500/20', 'icon' => 'bi-check-circle-fill'],
                                        'confirmada_total' => ['bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-500', 'border' => 'border-emerald-500/20', 'icon' => 'bi-patch-check-fill'],
                                        'rechazada' => ['bg' => 'bg-red-500/10', 'text' => 'text-red-500', 'border' => 'border-red-500/20', 'icon' => 'bi-x-circle-fill'],
                                        'cancelada' => ['bg' => 'bg-red-500/10', 'text' => 'text-red-500', 'border' => 'border-red-500/20', 'icon' => 'bi-slash-circle'],
                                        'terminada' => ['bg' => 'bg-djpro-purple/10', 'text' => 'text-djpro-purple', 'border' => 'border-djpro-purple/20', 'icon' => 'bi-flag-fill'],
                                        'completada' => ['bg' => 'bg-djpro-purple/10', 'text' => 'text-djpro-purple', 'border' => 'border-djpro-purple/20', 'icon' => 'bi-stars'],
                                    ];
                                    $conf = $statusConfig[$con->estado] ?? $statusConfig['pendiente'];
                                ?>
                                <div class="bg-djpro-surface-2/30 border border-djpro-border rounded-3xl overflow-hidden hover:border-djpro-accent/30 transition-all duration-300 group">
                                    <div class="p-6">
                                        <!-- Banner de Alerta para reservas Aceptadas (Falta Pagar) -->
                                        <?php if($con->estado == 'aceptada'): ?>
                                        <div class="mb-5 bg-yellow-500/10 border border-yellow-500/20 p-4 rounded-2xl flex items-center gap-3">
                                            <i class="bi bi-exclamation-circle-fill text-yellow-500 text-xl animate-pulse"></i>
                                            <p class="text-xs text-djpro-text font-semibold">
                                                <span class="text-yellow-500 font-bold uppercase tracking-wider block">¡Solicitud Aceptada por el DJ!</span>
                                                Tienes 24 horas para realizar el depósito por Nequi, de lo contrario se cancelará.
                                            </p>
                                        </div>
                                        <?php elseif($con->estado == 'confirmada' || $con->estado == 'confirmada_total'): ?>
                                        <!-- Banner de Alerta para reservas Confirmadas (Pagadas) -->
                                        <div class="mb-5 bg-[#05140A] border border-green-600/40 p-4 rounded-2xl flex items-center gap-4 shadow-lg">
                                            <i class="bi <?php echo $con->estado == 'confirmada_total' ? 'bi-patch-check-fill text-emerald-500' : 'bi-check-circle-fill text-green-500'; ?> text-[28px]"></i>
                                            <div class="flex flex-col gap-0.5">
                                                <span class="<?php echo $con->estado == 'confirmada_total' ? 'text-emerald-500' : 'text-green-500'; ?> font-bold uppercase tracking-widest text-xs">
                                                    <?php echo $con->estado == 'confirmada_total' ? '¡Pago Total Confirmado por el DJ!' : '¡Pago Confirmado por el DJ!'; ?>
                                                </span>
                                                <span class="text-xs text-white/90 font-medium">
                                                    <?php echo $con->estado == 'confirmada_total' 
                                                        ? 'Tu evento está pagado al 100%. No tienes saldo pendiente.' 
                                                        : 'El resto del dinero se cancelará al momento de que el DJ llegue al evento.'; ?>
                                                </span>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                            <!-- DJ & Event Info -->
                                            <div class="flex items-center gap-5">
                                                <div class="relative">
                                                    <div class="w-16 h-16 rounded-2xl bg-djpro-surface flex items-center justify-center border border-djpro-border overflow-hidden">
                                                        <?php if(!empty($con->dj_foto) && $con->dj_foto != 'default_dj.png'): ?>
                                                            <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $con->dj_foto; ?>" class="w-full h-full object-cover">
                                                        <?php else: ?>
                                                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($con->dj_nombre); ?>&background=1c1c2e&color=f97316" class="w-full h-full object-cover">
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="absolute -bottom-1 -right-1 w-6 h-6 <?php echo $conf['bg']; ?> <?php echo $conf['text']; ?> border <?php echo $conf['border']; ?> rounded-lg flex items-center justify-center text-xs">
                                                        <i class="bi <?php echo $conf['icon']; ?>"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h5 class="text-xl font-bebas text-white tracking-widest uppercase group-hover:text-djpro-accent transition-colors"><?php echo $con->dj_nombre; ?></h5>
                                                    <div class="flex items-center gap-3 mt-1 flex-wrap">
                                                        <span class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest flex items-center gap-1">
                                                            <i class="bi bi-tag-fill text-djpro-purple"></i> <?php echo $con->tipo_evento; ?>
                                                        </span>
                                                        <span class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest flex items-center gap-1">
                                                            <i class="bi bi-calendar-event text-djpro-accent"></i> <?php echo date('d M, Y', strtotime($con->fecha_evento)); ?>
                                                        </span>
                                                        <?php if(!empty($con->hora_inicio)): ?>
                                                        <span class="text-[10px] font-bold text-djpro-accent uppercase tracking-widest flex items-center gap-1 bg-djpro-accent/10 px-2 py-0.5 rounded-lg border border-djpro-accent/20">
                                                            <i class="bi bi-clock-fill"></i> <?php echo date('h:i A', strtotime($con->hora_inicio)); ?>
                                                        </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Status & Price -->
                                            <div class="flex items-center gap-8 px-6 border-l border-djpro-border/50">
                                                <div class="text-center">
                                                    <span class="block text-[9px] font-bold text-djpro-muted uppercase tracking-tighter mb-1">Estado actual</span>
                                                    <span class="<?php echo $conf['bg']; ?> <?php echo $conf['text']; ?> <?php echo $conf['border']; ?> border px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest whitespace-nowrap inline-block"><?php echo str_replace('_', ' ', $con->estado); ?></span>
                                                </div>
                                                <div class="text-right">
                                                    <span class="block text-[9px] font-bold text-djpro-muted uppercase tracking-tighter mb-1">Inversión</span>
                                                    <span class="text-2xl font-bebas text-djpro-accent tracking-widest">$<?php echo number_format($con->precio_total, 0); ?></span>
                                                </div>
                                            </div>

                                            <!-- Actions -->
                                            <div class="flex items-center gap-3">
                                                <?php if(($con->estado == 'terminada' || $con->estado == 'completada') && empty($con->resena_id)): ?>
                                                    <button onclick="openReviewModal('<?php echo $con->id; ?>', '<?php echo $con->dj_id; ?>', '<?php echo $con->dj_nombre; ?>', '<?php echo $con->tipo_evento; ?>')" 
                                                             class="px-6 py-3 bg-djpro-accent text-white text-[10px] font-bold rounded-xl hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20 uppercase tracking-widest flex items-center gap-2">
                                                         <i class="bi bi-star-fill"></i> CALIFICAR DJ
                                                    </button>
                                                <?php elseif($con->estado == 'aceptada'): ?>
                                                    <a href="https://checkout.nequi.wompi.co/l/PYYtZx?amount-in-cents=<?php echo round($con->precio_total / 2) * 100; ?>" target="_blank" onclick="alertarPagoNequi('<?php echo number_format($con->precio_total / 2, 0); ?>')"
                                                            class="w-full px-5 py-3 bg-djpro-purple text-white text-[10px] font-bold rounded-xl hover:bg-pink-600 transition-all shadow-lg shadow-djpro-purple/20 uppercase tracking-widest flex items-center justify-center gap-2">
                                                        <i class="bi bi-phone-fill"></i> PAGAR 50% POR NEQUI ($<?php echo number_format($con->precio_total / 2, 0); ?>)
                                                    </a>
                                                    <a href="<?php echo URL_ROOT; ?>/chat/index/<?php echo $con->dj_id; ?>" class="w-12 h-12 bg-djpro-surface flex items-center justify-center rounded-xl text-djpro-muted hover:text-white hover:bg-djpro-accent transition-all border border-djpro-border" title="Enviar Mensaje">
                                                        <i class="bi bi-chat-dots-fill text-lg"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="confirmAction('<?php echo URL_ROOT; ?>/contrataciones/cancelar_cliente/<?php echo $con->id; ?>', '¿Cancelar Reserva?', 'Esta acción notificará al DJ y liberará la fecha.', 'warning', 'SÍ, CANCELAR')" 
                                                       class="w-12 h-12 bg-red-500/10 text-red-500 flex items-center justify-center rounded-xl border border-red-500/20 hover:bg-red-500 hover:text-white transition-all"
                                                       title="Cancelar">
                                                        <i class="bi bi-trash3-fill"></i>
                                                    </a>
                                                <?php elseif($con->estado == 'pendiente'): ?>
                                                    <a href="<?php echo URL_ROOT; ?>/chat/index/<?php echo $con->dj_id; ?>" class="w-12 h-12 bg-djpro-surface flex items-center justify-center rounded-xl text-djpro-muted hover:text-white hover:bg-djpro-accent transition-all border border-djpro-border" title="Enviar Mensaje">
                                                        <i class="bi bi-chat-dots-fill text-lg"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="confirmAction('<?php echo URL_ROOT; ?>/contrataciones/cancelar_cliente/<?php echo $con->id; ?>', '¿Cancelar Reserva?', 'Esta acción notificará al DJ y liberará la fecha.', 'warning', 'SÍ, CANCELAR')" 
                                                       class="w-12 h-12 bg-red-500/10 text-red-500 flex items-center justify-center rounded-xl border border-red-500/20 hover:bg-red-500 hover:text-white transition-all"
                                                       title="Cancelar">
                                                        <i class="bi bi-trash3-fill"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- Counter Offer Section -->
                                        <?php if($con->contra_oferta > 0 && $con->estado == 'pendiente'): ?>
                                        <div class="mt-6 pt-6 border-t border-djpro-border/50">
                                            <div class="bg-gradient-to-r <?php echo $con->quien_contraoferto == 'dj' ? 'from-djpro-accent/20' : 'from-blue-500/10'; ?> to-transparent p-5 rounded-2xl border <?php echo $con->quien_contraoferto == 'dj' ? 'border-djpro-accent/20' : 'border-blue-500/20'; ?> flex flex-col md:flex-row items-center justify-between gap-4">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-12 h-12 <?php echo $con->quien_contraoferto == 'dj' ? 'bg-djpro-accent shadow-orange-500/30' : 'bg-blue-500 shadow-blue-500/30'; ?> rounded-xl flex items-center justify-center text-white shadow-lg animate-bounce">
                                                        <i class="bi <?php echo $con->quien_contraoferto == 'dj' ? 'bi-lightning-charge-fill' : 'bi-send-fill'; ?> text-xl"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="text-sm font-bold text-white uppercase tracking-widest"><?php echo $con->quien_contraoferto == 'dj' ? '¡Propuesta del DJ!' : 'Tu Propuesta Enviada'; ?></h6>
                                                        <p class="text-[10px] text-djpro-muted font-medium uppercase tracking-wider">
                                                            <?php echo $con->quien_contraoferto == 'dj' ? 'El DJ ha sugerido un nuevo presupuesto para tu evento.' : 'Esperando respuesta del DJ a tu contra-propuesta.'; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-6">
                                                    <div class="text-right">
                                                        <span class="block text-[9px] font-bold text-djpro-muted uppercase tracking-tighter"><?php echo $con->quien_contraoferto == 'dj' ? 'Precio Sugerido' : 'Tu Oferta'; ?></span>
                                                        <span class="text-2xl font-bebas text-white">$<?php echo number_format($con->contra_oferta, 0); ?></span>
                                                    </div>
                                                    <div class="flex gap-2">
                                                        <?php if($con->quien_contraoferto == 'dj'): ?>
                                                            <a href="<?php echo URL_ROOT; ?>/contrataciones/aceptar_contra_oferta/<?php echo $con->id; ?>" class="btn-djpro-primary px-6 py-3 text-[10px] shadow-orange-500/40">ACEPTAR</a>
                                                            <button onclick="openClientContraOfertaModal('<?php echo $con->id; ?>', '<?php echo $con->contra_oferta; ?>')" class="px-6 py-3 bg-djpro-surface-2 text-white text-[10px] font-bold rounded-xl border border-djpro-border hover:bg-djpro-surface transition-all uppercase tracking-widest">CONTRAOFERTA</button>
                                                            <a href="<?php echo URL_ROOT; ?>/contrataciones/rechazar_contra_oferta/<?php echo $con->id; ?>" class="w-11 h-11 bg-red-500/10 text-red-500 flex items-center justify-center rounded-xl border border-red-500/20 hover:bg-red-500 hover:text-white transition-all" title="Rechazar">
                                                                <i class="bi bi-x-lg"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            <a href="<?php echo URL_ROOT; ?>/contrataciones/rechazar_contra_oferta/<?php echo $con->id; ?>" class="px-6 py-3 bg-red-500/10 text-red-500 text-[10px] font-bold rounded-xl border border-red-500/20 hover:bg-red-500 hover:text-white transition-all uppercase tracking-widest" title="Cancelar mi propuesta">
                                                                CANCELAR MI OFERTA
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                 </div>

                <!-- Sugerencias y Géneros -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-djpro-surface p-6 rounded-3xl border border-djpro-border">
                        <h4 class="text-lg font-bebas text-white tracking-widest mb-4 uppercase">Explorar Ritmos</h4>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach($data['generos'] as $gen): ?>
                                <a href="<?php echo URL_ROOT; ?>/djs/explorar?genero=<?php echo urlencode($gen->nombre); ?>" class="px-4 py-1.5 bg-djpro-surface-2 border border-djpro-border rounded-full text-[10px] font-bold text-djpro-muted hover:border-djpro-accent hover:text-white transition-all cursor-pointer uppercase tracking-widest"><?php echo $gen->nombre; ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="bg-djpro-surface p-6 rounded-3xl border border-djpro-border flex flex-col justify-center items-center text-center">
                        <i class="bi bi-lightning-charge text-3xl text-djpro-purple mb-2"></i>
                        <h4 class="text-lg font-bebas text-white tracking-widest uppercase">Ofertas Flash</h4>
                        <p class="text-[9px] text-djpro-muted font-bold uppercase tracking-tighter">Próximamente: DJs con descuentos de último minuto.</p>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-8">
                <div class="bg-djpro-surface rounded-3xl border border-djpro-border p-8 shadow-xl">
                    <h4 class="text-xl font-bebas text-white tracking-widest uppercase mb-6">Mi Actividad</h4>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-djpro-accent/10 rounded-xl flex items-center justify-center text-djpro-accent">
                                <i class="bi bi-chat-heart"></i>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-white uppercase tracking-wider">Mensajes</span>
                                <span class="text-[10px] text-djpro-muted uppercase font-bold">0 Pendientes</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-djpro-purple/10 rounded-xl flex items-center justify-center text-djpro-purple">
                                <i class="bi bi-star"></i>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-white uppercase tracking-wider">Reseñas</span>
                                <span class="text-[10px] text-djpro-muted uppercase font-bold">Sin calificar</span>
                            </div>
                        </div>
                    </div>
                    <hr class="border-djpro-border my-8">
                    <a href="<?php echo URL_ROOT; ?>/chat" class="btn-djpro-primary w-full text-center py-4 flex items-center justify-center gap-2">
                        IR A MENSAJES <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reseñar DJ -->
<div id="modalReview" class="fixed inset-0 z-[100] flex items-start md:items-center justify-center p-4 bg-djpro-bg/80 backdrop-blur-sm hidden overflow-y-auto py-10 custom-scrollbar">
    <div class="bg-djpro-surface w-full max-w-md rounded-3xl border border-djpro-border shadow-2xl overflow-hidden my-auto">
        <div class="p-6 border-b border-djpro-border flex justify-between items-center bg-djpro-surface-2/50">
            <div>
                <h5 class="text-xl font-bebas text-white tracking-widest uppercase">Calificar a <span id="review-dj-name" class="text-djpro-accent"></span></h5>
                <p id="review-event-type" class="text-[9px] text-djpro-muted font-bold uppercase tracking-widest"></p>
            </div>
            <button onclick="closeReviewModal()" class="text-djpro-muted hover:text-white transition-all text-xl"><i class="bi bi-x-lg"></i></button>
        </div>
        <form id="reviewForm" action="<?php echo URL_ROOT; ?>/resenas/publicar" method="POST" class="p-6 space-y-6 max-h-[75vh] overflow-y-auto scrollbar-thin">
            <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
            <input type="hidden" name="contratacion_id" id="review-contratacion-id">
            <input type="hidden" name="dj_id" id="review-dj-id">
            <input type="hidden" name="puntuacion" id="review-rating" value="5">
            
            <!-- Estrellas -->
            <div class="text-center">
                <label class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest block mb-3">Tu Calificación</label>
                <div class="flex justify-center gap-2 text-3xl">
                    <?php for($i=1; $i<=5; $i++): ?>
                        <i class="bi bi-star-fill cursor-pointer transition-all star-btn text-yellow-500" data-value="<?php echo $i; ?>"></i>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest ml-1">Comentario</label>
                <textarea name="comentario" rows="4" placeholder="¿Cómo fue tu experiencia con el DJ? (Opcional)" class="input-djpro w-full resize-none border-djpro-accent/30"></textarea>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <button type="button" onclick="closeReviewModal()" class="w-full sm:flex-1 px-6 py-3 border border-djpro-border text-djpro-muted font-bold rounded-xl hover:text-white transition-all order-2 sm:order-1">CANCELAR</button>
                <button type="submit" class="w-full sm:flex-1 btn-djpro-primary order-1 sm:order-2">PUBLICAR</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Contra-oferta Cliente -->
<div id="modalClientContraOferta" class="fixed inset-0 z-[100] flex items-start md:items-center justify-center p-4 bg-djpro-bg/80 backdrop-blur-sm hidden overflow-y-auto py-10 custom-scrollbar">
    <div class="bg-djpro-surface w-full max-w-md rounded-3xl border border-djpro-border shadow-2xl overflow-hidden my-auto">
        <div class="p-6 border-b border-djpro-border flex justify-between items-center bg-djpro-surface-2/50">
            <div>
                <h5 class="text-xl font-bebas text-white tracking-widest uppercase">Enviar <span class="text-djpro-accent">Contra-Propuesta</span></h5>
                <p class="text-[9px] text-djpro-muted font-bold uppercase tracking-widest">¿Cuál es tu presupuesto para este DJ?</p>
            </div>
            <button onclick="closeClientContraOfertaModal()" class="text-djpro-muted hover:text-white transition-all text-xl"><i class="bi bi-x-lg"></i></button>
        </div>
        <form action="<?php echo URL_ROOT; ?>/contrataciones/contra_oferta_cliente" method="POST" class="p-6 space-y-6 max-h-[75vh] overflow-y-auto scrollbar-thin">
            <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
            <input type="hidden" name="contratacion_id" id="client-contra-id">
            
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest ml-1">Tu nueva oferta ($)</label>
                <input type="number" name="monto_contra_oferta" id="client-contra-monto" class="input-djpro w-full border-djpro-accent/30" required>
                <p class="text-[9px] text-djpro-muted font-medium italic mt-2">Se notificará al DJ sobre tu nueva propuesta de precio.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <button type="button" onclick="closeClientContraOfertaModal()" class="w-full sm:flex-1 px-6 py-3 border border-djpro-border text-djpro-muted font-bold rounded-xl hover:text-white transition-all order-2 sm:order-1">CANCELAR</button>
                <button type="submit" class="w-full sm:flex-1 btn-djpro-primary order-1 sm:order-2">ENVIAR</button>
            </div>
        </form>
    </div>
</div>

<!-- Nequi Payment Modal removed in favor of direct payment link -->

<script>
    const modalReview = document.getElementById('modalReview');
    const modalClientContra = document.getElementById('modalClientContraOferta');
    const reviewForm = document.getElementById('reviewForm');
    const stars = document.querySelectorAll('.star-btn');
    const ratingInput = document.getElementById('review-rating');

    function openReviewModal(contratacionId, djId, djName, eventType) {
        document.getElementById('review-contratacion-id').value = contratacionId;
        document.getElementById('review-dj-id').value = djId;
        document.getElementById('review-dj-name').innerText = djName;
        document.getElementById('review-event-type').innerText = 'Evento: ' + eventType;
        
        modalReview.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeReviewModal() {
        modalReview.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function openClientContraOfertaModal(id, montoActual) {
        document.getElementById('client-contra-id').value = id;
        document.getElementById('client-contra-monto').value = montoActual;
        modalClientContra.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeClientContraOfertaModal() {
        modalClientContra.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Lógica de Estrellas
    stars.forEach(star => {
        star.addEventListener('click', () => {
            const val = parseInt(star.getAttribute('data-value'));
            ratingInput.value = val;
            
            stars.forEach(s => {
                const sVal = parseInt(s.getAttribute('data-value'));
                if (sVal <= val) {
                    s.classList.replace('bi-star', 'bi-star-fill');
                    s.classList.add('text-yellow-500');
                } else {
                    s.classList.replace('bi-star-fill', 'bi-star');
                    s.classList.remove('text-yellow-500');
                }
            });
        });
    });

    // Envío AJAX
    if (reviewForm) {
        reviewForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(reviewForm);
            
            try {
                const response = await fetch(reviewForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                
                const result = await response.json();
                if (result.success) {
                    djpro.toast(result.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    djpro.toast(result.error || 'Error al publicar reseña', 'error');
                }
            } catch (error) {
                djpro.toast('Reseña publicada con éxito.', 'success');
                setTimeout(() => location.reload(), 1500);
            }
        });
    }

    function alertarPagoNequi(monto) {
        djpro.toast("Recuerda que el pago debe ser de $" + monto + ". Luego notifica al DJ.", "info");
    }
    /* -------------------- */
    // Confirmación genérica (antes en footer.php global)
    function confirmAction(url, title, text, icon = 'question', confirmText = 'SÍ, CONTINUAR') {
        Swal.fire({ title: title, text: text, icon: icon, showCancelButton: true, confirmButtonColor: '#2E5BFF', cancelButtonColor: '#334155', confirmButtonText: confirmText, cancelButtonText: 'CANCELAR', background: '#101018', color: '#f4f5fb' }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form'); form.method = 'POST'; form.action = url; form.style.display = 'none';
                const csrf = document.createElement('input'); csrf.type = 'hidden'; csrf.name = 'csrf_token'; csrf.value = '<?php echo $_SESSION['csrf_token'] ?? ''; ?>';
                form.appendChild(csrf); document.body.appendChild(form); form.submit();
            }
        });
    }
</script>
<?php require APPROOT . '/app/Views/inc/dj_shell_bottom.php'; ?>


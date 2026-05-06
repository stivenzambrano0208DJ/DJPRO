<?php require APPROOT . '/app/Views/inc/header.php'; ?>
<?php require APPROOT . '/app/Views/inc/sidebar_cliente.php'; ?>

<div class="lg:ml-64 p-8">
    <div class="container mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:row md:flex-row justify-between items-start md:items-center gap-4 mb-10">
            <div>
                <h1 class="text-4xl font-bebas text-white tracking-wider">MI <span class="text-djpro-accent">CENTRO DE EVENTOS</span></h1>
                <p class="text-djpro-muted tracking-wide font-medium">Gestiona tus reservas y descubre nuevos talentos.</p>
            </div>
            <a href="<?php echo URL_ROOT; ?>/clientes/explorar" class="btn-djpro-primary px-8 py-3 text-sm">
                BUSCAR DJS <i class="bi bi-search ml-2"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Listado de Reservas -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-djpro-surface rounded-3xl border border-djpro-border overflow-hidden shadow-xl">
                    <div class="p-8 border-b border-djpro-border flex justify-between items-center bg-djpro-surface-2/50">
                        <h4 class="text-2xl font-bebas text-white tracking-widest uppercase">Mis Contrataciones</h4>
                    </div>
                    
                    <?php if(empty($data['contrataciones'])): ?>
                        <div class="p-16 text-center">
                            <div class="w-20 h-20 bg-djpro-surface-2 rounded-full flex items-center justify-center mx-auto mb-6 border border-djpro-border">
                                <i class="bi bi-calendar-x text-3xl text-djpro-muted"></i>
                            </div>
                            <p class="text-djpro-muted font-bold uppercase tracking-widest mb-6 text-sm">Aún no tienes reservas activas</p>
                            <a href="<?php echo URL_ROOT; ?>/clientes/explorar" class="text-djpro-accent hover:underline font-bold text-xs uppercase tracking-widest">Empezar a buscar talentos →</a>
                        </div>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="bg-djpro-surface-2">
                                        <th class="px-8 py-4 text-[10px] font-bold text-djpro-muted uppercase tracking-widest">DJ Artista</th>
                                        <th class="px-8 py-4 text-[10px] font-bold text-djpro-muted uppercase tracking-widest">Fecha Evento</th>
                                        <th class="px-8 py-4 text-[10px] font-bold text-djpro-muted uppercase tracking-widest">Inversión</th>
                                        <th class="px-8 py-4 text-[10px] font-bold text-djpro-muted uppercase tracking-widest">Estado</th>
                                        <th class="px-8 py-4 text-[10px] font-bold text-djpro-muted uppercase tracking-widest text-center">Acciones</th>
                                     </tr>
                                 </thead>
                                 <tbody class="divide-y divide-djpro-border">
                                     <?php foreach($data['contrataciones'] as $con): ?>
                                     <tr class="hover:bg-djpro-surface-2 transition-colors">
                                         <td class="px-8 py-6">
                                             <div class="flex items-center gap-3">
                                                 <div class="w-8 h-8 rounded-lg bg-djpro-purple/20 flex items-center justify-center text-djpro-purple">
                                                     <i class="bi bi-music-note-beamed"></i>
                                                 </div>
                                                 <div>
                                                     <span class="block font-bold text-white text-sm uppercase tracking-wider"><?php echo $con->dj_nombre; ?></span>
                                                     <span class="text-[9px] text-djpro-muted font-bold uppercase tracking-tighter"><?php echo $con->tipo_evento; ?></span>
                                                 </div>
                                             </div>
                                         </td>
                                         <td class="px-8 py-6 text-xs font-bold text-white uppercase tracking-widest"><?php echo date('d M, Y', strtotime($con->fecha_evento)); ?></td>
                                         <td class="px-8 py-6 text-sm font-bold text-djpro-accent">$<?php echo number_format($con->precio_total, 0); ?></td>
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
                                             <div class="flex justify-cente                                                 <?php if(($con->estado == 'terminada' || $con->estado == 'completada') && empty($con->resena_id)): ?>
                                                     <button onclick="openReviewModal('<?php echo $con->id; ?>', '<?php echo $con->dj_id; ?>', '<?php echo $con->dj_nombre; ?>', '<?php echo $con->tipo_evento; ?>')" 
                                                              class="group flex items-center gap-2 px-5 py-2.5 bg-djpro-accent text-white text-[10px] font-bold rounded-xl hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20 uppercase tracking-widest">
                                                          <i class="bi bi-star-fill text-[12px] group-hover:scale-125 transition-transform"></i>
                                                          RESEÑAR DJ
                                                     </button>
                                                 <?php elseif(!empty($con->resena_id)): ?>
                                                     <div class="flex flex-col items-center gap-1">
                                                         <span class="text-[9px] text-green-500 font-bold uppercase tracking-widest flex items-center gap-1">
                                                             <i class="bi bi-patch-check-fill text-xs"></i> CALIFICADO
                                                         </span>
                                                     </div>
                                                 <?php elseif($con->estado == 'pendiente' || $con->estado == 'aceptada'): ?>
                                                     <a href="<?php echo URL_ROOT; ?>/contrataciones/cancelar_cliente/<?php echo $con->id; ?>" 
                                                        class="px-4 py-2 bg-red-500/10 text-red-400 text-[9px] font-bold rounded-xl border border-red-500/20 hover:bg-red-500 hover:text-white transition-all uppercase tracking-widest"
                                                        onclick="return confirm('¿Estás seguro de cancelar esta solicitud? Se notificará al DJ.')">
                                                         Cancelar Solicitud
                                                     </a>
                                                 <?php else: ?>
                                                     <span class="text-[9px] text-djpro-muted font-bold uppercase tracking-widest italic opacity-50">Evento Finalizado</span>
                                                 <?php endif; ?>
f; ?>
                                             </div>
                                         </td>
                                     </tr>
                                     <?php endforeach; ?>
                                 </tbody>
                             </table>
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
<div id="modalReview" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-djpro-bg/80 backdrop-blur-sm hidden">
    <div class="bg-djpro-surface w-full max-w-md rounded-3xl border border-djpro-border shadow-2xl overflow-hidden">
        <div class="p-6 border-b border-djpro-border flex justify-between items-center bg-djpro-surface-2/50">
            <div>
                <h5 class="text-xl font-bebas text-white tracking-widest uppercase">Calificar a <span id="review-dj-name" class="text-djpro-accent"></span></h5>
                <p id="review-event-type" class="text-[9px] text-djpro-muted font-bold uppercase tracking-widest"></p>
            </div>
            <button onclick="closeReviewModal()" class="text-djpro-muted hover:text-white transition-all text-xl"><i class="bi bi-x-lg"></i></button>
        </div>
        <form id="reviewForm" action="<?php echo URL_ROOT; ?>/resenas/publicar" method="POST" class="p-6 space-y-6">
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
                <textarea name="comentario" rows="4" placeholder="¿Cómo fue tu experiencia con el DJ? (Opcional)" class="input-djpro w-full resize-none"></textarea>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeReviewModal()" class="flex-1 px-6 py-3 border border-djpro-border text-djpro-muted font-bold rounded-xl hover:text-white transition-all">CANCELAR</button>
                <button type="submit" class="flex-1 btn-djpro-primary">PUBLICAR</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modalReview = document.getElementById('modalReview');
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
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>


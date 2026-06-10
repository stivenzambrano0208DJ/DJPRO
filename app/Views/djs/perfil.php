<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<!-- Perfil Banner Section -->
<section class="relative h-[300px] md:h-[400px]">
    <!-- Banner Visual con Nombre -->
    <div class="absolute inset-0 bg-djpro-surface-2 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-djpro-purple/20 to-djpro-accent/10"></div>
        <!-- Texto Gigante de Fondo -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.03] select-none">
            <h2 class="text-[20vw] font-bebas leading-none whitespace-nowrap uppercase"><?php echo $data['perfil']->nombre; ?></h2>
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-djpro-bg via-transparent to-transparent"></div>
    </div>

    <!-- Foto y Status -->
    <div class="container mx-auto px-4 h-full relative flex items-end pb-8">
        <div class="flex flex-col md:row md:flex-row items-center md:items-end gap-6 w-full">
            <div class="relative group">
                <div class="w-32 h-32 md:w-48 md:h-48 rounded-2xl border-4 border-djpro-bg overflow-hidden shadow-2xl relative z-10 bg-djpro-surface">
                    <?php if($data['perfil']->foto_perfil != 'default_dj.png'): ?>
                        <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $data['perfil']->foto_perfil; ?>" class="w-full h-full object-cover" alt="DJ Profile">
                    <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($data['perfil']->nombre); ?>&background=12121a&color=f97316" class="w-full h-full object-cover" alt="DJ Profile">
                    <?php endif; ?>
                </div>
                <div class="absolute -bottom-2 -right-2 md:bottom-2 md:right-2 z-20 px-3 py-1 bg-green-500 text-white text-[10px] md:text-xs font-bold uppercase tracking-widest rounded-full border-2 border-djpro-bg shadow-lg">
                    Disponible
                </div>
            </div>

            <div class="flex-1 text-center md:text-left mb-2">
                <h1 class="text-4xl md:text-6xl font-bebas text-white tracking-wider mb-1 uppercase flex items-center justify-center md:justify-start gap-4">
                    <?php echo $data['perfil']->nombre; ?>
                    <?php if($data['perfil']->verificado): ?>
                        <i class="bi bi-patch-check-fill text-djpro-accent text-3xl md:text-4xl" title="DJ Verificado por DJPRO"></i>
                    <?php endif; ?>
                </h1>
                <?php if(!empty($data['perfil']->username)): ?>
                    <p class="text-djpro-accent font-bold text-sm tracking-widest mb-3 uppercase opacity-90">@<?php echo $data['perfil']->username; ?></p>
                <?php endif; ?>
                <div class="flex flex-wrap justify-center md:justify-start items-center gap-4 text-djpro-muted font-semibold tracking-wide">
                    <span class="flex items-center gap-1"><i class="bi bi-geo-alt-fill text-djpro-accent"></i> <?php echo $data['perfil']->ciudad ?: 'Caquetá'; ?></span>
                    <span class="text-white font-bold">
                        <?php if(!empty($data['perfil']->precio_hora)): ?>
                            $<?php echo number_format($data['perfil']->precio_hora, 0); ?> <span class="text-djpro-muted font-normal text-xs">/ hora</span>
                        <?php else: ?>
                            Presupuesto Abierto
                        <?php endif; ?>
                    </span>
                </div>
            </div>

            <!-- Acciones -->
            <div class="flex gap-3 w-full md:w-auto">
                <?php if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] != $data['perfil']->usuario_id): ?>
                <button onclick="openBookingModal()" class="flex-1 md:flex-none btn-djpro-primary px-8 py-4 flex items-center justify-center gap-2">
                    <i class="bi bi-calendar-check text-xl"></i>
                    CONTRATAR
                </button>
                <?php endif; ?>
                <a href="<?php echo URL_ROOT; ?>/chat/index/<?php echo $data['perfil']->usuario_id; ?>" class="w-14 h-14 rounded-xl border border-djpro-border bg-djpro-surface-2 flex items-center justify-center text-xl text-white hover:border-djpro-accent transition-all">
                    <i class="bi bi-chat-dots"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Content Sections -->
<section class="py-12 pb-24">
    <div class="container mx-auto px-4">
        
        <!-- Badges de especialidad -->
        <div class="flex flex-wrap gap-3 mb-12">
            <?php 
            $generos = explode(',', $data['perfil']->generos);
            foreach($generos as $gen): if(!empty($gen)):
            ?>
            <span class="badge-genre !text-sm !py-2 !px-5"><?php echo $gen; ?></span>
            <?php endif; endforeach; ?>
            <span class="h-10 w-[1px] bg-djpro-border mx-2"></span>
            <?php 
            $eventos = explode(',', $data['perfil']->tipos_evento);
            foreach($eventos as $ev): if(!empty($ev)):
            ?>
            <span class="badge-event !text-sm !py-2 !px-5"><?php echo $ev; ?></span>
            <?php endif; endforeach; ?>
        </div>

        <!-- Zonas de Cobertura -->
        <?php if(!empty($data['perfil']->lugares_trabajo)): ?>
        <div class="mb-12 bg-djpro-surface-2 p-8 rounded-3xl border border-djpro-border shadow-inner">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 bg-djpro-accent/10 text-djpro-accent rounded-xl flex items-center justify-center text-2xl">
                    <i class="bi bi-geo-fill"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bebas text-white tracking-widest uppercase">Zonas de Cobertura</h3>
                    <p class="text-[10px] text-djpro-muted font-bold uppercase tracking-widest">Municipios donde este DJ ofrece sus servicios</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-3">
                <?php 
                $lugares = explode(',', $data['perfil']->lugares_trabajo);
                foreach($lugares as $lugar): if(!empty($lugar)):
                ?>
                <span class="px-4 py-2 bg-djpro-bg border border-djpro-border text-white text-xs font-bold rounded-lg hover:border-djpro-accent transition-all cursor-default flex items-center gap-2">
                    <i class="bi bi-pin-map-fill text-djpro-accent"></i>
                    <?php echo trim($lugar); ?>
                </span>
                <?php endif; endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Tabs -->
        <div class="mb-10 border-b border-djpro-border">
            <div class="flex gap-12">
                <button class="tab-btn active border-b-2 border-djpro-accent pb-4 font-bold text-lg text-white tracking-widest uppercase">Videos</button>
                <button class="tab-btn border-b-2 border-transparent pb-4 font-bold text-lg text-djpro-muted hover:text-white tracking-widest uppercase transition-all">Sobre Mí</button>
                <button class="tab-btn border-b-2 border-transparent pb-4 font-bold text-lg text-djpro-muted hover:text-white tracking-widest uppercase transition-all">Reseñas</button>
            </div>
        </div>

        <!-- Tab Content: Videos -->
        <div id="content-videos" class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php if(empty($data['videos'])): ?>
                <div class="col-span-full py-20 text-center bg-djpro-surface rounded-3xl border border-djpro-border border-dashed">
                    <i class="bi bi-play-circle text-4xl text-djpro-muted mb-4 block"></i>
                    <p class="text-djpro-muted font-bold uppercase tracking-widest">Este DJ aún no ha subido videos a su galería.</p>
                </div>
            <?php else: ?>
                <?php foreach($data['videos'] as $video): 
                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video->url_video, $match);
                    $youtube_id = $match[1] ?? '';
                ?>
                <div class="space-y-4 group">
                    <div class="aspect-video bg-djpro-surface-2 rounded-2xl overflow-hidden border border-djpro-border relative">
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/<?php echo $youtube_id; ?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <h4 class="text-xl font-bold text-white uppercase tracking-widest group-hover:text-djpro-accent transition-colors"><?php echo $video->titulo; ?></h4>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Tab Content: Sobre Mí (Hidden) -->
        <div id="content-about" class="hidden max-w-4xl">
            <div class="prose prose-invert max-w-none">
                <p class="text-lg text-djpro-muted leading-relaxed mb-6">
                    <?php echo $data['perfil']->biografia ?: 'Este DJ aún no ha completado su biografía profesional.'; ?>
                </p>
            </div>
        </div>

        <!-- Tab Content: Reseñas (Hidden) -->
        <div id="content-reviews" class="hidden">
            <div class="flex flex-col md:flex-row gap-10">
                <!-- Puntuación general -->
                <div class="w-full md:w-64 flex-shrink-0">
                    <div class="bg-djpro-surface p-8 rounded-2xl border border-djpro-border text-center sticky top-4">
                        <h3 class="text-7xl font-bebas text-white"><?php echo number_format($data['perfil']->calificacion_promedio, 1); ?></h3>
                        <div class="flex justify-center gap-1 text-yellow-500 text-xl mb-2">
                            <?php for($i=1; $i<=5; $i++): ?>
                                <i class="bi <?php echo $i <= round($data['perfil']->calificacion_promedio) ? 'bi-star-fill' : 'bi-star'; ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="text-djpro-muted font-bold tracking-widest uppercase text-[10px] block">Puntuación General</span>
                        <span class="text-[10px] text-djpro-accent font-bold mt-1 block"><?php echo count($data['resenas']); ?> reseña(s)</span>
                    </div>
                </div>

                <!-- Lista de reseñas -->
                <div class="flex-1 space-y-4">
                    <?php if(empty($data['resenas'])): ?>
                        <div class="py-16 text-center border-2 border-dashed border-djpro-border rounded-3xl">
                            <i class="bi bi-chat-square-heart text-4xl text-djpro-muted mb-3 block"></i>
                            <p class="text-djpro-muted uppercase font-bold tracking-widest text-sm">Este DJ aún no tiene reseñas.</p>
                            <p class="text-djpro-muted text-xs mt-1">¡Sé el primero en calificarlo después de tu evento!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($data['resenas'] as $res): ?>
                        <div class="bg-djpro-surface border border-djpro-border rounded-2xl p-6 hover:border-djpro-accent/30 transition-all">
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-djpro-surface-2 border border-djpro-border flex items-center justify-center text-[11px] font-bold text-djpro-accent">
                                        <?php echo strtoupper(substr($res->cliente_nombre, 0, 2)); ?>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-bold text-white uppercase tracking-wider"><?php echo $res->cliente_nombre; ?></span>
                                        <span class="text-[9px] text-djpro-muted font-bold uppercase tracking-widest"><?php echo date('d M, Y', strtotime($res->fecha_creacion)); ?></span>
                                    </div>
                                </div>
                                <div class="flex gap-0.5 text-yellow-500 flex-shrink-0">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <i class="bi <?php echo $i <= $res->puntuacion ? 'bi-star-fill' : 'bi-star'; ?> text-sm"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <?php if(!empty($res->comentario)): ?>
                                <p class="text-djpro-muted text-sm leading-relaxed italic">"<?php echo htmlspecialchars($res->comentario); ?>"</p>
                            <?php else: ?>
                                <p class="text-djpro-muted text-xs italic opacity-60">Sin comentario adicional.</p>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>


    </div>
</section>

<!-- Modal Contratar -->
<div id="modalBooking" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-djpro-bg/80 backdrop-blur-sm hidden">
    <div class="bg-djpro-surface w-full max-w-lg rounded-3xl border border-djpro-border shadow-2xl overflow-hidden">
        <div class="p-8 border-b border-djpro-border flex justify-between items-center bg-djpro-surface-2/50">
            <div>
                <h5 class="text-2xl font-bebas text-white tracking-widest uppercase">CONTRATAR A <span class="text-djpro-accent"><?php echo $data['perfil']->nombre; ?></span></h5>
                <p class="text-[10px] text-djpro-muted font-bold uppercase tracking-widest mt-1">Coordinemos tu gran evento</p>
            </div>
            <button onclick="closeBookingModal()" class="text-djpro-muted hover:text-white transition-all text-xl"><i class="bi bi-x-lg"></i></button>
        </div>
        <form id="bookingForm" action="<?php echo URL_ROOT; ?>/contrataciones/solicitar" method="POST" class="p-8 space-y-6 max-h-[75vh] overflow-y-auto">
            <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
            <input type="hidden" name="dj_id" value="<?php echo $data['perfil']->usuario_id; ?>">
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1">Fecha del Evento</label>
                    <input type="date" name="fecha_evento" class="input-djpro w-full cursor-pointer border-djpro-accent/30" required min="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1">Hora Inicio</label>
                    <input type="time" name="hora_inicio" class="input-djpro w-full cursor-pointer border-djpro-accent/30" required>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1">Hora Fin</label>
                    <input type="time" name="hora_fin" class="input-djpro w-full cursor-pointer border-djpro-accent/30" required>
                </div>
            </div>

            <div id="time-error-msg" class="hidden bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold uppercase tracking-widest rounded-xl px-4 py-3 flex items-center gap-2">
                <i class="bi bi-clock-history"></i>
                <span>No puedes agendar en una hora que ya pasó hoy. Elige una hora futura.</span>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1">Tipo de Evento</label>
                <select name="evento" class="input-djpro w-full cursor-pointer outline-none appearance-none border-djpro-accent/30" required>
                    <option value="">Seleccionar...</option>
                    <option value="Boda">Boda</option>
                    <option value="XV Años">XV Años</option>
                    <option value="Corporativo">Corporativo</option>
                    <option value="Discoteca / Bar">Discoteca / Bar</option>
                    <option value="Fiesta Privada">Fiesta Privada</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1">Horas de Servicio</label>
                    <input type="number" name="horas" id="booking_horas" value="1" min="1" step="0.5" class="input-djpro w-full border-djpro-accent/30" oninput="calcularTotal()">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1">Total Estimado ($)</label>
                    <input type="number" name="presupuesto_estimado" id="booking_estimado" value="<?php echo $data['perfil']->precio_hora ?: ''; ?>" class="input-djpro w-full opacity-60 border-djpro-accent/30" readonly>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1">Mi Presupuesto para el Evento ($)</label>
                <input type="number" name="precio_total" id="booking_total" value="<?php echo $data['perfil']->precio_hora ?: ''; ?>" placeholder="Ej: 500.000" class="input-djpro w-full border-djpro-accent/30" required>
                <p class="text-[9px] text-djpro-muted font-bold uppercase tracking-tighter">Indica cuánto estás dispuesto a pagar por el servicio.</p>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1">Detalles y Expectativas</label>
                <textarea name="mensaje_cliente" rows="4" placeholder="Háblale al DJ sobre tu evento..." class="input-djpro w-full resize-none border-djpro-accent/30"></textarea>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <button type="button" onclick="closeBookingModal()" class="w-full sm:flex-1 px-8 py-4 border border-djpro-border text-djpro-muted font-bold rounded-xl hover:text-white transition-all order-2 sm:order-1">CANCELAR</button>
                <button type="submit" class="w-full sm:flex-1 btn-djpro-primary py-4 order-1 sm:order-2 shadow-lg shadow-orange-500/20">ENVIAR SOLICITUD</button>
            </div>
        </form>
    </div>
</div>

<script>
    const tabs = document.querySelectorAll('.tab-btn');
    const contentVideos = document.getElementById('content-videos');
    const contentAbout = document.getElementById('content-about');
    const contentReviews = document.getElementById('content-reviews');

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => {
                t.classList.remove('active', 'border-djpro-accent', 'text-white');
                t.classList.add('border-transparent', 'text-djpro-muted');
            });
            tab.classList.add('active', 'border-djpro-accent', 'text-white');
            tab.classList.remove('border-transparent', 'text-djpro-muted');
            [contentVideos, contentAbout, contentReviews].forEach(c => c.classList.add('hidden'));
            if(index === 0) contentVideos.classList.remove('hidden');
            if(index === 1) contentAbout.classList.remove('hidden');
            if(index === 2) contentReviews.classList.remove('hidden');
        });
    });

    const modal = document.getElementById('modalBooking');
    const bookingForm = document.getElementById('bookingForm');

    function openBookingModal() {
        <?php if(!isset($_SESSION['usuario_id'])): ?>
            window.location.href = '<?php echo URL_ROOT; ?>/usuarios/login?redirect=djs/perfil/<?php echo $data['perfil']->usuario_id; ?>&reservar=1';
            return;
        <?php endif; ?>
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeBookingModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // AJAX Submission
    if (bookingForm) {
        bookingForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = bookingForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerText;
            
            submitBtn.innerText = 'ENVIANDO...';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.7';
            submitBtn.style.cursor = 'not-allowed';

            const formData = new FormData(bookingForm);
            
            try {
                const response = await fetch(bookingForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    Swal.fire({ title: '¡Solicitud Enviada!', text: result.message, icon: 'success', confirmButtonColor: '#f97316', background: '#12121a', color: '#fff' });
                    closeBookingModal();
                    bookingForm.reset();
                } else {
                    Swal.fire({ title: 'No disponible', text: result.error || 'Error al enviar solicitud', icon: 'warning', confirmButtonColor: '#f97316', background: '#12121a', color: '#fff' });
                }
            } catch (error) {
                console.error(error);
                Toast.fire({icon: 'error', title: 'Error de conexión. Intente nuevamente.'});
            } finally {
                submitBtn.innerText = originalText;
                submitBtn.disabled = false;
            }
        });
    }

    // Cálculo dinámico de total y horas
    function calcularTotal() {
        const precioHora = <?php echo $data['perfil']->precio_hora ?: 0; ?>;
        const horaInicio = document.querySelector('input[name="hora_inicio"]').value;
        const horaFin = document.querySelector('input[name="hora_fin"]').value;
        const horasInput = document.getElementById('booking_horas');
        const estimadoInput = document.getElementById('booking_estimado');
        const totalInput = document.getElementById('booking_total');
        
        // Calcular horas si ambas están presentes
        if (horaInicio && horaFin) {
            const start = new Date(`2000-01-01T${horaInicio}:00`);
            let end = new Date(`2000-01-01T${horaFin}:00`);
            
            // Si la hora de fin es menor a la de inicio, asumimos que es del día siguiente
            if (end <= start) {
                end = new Date(`2000-01-02T${horaFin}:00`);
            }
            
            const diffMs = end - start;
            const diffHrs = diffMs / (1000 * 60 * 60);
            horasInput.value = Math.max(1, Math.round(diffHrs * 2) / 2); // Redondear a 0.5 más cercano
        }

        const horas = horasInput.value;
        if (precioHora > 0) {
            const total = Math.max(0, Math.round(precioHora * horas));
            estimadoInput.value = total;
            // Opcional: totalInput.value = total; 
        }
    }

    // Agregar listeners a los campos de hora
    document.addEventListener('DOMContentLoaded', function() {
        const hi = document.querySelector('input[name="hora_inicio"]');
        const hf = document.querySelector('input[name="hora_fin"]');
        const hs = document.getElementById('booking_horas');
        const fechaInput = document.querySelector('input[name="fecha_evento"]');
        const timeErrorMsg = document.getElementById('time-error-msg');
        const submitBtn = document.querySelector('#bookingForm button[type="submit"]');

        function validarHoraPasada() {
            if (!hi || !fechaInput) return true;
            const hoy = new Date();
            const fechaSeleccionada = fechaInput.value;
            const todayStr = hoy.toISOString().split('T')[0];

            if (fechaSeleccionada === todayStr && hi.value) {
                const [h, m] = hi.value.split(':').map(Number);
                const horaSeleccionada = new Date();
                horaSeleccionada.setHours(h, m, 0, 0);

                if (horaSeleccionada <= hoy) {
                    timeErrorMsg.classList.remove('hidden');
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.5';
                    submitBtn.style.cursor = 'not-allowed';
                    return false;
                }
            }
            timeErrorMsg.classList.add('hidden');
            submitBtn.disabled = false;
            submitBtn.style.opacity = '';
            submitBtn.style.cursor = '';
            return true;
        }

        if (hi) hi.addEventListener('change', () => { validarHoraPasada(); calcularTotal(); });
        if (hf) hf.addEventListener('change', calcularTotal);
        if (hs) hs.addEventListener('input', calcularTotal);
        if (fechaInput) fechaInput.addEventListener('change', validarHoraPasada);

        // Bloquear submit si la hora es pasada
        const form = document.getElementById('bookingForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!validarHoraPasada()) {
                    e.preventDefault();
                    return false;
                }
            }, true);
        }
    });

    // Auto-open modal if flag is present
    window.addEventListener('load', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('reservar') === '1') {
            openBookingModal();
        }
    });
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

<?php require APPROOT . '/app/Views/inc/header.php'; ?>
<?php if(isset($_SESSION['usuario_id'])): ?>
    <?php 
        if($_SESSION['usuario_rol'] == 'dj') {
            require APPROOT . '/app/Views/inc/sidebar_dj.php';
        } elseif($_SESSION['usuario_rol'] == 'admin') {
            require APPROOT . '/app/Views/inc/admin_sidebar.php';
        } else {
            require APPROOT . '/app/Views/inc/sidebar_cliente.php';
        }
    ?>
<?php endif; ?>

<div class="<?php echo isset($_SESSION['usuario_id']) ? 'lg:ml-64' : ''; ?> p-8">
    <div class="container mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bebas text-white tracking-widest mb-4">EXPLORAR <span class="text-djpro-accent">TALENTOS</span></h1>
            <p class="text-djpro-muted font-medium tracking-wide">Encuentra al artista perfecto para tu próximo evento en el Caquetá.</p>
        </div>

        <!-- Filtros de Búsqueda -->
        <div class="bg-djpro-surface p-8 rounded-3xl border border-djpro-border shadow-2xl mb-12">
            <form action="<?php echo URL_ROOT; ?>/djs/explorar" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest ml-1">Ciudad / Municipio</label>
                    <select name="ciudad" class="input-djpro w-full outline-none appearance-none cursor-pointer">
                        <option value="">Todas las ciudades</option>
                        <option value="Florencia" <?php echo ($data['filtros']['ciudad'] == 'Florencia') ? 'selected' : ''; ?>>Florencia</option>
                        <option value="Morelia" <?php echo ($data['filtros']['ciudad'] == 'Morelia') ? 'selected' : ''; ?>>Morelia</option>
                        <option value="Belén" <?php echo ($data['filtros']['ciudad'] == 'Belén') ? 'selected' : ''; ?>>Belén</option>
                        <option value="Curillo" <?php echo ($data['filtros']['ciudad'] == 'Curillo') ? 'selected' : ''; ?>>Curillo</option>
                        <option value="San Vicente" <?php echo ($data['filtros']['ciudad'] == 'San Vicente') ? 'selected' : ''; ?>>San Vicente</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest ml-1">Género Musical</label>
                    <select name="genero" class="input-djpro w-full outline-none appearance-none cursor-pointer">
                        <option value="">Todos los géneros</option>
                        <?php foreach($data['generos'] as $gen): ?>
                            <option value="<?php echo $gen->nombre; ?>" <?php echo ($data['filtros']['genero'] == $gen->nombre) ? 'selected' : ''; ?>><?php echo $gen->nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest ml-1">Tipo de Evento</label>
                    <select name="evento" class="input-djpro w-full outline-none appearance-none cursor-pointer">
                        <option value="">Todos los eventos</option>
                        <?php foreach($data['tipos_evento'] as $ev): ?>
                            <option value="<?php echo $ev->nombre; ?>" <?php echo ($data['filtros']['evento'] == $ev->nombre) ? 'selected' : ''; ?>><?php echo $ev->nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn-djpro-primary w-full py-3.5 flex items-center justify-center gap-2">
                    <i class="bi bi-search"></i> FILTRAR
                </button>
            </form>
        </div>

        <!-- Lista de DJs -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if(empty($data['djs'])): ?>
                <div class="col-span-full text-center py-20">
                    <div class="w-24 h-24 bg-djpro-surface-2 rounded-full flex items-center justify-center mx-auto mb-6 border border-djpro-border">
                        <i class="bi bi-person-x text-4xl text-djpro-muted"></i>
                    </div>
                    <h3 class="text-2xl font-bebas text-white tracking-widest mb-2">No se encontraron DJs</h3>
                    <p class="text-djpro-muted">Intenta ajustar tus filtros de búsqueda.</p>
                </div>
            <?php else: ?>
                <?php foreach($data['djs'] as $dj): ?>
                <div class="dj-card group rounded-2xl overflow-hidden relative">
                    <div class="h-40 bg-djpro-surface-2 relative overflow-hidden">
                        <!-- Nombre de fondo estilizado -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-[0.05] pointer-events-none">
                            <span class="text-6xl font-bebas uppercase whitespace-nowrap"><?php echo $dj->nombre; ?></span>
                        </div>
                        <?php if($dj->foto_perfil != 'default_dj.png'): ?>
                            <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $dj->foto_perfil; ?>" class="w-full h-full object-cover opacity-60 group-hover:scale-110 transition-transform duration-700">
                        <?php endif; ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-djpro-surface to-transparent"></div>
                    </div>

                    <!-- Perfil y Datos -->
                    <div class="p-6 pt-0 relative -mt-12 text-center">
                        <div class="w-20 h-20 rounded-2xl border-4 border-djpro-surface bg-djpro-surface-2 mx-auto overflow-hidden shadow-2xl group-hover:border-djpro-accent transition-all duration-300">
                            <?php if($dj->foto_perfil != 'default_dj.png'): ?>
                                <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $dj->foto_perfil; ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($dj->nombre); ?>&background=12121a&color=f97316" class="w-full h-full object-cover">
                            <?php endif; ?>
                        </div>
                        
                        <div class="mt-4">
                            <h3 class="text-2xl font-bebas text-white group-hover:text-djpro-accent transition-colors tracking-widest"><?php echo $dj->nombre; ?></h3>
                            <div class="flex items-center justify-center gap-1 text-djpro-muted text-[10px] uppercase font-bold tracking-widest mb-4">
                                <i class="bi bi-geo-alt-fill text-djpro-accent"></i>
                                <span><?php echo $dj->ciudad ? $dj->ciudad : 'Caquetá'; ?></span>
                            </div>
                            
                            <p class="text-[11px] text-djpro-muted font-medium italic mb-6 line-clamp-2 px-2">
                                <?php echo $dj->biografia ? $dj->biografia : 'Este DJ aún no ha completado su biografía profesional.'; ?>
                            </p>

                            <div class="flex items-center justify-between pt-4 border-t border-djpro-border">
                                <div class="text-left">
                                    <span class="block text-[10px] text-djpro-muted uppercase font-bold tracking-tighter">Rating</span>
                                    <div class="flex text-yellow-500 text-[10px]">
                                        <i class="bi bi-star-fill"></i>
                                        <span class="ml-1 text-white"><?php echo number_format($dj->calificacion_promedio, 1); ?></span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="block text-[10px] text-djpro-muted uppercase font-bold tracking-tighter">Status</span>
                                    <span class="text-[10px] font-bold text-green-500 uppercase tracking-widest">Disponible</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Hover Layer -->
                    <div class="absolute inset-0 bg-djpro-bg/90 backdrop-blur-md opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-center gap-4 p-8">
                        <?php if(isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $dj->id): ?>
                            <div class="text-djpro-accent font-bebas text-2xl tracking-widest mb-2">ES TU PERFIL</div>
                            <a href="<?php echo URL_ROOT; ?>/djs/editar" class="btn-djpro-primary w-full text-center py-3.5 shadow-xl shadow-orange-500/20">
                                EDITAR PERFIL
                            </a>
                            <a href="<?php echo URL_ROOT; ?>/djs/perfil/<?php echo $dj->id; ?>" class="text-[10px] text-djpro-muted hover:text-white font-bold uppercase tracking-widest mt-4">Ver Perfil Público</a>
                        <?php else: ?>
                            <?php if(isset($_SESSION['usuario_id'])): ?>
                                <button onclick="openModal('<?php echo $dj->id; ?>')" class="btn-djpro-primary w-full text-center py-3.5 shadow-xl shadow-orange-500/20">
                                    CONTRATAR AHORA
                                </button>
                            <?php else: ?>
                                <a href="<?php echo URL_ROOT; ?>/usuarios/login?redirect=djs/perfil/<?php echo $dj->id; ?>&reservar=1" class="btn-djpro-primary w-full text-center py-3.5 shadow-xl shadow-orange-500/20">
                                    CONTRATAR AHORA
                                </a>
                            <?php endif; ?>
                            <a href="<?php echo URL_ROOT; ?>/chat/index/<?php echo $dj->id; ?>" class="w-full py-3.5 border border-djpro-purple text-djpro-purple font-bold rounded-xl hover:bg-djpro-purple hover:text-white transition-all text-center">
                                CHATEAR CON DJ
                            </a>
                            <a href="<?php echo URL_ROOT; ?>/djs/perfil/<?php echo $dj->id; ?>" class="text-[10px] text-djpro-muted hover:text-white font-bold uppercase tracking-widest">Ver Perfil Completo</a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Modal Contratar -->
                <div id="modal-<?php echo $dj->id; ?>" class="fixed inset-0 z-[100] flex items-start md:items-center justify-center p-4 bg-djpro-bg/80 backdrop-blur-sm hidden overflow-y-auto py-10 custom-scrollbar">
                    <div class="bg-djpro-surface w-full max-w-lg rounded-3xl border border-djpro-border shadow-2xl overflow-hidden my-auto">
                        <div class="p-8 border-b border-djpro-border flex justify-between items-center bg-djpro-surface-2/50">
                            <div>
                                <h5 class="text-2xl font-bebas text-white tracking-widest uppercase">CONTRATAR A <span class="text-djpro-accent"><?php echo $dj->nombre; ?></span></h5>
                                <p class="text-[10px] text-djpro-muted font-bold uppercase tracking-widest mt-1">Completa los detalles de tu evento</p>
                            </div>
                            <button onclick="closeModal('<?php echo $dj->id; ?>')" class="text-djpro-muted hover:text-white transition-all text-xl"><i class="bi bi-x-lg"></i></button>
                        </div>
                        <form action="<?php echo URL_ROOT; ?>/contrataciones/solicitar" method="POST" class="p-8 space-y-6 max-h-[75vh] overflow-y-auto scrollbar-thin">
                            <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
                            <input type="hidden" name="dj_id" value="<?php echo $dj->id; ?>">
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1">Fecha</label>
                                    <input type="date" name="fecha_evento" class="input-djpro w-full cursor-pointer border-djpro-accent/30" required min="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1">Hora Inicio</label>
                                    <input type="time" name="hora_inicio" id="inicio-<?php echo $dj->id; ?>" class="input-djpro w-full cursor-pointer border-djpro-accent/30" required onchange="calcularTotal('<?php echo $dj->id; ?>', <?php echo $dj->precio_hora ?: 0; ?>)">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1">Hora Fin</label>
                                    <input type="time" name="hora_fin" id="fin-<?php echo $dj->id; ?>" class="input-djpro w-full cursor-pointer border-djpro-accent/30" required onchange="calcularTotal('<?php echo $dj->id; ?>', <?php echo $dj->precio_hora ?: 0; ?>)">
                                </div>
                            </div>

                            <div id="time-error-<?php echo $dj->id; ?>" class="hidden bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold uppercase tracking-widest rounded-xl px-4 py-3 flex items-center gap-2">
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

                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1">Horas de Servicio</label>
                                <input type="number" name="horas" id="horas-<?php echo $dj->id; ?>" value="1" min="1" step="0.5" class="input-djpro w-full border-djpro-accent/30" oninput="calcularTotal('<?php echo $dj->id; ?>', <?php echo $dj->precio_hora ?: 0; ?>)">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1">Total Estimado ($)</label>
                                    <input type="number" name="presupuesto_estimado" id="estimado-<?php echo $dj->id; ?>" value="<?php echo $dj->precio_hora ?: ''; ?>" class="input-djpro w-full opacity-60 border-djpro-accent/30" readonly>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1">Mi Presupuesto ($)</label>
                                    <input type="number" name="precio_total" id="total-<?php echo $dj->id; ?>" value="<?php echo $dj->precio_hora ?: ''; ?>" placeholder="Ej: 500.000" class="input-djpro w-full border-djpro-accent/30" required>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1">Detalles del Evento</label>
                                <textarea name="mensaje_cliente" rows="4" placeholder="Cuéntale al DJ sobre el tipo de evento, duración y expectativas..." class="input-djpro w-full resize-none border-djpro-accent/30"></textarea>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                                <button type="button" onclick="closeModal('<?php echo $dj->id; ?>')" class="w-full sm:flex-1 px-8 py-4 border border-djpro-border text-djpro-muted font-bold rounded-xl hover:text-white transition-all order-2 sm:order-1">CANCELAR</button>
                                <button type="submit" class="w-full sm:flex-1 btn-djpro-primary py-4 order-1 sm:order-2 shadow-lg shadow-orange-500/20">ENVIAR SOLICITUD</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(`modal-${id}`).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(`modal-${id}`).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function calcularTotal(id, precioHora) {
        const horaInicio = document.getElementById(`inicio-${id}`).value;
        const horaFin = document.getElementById(`fin-${id}`).value;
        const horasInput = document.getElementById(`horas-${id}`);
        const estimadoInput = document.getElementById(`estimado-${id}`);
        
        if (horaInicio && horaFin) {
            const start = new Date(`2000-01-01T${horaInicio}:00`);
            let end = new Date(`2000-01-01T${horaFin}:00`);
            if (end <= start) end = new Date(`2000-01-02T${horaFin}:00`);
            const diffHrs = (end - start) / (1000 * 60 * 60);
            horasInput.value = Math.max(1, Math.round(diffHrs * 2) / 2); // Redondear a 0.5 más cercano
        }

        const horas = horasInput.value;
        if (precioHora > 0) {
            estimadoInput.value = Math.max(0, Math.round(precioHora * horas));
        }
    }

    // --- Validación hora pasada y anti-doble-envío ---
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('form[action$="/contrataciones/solicitar"]').forEach(function (form) {
            const djId = form.querySelector('input[name="dj_id"]').value;
            const fechaInput = form.querySelector('input[name="fecha_evento"]');
            const horaInicioInput = form.querySelector('input[name="hora_inicio"]');
            const submitBtn = form.querySelector('button[type="submit"]');
            const errorDiv = document.getElementById('time-error-' + djId);

            function validarHoraPasada() {
                if (!fechaInput || !horaInicioInput || !horaInicioInput.value) {
                    if (errorDiv) errorDiv.classList.add('hidden');
                    if (submitBtn) { submitBtn.disabled = false; submitBtn.style.opacity = ''; submitBtn.style.cursor = ''; }
                    return true;
                }
                const hoy = new Date();
                const todayStr = hoy.toISOString().split('T')[0];
                if (fechaInput.value === todayStr) {
                    const [h, m] = horaInicioInput.value.split(':').map(Number);
                    const horaSeleccionada = new Date();
                    horaSeleccionada.setHours(h, m, 0, 0);
                    if (horaSeleccionada <= hoy) {
                        if (errorDiv) errorDiv.classList.remove('hidden');
                        if (submitBtn) { submitBtn.disabled = true; submitBtn.style.opacity = '0.5'; submitBtn.style.cursor = 'not-allowed'; }
                        return false;
                    }
                }
                if (errorDiv) errorDiv.classList.add('hidden');
                if (submitBtn) { submitBtn.disabled = false; submitBtn.style.opacity = ''; submitBtn.style.cursor = ''; }
                return true;
            }

            if (horaInicioInput) horaInicioInput.addEventListener('change', validarHoraPasada);
            if (fechaInput) fechaInput.addEventListener('change', validarHoraPasada);

            // Manejo AJAX y Anti-doble-envío
            form.setAttribute('data-no-protect', 'true'); // Prevenir que footer.php intercepte
            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                
                if (!validarHoraPasada()) { return false; }
                if (form.dataset.submitting === 'true') { return false; }
                
                form.dataset.submitting = 'true';
                const originalText = submitBtn.innerHTML;
                
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split mr-2"></i> ENVIANDO...';
                    submitBtn.style.opacity = '0.7';
                    submitBtn.style.cursor = 'not-allowed';
                }

                const formData = new FormData(form);
                
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        Swal.fire({ title: '¡Solicitud Enviada!', text: result.message, icon: 'success', confirmButtonColor: '#f97316', background: '#12121a', color: '#fff' });
                        closeModal(djId);
                        form.reset();
                    } else {
                        Swal.fire({ title: 'No disponible', text: result.error || 'Error al enviar solicitud', icon: 'warning', confirmButtonColor: '#f97316', background: '#12121a', color: '#fff' });
                    }
                } catch (error) {
                    console.error(error);
                    Toast.fire({icon: 'error', title: 'Error de conexión. Intente nuevamente.'});
                } finally {
                    form.dataset.submitting = 'false';
                    if (submitBtn) {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                        submitBtn.style.opacity = '';
                        submitBtn.style.cursor = '';
                    }
                }
            });
        });
    });
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

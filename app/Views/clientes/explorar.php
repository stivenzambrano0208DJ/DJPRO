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

<style>
  .expx{font-family:'Sora',system-ui,sans-serif}
  .expx .grad{background:linear-gradient(105deg,#2E5BFF,#00C2FF);-webkit-background-clip:text;background-clip:text;color:transparent}
  /* Header */
  .expx-head{text-align:center;margin-bottom:2.5rem}
  .expx-kick{display:inline-flex;align-items:center;gap:.5rem;font-family:'Space Mono','JetBrains Mono',monospace;font-size:.72rem;letter-spacing:.18em;text-transform:uppercase;color:#00C2FF;background:rgba(0,194,255,.08);border:1px solid rgba(0,194,255,.2);padding:.4rem 1rem;border-radius:100px;margin-bottom:1.2rem}
  .expx-kick .dot{width:7px;height:7px;border-radius:50%;background:#22c55e;box-shadow:0 0 8px #22c55e;animation:expulse 1.6s infinite}
  @keyframes expulse{0%,100%{opacity:1}50%{opacity:.35}}
  .expx-title{font-family:'Unbounded',sans-serif;font-weight:800;font-size:clamp(2.2rem,5vw,3.6rem);letter-spacing:-.02em;color:#fff;margin:0}
  .expx-sub{color:#8b95b5;margin-top:.7rem;font-size:1.02rem}

  /* Filtros glass */
  .expx-filters{display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:.7rem;background:rgba(16,16,24,.7);backdrop-filter:blur(12px);border:1px solid #232338;border-radius:22px;padding:.7rem;margin-bottom:3rem;box-shadow:0 24px 50px -24px rgba(0,0,0,.7)}
  .ef{position:relative;background:#171724;border:1px solid #262636;border-radius:15px;padding:.55rem 1rem;transition:border-color .2s}
  .ef:focus-within{border-color:#2E5BFF}
  .ef label{display:block;font-family:'Space Mono',monospace;font-size:.58rem;letter-spacing:.14em;text-transform:uppercase;color:#5b657f;margin-bottom:.1rem}
  .ef select{width:100%;background:none;border:none;color:#f4f5fb;font-family:'Sora';font-weight:600;font-size:.95rem;outline:none;cursor:pointer;appearance:none}
  .ef select option{background:#171724;color:#f4f5fb}
  .ef::after{content:"⌄";position:absolute;right:1rem;top:50%;transform:translateY(-40%);color:#5b657f;pointer-events:none;font-size:1rem}
  .ef-btn{background:linear-gradient(135deg,#2E5BFF,#00C2FF);color:#fff;border:none;border-radius:15px;padding:0 1.8rem;font-family:'Sora';font-weight:700;cursor:pointer;display:flex;align-items:center;gap:.5rem;box-shadow:0 10px 24px rgba(46,91,255,.3);transition:transform .2s,filter .2s}
  .ef-btn:hover{transform:translateY(-2px);filter:brightness(1.08)}

  /* Grid de posters */
  .expx-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(270px,1fr));gap:1.6rem;perspective:1400px}
  .djx{position:relative;border-radius:26px;overflow:hidden;aspect-ratio:3/4.05;background:#101018;border:1px solid #232338;
    transition:transform .35s cubic-bezier(.16,1,.3,1),box-shadow .35s,border-color .3s;will-change:transform;transform-style:preserve-3d;cursor:pointer}
  .djx:hover{border-color:#2E5BFF;box-shadow:0 30px 60px -24px rgba(46,91,255,.55)}
  .djx .photo{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform .8s cubic-bezier(.16,1,.3,1)}
  .djx:hover .photo{transform:scale(1.08)}
  .djx .fallback{position:absolute;inset:0;display:grid;place-items:center;background:radial-gradient(circle at 50% 30%,rgba(46,91,255,.4),transparent 60%),linear-gradient(160deg,#152046,#0a0a12)}
  .djx .fallback span{font-family:'Unbounded';font-weight:900;font-size:4rem;color:rgba(255,255,255,.9)}
  .djx .scrim{position:absolute;inset:0;background:linear-gradient(to top,#07070c 10%,rgba(7,7,12,.2) 45%,transparent 65%)}
  .djx .chips-top{position:absolute;top:1rem;left:1rem;right:1rem;display:flex;justify-content:space-between;z-index:2}
  .djx .chip{display:inline-flex;align-items:center;gap:.35rem;background:rgba(7,7,12,.6);backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,.12);color:#fff;font-size:.72rem;font-weight:700;padding:.35rem .7rem;border-radius:100px}
  .djx .chip.rt i{color:#fbbf24}
  .djx .chip.st{color:#4ade80}.djx .chip.st .d{width:6px;height:6px;border-radius:50%;background:#4ade80;box-shadow:0 0 6px #4ade80}
  .djx .eqm{position:absolute;left:1.1rem;bottom:6.6rem;display:flex;gap:3px;align-items:flex-end;height:26px;z-index:2;opacity:.85}
  .djx .eqm i{width:4px;background:linear-gradient(to top,#2E5BFF,#00C2FF);border-radius:2px;animation:expeq 1s ease-in-out infinite}
  @keyframes expeq{0%,100%{height:25%}50%{height:100%}}
  .djx .meta{position:absolute;left:0;right:0;bottom:0;padding:1.4rem;z-index:2}
  .djx .name{font-family:'Unbounded';font-weight:800;font-size:1.35rem;letter-spacing:-.01em;color:#fff;line-height:1.05;margin:0}
  .djx .loc{display:flex;align-items:center;gap:.4rem;color:#b9c2db;font-size:.82rem;font-weight:600;margin-top:.35rem}
  .djx .loc i{color:#00C2FF}
  /* panel de acciones (hover) */
  .djx .actions{position:absolute;inset:0;z-index:5;background:linear-gradient(to top,rgba(7,7,12,.96),rgba(10,12,26,.9));backdrop-filter:blur(10px);
    display:flex;flex-direction:column;justify-content:center;gap:.8rem;padding:1.6rem;opacity:0;transform:translateY(12px);transition:opacity .3s,transform .3s;pointer-events:none}
  .djx:hover .actions{opacity:1;transform:none;pointer-events:auto}
  .djx .actions .bio{color:#cbd5e1;font-size:.82rem;line-height:1.5;text-align:center;margin:0 0 .4rem;font-style:italic}
  .djx .abtn{width:100%;padding:.85rem;border-radius:13px;font-family:'Sora';font-weight:700;font-size:.9rem;text-align:center;cursor:pointer;border:none;transition:.2s;display:block}
  .djx .abtn.primary{background:linear-gradient(135deg,#2E5BFF,#00C2FF);color:#fff;box-shadow:0 10px 24px rgba(46,91,255,.35)}
  .djx .abtn.primary:hover{transform:translateY(-2px);filter:brightness(1.08)}
  .djx .abtn.ghost{background:transparent;border:1.5px solid #7c4dff;color:#a78bfa}
  .djx .abtn.ghost:hover{background:#7c4dff;color:#fff}
  .djx .alink{color:#8b95b5;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;text-align:center;text-decoration:none}
  .djx .alink:hover{color:#fff}
  .djx .own{font-family:'Unbounded';font-weight:800;color:#00C2FF;text-align:center;font-size:1.1rem;margin-bottom:.3rem}

  .expx-empty{grid-column:1/-1;text-align:center;padding:5rem 0}
  .expx-empty .circle{width:96px;height:96px;border-radius:50%;display:grid;place-items:center;margin:0 auto 1.5rem;background:#171724;border:1px solid #262636;font-size:2.4rem;color:#5b657f}
  .expx-empty h3{font-family:'Unbounded';font-weight:700;color:#fff;font-size:1.5rem;margin:0 0 .5rem}
  .expx-empty p{color:#8b95b5}

  @media(max-width:720px){.expx-filters{grid-template-columns:1fr}}
  @media(prefers-reduced-motion:reduce){.djx,.djx .photo,.djx .eqm i{transition:none;animation:none}}
</style>

<div class="expx <?php echo isset($_SESSION['usuario_id']) ? 'lg:ml-64' : ''; ?> p-6 md:p-8">
    <div class="container mx-auto">
        <!-- Header -->
        <div class="expx-head">
            <span class="expx-kick"><span class="dot"></span> En vivo · <?php echo count($data['djs'] ?? []); ?> talentos disponibles</span>
            <h1 class="expx-title">Explorar <span class="grad">Talentos</span></h1>
            <p class="expx-sub">Encuentra al artista perfecto para tu próximo evento en el Caquetá.</p>
        </div>

        <!-- Filtros -->
        <form action="<?php echo URL_ROOT; ?>/djs/explorar" method="GET" class="expx-filters">
            <div class="ef">
                <label>Ciudad / Municipio</label>
                <select name="ciudad">
                    <option value="">Todas las ciudades</option>
                    <option value="Florencia" <?php echo ($data['filtros']['ciudad'] == 'Florencia') ? 'selected' : ''; ?>>Florencia</option>
                    <option value="Morelia" <?php echo ($data['filtros']['ciudad'] == 'Morelia') ? 'selected' : ''; ?>>Morelia</option>
                    <option value="Belén" <?php echo ($data['filtros']['ciudad'] == 'Belén') ? 'selected' : ''; ?>>Belén</option>
                    <option value="Curillo" <?php echo ($data['filtros']['ciudad'] == 'Curillo') ? 'selected' : ''; ?>>Curillo</option>
                    <option value="San Vicente" <?php echo ($data['filtros']['ciudad'] == 'San Vicente') ? 'selected' : ''; ?>>San Vicente</option>
                </select>
            </div>
            <div class="ef">
                <label>Género musical</label>
                <select name="genero">
                    <option value="">Todos los géneros</option>
                    <?php foreach($data['generos'] as $gen): ?>
                        <option value="<?php echo $gen->nombre; ?>" <?php echo ($data['filtros']['genero'] == $gen->nombre) ? 'selected' : ''; ?>><?php echo $gen->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="ef">
                <label>Tipo de evento</label>
                <select name="evento">
                    <option value="">Todos los eventos</option>
                    <?php foreach($data['tipos_evento'] as $ev): ?>
                        <option value="<?php echo $ev->nombre; ?>" <?php echo ($data['filtros']['evento'] == $ev->nombre) ? 'selected' : ''; ?>><?php echo $ev->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="ef-btn"><i class="bi bi-search"></i> Filtrar</button>
        </form>

        <!-- Grid -->
        <div class="expx-grid">
            <?php if(empty($data['djs'])): ?>
                <div class="expx-empty">
                    <div class="circle"><i class="bi bi-person-x"></i></div>
                    <h3>No se encontraron DJs</h3>
                    <p>Intenta ajustar tus filtros de búsqueda.</p>
                </div>
            <?php else: ?>
                <?php foreach($data['djs'] as $dj): ?>
                <article class="djx tilt">
                    <?php if($dj->foto_perfil != 'default_dj.png'): ?>
                        <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $dj->foto_perfil; ?>" class="photo" alt="<?php echo $dj->nombre; ?>" loading="lazy">
                    <?php else: ?>
                        <div class="fallback"><span><?php echo strtoupper(substr($dj->nombre,0,2)); ?></span></div>
                    <?php endif; ?>
                    <div class="scrim"></div>

                    <div class="chips-top">
                        <span class="chip st"><span class="d"></span> Disponible</span>
                        <span class="chip rt"><i class="bi bi-star-fill"></i> <?php echo number_format($dj->calificacion_promedio, 1); ?></span>
                    </div>

                    <div class="eqm"><i style="height:60%"></i><i style="height:100%;animation-delay:-.2s"></i><i style="height:45%;animation-delay:-.4s"></i><i style="height:80%;animation-delay:-.1s"></i><i style="height:35%;animation-delay:-.5s"></i></div>

                    <div class="meta">
                        <h3 class="name"><?php echo $dj->nombre; ?></h3>
                        <div class="loc"><i class="bi bi-geo-alt-fill"></i> <?php echo $dj->ciudad ? $dj->ciudad : 'Caquetá'; ?></div>
                    </div>

                    <!-- Panel de acciones -->
                    <div class="actions">
                        <?php if(isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $dj->id): ?>
                            <div class="own">Es tu perfil</div>
                            <a href="<?php echo URL_ROOT; ?>/djs/editar" class="abtn primary">Editar perfil</a>
                            <a href="<?php echo URL_ROOT; ?>/djs/perfil/<?php echo $dj->id; ?>" class="alink">Ver perfil público</a>
                        <?php else: ?>
                            <p class="bio">"<?php echo $dj->biografia ? htmlspecialchars($dj->biografia) : 'Talento local listo para encender tu evento.'; ?>"</p>
                            <?php if(isset($_SESSION['usuario_id'])): ?>
                                <button onclick="openModal('<?php echo $dj->id; ?>')" class="abtn primary">Contratar ahora</button>
                            <?php else: ?>
                                <a href="<?php echo URL_ROOT; ?>/usuarios/login?redirect=djs/perfil/<?php echo $dj->id; ?>&reservar=1" class="abtn primary">Contratar ahora</a>
                            <?php endif; ?>
                            <a href="<?php echo URL_ROOT; ?>/chat/index/<?php echo $dj->id; ?>" class="abtn ghost">Chatear con DJ</a>
                            <a href="<?php echo URL_ROOT; ?>/djs/perfil/<?php echo $dj->id; ?>" class="alink">Ver perfil completo</a>
                        <?php endif; ?>
                    </div>
                </article>

                <!-- Modal Contratar (funcionalidad intacta) -->
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
                                <button type="submit" class="w-full sm:flex-1 btn-djpro-primary py-4 order-1 sm:order-2 shadow-lg shadow-blue-500/20">ENVIAR SOLICITUD</button>
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
            horasInput.value = Math.max(1, Math.round(diffHrs * 2) / 2);
        }

        const horas = horasInput.value;
        if (precioHora > 0) {
            estimadoInput.value = Math.max(0, Math.round(precioHora * horas));
        }
    }

    /* Tilt 3D en las tarjetas */
    (function(){
        if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        document.querySelectorAll('.djx.tilt').forEach(function(card){
            card.addEventListener('pointermove', function(e){
                if (card.querySelector('.actions:hover')) { card.style.transform=''; return; }
                var r = card.getBoundingClientRect();
                var px = (e.clientX - r.left)/r.width - .5;
                var py = (e.clientY - r.top)/r.height - .5;
                card.style.transform = 'rotateX('+(-py*6)+'deg) rotateY('+(px*6)+'deg) translateY(-6px)';
            });
            card.addEventListener('pointerleave', function(){ card.style.transform=''; });
        });
    })();

    /* Validación hora pasada y anti-doble-envío (intacto) */
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

            form.setAttribute('data-no-protect', 'true');
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
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const result = await response.json();

                    if (result.success) {
                        Swal.fire({ title: '¡Solicitud Enviada!', text: result.message, icon: 'success', confirmButtonColor: '#2E5BFF', background: '#12121a', color: '#fff' });
                        closeModal(djId);
                        form.reset();
                    } else {
                        Swal.fire({ title: 'No disponible', text: result.error || 'Error al enviar solicitud', icon: 'warning', confirmButtonColor: '#2E5BFF', background: '#12121a', color: '#fff' });
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

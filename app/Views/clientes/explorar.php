<?php
// Logueado → shell oscuro (sidebar por rol, sin barra superior). Invitado → header público.
if(isset($_SESSION['usuario_id'])) {
    $__pageTitle = 'DJPRO | Explorar DJs'; $__bare = true;
    require APPROOT . '/app/Views/inc/dj_shell_top.php';
} else {
    require APPROOT . '/app/Views/inc/header.php';
}
?>

<?php
    $fCiudad = $data['filtros']['ciudad'] ?? '';
    $fGenero = $data['filtros']['genero'] ?? '';
    $fEvento = $data['filtros']['evento'] ?? '';
    // Helper: link de chip de genero preservando ciudad/evento actuales
    $chipHref = function($genero) use ($fCiudad, $fEvento) {
        $q = http_build_query(array_filter(['ciudad'=>$fCiudad,'genero'=>$genero,'evento'=>$fEvento]));
        return URL_ROOT . '/djs/explorar' . ($q ? '?'.$q : '');
    };
?>

<style>
  .lx{font-family:'Sora',system-ui,sans-serif}
  .lx .grad{background:linear-gradient(105deg,#2E5BFF,#00C2FF);-webkit-background-clip:text;background-clip:text;color:transparent}

  /* Header tipo "portada de playlist" */
  .lx-hero{display:flex;align-items:flex-end;gap:1.6rem;flex-wrap:wrap;margin-bottom:2.2rem}
  .lx-cover{width:120px;height:120px;border-radius:24px;flex:none;display:grid;place-items:center;font-size:3rem;color:#fff;
    background:linear-gradient(140deg,#2E5BFF,#00C2FF);box-shadow:0 24px 50px -18px rgba(46,91,255,.6);position:relative;overflow:hidden}
  .lx-cover .wv{position:absolute;bottom:0;left:0;right:0;display:flex;align-items:flex-end;gap:3px;height:40px;padding:0 12px;opacity:.6}
  .lx-cover .wv i{flex:1;background:rgba(255,255,255,.7);border-radius:2px;animation:lxeq 1s ease-in-out infinite}
  @keyframes lxeq{0%,100%{height:20%}50%{height:100%}}
  .lx-htxt .k{font-family:'Space Mono',monospace;font-size:.72rem;letter-spacing:.2em;text-transform:uppercase;color:#00C2FF}
  .lx-htxt h1{font-family:'Unbounded',sans-serif;font-weight:900;font-size:clamp(2rem,5vw,3.4rem);letter-spacing:-.02em;color:#fff;margin:.3rem 0}
  .lx-htxt p{color:#8b95b5;margin:0}

  /* Chips de genero */
  .lx-chips{display:flex;gap:.6rem;overflow-x:auto;padding-bottom:.6rem;margin-bottom:1rem;scrollbar-width:thin}
  .lx-chips::-webkit-scrollbar{height:5px}.lx-chips::-webkit-scrollbar-thumb{background:#2b2b45;border-radius:10px}
  .gchip{white-space:nowrap;padding:.55rem 1.15rem;border-radius:100px;border:1px solid #262636;color:#9aa3bd;font-weight:600;font-size:.85rem;background:#141420;transition:.2s;text-decoration:none;flex:none}
  .gchip:hover{border-color:#2E5BFF;color:#fff}
  .gchip.active{background:linear-gradient(135deg,#2E5BFF,#00C2FF);color:#fff;border-color:transparent;box-shadow:0 8px 20px rgba(46,91,255,.3)}

  /* Toolbar (ciudad + evento) */
  .lx-tools{display:flex;gap:.7rem;flex-wrap:wrap;align-items:center;margin-bottom:2.4rem}
  .tsel{position:relative;display:flex;align-items:center;gap:.55rem;background:#141420;border:1px solid #262636;border-radius:100px;padding:.55rem 1.1rem;transition:border-color .2s}
  .tsel:focus-within{border-color:#2E5BFF}
  .tsel i{color:#00C2FF}
  .tsel select{background:none;border:none;color:#f4f5fb;font-family:'Sora';font-weight:600;outline:none;cursor:pointer;appearance:none;padding-right:.5rem}
  .tsel select option{background:#141420}
  .tbtn{background:linear-gradient(135deg,#2E5BFF,#00C2FF);color:#fff;border:none;border-radius:100px;padding:.6rem 1.4rem;font-family:'Sora';font-weight:700;cursor:pointer;display:flex;align-items:center;gap:.45rem;transition:.2s}
  .tbtn:hover{filter:brightness(1.08);transform:translateY(-1px)}
  .lx-count{margin-left:auto;font-family:'Space Mono',monospace;font-size:.8rem;color:#5b657f}
  .lx-count b{color:#00C2FF}

  /* Lista tipo chart */
  .lineup{display:flex;flex-direction:column;gap:.8rem}
  .drow{display:grid;grid-template-columns:2.4rem 66px 1fr auto;gap:1.2rem;align-items:center;
    background:#101018;border:1px solid #232338;border-radius:20px;padding:.9rem 1.3rem;position:relative;overflow:hidden;transition:.25s}
  .drow::before{content:"";position:absolute;left:0;top:0;bottom:0;width:0;background:linear-gradient(#2E5BFF,#00C2FF);transition:width .25s}
  .drow:hover{border-color:#2E5BFF;background:#12121e;transform:translateX(5px)}
  .drow:hover::before{width:4px}
  .drank{font-family:'Unbounded';font-weight:900;font-size:1.3rem;color:#2f3a5c;text-align:center;transition:color .2s}
  .drow:hover .drank{color:#00C2FF}
  .davatar{width:66px;height:66px;border-radius:18px;object-fit:cover;border:1px solid #2b3352}
  .davatar.fb{display:grid;place-items:center;font-family:'Unbounded';font-weight:800;font-size:1.4rem;color:#fff;background:linear-gradient(135deg,#2E5BFF,#00C2FF)}
  .dmid{min-width:0}
  .dname{font-family:'Unbounded';font-weight:700;font-size:1.15rem;color:#fff;letter-spacing:-.01em;line-height:1.1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .dsub{display:flex;align-items:center;gap:.9rem;margin-top:.35rem;flex-wrap:wrap}
  .dloc{display:flex;align-items:center;gap:.35rem;color:#9aa3bd;font-size:.8rem;font-weight:600}
  .dloc i{color:#00C2FF}
  .dgen{display:flex;gap:.4rem}
  .dgen span{font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#8b95b5;background:#1a1a28;border:1px solid #262636;padding:.2rem .55rem;border-radius:6px}
  .dwave{display:none}
  @media(min-width:900px){.dwave{display:flex;align-items:flex-end;gap:2px;height:26px;width:80px}.dwave i{flex:1;background:linear-gradient(to top,#2E5BFF,#00C2FF);border-radius:2px;opacity:.5;transition:opacity .2s}.drow:hover .dwave i{opacity:1;animation:lxeq 1s ease-in-out infinite}}
  .dend{display:flex;align-items:center;gap:1rem}
  .drate{display:flex;flex-direction:column;align-items:center;font-family:'Unbounded';font-weight:800;color:#fff}
  .drate i{color:#fbbf24;font-size:.85rem}
  .drate small{font-family:'Sora';font-weight:600;font-size:.6rem;color:#5b657f;text-transform:uppercase;letter-spacing:.1em}
  .dact{display:flex;gap:.55rem}
  .dbtn{width:44px;height:44px;border-radius:14px;display:grid;place-items:center;font-size:1.05rem;cursor:pointer;border:none;transition:.2s;text-decoration:none}
  .dbtn.play{background:linear-gradient(135deg,#2E5BFF,#00C2FF);color:#fff;box-shadow:0 8px 18px rgba(46,91,255,.35);width:auto;padding:0 1.3rem;gap:.5rem;font-family:'Sora';font-weight:700;font-size:.9rem}
  .dbtn.play:hover{transform:translateY(-2px);filter:brightness(1.08)}
  .dbtn.chat{background:#171724;border:1px solid #2b2b45;color:#a78bfa}
  .dbtn.chat:hover{background:#7c4dff;color:#fff;border-color:transparent}
  .dbtn.view{background:#171724;border:1px solid #262636;color:#9aa3bd}
  .dbtn.view:hover{color:#fff;border-color:#2E5BFF}
  .down-tag{font-family:'Space Mono',monospace;font-size:.7rem;color:#00C2FF;text-transform:uppercase;letter-spacing:.1em}

  .lx-empty{text-align:center;padding:5rem 0}
  .lx-empty .c{width:90px;height:90px;border-radius:50%;display:grid;place-items:center;margin:0 auto 1.5rem;background:#171724;border:1px solid #262636;font-size:2.2rem;color:#5b657f}
  .lx-empty h3{font-family:'Unbounded';font-weight:700;color:#fff;font-size:1.4rem;margin:0 0 .4rem}
  .lx-empty p{color:#8b95b5}

  @media(max-width:640px){
    .drow{grid-template-columns:2rem 54px 1fr;gap:.8rem}
    .davatar{width:54px;height:54px}
    .dend{grid-column:2/-1;just-content:space-between;margin-top:.3rem}
  }
  @media(prefers-reduced-motion:reduce){.lx-cover .wv i,.dwave i{animation:none!important}}
</style>

<div class="lx <?php echo isset($_SESSION['usuario_id']) ? 'lg:ml-64' : ''; ?> p-6 md:p-8">
    <div class="container mx-auto">

        <!-- Hero tipo portada -->
        <div class="lx-hero">
            <div class="lx-cover">
                <i class="bi bi-soundwave"></i>
                <div class="wv"><?php for($i=0;$i<7;$i++): ?><i style="height:<?php echo rand(20,90); ?>%;animation-delay:-<?php echo $i*0.13; ?>s"></i><?php endfor; ?></div>
            </div>
            <div class="lx-htxt">
                <div class="k">El lineup del Caquetá</div>
                <h1>Talentos <span class="grad">en cabina</span></h1>
                <p>El ranking de los DJs listos para encender tu próximo evento.</p>
            </div>
        </div>

        <!-- Chips de género -->
        <div class="lx-chips">
            <a href="<?php echo $chipHref(''); ?>" class="gchip <?php echo $fGenero === '' ? 'active' : ''; ?>">Todos</a>
            <?php foreach($data['generos'] as $gen): ?>
                <a href="<?php echo $chipHref($gen->nombre); ?>" class="gchip <?php echo $fGenero === $gen->nombre ? 'active' : ''; ?>"><?php echo $gen->nombre; ?></a>
            <?php endforeach; ?>
        </div>

        <!-- Toolbar ciudad + evento -->
        <form action="<?php echo URL_ROOT; ?>/djs/explorar" method="GET" class="lx-tools">
            <input type="hidden" name="genero" value="<?php echo htmlspecialchars($fGenero); ?>">
            <div class="tsel">
                <i class="bi bi-geo-alt-fill"></i>
                <select name="ciudad">
                    <option value="">Toda la región</option>
                    <?php foreach(['Florencia','Morelia','Belén','Curillo','San Vicente'] as $c): ?>
                        <option value="<?php echo $c; ?>" <?php echo $fCiudad === $c ? 'selected' : ''; ?>><?php echo $c; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="tsel">
                <i class="bi bi-calendar-event"></i>
                <select name="evento">
                    <option value="">Cualquier evento</option>
                    <?php foreach($data['tipos_evento'] as $ev): ?>
                        <option value="<?php echo $ev->nombre; ?>" <?php echo $fEvento === $ev->nombre ? 'selected' : ''; ?>><?php echo $ev->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="tbtn"><i class="bi bi-sliders"></i> Aplicar</button>
            <span class="lx-count"><b><?php echo count($data['djs'] ?? []); ?></b> DJs</span>
        </form>

        <!-- Lista tipo chart -->
        <?php if(empty($data['djs'])): ?>
            <div class="lx-empty">
                <div class="c"><i class="bi bi-search"></i></div>
                <h3>No hay DJs con esos filtros</h3>
                <p>Prueba con otro género o ciudad.</p>
            </div>
        <?php else: ?>
        <div class="lineup">
            <?php foreach($data['djs'] as $idx => $dj): ?>
            <div class="drow">
                <div class="drank"><?php echo str_pad($idx+1, 2, '0', STR_PAD_LEFT); ?></div>
                <?php if($dj->foto_perfil != 'default_dj.png'): ?>
                    <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $dj->foto_perfil; ?>" class="davatar" alt="<?php echo $dj->nombre; ?>" loading="lazy">
                <?php else: ?>
                    <div class="davatar fb"><?php echo strtoupper(substr($dj->nombre,0,2)); ?></div>
                <?php endif; ?>

                <div class="dmid">
                    <div class="dname"><?php echo $dj->nombre; ?></div>
                    <div class="dsub">
                        <span class="dloc"><i class="bi bi-geo-alt-fill"></i> <?php echo $dj->ciudad ? $dj->ciudad : 'Caquetá'; ?></span>
                        <?php $gs = array_filter(array_map('trim', explode(',', (string)($dj->generos ?? '')))); if(!empty($gs)): ?>
                        <span class="dgen">
                            <?php foreach(array_slice($gs,0,2) as $g): ?><span><?php echo $g; ?></span><?php endforeach; ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="dend">
                    <div class="dwave"><i style="height:40%"></i><i style="height:70%"></i><i style="height:95%"></i><i style="height:55%"></i><i style="height:80%"></i><i style="height:35%"></i></div>
                    <div class="drate"><span><i class="bi bi-star-fill"></i> <?php echo number_format($dj->calificacion_promedio, 1); ?></span><small>Rating</small></div>
                    <div class="dact">
                        <?php if(isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $dj->id): ?>
                            <span class="down-tag">Tu perfil</span>
                            <a href="<?php echo URL_ROOT; ?>/djs/editar" class="dbtn view" title="Editar"><i class="bi bi-pencil"></i></a>
                        <?php else: ?>
                            <?php if(isset($_SESSION['usuario_id'])): ?>
                                <button onclick="openModal('<?php echo $dj->id; ?>')" class="dbtn play"><i class="bi bi-lightning-charge-fill"></i> Contratar</button>
                            <?php else: ?>
                                <a href="<?php echo URL_ROOT; ?>/usuarios/login?redirect=djs/perfil/<?php echo $dj->id; ?>&reservar=1" class="dbtn play"><i class="bi bi-lightning-charge-fill"></i> Contratar</a>
                            <?php endif; ?>
                            <a href="<?php echo URL_ROOT; ?>/chat/index/<?php echo $dj->id; ?>" class="dbtn chat" title="Chatear"><i class="bi bi-chat-dots-fill"></i></a>
                            <a href="<?php echo URL_ROOT; ?>/djs/perfil/<?php echo $dj->id; ?>" class="dbtn view" title="Ver perfil"><i class="bi bi-arrow-right"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

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
        </div>
        <?php endif; ?>
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

<?php
if(isset($_SESSION['usuario_id'])) { require APPROOT . '/app/Views/inc/dj_shell_bottom.php'; }
else { require APPROOT . '/app/Views/inc/footer.php'; }
?>

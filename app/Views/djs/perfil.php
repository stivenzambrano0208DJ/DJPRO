<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<style>
  .pf{font-family:'Sora',system-ui,sans-serif}
  .pf .grad{background:linear-gradient(105deg,#2E5BFF,#00C2FF);-webkit-background-clip:text;background-clip:text;color:transparent}

  /* Cover */
  .pf-cover{position:relative;height:240px;overflow:hidden;
    background:radial-gradient(700px circle at 20% 20%,rgba(46,91,255,.35),transparent 60%),radial-gradient(600px circle at 85% 30%,rgba(0,194,255,.22),transparent 60%),linear-gradient(160deg,#0c1430,#0a0a12)}
  .pf-cover .watermark{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none;opacity:.06}
  .pf-cover .watermark span{font-family:'Unbounded';font-weight:900;font-size:16vw;line-height:1;white-space:nowrap;text-transform:uppercase;color:#fff}
  .pf-cover .eq{position:absolute;left:0;right:0;bottom:0;display:flex;align-items:flex-end;gap:4px;height:70px;padding:0 6vw;opacity:.35}
  .pf-cover .eq i{flex:1;background:linear-gradient(to top,#2E5BFF,#00C2FF);border-radius:3px;animation:pfeq 1s ease-in-out infinite}
  @keyframes pfeq{0%,100%{height:15%}50%{height:100%}}
  .pf-cover::after{content:"";position:absolute;inset:0;background:linear-gradient(to top,#0a0a0f,transparent 55%)}

  .pf-grid{display:grid;grid-template-columns:340px 1fr;gap:2.5rem;align-items:start;margin-top:-90px;position:relative;z-index:2}
  @media(max-width:900px){.pf-grid{grid-template-columns:1fr;margin-top:-70px}}

  /* Tarjeta lateral */
  .pf-card{background:#101018;border:1px solid #232338;border-radius:26px;padding:1.6rem;box-shadow:0 30px 60px -24px rgba(0,0,0,.7)}
  @media(min-width:900px){.pf-card{position:sticky;top:6.5rem}}
  .pf-photo{width:100%;aspect-ratio:1;border-radius:20px;overflow:hidden;position:relative;border:1px solid #2b3352;background:#171724}
  .pf-photo img{width:100%;height:100%;object-fit:cover}
  .pf-photo .fb{width:100%;height:100%;display:grid;place-items:center;font-family:'Unbounded';font-weight:900;font-size:3.5rem;color:#fff;background:linear-gradient(140deg,#2E5BFF,#00C2FF)}
  .pf-status{position:absolute;bottom:.8rem;left:.8rem;display:inline-flex;align-items:center;gap:.4rem;background:rgba(7,7,12,.7);backdrop-filter:blur(6px);border:1px solid rgba(74,222,128,.4);color:#4ade80;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.35rem .7rem;border-radius:100px}
  .pf-status .d{width:6px;height:6px;border-radius:50%;background:#4ade80;box-shadow:0 0 6px #4ade80}
  .pf-name{font-family:'Unbounded';font-weight:800;font-size:1.6rem;letter-spacing:-.02em;color:#fff;margin:1.2rem 0 .1rem;display:flex;align-items:center;gap:.5rem;line-height:1.05}
  .pf-name i{color:#00C2FF;font-size:1.1rem}
  .pf-user{color:#00C2FF;font-weight:700;font-size:.82rem;letter-spacing:.05em}
  .pf-metrics{display:flex;align-items:center;gap:1.2rem;margin:1.1rem 0;flex-wrap:wrap}
  .pf-metric{display:flex;flex-direction:column}
  .pf-metric .v{font-family:'Unbounded';font-weight:800;color:#fff;font-size:1.15rem;display:flex;align-items:center;gap:.3rem}
  .pf-metric .v i{color:#fbbf24;font-size:.9rem}
  .pf-metric .l{font-size:.66rem;color:#5b657f;text-transform:uppercase;letter-spacing:.1em;font-weight:700}
  .pf-metric.price .v{color:#00C2FF}
  .pf-divider{height:1px;background:#232338;margin:1.2rem 0}
  .pf-actions{display:flex;gap:.7rem}
  .pf-hire{flex:1;background:linear-gradient(135deg,#2E5BFF,#00C2FF);color:#fff;border:none;border-radius:14px;padding:.95rem;font-family:'Sora';font-weight:700;font-size:.95rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.5rem;box-shadow:0 12px 26px rgba(46,91,255,.35);transition:transform .2s,filter .2s}
  .pf-hire:hover{transform:translateY(-2px);filter:brightness(1.08)}
  .pf-chat{width:52px;flex:none;border-radius:14px;border:1px solid #2b2b45;background:#171724;color:#a78bfa;display:grid;place-items:center;font-size:1.2rem;transition:.2s;text-decoration:none}
  .pf-chat:hover{background:#7c4dff;color:#fff;border-color:transparent}
  .pf-sec-title{font-family:'Space Mono',monospace;font-size:.66rem;letter-spacing:.16em;text-transform:uppercase;color:#5b657f;margin:1.3rem 0 .7rem}
  .pf-chips{display:flex;flex-wrap:wrap;gap:.45rem}
  .pf-chip{font-size:.72rem;font-weight:700;padding:.35rem .75rem;border-radius:8px;background:#171724;border:1px solid #262636;color:#cbd5e1}
  .pf-chip.ev{color:#a78bfa;border-color:rgba(124,77,255,.3);background:rgba(124,77,255,.08)}
  .pf-zone{display:flex;align-items:center;gap:.4rem;font-size:.78rem;color:#9aa3bd;font-weight:600;padding:.3rem 0}
  .pf-zone i{color:#00C2FF}

  /* Main */
  .pf-main{min-width:0;padding-top:5.5rem}
  @media(max-width:900px){.pf-main{padding-top:1rem}}
  .pf-tabs{display:flex;gap:.5rem;background:#101018;border:1px solid #232338;border-radius:16px;padding:.4rem;margin-bottom:2rem;width:fit-content}
  .pf-tab{border:none;background:none;color:#8b95b5;font-family:'Sora';font-weight:700;font-size:.9rem;padding:.6rem 1.3rem;border-radius:12px;cursor:pointer;transition:.2s;display:flex;align-items:center;gap:.5rem}
  .pf-tab:hover{color:#fff}
  .pf-tab.active{background:linear-gradient(135deg,#2E5BFF,#00C2FF);color:#fff;box-shadow:0 8px 18px rgba(46,91,255,.3)}

  .pf-videos{display:grid;grid-template-columns:repeat(auto-fit,minmax(340px,1fr));gap:1.5rem}
  .pf-video .frame{aspect-ratio:16/9;border-radius:18px;overflow:hidden;border:1px solid #232338;background:#171724}
  .pf-video .frame iframe{width:100%;height:100%}
  .pf-video h4{font-family:'Unbounded';font-weight:700;font-size:1rem;color:#fff;margin:.8rem 0 0;transition:color .2s}
  .pf-video:hover h4{color:#00C2FF}

  .pf-empty{padding:4rem 2rem;text-align:center;background:#101018;border:1px dashed #262636;border-radius:24px}
  .pf-empty i{font-size:2.5rem;color:#5b657f;display:block;margin-bottom:1rem}
  .pf-empty p{color:#8b95b5;font-weight:600}

  .pf-about{background:#101018;border:1px solid #232338;border-radius:24px;padding:2.4rem;max-width:760px}
  .pf-about p{color:#c3cbe0;font-size:1.05rem;line-height:1.8;margin:0}

  .pf-reviews{display:flex;gap:2rem;flex-wrap:wrap}
  .pf-score{flex:none;width:230px;background:linear-gradient(160deg,#0c1430,#101018);border:1px solid #232338;border-radius:24px;padding:2rem;text-align:center}
  .pf-score .big{font-family:'Unbounded';font-weight:900;font-size:4rem;line-height:1;background:linear-gradient(135deg,#2E5BFF,#00C2FF);-webkit-background-clip:text;background-clip:text;color:transparent}
  .pf-score .stars{color:#fbbf24;font-size:1.1rem;margin:.6rem 0}
  .pf-score .lbl{font-size:.68rem;color:#5b657f;text-transform:uppercase;letter-spacing:.1em;font-weight:700}
  .pf-score .cnt{color:#00C2FF;font-weight:700;font-size:.8rem;margin-top:.4rem}
  .pf-rlist{flex:1;min-width:260px;display:flex;flex-direction:column;gap:1rem}
  .pf-rev{background:#101018;border:1px solid #232338;border-radius:18px;padding:1.4rem;transition:border-color .2s}
  .pf-rev:hover{border-color:rgba(46,91,255,.4)}
  .pf-rev .head{display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:.8rem}
  .pf-rev .who{display:flex;align-items:center;gap:.8rem}
  .pf-rev .av{width:42px;height:42px;border-radius:12px;display:grid;place-items:center;font-weight:800;font-size:.85rem;color:#fff;background:linear-gradient(135deg,#2E5BFF,#00C2FF)}
  .pf-rev .who b{color:#fff;font-size:.9rem;font-weight:700;display:block}
  .pf-rev .who span{color:#5b657f;font-size:.72rem}
  .pf-rev .rstars{color:#fbbf24;font-size:.85rem;flex:none}
  .pf-rev p{color:#9aa3bd;font-size:.92rem;line-height:1.6;font-style:italic;margin:0}

  @media(prefers-reduced-motion:reduce){.pf-cover .eq i{animation:none}}
</style>

<div class="pf">
  <!-- Cover -->
  <div class="pf-cover">
    <div class="watermark"><span><?php echo $data['perfil']->nombre; ?></span></div>
    <div class="eq"><?php for($i=0;$i<40;$i++): ?><i style="height:<?php echo rand(15,90); ?>%;animation-delay:-<?php echo $i*0.07; ?>s;animation-duration:<?php echo (8+rand(0,8))/10; ?>s"></i><?php endfor; ?></div>
  </div>

  <div class="container mx-auto px-4">
    <div class="pf-grid">
      <!-- ═══════ Tarjeta lateral ═══════ -->
      <aside class="pf-card">
        <div class="pf-photo">
          <?php if($data['perfil']->foto_perfil != 'default_dj.png'): ?>
            <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $data['perfil']->foto_perfil; ?>" alt="<?php echo $data['perfil']->nombre; ?>">
          <?php else: ?>
            <div class="fb"><?php echo strtoupper(substr($data['perfil']->nombre,0,2)); ?></div>
          <?php endif; ?>
          <span class="pf-status"><span class="d"></span> Disponible</span>
        </div>

        <div class="pf-name">
          <?php echo $data['perfil']->nombre; ?>
          <?php if($data['perfil']->verificado): ?><i class="bi bi-patch-check-fill" title="DJ Verificado"></i><?php endif; ?>
        </div>
        <?php if(!empty($data['perfil']->username)): ?><div class="pf-user">@<?php echo $data['perfil']->username; ?></div><?php endif; ?>

        <div class="pf-metrics">
          <div class="pf-metric"><span class="v"><i class="bi bi-star-fill"></i> <?php echo number_format($data['perfil']->calificacion_promedio, 1); ?></span><span class="l">Rating</span></div>
          <div class="pf-metric"><span class="v"><i class="bi bi-geo-alt-fill" style="color:#00C2FF"></i> <?php echo $data['perfil']->ciudad ?: 'Caquetá'; ?></span><span class="l">Ubicación</span></div>
          <div class="pf-metric price"><span class="v"><?php echo !empty($data['perfil']->precio_hora) ? '$'.number_format($data['perfil']->precio_hora, 0) : 'Abierto'; ?></span><span class="l"><?php echo !empty($data['perfil']->precio_hora) ? 'Por hora' : 'Presupuesto'; ?></span></div>
        </div>

        <div class="pf-actions">
          <?php if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] != $data['perfil']->usuario_id): ?>
            <button onclick="openBookingModal()" class="pf-hire"><i class="bi bi-calendar-check"></i> Contratar</button>
          <?php else: ?>
            <a href="<?php echo URL_ROOT; ?>/djs/editar" class="pf-hire"><i class="bi bi-pencil"></i> Editar perfil</a>
          <?php endif; ?>
          <a href="<?php echo URL_ROOT; ?>/chat/index/<?php echo $data['perfil']->usuario_id; ?>" class="pf-chat" title="Chatear"><i class="bi bi-chat-dots-fill"></i></a>
        </div>

        <?php $generos = array_filter(array_map('trim', explode(',', (string)$data['perfil']->generos))); ?>
        <?php if(!empty($generos)): ?>
        <div class="pf-sec-title">Géneros</div>
        <div class="pf-chips"><?php foreach($generos as $g): ?><span class="pf-chip"><?php echo $g; ?></span><?php endforeach; ?></div>
        <?php endif; ?>

        <?php $eventos = array_filter(array_map('trim', explode(',', (string)$data['perfil']->tipos_evento))); ?>
        <?php if(!empty($eventos)): ?>
        <div class="pf-sec-title">Tipos de evento</div>
        <div class="pf-chips"><?php foreach($eventos as $ev): ?><span class="pf-chip ev"><?php echo $ev; ?></span><?php endforeach; ?></div>
        <?php endif; ?>

        <?php $lugares = array_filter(array_map('trim', explode(',', (string)($data['perfil']->lugares_trabajo ?? '')))); ?>
        <?php if(!empty($lugares)): ?>
        <div class="pf-sec-title">Zonas de cobertura</div>
        <div><?php foreach($lugares as $lugar): ?><div class="pf-zone"><i class="bi bi-pin-map-fill"></i> <?php echo $lugar; ?></div><?php endforeach; ?></div>
        <?php endif; ?>
      </aside>

      <!-- ═══════ Contenido ═══════ -->
      <main class="pf-main">
        <div class="pf-tabs">
          <button class="pf-tab active"><i class="bi bi-play-btn"></i> Videos</button>
          <button class="pf-tab"><i class="bi bi-person"></i> Sobre mí</button>
          <button class="pf-tab"><i class="bi bi-star"></i> Reseñas</button>
        </div>

        <!-- Videos -->
        <div id="content-videos" class="pf-videos">
          <?php if(empty($data['videos'])): ?>
            <div class="pf-empty" style="grid-column:1/-1"><i class="bi bi-play-circle"></i><p>Este DJ aún no ha subido videos a su galería.</p></div>
          <?php else: ?>
            <?php foreach($data['videos'] as $video):
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video->url_video, $match);
                $youtube_id = $match[1] ?? '';
            ?>
            <div class="pf-video">
              <div class="frame"><iframe src="https://www.youtube.com/embed/<?php echo $youtube_id; ?>" frameborder="0" allowfullscreen></iframe></div>
              <h4><?php echo $video->titulo; ?></h4>
            </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <!-- Sobre mí -->
        <div id="content-about" class="hidden">
          <div class="pf-about">
            <p><?php echo $data['perfil']->biografia ?: 'Este DJ aún no ha completado su biografía profesional.'; ?></p>
          </div>
        </div>

        <!-- Reseñas -->
        <div id="content-reviews" class="hidden">
          <div class="pf-reviews">
            <div class="pf-score">
              <div class="big"><?php echo number_format($data['perfil']->calificacion_promedio, 1); ?></div>
              <div class="stars"><?php for($i=1;$i<=5;$i++): ?><i class="bi <?php echo $i <= round($data['perfil']->calificacion_promedio) ? 'bi-star-fill' : 'bi-star'; ?>"></i><?php endfor; ?></div>
              <div class="lbl">Puntuación general</div>
              <div class="cnt"><?php echo count($data['resenas']); ?> reseña(s)</div>
            </div>
            <div class="pf-rlist">
              <?php if(empty($data['resenas'])): ?>
                <div class="pf-empty"><i class="bi bi-chat-square-heart"></i><p>Este DJ aún no tiene reseñas.<br><span style="font-weight:400;font-size:.85rem">¡Sé el primero en calificarlo!</span></p></div>
              <?php else: ?>
                <?php foreach($data['resenas'] as $res): ?>
                <div class="pf-rev">
                  <div class="head">
                    <div class="who">
                      <div class="av"><?php echo strtoupper(substr($res->cliente_nombre, 0, 2)); ?></div>
                      <div><b><?php echo $res->cliente_nombre; ?></b><span><?php echo date('d M, Y', strtotime($res->fecha_creacion)); ?></span></div>
                    </div>
                    <div class="rstars"><?php for($i=1;$i<=5;$i++): ?><i class="bi <?php echo $i <= $res->puntuacion ? 'bi-star-fill' : 'bi-star'; ?>"></i><?php endfor; ?></div>
                  </div>
                  <?php if(!empty($res->comentario)): ?><p>"<?php echo htmlspecialchars($res->comentario); ?>"</p><?php else: ?><p style="opacity:.6">Sin comentario adicional.</p><?php endif; ?>
                </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</div>

<div style="height:5rem"></div>

<!-- Modal Contratar (funcionalidad intacta) -->
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
                <button type="submit" class="w-full sm:flex-1 btn-djpro-primary py-4 order-1 sm:order-2 shadow-lg shadow-blue-500/20">ENVIAR SOLICITUD</button>
            </div>
        </form>
    </div>
</div>

<script>
    const tabs = document.querySelectorAll('.pf-tab');
    const contentVideos = document.getElementById('content-videos');
    const contentAbout = document.getElementById('content-about');
    const contentReviews = document.getElementById('content-reviews');
    const panes = [contentVideos, contentAbout, contentReviews];

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            panes.forEach(c => c.classList.add('hidden'));
            panes[index].classList.remove('hidden');
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
                    method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const result = await response.json();
                if (result.success) {
                    Swal.fire({ title: '¡Solicitud Enviada!', text: result.message, icon: 'success', confirmButtonColor: '#2E5BFF', background: '#12121a', color: '#fff' });
                    closeBookingModal();
                    bookingForm.reset();
                } else {
                    Swal.fire({ title: 'No disponible', text: result.error || 'Error al enviar solicitud', icon: 'warning', confirmButtonColor: '#2E5BFF', background: '#12121a', color: '#fff' });
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

    function calcularTotal() {
        const precioHora = <?php echo $data['perfil']->precio_hora ?: 0; ?>;
        const horaInicio = document.querySelector('input[name="hora_inicio"]').value;
        const horaFin = document.querySelector('input[name="hora_fin"]').value;
        const horasInput = document.getElementById('booking_horas');
        const estimadoInput = document.getElementById('booking_estimado');

        if (horaInicio && horaFin) {
            const start = new Date(`2000-01-01T${horaInicio}:00`);
            let end = new Date(`2000-01-01T${horaFin}:00`);
            if (end <= start) end = new Date(`2000-01-02T${horaFin}:00`);
            const diffHrs = (end - start) / (1000 * 60 * 60);
            horasInput.value = Math.max(1, Math.round(diffHrs * 2) / 2);
        }
        const horas = horasInput.value;
        if (precioHora > 0) estimadoInput.value = Math.max(0, Math.round(precioHora * horas));
    }

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
            const todayStr = hoy.toISOString().split('T')[0];
            if (fechaInput.value === todayStr && hi.value) {
                const [h, m] = hi.value.split(':').map(Number);
                const horaSeleccionada = new Date();
                horaSeleccionada.setHours(h, m, 0, 0);
                if (horaSeleccionada <= hoy) {
                    timeErrorMsg.classList.remove('hidden');
                    submitBtn.disabled = true; submitBtn.style.opacity = '0.5'; submitBtn.style.cursor = 'not-allowed';
                    return false;
                }
            }
            timeErrorMsg.classList.add('hidden');
            submitBtn.disabled = false; submitBtn.style.opacity = ''; submitBtn.style.cursor = '';
            return true;
        }

        if (hi) hi.addEventListener('change', () => { validarHoraPasada(); calcularTotal(); });
        if (hf) hf.addEventListener('change', calcularTotal);
        if (hs) hs.addEventListener('input', calcularTotal);
        if (fechaInput) fechaInput.addEventListener('change', validarHoraPasada);

        const form = document.getElementById('bookingForm');
        if (form) form.addEventListener('submit', function(e) { if (!validarHoraPasada()) { e.preventDefault(); return false; } }, true);
    });

    window.addEventListener('load', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('reservar') === '1') openBookingModal();
    });
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

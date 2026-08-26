<?php require APPROOT . '/app/Views/inc/header.php'; ?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;600;800;900&family=Sora:wght@400;500;600;700&display=swap">

<style>
  /* ═══════════ Landing DJPRO v3 — Unbounded + Sora, hero centrado ═══════════ */
  .lpx{font-family:'Sora',system-ui,sans-serif;line-height:1.6}
  .lpx .ub{font-family:'Unbounded',sans-serif}
  .lpx .grad{background:linear-gradient(105deg,#2E5BFF,#00C2FF);-webkit-background-clip:text;background-clip:text;color:transparent}
  .lpx .eyebrow{font-family:'Unbounded',sans-serif;font-weight:600;font-size:.7rem;letter-spacing:.35em;text-transform:uppercase;color:#00C2FF}
  .lpx .btn{font-family:'Sora',sans-serif;font-weight:700;border-radius:100px;padding:.95rem 2rem;display:inline-flex;align-items:center;gap:.6rem;cursor:pointer;border:none;transition:.22s;font-size:.98rem;text-decoration:none}
  .lpx .btn-p{background:linear-gradient(135deg,#2E5BFF,#00C2FF);color:#fff;box-shadow:0 12px 30px rgba(46,91,255,.35)}
  .lpx .btn-p:hover{transform:translateY(-3px) scale(1.02)}
  .lpx .btn-o{background:transparent;border:1.5px solid #2b2b45;color:#fff}
  .lpx .btn-o:hover{border-color:#00C2FF;color:#00C2FF}

  .lpx .rv{opacity:0;transform:translateY(26px);transition:opacity .7s ease,transform .7s cubic-bezier(.16,1,.3,1)}
  .lpx .rv.vis{opacity:1;transform:none}
  @keyframes lpxeq{0%,100%{height:12%}50%{height:100%}}
  @media(prefers-reduced-motion:reduce){.lpx .rv{opacity:1;transform:none}.lpx .eqi{animation:none!important}}

  /* HERO centrado */
  .lpx .hero{position:relative;text-align:center;padding:5rem 0 4rem;overflow:hidden}
  .lpx .hero .glow{position:absolute;left:50%;top:0;transform:translateX(-50%);width:900px;height:600px;background:radial-gradient(circle,rgba(46,91,255,.2),transparent 60%);filter:blur(20px);z-index:0;pointer-events:none}
  .lpx .hero .in{position:relative;z-index:2}
  .lpx .pill{display:inline-flex;align-items:center;gap:.6rem;border:1px solid #232338;background:#101018;border-radius:100px;padding:.5rem 1.1rem;font-size:.78rem;font-weight:600;color:#8b8ba3;margin-bottom:2rem}
  .lpx .pill .d{width:7px;height:7px;border-radius:50%;background:#22c55e;box-shadow:0 0 8px #22c55e}
  .lpx h1.big{font-family:'Unbounded',sans-serif;font-weight:900;font-size:clamp(2.4rem,6.5vw,5.2rem);line-height:1;letter-spacing:-.03em;margin:0 0 1.5rem;color:#fff}
  .lpx .hsub{color:#8b8ba3;font-size:1.15rem;max-width:40ch;margin:0 auto 2.4rem}
  .lpx .hbtns{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap}

  .lpx .eqband{position:relative;height:110px;margin-top:3.5rem;display:flex;align-items:flex-end;justify-content:center;gap:5px;padding:0 24px;overflow:hidden}
  .lpx .eqband .eqi{width:9px;background:linear-gradient(to top,rgba(46,91,255,.15),#00C2FF);border-radius:5px;animation:lpxeq 1.1s ease-in-out infinite}

  /* Search console */
  .lpx .console{max-width:900px;margin:0 auto;background:#101018;border:1px solid #232338;border-radius:24px;padding:.5rem;display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:.5rem;box-shadow:0 30px 60px -20px rgba(0,0,0,.8)}
  .lpx .fld{display:flex;align-items:center;gap:.7rem;background:#171724;border-radius:18px;padding:.9rem 1.1rem}
  .lpx .fld i{color:#00C2FF}
  .lpx .fld select{width:100%;background:none;border:none;color:#f4f5fb;font-family:'Sora';font-weight:500;outline:none;cursor:pointer}
  .lpx .fld select option{background:#171724;color:#f4f5fb}
  .lpx .console .go{background:linear-gradient(135deg,#2E5BFF,#00C2FF);color:#fff;border:none;border-radius:18px;padding:0 1.8rem;font-weight:700;font-family:'Sora';cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.5rem}

  .lpx section.blk{padding:5.5rem 0}
  .lpx .shead{margin-bottom:2.6rem}
  .lpx .shead.center{text-align:center}
  .lpx h2.t{font-family:'Unbounded',sans-serif;font-weight:800;font-size:clamp(1.9rem,4.5vw,3.2rem);line-height:1.05;letter-spacing:-.02em;margin:.6rem 0 0;color:#fff}
  .lpx .ssub{color:#8b8ba3;margin-top:.7rem;max-width:46ch}
  .lpx .shead.center .ssub{margin-left:auto;margin-right:auto}

  /* DJ rail */
  .lpx .rail{display:flex;gap:1.4rem;overflow-x:auto;padding:1rem 0 2rem;scroll-snap-type:x mandatory}
  .lpx .rail::-webkit-scrollbar{height:6px}.lpx .rail::-webkit-scrollbar-thumb{background:#2b2b45;border-radius:10px}
  .lpx .djc{flex:0 0 290px;scroll-snap-align:start;background:#101018;border:1px solid #232338;border-radius:24px;overflow:hidden;transition:.3s;position:relative}
  .lpx .djc:hover{border-color:#2E5BFF;transform:translateY(-6px)}
  .lpx .djc .top{height:150px;position:relative;background:linear-gradient(140deg,#2E5BFF,#0b1836);overflow:hidden}
  .lpx .djc .top img{width:100%;height:100%;object-fit:cover;opacity:.55}
  .lpx .djc .top .eqm{position:absolute;left:1.2rem;bottom:1.2rem;display:flex;gap:3px;align-items:flex-end;height:30px}
  .lpx .djc .top .eqm i{width:4px;background:rgba(255,255,255,.6);border-radius:2px;animation:lpxeq 1s ease-in-out infinite}
  .lpx .djc .bd{padding:1.5rem}
  .lpx .djc .av{width:60px;height:60px;border-radius:18px;margin-top:-52px;border:3px solid #101018;display:grid;place-items:center;font-family:'Unbounded';font-weight:800;font-size:1.2rem;color:#fff;background:linear-gradient(135deg,#2E5BFF,#00C2FF);position:relative;z-index:2;overflow:hidden}
  .lpx .djc .av img{width:100%;height:100%;object-fit:cover}
  .lpx .djc h3{font-family:'Unbounded';font-weight:700;font-size:1.1rem;margin:1rem 0 .3rem;letter-spacing:-.01em;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .lpx .djc .loc{color:#8b8ba3;font-size:.85rem;display:flex;align-items:center;gap:.4rem}
  .lpx .djc .loc i{color:#00C2FF}
  .lpx .djc .row{display:flex;align-items:center;justify-content:space-between;margin-top:1.2rem;padding-top:1.2rem;border-top:1px solid #232338}
  .lpx .djc .rt{font-weight:700;display:flex;align-items:center;gap:.3rem;color:#fff}.lpx .djc .rt i{color:#fbbf24}
  .lpx .djc .lk{color:#00C2FF;font-weight:600;font-size:.85rem;text-decoration:none}

  /* Timeline */
  .lpx .statsband{background:linear-gradient(135deg,#0a1330,#0b0a1e);border-top:1px solid #232338;border-bottom:1px solid #232338}
  .lpx .timeline{display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;position:relative}
  .lpx .timeline::before{content:"";position:absolute;top:26px;left:8%;right:8%;height:2px;background:linear-gradient(90deg,#2E5BFF,#00C2FF);opacity:.35}
  .lpx .tstep{text-align:center;position:relative}
  .lpx .tstep .n{width:54px;height:54px;margin:0 auto 1.2rem;border-radius:50%;display:grid;place-items:center;font-family:'Unbounded';font-weight:800;background:#101018;border:2px solid #2E5BFF;color:#00C2FF;position:relative;z-index:1}
  .lpx .tstep h4{font-family:'Unbounded';font-weight:700;font-size:1.05rem;margin:0 0 .5rem;color:#fff}
  .lpx .tstep p{color:#8b8ba3;font-size:.9rem;margin:0}

  /* Stats band */
  .lpx .sb-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;text-align:center}
  .lpx .sb .n{font-family:'Unbounded';font-weight:900;font-size:clamp(2.4rem,5vw,4rem);line-height:1;background:linear-gradient(135deg,#2E5BFF,#00C2FF);-webkit-background-clip:text;background-clip:text;color:transparent}
  .lpx .sb .l{color:#8b8ba3;font-size:.82rem;font-weight:600;text-transform:uppercase;letter-spacing:.1em;margin-top:.5rem}

  /* Why cards */
  .lpx .why{display:grid;grid-template-columns:repeat(3,1fr);gap:1.4rem}
  .lpx .wc{background:#101018;border:1px solid #232338;border-radius:24px;padding:2.4rem;transition:.3s}
  .lpx .wc:hover{border-color:#2E5BFF}
  .lpx .wc .ic{font-size:1.6rem;width:60px;height:60px;border-radius:20px;display:grid;place-items:center;background:linear-gradient(135deg,rgba(46,91,255,.2),rgba(0,194,255,.1));border:1px solid #2b3a66;color:#00C2FF;margin-bottom:1.4rem}
  .lpx .wc h3{font-family:'Unbounded';font-weight:700;font-size:1.15rem;margin:0 0 .6rem;color:#fff}
  .lpx .wc p{color:#8b8ba3;margin:0;font-size:.95rem}

  /* CTA */
  .lpx .cta{text-align:center;position:relative;overflow:hidden;border-radius:32px;padding:5rem 2rem;background:radial-gradient(700px circle at 30% 20%,rgba(46,91,255,.25),transparent 60%),radial-gradient(700px circle at 80% 90%,rgba(0,194,255,.2),transparent 60%),#0b0a16;border:1px solid #232338}
  .lpx .cta h2{font-family:'Unbounded';font-weight:900;font-size:clamp(2rem,5vw,3.6rem);line-height:1;margin:0 0 1.2rem;color:#fff}

  @media(max-width:820px){
    .lpx .console{grid-template-columns:1fr}
    .lpx .timeline{grid-template-columns:1fr 1fr}.lpx .timeline::before{display:none}
    .lpx .sb-grid,.lpx .why{grid-template-columns:1fr 1fr}
  }
  @media(max-width:520px){.lpx .sb-grid,.lpx .why{grid-template-columns:1fr}}
</style>

<div class="lpx">
<!-- HERO -->
<section class="hero">
  <div class="glow"></div>
  <div class="in container mx-auto px-4">
    <span class="pill"><span class="d"></span> La red #1 de DJs del Caquetá</span>
    <h1 class="big">Tu fiesta empieza<br>con el <span class="grad">beat correcto</span></h1>
    <p class="hsub">Descubre, escucha y reserva a los mejores DJs de la región. Coordina todo por chat y asegura tu fecha en minutos.</p>
    <div class="hbtns">
      <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="btn btn-p">Explorar DJs →</a>
      <?php if(isset($_SESSION['usuario_id'])): ?>
        <a href="<?php echo URL_ROOT; ?>/clientes/dashboard" class="btn btn-o">Mi panel</a>
      <?php else: ?>
        <a href="<?php echo URL_ROOT; ?>/usuarios/registro" class="btn btn-o">Crear cuenta gratis</a>
      <?php endif; ?>
    </div>
  </div>
  <div class="eqband" id="lpxeq"></div>
</section>

<!-- SEARCH -->
<section class="blk" style="padding-top:0">
  <div class="container mx-auto px-4">
    <form action="<?php echo URL_ROOT; ?>/djs/explorar" method="GET" class="console">
      <div class="fld"><i class="bi bi-calendar-event"></i>
        <select name="evento"><option value="">Tipo de evento</option>
          <?php foreach(($data['tipos_evento'] ?? []) as $ev): ?><option value="<?php echo $ev->nombre; ?>"><?php echo $ev->nombre; ?></option><?php endforeach; ?>
        </select></div>
      <div class="fld"><i class="bi bi-music-note-beamed"></i>
        <select name="genero"><option value="">Género</option>
          <?php foreach(($data['generos'] ?? []) as $gen): ?><option value="<?php echo $gen->nombre; ?>"><?php echo $gen->nombre; ?></option><?php endforeach; ?>
        </select></div>
      <div class="fld"><i class="bi bi-geo-alt"></i>
        <select name="ciudad"><option value="">Ciudad</option>
          <option value="Florencia">Florencia</option><option value="Morelia">Morelia</option>
          <option value="San Vicente del Caguán">San Vicente</option><option value="El Doncello">El Doncello</option>
          <option value="El Paujil">El Paujil</option><option value="Puerto Rico">Puerto Rico</option>
          <option value="Belén de los Andaquíes">Belén</option><option value="Cartagena del Chairá">Cartagena del Chairá</option>
        </select></div>
      <button type="submit" class="go"><i class="bi bi-search"></i> Buscar</button>
    </form>
  </div>
</section>

<!-- DJ RAIL -->
<section class="blk" style="padding-top:0">
  <div class="container mx-auto px-4">
    <div class="shead rv" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:1rem">
      <div><span class="eyebrow">Destacados</span><h2 class="t">DJs top del Caquetá</h2></div>
      <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="btn btn-o">Ver todos</a>
    </div>
    <?php if(empty($data['djs'])): ?>
      <div style="text-align:center;padding:3rem 0;color:#8b8ba3;border:2px dashed #232338;border-radius:24px">No hay DJs registrados todavía.</div>
    <?php else: ?>
    <div class="rail">
      <?php foreach(array_slice($data['djs'], 0, 8) as $dj): ?>
      <div class="djc rv">
        <div class="top">
          <?php if($dj->foto_perfil != 'default_dj.png'): ?><img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $dj->foto_perfil; ?>" alt="<?php echo $dj->nombre; ?>" loading="lazy"><?php endif; ?>
          <div class="eqm"><i style="height:60%"></i><i style="height:90%;animation-delay:-.2s"></i><i style="height:45%;animation-delay:-.4s"></i><i style="height:100%;animation-delay:-.1s"></i><i style="height:70%;animation-delay:-.5s"></i></div>
        </div>
        <div class="bd">
          <div class="av">
            <?php if($dj->foto_perfil != 'default_dj.png'): ?><img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $dj->foto_perfil; ?>"><?php else: ?><?php echo strtoupper(substr($dj->nombre,0,2)); ?><?php endif; ?>
          </div>
          <h3><?php echo $dj->nombre; ?></h3>
          <div class="loc"><i class="bi bi-geo-alt-fill"></i> <?php echo $dj->ciudad ? $dj->ciudad : 'Caquetá'; ?></div>
          <div class="row">
            <span class="rt"><i class="bi bi-star-fill"></i> <?php echo number_format($dj->calificacion_promedio, 1); ?></span>
            <a href="<?php echo URL_ROOT; ?>/djs/perfil/<?php echo $dj->id; ?>" class="lk">Ver perfil →</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- TIMELINE -->
<section class="blk statsband">
  <div class="container mx-auto px-4">
    <div class="shead center rv"><span class="eyebrow">Así funciona</span><h2 class="t">De la búsqueda a la pista</h2></div>
    <div class="timeline">
      <div class="tstep rv"><div class="n">1</div><h4>Regístrate</h4><p>Crea tu cuenta gratis en segundos.</p></div>
      <div class="tstep rv"><div class="n">2</div><h4>Elige tu DJ</h4><p>Filtra, escucha mezclas y compara.</p></div>
      <div class="tstep rv"><div class="n">3</div><h4>Solicita</h4><p>Propón fecha y negocia por chat.</p></div>
      <div class="tstep rv"><div class="n">4</div><h4>Vive la fiesta</h4><p>El DJ llega y enciende tu evento.</p></div>
    </div>
  </div>
</section>

<!-- STATS -->
<section class="blk">
  <div class="container mx-auto px-4">
    <div class="sb-grid">
      <div class="sb rv"><div class="n"><?php echo $data['total_djs'] ?? '25'; ?>+</div><div class="l">DJs registrados</div></div>
      <div class="sb rv"><div class="n"><?php echo $data['total_eventos'] ?? '150'; ?>+</div><div class="l">Eventos realizados</div></div>
      <div class="sb rv"><div class="n">12</div><div class="l">Ciudades</div></div>
      <div class="sb rv"><div class="n">100%</div><div class="l">Registro gratis</div></div>
    </div>
  </div>
</section>

<!-- WHY -->
<section class="blk statsband">
  <div class="container mx-auto px-4">
    <div class="shead center rv"><span class="eyebrow">Ventajas</span><h2 class="t">¿Por qué DJPRO?</h2></div>
    <div class="why">
      <div class="wc rv"><div class="ic"><i class="bi bi-shield-check"></i></div><h3>DJs verificados</h3><p>Perfiles con portafolio, géneros y calificaciones reales. Sabes a quién contratas.</p></div>
      <div class="wc rv"><div class="ic"><i class="bi bi-chat-dots-fill"></i></div><h3>Chat interno</h3><p>Coordina cada detalle, negocia el precio y confirma sin salir de la plataforma.</p></div>
      <div class="wc rv"><div class="ic"><i class="bi bi-calendar2-check-fill"></i></div><h3>Reservas seguras</h3><p>Estados claros, contra-ofertas y confirmación de pago. Tu fecha queda asegurada.</p></div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="blk">
  <div class="container mx-auto px-4">
    <div class="cta rv">
      <span class="eyebrow">¿Tienes las manos en el mezclador?</span>
      <h2>Pon tu nombre<br>en la <span class="grad">cabina</span></h2>
      <p class="ssub" style="margin:0 auto 2rem">Únete a la red de DJs más grande del Caquetá y cobra por hacer lo que amas.</p>
      <a href="<?php echo URL_ROOT; ?>/usuarios/registro" class="btn btn-p" style="font-size:1.05rem"><i class="bi bi-headphones"></i> Crear mi perfil de DJ</a>
    </div>
  </div>
</section>
</div>

<script>
  (function(){
    var eq=document.getElementById('lpxeq');
    if(eq){var n=60;for(var i=0;i<n;i++){var b=document.createElement('i');b.className='eqi';b.style.animationDelay=(-(i*0.05))+'s';b.style.animationDuration=(0.8+Math.random()*0.9)+'s';eq.appendChild(b);}}
    var reduce=matchMedia('(prefers-reduced-motion: reduce)').matches;
    var els=document.querySelectorAll('.lpx .rv');
    if(reduce||!('IntersectionObserver' in window)){els.forEach(function(e){e.classList.add('vis')});return;}
    var io=new IntersectionObserver(function(en){en.forEach(function(e){if(e.isIntersecting){e.target.classList.add('vis');io.unobserve(e.target);}})},{threshold:.12,rootMargin:'0px 0px -8% 0px'});
    els.forEach(function(e){io.observe(e)});
  })();
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

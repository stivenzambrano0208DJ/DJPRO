<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<style>
    /* ── Landing "DJ Blue" ── */
    .hero-mesh{
        background:
            radial-gradient(600px circle at 15% 15%, rgba(46,91,255,.22), transparent 60%),
            radial-gradient(560px circle at 85% 25%, rgba(0,194,255,.16), transparent 60%),
            radial-gradient(700px circle at 50% 110%, rgba(124,77,255,.14), transparent 60%);
    }
    #heroViz{position:absolute;left:0;right:0;bottom:0;width:100%;height:42%;z-index:0;opacity:.55;pointer-events:none}
    .grad-text{background:linear-gradient(105deg,#2E5BFF,#00C2FF 70%,#9ad8ff);-webkit-background-clip:text;background-clip:text;color:transparent}
    .kin{display:block;overflow:hidden}
    .kin>span{display:block;transform:translateY(105%);animation:kinUp .9s cubic-bezier(.16,1,.3,1) forwards}
    .kin:nth-child(2)>span{animation-delay:.12s}
    .kin:nth-child(3)>span{animation-delay:.24s}
    @keyframes kinUp{to{transform:translateY(0)}}

    .mq{overflow:hidden;position:relative}
    .mq-track{display:flex;width:max-content;gap:0;animation:mqScroll 30s linear infinite}
    .mq:hover .mq-track{animation-play-state:paused}
    @keyframes mqScroll{to{transform:translateX(-50%)}}
    .mq-item{font-family:'Bebas Neue',cursive;font-size:2rem;letter-spacing:.05em;color:#3a4a6b;padding:0 2rem;white-space:nowrap;display:flex;align-items:center;gap:2rem;transition:color .2s}
    .mq-item::after{content:"◆";font-size:.7rem;color:#2E5BFF}
    .mq-item:hover{color:#fff}

    .step-num{font-family:'Bebas Neue',cursive;font-size:9rem;line-height:1;color:#141b30;position:absolute;right:-.5rem;bottom:-2rem;z-index:0}

    @media (prefers-reduced-motion: reduce){
        .kin>span{transform:none;animation:none}
        .mq-track{animation:none}
    }
</style>

<!-- ══════════════ HERO ══════════════ -->
<section class="hero-mesh relative min-h-[92vh] flex items-center justify-center overflow-hidden">
    <canvas id="heroViz" aria-hidden="true"></canvas>
    <div class="absolute inset-0 opacity-[0.04] bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] z-0"></div>

    <div class="container mx-auto px-4 relative z-10 text-center">
        <span class="inline-flex items-center gap-2 bg-djpro-surface border border-djpro-border rounded-full px-4 py-2 mb-8 text-[11px] font-bold uppercase tracking-[0.2em] text-djpro-muted">
            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
            La red #1 de DJs del Caquetá
        </span>

        <h1 class="text-6xl md:text-8xl font-bebas text-white mb-6 tracking-tight leading-[0.86]">
            <span class="kin"><span>ENCUENTRA TU</span></span>
            <span class="kin"><span class="grad-text">DJ PERFECTO</span></span>
            <span class="kin"><span>EN EL CAQUETÁ</span></span>
        </h1>
        <p class="text-xl md:text-2xl text-djpro-muted font-light mb-12 max-w-2xl mx-auto tracking-wide">
            La red profesional de DJs más grande de la región. <span class="text-white font-medium">Calidad, energía y profesionalismo</span> para tu próximo evento.
        </p>

        <!-- Barra de Búsqueda -->
        <div class="max-w-4xl mx-auto bg-djpro-surface/90 backdrop-blur p-2 rounded-3xl border border-djpro-border shadow-2xl shadow-blue-900/30">
            <form action="<?php echo URL_ROOT; ?>/djs/explorar" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-2">
                <div class="flex items-center px-4 py-3 bg-djpro-surface-2 rounded-2xl">
                    <i class="bi bi-calendar-event text-djpro-accent mr-3"></i>
                    <select name="evento" class="bg-transparent border-none text-djpro-text focus:ring-0 w-full cursor-pointer font-semibold outline-none">
                        <option value="" class="bg-djpro-surface-2">Tipo de Evento</option>
                        <?php foreach(($data['tipos_evento'] ?? []) as $ev): ?>
                            <option value="<?php echo $ev->nombre; ?>" class="bg-djpro-surface-2"><?php echo $ev->nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex items-center px-4 py-3 bg-djpro-surface-2 rounded-2xl">
                    <i class="bi bi-music-note-beamed text-djpro-accent mr-3"></i>
                    <select name="genero" class="bg-transparent border-none text-djpro-text focus:ring-0 w-full cursor-pointer font-semibold outline-none">
                        <option value="" class="bg-djpro-surface-2">Género Musical</option>
                        <?php foreach(($data['generos'] ?? []) as $gen): ?>
                            <option value="<?php echo $gen->nombre; ?>" class="bg-djpro-surface-2"><?php echo $gen->nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex items-center px-4 py-3 bg-djpro-surface-2 rounded-2xl">
                    <i class="bi bi-geo-alt text-djpro-accent mr-3"></i>
                    <select name="ciudad" class="bg-transparent border-none text-djpro-text focus:ring-0 w-full cursor-pointer font-semibold outline-none">
                        <option value="" class="bg-djpro-surface-2">Toda la región</option>
                        <option value="Florencia" class="bg-djpro-surface-2">Florencia</option>
                        <option value="Morelia" class="bg-djpro-surface-2">Morelia</option>
                        <option value="Belén de los Andaquíes" class="bg-djpro-surface-2">Belén</option>
                        <option value="San Vicente del Caguán" class="bg-djpro-surface-2">San Vicente</option>
                        <option value="Puerto Rico" class="bg-djpro-surface-2">Puerto Rico</option>
                        <option value="El Doncello" class="bg-djpro-surface-2">El Doncello</option>
                        <option value="El Paujil" class="bg-djpro-surface-2">El Paujil</option>
                        <option value="Cartagena del Chairá" class="bg-djpro-surface-2">Cartagena del Chairá</option>
                        <option value="Curillo" class="bg-djpro-surface-2">Curillo</option>
                        <option value="Albania" class="bg-djpro-surface-2">Albania</option>
                        <option value="San José del Fragua" class="bg-djpro-surface-2">San José del Fragua</option>
                        <option value="Valparaíso" class="bg-djpro-surface-2">Valparaíso</option>
                        <option value="Solita" class="bg-djpro-surface-2">Solita</option>
                        <option value="Solano" class="bg-djpro-surface-2">Solano</option>
                        <option value="La Montañita" class="bg-djpro-surface-2">La Montañita</option>
                        <option value="Milan" class="bg-djpro-surface-2">Milán</option>
                    </select>
                </div>
                <button type="submit" class="text-white font-bold py-4 rounded-2xl transition-all flex items-center justify-center gap-2 group hover:brightness-110 shadow-lg shadow-blue-500/25" style="background:linear-gradient(135deg,#2E5BFF,#00C2FF)">
                    <i class="bi bi-search group-hover:scale-110 transition-transform"></i>
                    BUSCAR DJ
                </button>
            </form>
        </div>

        <!-- Stats -->
        <div class="mt-16 flex flex-wrap justify-center gap-8 md:gap-16 relative">
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 flex items-center gap-2 bg-green-500/10 border border-green-500/20 px-3 py-1 rounded-full">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-[9px] font-bold text-green-500 uppercase tracking-widest">Live Updates</span>
            </div>
            <div class="text-center">
                <span id="stat-djs" class="block text-4xl font-bebas text-white"><?php echo $data['total_djs'] ?? '25'; ?>+</span>
                <span class="text-sm text-djpro-muted uppercase tracking-widest font-bold">DJs Registrados</span>
            </div>
            <div class="text-center">
                <span id="stat-eventos" class="block text-4xl font-bebas text-white"><?php echo $data['total_eventos'] ?? '150'; ?>+</span>
                <span class="text-sm text-djpro-muted uppercase tracking-widest font-bold">Eventos Realizados</span>
            </div>
            <div class="text-center">
                <span class="block text-4xl font-bebas text-white">12</span>
                <span class="text-sm text-djpro-muted uppercase tracking-widest font-bold">Ciudades Cubiertas</span>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════ MARQUEE GÉNEROS ══════════════ -->
<div class="mq border-y border-djpro-border py-5 bg-djpro-surface/40">
    <div class="mq-track">
        <?php
            $gens = array_map(fn($g) => $g->nombre, $data['generos'] ?? []);
            if(empty($gens)) $gens = ['Guaracha','Reggaetón','Techno','Salsa','Crossover','Champeta','House','Cumbia','Afrobeat','Electrónica'];
            $loop = array_merge($gens, $gens);
            foreach($loop as $g): ?>
            <span class="mq-item"><?php echo strtoupper($g); ?></span>
        <?php endforeach; ?>
    </div>
</div>

<!-- ══════════════ CÓMO FUNCIONA ══════════════ -->
<section class="py-24 bg-djpro-bg">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="text-djpro-accent font-mono text-xs font-bold uppercase tracking-[0.3em]">Tres pasos, cero enredos</span>
            <h2 class="text-5xl font-bebas text-white mt-3">CÓMO <span class="grad-text">FUNCIONA</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="relative overflow-hidden bg-djpro-surface border border-djpro-border rounded-3xl p-8 hover:border-djpro-accent transition-all">
                <span class="step-num">1</span>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl grid place-items-center text-white mb-5" style="background:linear-gradient(135deg,#2E5BFF,#00C2FF)"><i class="bi bi-search text-2xl"></i></div>
                    <h3 class="text-2xl font-bebas text-white tracking-widest mb-2">BUSCA</h3>
                    <p class="text-djpro-muted text-sm leading-relaxed">Filtra por tipo de evento, género y ciudad. Escucha sus mezclas y mira sus calificaciones reales.</p>
                </div>
            </div>
            <div class="relative overflow-hidden bg-djpro-surface border border-djpro-border rounded-3xl p-8 hover:border-djpro-accent transition-all">
                <span class="step-num">2</span>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl grid place-items-center text-white mb-5" style="background:linear-gradient(135deg,#2E5BFF,#00C2FF)"><i class="bi bi-calendar2-check text-2xl"></i></div>
                    <h3 class="text-2xl font-bebas text-white tracking-widest mb-2">RESERVA</h3>
                    <p class="text-djpro-muted text-sm leading-relaxed">Envía tu solicitud con fecha y horario. El DJ la acepta y coordinan todo por el chat interno.</p>
                </div>
            </div>
            <div class="relative overflow-hidden bg-djpro-surface border border-djpro-border rounded-3xl p-8 hover:border-djpro-accent transition-all">
                <span class="step-num">3</span>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl grid place-items-center text-white mb-5" style="background:linear-gradient(135deg,#2E5BFF,#00C2FF)"><i class="bi bi-music-note-list text-2xl"></i></div>
                    <h3 class="text-2xl font-bebas text-white tracking-widest mb-2">VIVE LA FIESTA</h3>
                    <p class="text-djpro-muted text-sm leading-relaxed">Disfruta tu evento. Al terminar, calificas al DJ y ayudas a que la comunidad siga creciendo.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════ DJs DESTACADOS ══════════════ -->
<section class="py-24 bg-djpro-bg">
    <div class="container mx-auto px-4">
        <div class="flex items-end justify-between mb-12">
            <div>
                <span class="text-djpro-accent font-mono text-xs font-bold uppercase tracking-[0.3em]">En cabina esta semana</span>
                <h2 class="text-5xl font-bebas text-white mt-3">DJs <span class="grad-text">DESTACADOS</span></h2>
                <p class="text-djpro-muted tracking-wide mt-2">Los perfiles más solicitados y mejor calificados de la semana.</p>
            </div>
            <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="hidden md:flex items-center gap-2 text-djpro-accent font-bold hover:gap-3 transition-all">
                Ver todos los DJs <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php if(empty($data['djs'])): ?>
                <div class="col-span-full text-center py-12 border-2 border-dashed border-djpro-border rounded-3xl">
                    <p class="text-djpro-muted uppercase font-bold tracking-widest">No hay DJs registrados todavía.</p>
                </div>
            <?php else: ?>
                <?php foreach($data['djs'] as $dj): ?>
                <div class="dj-card group rounded-2xl overflow-hidden relative">
                    <div class="h-32 overflow-hidden" style="background:linear-gradient(140deg,#2E5BFF,#0b1836)">
                        <?php if($dj->foto_perfil != 'default_dj.png'): ?>
                            <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $dj->foto_perfil; ?>" class="w-full h-full object-cover opacity-40 group-hover:scale-110 transition-transform duration-700">
                        <?php endif; ?>
                    </div>
                    <div class="p-6 pt-0 relative">
                        <div class="w-20 h-20 rounded-2xl border-4 border-djpro-surface bg-djpro-surface-2 mx-auto -mt-10 overflow-hidden shadow-2xl group-hover:border-djpro-accent transition-all duration-300">
                            <?php if($dj->foto_perfil != 'default_dj.png'): ?>
                                <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $dj->foto_perfil; ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($dj->nombre); ?>&background=0b1836&color=2E5BFF" class="w-full h-full object-cover">
                            <?php endif; ?>
                        </div>
                        <div class="text-center mt-4">
                            <h3 class="text-2xl font-bebas text-white group-hover:text-djpro-accent transition-colors tracking-widest uppercase truncate"><?php echo $dj->nombre; ?></h3>
                            <div class="flex items-center justify-center gap-1 text-djpro-muted text-[10px] uppercase font-bold tracking-widest mb-4">
                                <i class="bi bi-geo-alt-fill text-djpro-accent"></i>
                                <span><?php echo $dj->ciudad ? $dj->ciudad : 'Caquetá'; ?></span>
                            </div>
                            <div class="flex flex-wrap justify-center gap-1 mb-6">
                                <?php
                                $generos = explode(',', $dj->generos);
                                foreach(array_slice($generos, 0, 2) as $gen): if(!empty($gen)):
                                ?>
                                <span class="bg-djpro-surface-2 text-djpro-muted text-[8px] font-bold px-2 py-1 rounded-md border border-djpro-border uppercase tracking-tighter"><?php echo $gen; ?></span>
                                <?php endif; endforeach; ?>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t border-djpro-border">
                                <div class="text-left">
                                    <span class="block text-[10px] text-djpro-muted uppercase font-bold tracking-tighter">Status</span>
                                    <span class="text-[10px] font-bold text-green-500 uppercase">Disponible</span>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center justify-end text-yellow-500 text-[10px] mb-1">
                                        <i class="bi bi-star-fill"></i>
                                        <span class="ml-1 text-white"><?php echo number_format($dj->calificacion_promedio, 1); ?></span>
                                    </div>
                                    <span class="text-[9px] text-djpro-muted uppercase font-bold">PRO DJ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Hover Layer -->
                    <div class="absolute inset-0 bg-djpro-bg/90 backdrop-blur-md opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center gap-4 p-6">
                        <p class="text-white text-xs font-medium text-center line-clamp-3">
                            <?php echo $dj->biografia ?: 'Experimenta lo mejor del talento local con '.$dj->nombre.'.'; ?>
                        </p>
                        <?php if(isset($_SESSION['usuario_id'])): ?>
                            <a href="<?php echo URL_ROOT; ?>/djs/perfil/<?php echo $dj->id; ?>?reservar=1" class="btn-djpro-primary w-full text-center py-2.5">RESERVAR AHORA</a>
                        <?php else: ?>
                            <a href="<?php echo URL_ROOT; ?>/usuarios/login?redirect=djs/perfil/<?php echo $dj->id; ?>" class="btn-djpro-primary w-full text-center py-2.5">RESERVAR AHORA</a>
                        <?php endif; ?>
                        <a href="<?php echo URL_ROOT; ?>/djs/perfil/<?php echo $dj->id; ?>" class="text-[10px] text-djpro-muted hover:text-white font-bold uppercase tracking-widest">Ver Perfil</a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ══════════════ CTA DJs ══════════════ -->
<section class="py-24 bg-djpro-bg">
    <div class="container mx-auto px-4">
        <div class="relative overflow-hidden rounded-[2rem] border border-djpro-border p-12 md:p-16 text-center" style="background:linear-gradient(135deg,#0a1228,#0e0a1e)">
            <div class="absolute inset-0 opacity-60" style="background:radial-gradient(600px circle at 20% 10%,rgba(46,91,255,.3),transparent 55%),radial-gradient(600px circle at 85% 90%,rgba(0,194,255,.22),transparent 55%)"></div>
            <div class="relative z-10">
                <span class="text-djpro-accent-2 font-mono text-xs font-bold uppercase tracking-[0.3em]" style="color:#00C2FF">¿Tienes las manos en el mezclador?</span>
                <h2 class="text-5xl md:text-7xl font-bebas text-white mt-4 mb-4 leading-none">PON TU NOMBRE<br>EN LA <span class="grad-text">CABINA</span></h2>
                <p class="text-djpro-muted max-w-xl mx-auto mb-8 text-lg">Únete a la red de DJs más grande del Caquetá. Crea tu perfil, recibe reservas y cobra por hacer lo que amas.</p>
                <a href="<?php echo URL_ROOT; ?>/usuarios/registro" class="btn-djpro-primary inline-flex items-center gap-2 text-base px-8 py-4">
                    <i class="bi bi-headphones"></i> CREAR MI PERFIL DE DJ
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    // Stats en tiempo real
    function updateStats() {
        fetch('<?php echo URL_ROOT; ?>/pages/api_stats')
            .then(r => r.json())
            .then(d => {
                const dj = document.getElementById('stat-djs');
                const ev = document.getElementById('stat-eventos');
                if (dj) dj.innerText = d.total_djs + '+';
                if (ev) ev.innerText = d.total_eventos + '+';
            })
            .catch(() => {});
    }
    setInterval(updateStats, 10000);

    // Ecualizador ambiental del hero
    (function(){
        const cv = document.getElementById('heroViz');
        if (!cv) return;
        const ctx = cv.getContext('2d');
        const reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        let W, H, DPR = Math.min(window.devicePixelRatio || 1, 2), N = 56, ph = [];
        for (let i=0;i<N;i++) ph[i] = Math.random()*Math.PI*2;
        function size(){ W = cv.clientWidth; H = cv.clientHeight; cv.width = W*DPR; cv.height = H*DPR; ctx.setTransform(DPR,0,0,DPR,0,0); }
        size(); window.addEventListener('resize', size);
        function draw(t){
            ctx.clearRect(0,0,W,H);
            const bw = W/N, base = H;
            for (let i=0;i<N;i++){
                const m = Math.sin(t/620 + ph[i])*.5 + .5;
                const m2 = Math.sin(t/300 + i*.35)*.5 + .5;
                const h = (m*.6 + m2*.4) * H * .8 + 6;
                const g = ctx.createLinearGradient(0, base-h, 0, base);
                g.addColorStop(0, 'rgba(0,194,255,.9)');
                g.addColorStop(1, 'rgba(46,91,255,.1)');
                ctx.fillStyle = g;
                const x = i*bw + bw*.2, w = bw*.6;
                if (ctx.roundRect){ ctx.beginPath(); ctx.roundRect(x, base-h, w, h, 3); ctx.fill(); }
                else ctx.fillRect(x, base-h, w, h);
            }
            raf = requestAnimationFrame(draw);
        }
        let raf;
        if (reduce) draw(1000); else raf = requestAnimationFrame(draw);
    })();
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

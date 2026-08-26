<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<style>
    /* ═══════════ Landing DJPRO (estructura NeivActiva · colores DJPRO azul) ═══════════ */
    .lp{--a:#2E5BFF;--a2:#00C2FF}
    .lp .kicker{font-family:'JetBrains Mono','Rajdhani',monospace;font-size:.72rem;font-weight:700;letter-spacing:.28em;text-transform:uppercase;color:var(--a)}
    .lp h2.title{font-family:'Bebas Neue',cursive;font-size:clamp(2.4rem,5vw,4rem);line-height:.95;color:#fff;margin:.6rem 0 0;letter-spacing:.02em}
    .lp h2.title em{font-style:normal;background:linear-gradient(105deg,var(--a),var(--a2));-webkit-background-clip:text;background-clip:text;color:transparent}
    .lp .subtitle{color:#64748b;max-width:44ch;margin:1rem auto 0;font-size:1.05rem}
    .grad-b{background:linear-gradient(105deg,#2E5BFF,#00C2FF 70%,#9ad8ff);-webkit-background-clip:text;background-clip:text;color:transparent}
    .btn-glow{background:linear-gradient(135deg,#2E5BFF,#00C2FF);color:#fff;font-weight:700;padding:.85rem 1.6rem;border-radius:.85rem;display:inline-flex;align-items:center;gap:.55rem;box-shadow:0 10px 26px rgba(46,91,255,.3);transition:transform .2s,box-shadow .25s}
    .btn-glow:hover{transform:translateY(-2px);box-shadow:0 14px 32px rgba(46,91,255,.42)}
    .btn-ghost{background:rgba(255,255,255,.04);border:1px solid #26304a;color:#e2e8f0;font-weight:700;padding:.85rem 1.6rem;border-radius:.85rem;display:inline-flex;align-items:center;gap:.55rem;transition:all .2s}
    .btn-ghost:hover{border-color:#2E5BFF;color:#fff}

    /* Reveal */
    .rv{opacity:0;transform:translateY(26px);transition:opacity .7s ease,transform .7s cubic-bezier(.16,1,.3,1)}
    .rv.vis{opacity:1;transform:none}
    @keyframes floaty{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
    @keyframes discspin{to{transform:rotate(360deg)}}
    @keyframes eqb{0%,100%{height:22%}50%{height:100%}}
    @media(prefers-reduced-motion:reduce){.rv{opacity:1;transform:none}.floaty,.disc,.eqbar{animation:none!important}}

    /* Hero */
    .lp-hero{position:relative;overflow:hidden;padding:2rem 0 5rem}
    .lp-hero .mesh{position:absolute;inset:0;z-index:0;background:
        radial-gradient(620px circle at 12% 20%,rgba(46,91,255,.18),transparent 60%),
        radial-gradient(560px circle at 88% 30%,rgba(0,194,255,.12),transparent 60%)}
    .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1.05fr .95fr;gap:3rem;align-items:center}
    .hero-badge{display:inline-flex;align-items:center;gap:.5rem;background:#12121a;border:1px solid #1e293b;border-radius:100px;padding:.5rem 1rem;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.16em;color:#94a3b8}
    .hero-badge i{color:var(--a)}
    .hero-h1{font-family:'Bebas Neue',cursive;font-size:clamp(3rem,6.5vw,5.5rem);line-height:.9;color:#fff;margin:1.4rem 0 1rem;letter-spacing:.02em}
    .hero-p{color:#94a3b8;font-size:1.15rem;max-width:34ch;margin-bottom:2rem;line-height:1.55}
    .hero-visual{position:relative;height:420px;display:grid;place-items:center}
    .disc{width:270px;height:270px;border-radius:50%;background:repeating-radial-gradient(circle at center,#0d0d14 0 4px,#191922 4px 8px);box-shadow:0 30px 70px rgba(0,0,0,.6),0 0 0 10px #0b0b12,0 0 0 11px #1e293b;animation:discspin 10s linear infinite;position:relative}
    .disc::after{content:"";position:absolute;inset:0;margin:auto;width:82px;height:82px;border-radius:50%;background:linear-gradient(135deg,#2E5BFF,#00C2FF);border:7px solid #0a0a0f;box-shadow:0 0 24px rgba(46,91,255,.6)}
    .disc::before{content:"";position:absolute;inset:0;margin:auto;width:12px;height:12px;border-radius:50%;background:#0a0a0f;z-index:2}
    .float-pill{position:absolute;background:rgba(18,18,26,.9);backdrop-filter:blur(8px);border:1px solid #26304a;border-radius:1rem;padding:.85rem 1.1rem;display:flex;align-items:center;gap:.65rem;font-weight:700;color:#fff;font-size:.9rem;box-shadow:0 16px 40px rgba(0,0,0,.5);animation:floaty 4s ease-in-out infinite}
    .float-pill i{width:34px;height:34px;border-radius:.6rem;display:grid;place-items:center;background:linear-gradient(135deg,#2E5BFF,#00C2FF);color:#fff;font-size:1rem}
    .fp-1{top:24px;left:-6px;animation-delay:0s}
    .fp-2{bottom:34px;right:-10px;animation-delay:1.5s}
    .fp-3{bottom:120px;left:-26px;animation-delay:.8s}

    /* Categorías */
    .cats{border-top:1px solid #1e293b;border-bottom:1px solid #1e293b;background:rgba(18,18,26,.4);padding:2rem 0}
    .cats-grid{display:flex;flex-wrap:wrap;justify-content:center;gap:2.5rem}
    .cat-item{display:flex;flex-direction:column;align-items:center;gap:.7rem;color:#94a3b8;transition:color .2s}
    .cat-item:hover{color:#fff}
    .cat-circle{width:66px;height:66px;border-radius:50%;display:grid;place-items:center;font-size:1.5rem;color:var(--a);background:#12121a;border:1px solid #1e293b;transition:all .25s}
    .cat-item:hover .cat-circle{border-color:var(--a);box-shadow:0 0 22px rgba(46,91,255,.25);transform:translateY(-4px)}
    .cat-item span{font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em}

    /* Secciones */
    .lp-section{padding:6rem 0}
    .section-alt{background:rgba(18,18,26,.4);border-top:1px solid #1e293b;border-bottom:1px solid #1e293b}
    .sec-head{text-align:center;margin-bottom:3.5rem}

    /* Showcase cards */
    .showcase{display:grid;grid-template-columns:repeat(3,1fr);gap:1.75rem}
    .sc-card{background:#12121a;border:1px solid #1e293b;border-radius:1.25rem;overflow:hidden;transition:all .3s;display:flex;flex-direction:column}
    .sc-card:hover{border-color:var(--a);transform:translateY(-6px);box-shadow:0 24px 50px -20px rgba(46,91,255,.4)}
    .sc-img{height:180px;position:relative;overflow:hidden;background:linear-gradient(140deg,#2E5BFF,#0b1836)}
    .sc-img img{width:100%;height:100%;object-fit:cover;opacity:.85;transition:transform .6s}
    .sc-card:hover .sc-img img{transform:scale(1.08)}
    .sc-badge{position:absolute;top:12px;left:12px;background:rgba(10,10,15,.7);backdrop-filter:blur(6px);border:1px solid #26304a;color:#fff;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;padding:.35rem .7rem;border-radius:100px}
    .sc-avatar{position:absolute;bottom:-26px;left:20px;width:64px;height:64px;border-radius:1rem;border:4px solid #12121a;display:grid;place-items:center;font-family:'Bebas Neue',cursive;font-size:1.5rem;color:#fff;background:linear-gradient(135deg,#2E5BFF,#00C2FF);overflow:hidden}
    .sc-avatar img{width:100%;height:100%;object-fit:cover}
    .sc-body{padding:2.2rem 1.4rem 1.2rem;flex:1}
    .sc-body h3{font-family:'Bebas Neue',cursive;font-size:1.5rem;color:#fff;letter-spacing:.06em;margin:0 0 .5rem}
    .sc-meta{display:flex;flex-direction:column;gap:.45rem}
    .sc-meta span{display:flex;align-items:center;gap:.5rem;color:#94a3b8;font-size:.85rem;font-weight:500}
    .sc-meta i{color:var(--a)}
    .sc-foot{border-top:1px solid #1e293b;padding:1rem 1.4rem;display:flex;align-items:center;justify-content:space-between}
    .sc-rating{display:flex;align-items:center;gap:.35rem;color:#fff;font-weight:700;font-size:.9rem}
    .sc-rating i{color:#fbbf24}
    .sc-link{color:var(--a);font-weight:700;font-size:.8rem;text-transform:uppercase;letter-spacing:.06em;display:flex;align-items:center;gap:.35rem;transition:gap .2s}
    .sc-card:hover .sc-link{gap:.6rem}

    /* How it works */
    .how{display:grid;grid-template-columns:.9fr 1.1fr;gap:4rem;align-items:center}
    .how-visual{position:relative;border-radius:1.5rem;overflow:hidden;aspect-ratio:4/5;background:radial-gradient(circle at 60% 30%,rgba(46,91,255,.3),transparent 60%),linear-gradient(160deg,#12121a,#0a0a0f);border:1px solid #1e293b;display:grid;place-items:center}
    .how-visual .disc{width:180px;height:180px;box-shadow:0 20px 50px rgba(0,0,0,.5),0 0 0 8px #0b0b12,0 0 0 9px #1e293b}
    .how-visual .waves{position:absolute;bottom:0;left:0;right:0;display:flex;align-items:flex-end;gap:5px;height:80px;padding:0 24px;opacity:.5}
    .how-visual .waves i{flex:1;background:linear-gradient(to top,#2E5BFF,#00C2FF);border-radius:4px 4px 0 0}
    .how-steps{display:flex;flex-direction:column;gap:1.4rem;margin-top:1.8rem}
    .how-step{display:flex;gap:1.1rem;align-items:flex-start}
    .how-num{width:44px;height:44px;flex:none;border-radius:.85rem;display:grid;place-items:center;font-family:'Bebas Neue',cursive;font-size:1.4rem;color:#fff;background:linear-gradient(135deg,#2E5BFF,#00C2FF);box-shadow:0 8px 18px rgba(46,91,255,.3)}
    .how-step strong{display:block;color:#fff;font-size:1.05rem;font-weight:700;margin-bottom:.2rem}
    .how-step p{color:#94a3b8;font-size:.92rem;margin:0;line-height:1.5}

    /* Feature cards (por qué) */
    .feat-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.75rem}
    .feat-card{background:#12121a;border:1px solid #1e293b;border-radius:1.25rem;padding:2.2rem;transition:all .3s}
    .feat-card:hover{border-color:var(--a);transform:translateY(-5px)}
    .feat-ic{width:56px;height:56px;border-radius:1rem;display:grid;place-items:center;font-size:1.6rem;color:#fff;background:linear-gradient(135deg,#2E5BFF,#00C2FF);margin-bottom:1.3rem}
    .feat-card h3{font-family:'Bebas Neue',cursive;font-size:1.5rem;color:#fff;letter-spacing:.05em;margin:0 0 .6rem}
    .feat-card p{color:#94a3b8;margin:0;line-height:1.55}

    /* About + stats */
    .about{display:grid;grid-template-columns:1.1fr .9fr;gap:4rem;align-items:center}
    .about h2{font-family:'Bebas Neue',cursive;font-size:clamp(2.2rem,4.5vw,3.4rem);color:#fff;line-height:1;margin:.7rem 0 1.2rem}
    .about h2 em{font-style:normal}
    .about p{color:#94a3b8;line-height:1.7;margin-bottom:1rem}
    .stat-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;margin:1.8rem 0}
    .stat-card{background:#12121a;border:1px solid #1e293b;border-radius:1rem;padding:1.4rem}
    .stat-card .n{font-family:'Bebas Neue',cursive;font-size:2.6rem;line-height:1;background:linear-gradient(105deg,#2E5BFF,#00C2FF);-webkit-background-clip:text;background-clip:text;color:transparent}
    .stat-card .l{color:#94a3b8;font-size:.82rem;font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-top:.3rem}
    .about-visual{position:relative;border-radius:1.5rem;overflow:hidden;aspect-ratio:1;background:radial-gradient(circle at 40% 30%,rgba(0,194,255,.25),transparent 55%),linear-gradient(150deg,#141b30,#0a0a0f);border:1px solid #1e293b;display:grid;place-items:center}

    /* CTA banner */
    .cta-band{position:relative;overflow:hidden;border-radius:2rem;padding:5rem 2rem;text-align:center;background:linear-gradient(135deg,#0a1228,#0e0a1e);border:1px solid #1e293b}
    .cta-band::before{content:"";position:absolute;inset:0;opacity:.6;background:radial-gradient(600px circle at 20% 10%,rgba(46,91,255,.3),transparent 55%),radial-gradient(600px circle at 85% 90%,rgba(0,194,255,.22),transparent 55%)}
    .cta-band>*{position:relative;z-index:1}
    .cta-band h2{font-family:'Bebas Neue',cursive;font-size:clamp(2.4rem,5vw,4rem);color:#fff;line-height:.95;margin:0 0 1rem}

    /* Testimonials */
    .tst-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.75rem}
    .tst-card{background:#12121a;border:1px solid #1e293b;border-radius:1.25rem;padding:2rem;transition:all .3s}
    .tst-card:hover{border-color:var(--a)}
    .tst-stars{color:#fbbf24;margin-bottom:1rem;font-size:.9rem}
    .tst-card blockquote{color:#cbd5e1;font-size:.95rem;line-height:1.7;margin:0 0 1.5rem;font-style:italic}
    .tst-author{display:flex;align-items:center;gap:.8rem}
    .tst-avatar{width:46px;height:46px;border-radius:50%;display:grid;place-items:center;font-weight:800;color:#fff;background:linear-gradient(135deg,#2E5BFF,#00C2FF)}
    .tst-author h4{margin:0;color:#fff;font-size:.95rem;font-weight:700}
    .tst-author p{margin:0;color:#64748b;font-size:.8rem}

    @media(max-width:900px){
        .hero-grid,.how,.about{grid-template-columns:1fr}
        .hero-visual{height:340px;order:-1}
        .showcase,.feat-grid,.tst-grid{grid-template-columns:1fr}
        .stat-grid{grid-template-columns:repeat(2,1fr)}
    }
</style>

<div class="lp">
<!-- ═══════════ HERO ═══════════ -->
<section class="lp-hero">
    <div class="mesh"></div>
    <div class="container mx-auto px-4">
        <div class="hero-grid">
            <div class="hero-text">
                <span class="hero-badge"><i class="bi bi-lightning-charge-fill"></i> La red #1 de DJs del Caquetá</span>
                <h1 class="hero-h1">Encuentra el DJ<br><span class="grad-b">perfecto</span> para tu evento.</h1>
                <p class="hero-p">Una plataforma moderna para descubrir, escuchar y reservar a los mejores DJs del Caquetá. Coordina todo por chat interno y asegura tu fecha en minutos.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="btn-glow"><i class="bi bi-search"></i> Explorar DJs</a>
                    <?php if(isset($_SESSION['usuario_id'])): ?>
                        <a href="<?php echo URL_ROOT; ?>/clientes/dashboard" class="btn-ghost"><i class="bi bi-grid-1x2"></i> Mi panel</a>
                    <?php else: ?>
                        <a href="<?php echo URL_ROOT; ?>/usuarios/registro" class="btn-ghost"><i class="bi bi-person-plus"></i> Crear cuenta gratis</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="hero-visual">
                <div class="float-pill fp-1"><i class="bi bi-people-fill"></i> +<?php echo $data['total_djs'] ?? '25'; ?> DJs activos</div>
                <div class="disc"></div>
                <div class="float-pill fp-2"><i class="bi bi-chat-dots-fill"></i> Reserva con chat</div>
                <div class="float-pill fp-3"><i class="bi bi-star-fill"></i> DJs verificados</div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════ CATEGORÍAS ═══════════ -->
<div class="cats">
    <div class="container mx-auto px-4">
        <div class="cats-grid">
            <?php
                $catIconos = ['bi-disc','bi-music-note-beamed','bi-heart-fill','bi-mortarboard-fill','bi-building','bi-stars'];
                $tipos = $data['tipos_evento'] ?? [];
                if(!empty($tipos)):
                    foreach(array_slice($tipos, 0, 6) as $i => $ev): ?>
                    <a href="<?php echo URL_ROOT; ?>/djs/explorar?evento=<?php echo urlencode($ev->nombre); ?>" class="cat-item">
                        <div class="cat-circle"><i class="bi <?php echo $catIconos[$i % count($catIconos)]; ?>"></i></div>
                        <span><?php echo $ev->nombre; ?></span>
                    </a>
                <?php endforeach; else: ?>
                    <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="cat-item"><div class="cat-circle"><i class="bi bi-disc"></i></div><span>Fiestas</span></a>
                    <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="cat-item"><div class="cat-circle"><i class="bi bi-heart-fill"></i></div><span>Bodas</span></a>
                    <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="cat-item"><div class="cat-circle"><i class="bi bi-music-note-beamed"></i></div><span>Clubs</span></a>
                    <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="cat-item"><div class="cat-circle"><i class="bi bi-mortarboard-fill"></i></div><span>Grados</span></a>
                    <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="cat-item"><div class="cat-circle"><i class="bi bi-building"></i></div><span>Corporativo</span></a>
                <?php endif; ?>
        </div>
    </div>
</div>

<!-- ═══════════ DJs DESTACADOS ═══════════ -->
<section class="lp-section">
    <div class="container mx-auto px-4">
        <div class="sec-head rv">
            <span class="kicker">Destacados</span>
            <h2 class="title">DJs top en <em>el Caquetá</em></h2>
            <p class="subtitle">Descubre el mejor talento local, escucha sus mezclas y reserva tu fecha.</p>
        </div>

        <?php if(empty($data['djs'])): ?>
            <div class="text-center py-12 border-2 border-dashed border-djpro-border rounded-3xl">
                <p class="text-djpro-muted uppercase font-bold tracking-widest">No hay DJs registrados todavía.</p>
            </div>
        <?php else: ?>
            <div class="showcase">
                <?php foreach(array_slice($data['djs'], 0, 6) as $dj): ?>
                <div class="sc-card rv">
                    <div class="sc-img">
                        <?php if($dj->foto_perfil != 'default_dj.png'): ?>
                            <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $dj->foto_perfil; ?>" alt="<?php echo $dj->nombre; ?>" loading="lazy">
                        <?php endif; ?>
                        <span class="sc-badge"><i class="bi bi-geo-alt-fill"></i> <?php echo $dj->ciudad ? $dj->ciudad : 'Caquetá'; ?></span>
                        <div class="sc-avatar">
                            <?php if($dj->foto_perfil != 'default_dj.png'): ?>
                                <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $dj->foto_perfil; ?>">
                            <?php else: ?>
                                <?php echo strtoupper(substr($dj->nombre,0,2)); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="sc-body">
                        <h3><?php echo $dj->nombre; ?></h3>
                        <div class="sc-meta">
                            <?php $gs = array_filter(array_map('trim', explode(',', (string)$dj->generos))); ?>
                            <span><i class="bi bi-music-note-list"></i> <?php echo !empty($gs) ? implode(' · ', array_slice($gs,0,3)) : 'Multigénero'; ?></span>
                            <span><i class="bi bi-broadcast"></i> Disponible para eventos</span>
                        </div>
                    </div>
                    <div class="sc-foot">
                        <span class="sc-rating"><i class="bi bi-star-fill"></i> <?php echo number_format($dj->calificacion_promedio, 1); ?></span>
                        <a href="<?php echo URL_ROOT; ?>/djs/perfil/<?php echo $dj->id; ?>" class="sc-link">Ver perfil <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-10">
                <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="btn-ghost"><i class="bi bi-grid-3x3-gap"></i> Ver todos los DJs</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ═══════════ CÓMO FUNCIONA ═══════════ -->
<section class="lp-section section-alt">
    <div class="container mx-auto px-4">
        <div class="how">
            <div class="how-visual rv">
                <div class="disc"></div>
                <div class="waves">
                    <?php for($i=0;$i<16;$i++): ?><i class="eqbar" style="height:<?php echo rand(20,90); ?>%;animation:eqb <?php echo (8+rand(0,8))/10; ?>s ease-in-out infinite;animation-delay:-<?php echo $i*0.1; ?>s"></i><?php endfor; ?>
                </div>
            </div>
            <div class="how-text-side rv">
                <span class="kicker">Así funciona</span>
                <h2 class="title" style="text-align:left">Reservar tu DJ es <em>así de simple</em></h2>
                <div class="how-steps">
                    <div class="how-step"><div class="how-num">1</div><div><strong>Regístrate gratis</strong><p>Crea tu cuenta en segundos y accede a todo el catálogo de DJs del Caquetá.</p></div></div>
                    <div class="how-step"><div class="how-num">2</div><div><strong>Explora y elige tu DJ</strong><p>Filtra por evento, género y ciudad. Escucha sus mezclas y mira sus calificaciones reales.</p></div></div>
                    <div class="how-step"><div class="how-num">3</div><div><strong>Envía tu solicitud</strong><p>Propón fecha, horario y presupuesto. Negocian por el chat interno hasta cerrar el trato.</p></div></div>
                    <div class="how-step"><div class="how-num">4</div><div><strong>Vive la fiesta</strong><p>El DJ confirma, llega y enciende tu evento. Al final lo calificas y ayudas a la comunidad.</p></div></div>
                </div>
                <div class="flex flex-wrap gap-3 mt-8">
                    <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="btn-glow"><i class="bi bi-search"></i> Empezar ahora</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════ POR QUÉ DJPRO ═══════════ -->
<section class="lp-section">
    <div class="container mx-auto px-4">
        <div class="sec-head rv">
            <span class="kicker">Ventajas</span>
            <h2 class="title">¿Por qué <em>DJPRO</em>?</h2>
            <p class="subtitle">La forma más profesional de contratar un DJ en la región.</p>
        </div>
        <div class="feat-grid">
            <div class="feat-card rv"><div class="feat-ic"><i class="bi bi-shield-check"></i></div><h3>DJs Verificados</h3><p>Perfiles con portafolio, géneros y calificaciones reales de otros clientes. Sabes exactamente a quién contratas.</p></div>
            <div class="feat-card rv"><div class="feat-ic"><i class="bi bi-chat-dots-fill"></i></div><h3>Chat Interno</h3><p>Coordina cada detalle del evento directamente con el DJ, negocia el precio y confirma sin salir de la plataforma.</p></div>
            <div class="feat-card rv"><div class="feat-ic"><i class="bi bi-calendar2-check-fill"></i></div><h3>Reservas Seguras</h3><p>Sistema de solicitudes con estados claros, contra-ofertas y confirmación de pago. Tu fecha queda asegurada.</p></div>
        </div>
    </div>
</section>

<!-- ═══════════ SOBRE LA PLATAFORMA ═══════════ -->
<section class="lp-section section-alt">
    <div class="container mx-auto px-4">
        <div class="about">
            <div class="about-text rv">
                <span class="kicker">Sobre DJPRO</span>
                <h2>La plataforma de <span class="grad-b">DJs</span> del Caquetá</h2>
                <p>Creemos en el poder de la música para transformar cualquier evento. DJPRO nació para conectar al mejor talento local con quienes quieren una fiesta inolvidable, con herramientas modernas para DJs y clientes por igual.</p>
                <p>Gestiona tus reservas, negocia por chat, recibe calificaciones y haz crecer tu marca como DJ — todo en un solo lugar.</p>
                <div class="stat-grid">
                    <div class="stat-card"><div class="n"><?php echo $data['total_djs'] ?? '25'; ?>+</div><div class="l">DJs registrados</div></div>
                    <div class="stat-card"><div class="n"><?php echo $data['total_eventos'] ?? '150'; ?>+</div><div class="l">Eventos realizados</div></div>
                    <div class="stat-card"><div class="n">12</div><div class="l">Ciudades cubiertas</div></div>
                    <div class="stat-card"><div class="n">100%</div><div class="l">Registro gratis</div></div>
                </div>
                <a href="<?php echo URL_ROOT; ?>/usuarios/registro" class="btn-glow"><i class="bi bi-rocket-takeoff"></i> Comenzar ahora</a>
            </div>
            <div class="about-visual rv">
                <div class="disc" style="width:200px;height:200px"></div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════ CTA BANNER ═══════════ -->
<section class="lp-section" style="padding-top:0">
    <div class="container mx-auto px-4">
        <div class="cta-band rv">
            <span class="kicker" style="color:#00C2FF">¿Tienes las manos en el mezclador?</span>
            <h2>Pon tu nombre en la <span class="grad-b">cabina</span></h2>
            <p class="subtitle" style="margin-bottom:2rem">Únete a la red de DJs más grande del Caquetá. Crea tu perfil, recibe reservas y cobra por hacer lo que amas.</p>
            <a href="<?php echo URL_ROOT; ?>/usuarios/registro" class="btn-glow" style="font-size:1.05rem;padding:1rem 2rem"><i class="bi bi-headphones"></i> Crear mi perfil de DJ</a>
        </div>
    </div>
</section>

<!-- ═══════════ TESTIMONIOS ═══════════ -->
<section class="lp-section section-alt">
    <div class="container mx-auto px-4">
        <div class="sec-head rv">
            <span class="kicker">Opiniones</span>
            <h2 class="title">Lo que dicen nuestros <em>clientes</em></h2>
            <p class="subtitle">Personas reales que vivieron su fiesta con un DJ de DJPRO.</p>
        </div>
        <div class="tst-grid">
            <article class="tst-card rv">
                <div class="tst-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                <blockquote>"Reservé al DJ para mi matrimonio en Florencia y fue increíble. El chat interno me dejó coordinar cada canción. Todo clarísimo desde el primer momento."</blockquote>
                <div class="tst-author"><div class="tst-avatar">LG</div><div><h4>Laura Gómez</h4><p>Matrimonio · Florencia</p></div></div>
            </article>
            <article class="tst-card rv">
                <div class="tst-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                <blockquote>"Como DJ, DJPRO me cambió el juego. Recibo solicitudes de toda la región y gestiono mis reservas sin enredos. Mi agenda no para."</blockquote>
                <div class="tst-author"><div class="tst-avatar">EM</div><div><h4>Edwar Mix</h4><p>DJ Profesional</p></div></div>
            </article>
            <article class="tst-card rv">
                <div class="tst-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                <blockquote>"Buscaba un DJ para los XV de mi hija y en minutos comparé varios, vi sus videos y reservé. La fiesta quedó espectacular. 10/10."</blockquote>
                <div class="tst-author"><div class="tst-avatar">CR</div><div><h4>Carlos Ríos</h4><p>XV Años · San Vicente</p></div></div>
            </article>
        </div>
    </div>
</section>
</div>

<script>
    // Scroll reveal
    (function(){
        var reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;
        var els = document.querySelectorAll('.rv');
        if (reduce || !('IntersectionObserver' in window)){ els.forEach(function(e){e.classList.add('vis')}); return; }
        var io = new IntersectionObserver(function(ent){
            ent.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('vis'); io.unobserve(e.target); } });
        }, { threshold:.12, rootMargin:'0px 0px -8% 0px' });
        els.forEach(function(e){ io.observe(e); });
    })();

    // Stats en vivo
    function updateStats(){
        fetch('<?php echo URL_ROOT; ?>/pages/api_stats').then(r=>r.json()).then(d=>{}).catch(()=>{});
    }
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

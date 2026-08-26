<?php
/**
 * Panel del DJ — Identidad "DJ Blue" (SaaS claro estilo NeivActiva, acento azul eléctrico).
 * Vista autónoma: no usa el header/footer oscuros globales para poder ir en tema claro
 * sin afectar el resto de la app. Toda la lógica y los datos reales se conservan.
 */
$h = (int)date('H');
$saludo = $h < 12 ? 'Buenos días' : ($h < 19 ? 'Buenas tardes' : 'Buenas noches');
$nombreCorto = explode(' ', $_SESSION['usuario_nombre'])[0];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DJPRO | Panel del DJ</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'djpro-bg': '#F4F7FE',
                        'djpro-surface': '#FFFFFF',
                        'djpro-surface-2': '#EEF2FB',
                        'djpro-accent': '#2E5BFF',      /* azul eléctrico */
                        'djpro-accent-2': '#00C2FF',    /* cian para gradientes */
                        'djpro-purple': '#7C4DFF',
                        'djpro-text': '#0F172A',
                        'djpro-muted': '#64748B',
                        'djpro-border': '#E4E9F4',
                        'djpro-success': '#10B981',
                        'djpro-danger': '#EF4444',
                    },
                    fontFamily: {
                        bebas: ['"Bebas Neue"', 'sans-serif'],
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body{
            background:
                radial-gradient(circle at 12% -10%, rgba(46,91,255,.06), transparent 40rem),
                radial-gradient(circle at 90% 0%, rgba(0,194,255,.05), transparent 36rem),
                #F4F7FE;
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            letter-spacing: -.011em;
        }
        ::-webkit-scrollbar{width:10px;height:10px}
        ::-webkit-scrollbar-track{background:#EEF2FB}
        ::-webkit-scrollbar-thumb{background:#c9d3ea;border-radius:10px}
        ::-webkit-scrollbar-thumb:hover{background:#aab8db}
        .scrollbar-thin{scrollbar-width:thin}

        /* Botón primario (azul → cian) */
        .btn-djpro-primary{
            background:linear-gradient(135deg,#2E5BFF,#00C2FF);color:#fff;font-weight:800;
            padding:.8rem 1.4rem;border-radius:.85rem;display:inline-flex;align-items:center;justify-content:center;gap:.5rem;
            transition:transform .2s, box-shadow .25s;box-shadow:0 10px 24px rgba(46,91,255,.30);border:none;cursor:pointer;letter-spacing:.02em;
        }
        .btn-djpro-primary:hover{transform:translateY(-2px);box-shadow:0 14px 30px rgba(46,91,255,.4)}

        .input-djpro{
            background:#fff;border:1px solid #E4E9F4;border-radius:.85rem;padding:.8rem 1rem;color:#0F172A;
            font-weight:600;width:100%;outline:none;transition:border-color .2s, box-shadow .2s;
        }
        .input-djpro:focus{border-color:#2E5BFF;box-shadow:0 0 0 4px rgba(46,91,255,.12)}

        .card-shadow{box-shadow:0 12px 22px -6px rgba(17,24,39,.08),0 4px 10px -2px rgba(17,24,39,.04)}
        .card-shadow-sm{box-shadow:0 2px 8px rgba(17,24,39,.05),0 1px 3px rgba(17,24,39,.03)}

        /* Disco giratorio del hero */
        @keyframes spin{to{transform:rotate(360deg)}}
        .vinyl{animation:spin 8s linear infinite}
        @keyframes eqbar{0%,100%{height:22%}50%{height:100%}}
        .eqbar{animation:eqbar 1s ease-in-out infinite}
        @media (prefers-reduced-motion: reduce){.vinyl,.eqbar{animation:none}}
    </style>
</head>
<body class="font-sans text-djpro-text">

<?php
// ── Flash messages (SweetAlert) ──
if(isset($_SESSION['flash_message'])):
    $flash_type = $_SESSION['flash_type'] ?? 'success';
    $flash_title = $flash_type === 'error' ? '¡Ups! Algo salió mal' : ($flash_type === 'warning' ? 'Aviso' : ($flash_type === 'info' ? 'Información' : '¡Listo!'));
?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            title: <?php echo json_encode($flash_title); ?>,
            text: <?php echo json_encode($_SESSION['flash_message']); ?>,
            icon: <?php echo json_encode($flash_type); ?>,
            confirmButtonColor: '#2E5BFF',
            background: '#ffffff',
            color: '#0F172A'
        });
    });
</script>
<?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); endif; ?>

<!-- ═══════════════ SIDEBAR (claro) ═══════════════ -->
<aside id="sidebar" class="fixed left-0 top-0 bottom-0 w-64 bg-djpro-surface border-r border-djpro-border z-40 flex flex-col p-4 overflow-y-auto scrollbar-thin transition-transform duration-300 -translate-x-full lg:translate-x-0">
    <!-- Logo -->
    <a href="<?php echo URL_ROOT; ?>" class="flex items-center gap-3 px-2 pb-5">
        <span class="w-10 h-10 rounded-xl grid place-items-center text-white" style="background:linear-gradient(135deg,#2E5BFF,#00C2FF);box-shadow:0 6px 16px rgba(46,91,255,.35)">
            <i class="bi bi-headphones text-xl"></i>
        </span>
        <span class="text-3xl font-bebas tracking-wide">DJ<span class="text-djpro-accent">PRO</span></span>
    </a>

    <!-- Perfil mini -->
    <div class="flex items-center gap-3 p-3 mb-3 bg-djpro-surface-2 border border-djpro-border rounded-2xl">
        <div class="relative">
            <?php if(isset($data['perfil']) && $data['perfil']->foto_perfil != 'default_dj.png'): ?>
                <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $data['perfil']->foto_perfil; ?>" class="w-11 h-11 rounded-full object-cover">
            <?php else: ?>
                <div class="w-11 h-11 rounded-full grid place-items-center text-white font-extrabold" style="background:linear-gradient(135deg,#2E5BFF,#00C2FF)"><?php echo strtoupper(substr($nombreCorto,0,1)); ?></div>
            <?php endif; ?>
            <span class="absolute bottom-0 right-0 w-3 h-3 bg-djpro-success border-2 border-white rounded-full"></span>
        </div>
        <div class="min-w-0">
            <h4 class="font-bold text-sm truncate"><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></h4>
            <p class="text-xs text-djpro-muted font-semibold">DJ Profesional</p>
        </div>
    </div>

    <!-- Navegación -->
    <nav class="flex flex-col gap-1 flex-1">
        <div class="text-[11px] font-bold uppercase tracking-widest text-djpro-muted px-3 pt-3 pb-2">Explorar</div>
        <a href="<?php echo URL_ROOT; ?>/djs/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm bg-djpro-accent/10 text-djpro-accent">
            <i class="bi bi-grid-1x2-fill text-lg"></i> Panel Control
        </a>
        <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text transition-all">
            <i class="bi bi-search text-lg"></i> Explorar DJs
        </a>

        <div class="text-[11px] font-bold uppercase tracking-widest text-djpro-muted px-3 pt-4 pb-2">Mi Actividad</div>
        <a href="<?php echo URL_ROOT; ?>/clientes/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text transition-all">
            <i class="bi bi-calendar2-check-fill text-lg"></i> Mis Reservas
        </a>
        <a href="<?php echo URL_ROOT; ?>/chat" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text transition-all">
            <i class="bi bi-chat-dots-fill text-lg"></i> Mensajería
        </a>
        <a href="<?php echo URL_ROOT; ?>/djs/estadisticas" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text transition-all">
            <i class="bi bi-graph-up-arrow text-lg"></i> Estadísticas
        </a>
        <a href="<?php echo URL_ROOT; ?>/djs/editar" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text transition-all">
            <i class="bi bi-person-fill-gear text-lg"></i> Editar Perfil
        </a>
    </nav>

    <div class="pt-3 mt-3 border-t border-djpro-border">
        <a href="<?php echo URL_ROOT; ?>/usuarios/logout" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm text-djpro-danger hover:bg-red-50 transition-all">
            <i class="bi bi-box-arrow-left text-lg"></i> Cerrar Sesión
        </a>
    </div>
</aside>

<!-- Botón menú móvil -->
<button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="lg:hidden fixed top-4 left-4 z-50 w-11 h-11 rounded-xl bg-white border border-djpro-border card-shadow-sm grid place-items-center text-djpro-text">
    <i class="bi bi-list text-2xl"></i>
</button>

<div id="panel-dashboard-container" class="lg:ml-64 p-4 md:p-8">
    <div class="max-w-[1300px] mx-auto">

        <!-- ═══════════ HERO ═══════════ -->
        <section class="bg-djpro-surface border border-djpro-border rounded-[1.75rem] card-shadow overflow-hidden mb-6">
            <div class="grid lg:grid-cols-[1.4fr_.9fr]">
                <div class="p-8 md:p-10">
                    <span class="inline-flex items-center gap-2 bg-djpro-accent/10 text-djpro-accent font-bold text-xs px-3.5 py-1.5 rounded-full">
                        <i class="bi bi-broadcast"></i> <?php echo $saludo; ?>
                    </span>
                    <h1 class="text-4xl md:text-5xl font-bebas tracking-wide mt-4 mb-1.5">Hola, <span class="text-djpro-accent"><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></span></h1>
                    <p class="text-djpro-muted font-medium max-w-md mb-6">Tu cabina está activa. Aquí tienes el resumen de tus solicitudes y tu actividad reciente en el Caquetá.</p>
                    <div class="flex flex-wrap gap-3">
                        <a href="#reservas" class="btn-djpro-primary"><i class="bi bi-calendar2-week"></i> Ver solicitudes</a>
                        <a href="<?php echo URL_ROOT; ?>/djs/editar" class="inline-flex items-center gap-2 bg-djpro-surface-2 text-djpro-text font-bold px-5 py-3 rounded-[.85rem] border border-djpro-border hover:bg-djpro-border/60 transition-all"><i class="bi bi-person-gear"></i> Editar perfil</a>
                    </div>
                </div>
                <div class="relative grid place-items-center overflow-hidden min-h-[200px]" style="background:radial-gradient(circle at 70% 20%,rgba(255,255,255,.25),transparent 55%),linear-gradient(140deg,#2E5BFF,#00C2FF 90%)">
                    <span class="absolute top-4 right-4 inline-flex items-center gap-1.5 bg-white/90 text-djpro-text font-bold text-xs px-3 py-1.5 rounded-full card-shadow-sm"><i class="bi bi-geo-alt-fill text-djpro-accent"></i> Caquetá</span>
                    <div class="vinyl w-36 h-36 rounded-full relative" style="background:repeating-radial-gradient(circle at center,#141414 0 3px,#262626 3px 6px);box-shadow:0 20px 50px rgba(0,0,0,.35)">
                        <span class="absolute inset-0 m-auto w-11 h-11 rounded-full border-4 border-white" style="background:linear-gradient(135deg,#2E5BFF,#00C2FF)"></span>
                    </div>
                    <div class="absolute left-0 right-0 bottom-0 flex items-end gap-1 h-14 px-5 opacity-90">
                        <?php for($b=0;$b<12;$b++): ?><i class="eqbar flex-1 bg-white/70 rounded-t" style="animation-delay:-<?php echo $b*0.12; ?>s"></i><?php endfor; ?>
                    </div>
                </div>
            </div>

            <!-- Stats row -->
            <div class="flex flex-wrap border-t border-djpro-border">
                <div class="flex-1 min-w-[160px] p-6 border-r border-djpro-border">
                    <span class="w-9 h-9 rounded-lg grid place-items-center text-djpro-accent bg-djpro-accent/10 mb-2"><i class="bi bi-lightning-charge-fill"></i></span>
                    <div class="text-3xl font-bebas leading-none"><?php echo $data['stats']['solicitudes'] ?? 0; ?></div>
                    <div class="text-sm text-djpro-muted font-semibold mt-1">Total solicitudes</div>
                </div>
                <div class="flex-1 min-w-[160px] p-6 border-r border-djpro-border">
                    <span class="w-9 h-9 rounded-lg grid place-items-center text-djpro-success bg-djpro-success/10 mb-2"><i class="bi bi-check2-circle"></i></span>
                    <div class="text-3xl font-bebas leading-none"><?php echo $data['stats']['aceptadas'] ?? 0; ?></div>
                    <div class="text-sm text-djpro-muted font-semibold mt-1">Aceptadas</div>
                </div>
                <div class="flex-1 min-w-[160px] p-6 border-r border-djpro-border">
                    <span class="w-9 h-9 rounded-lg grid place-items-center text-djpro-purple bg-djpro-purple/10 mb-2"><i class="bi bi-star-fill"></i></span>
                    <div class="text-3xl font-bebas leading-none"><?php echo number_format($data['perfil']->calificacion_promedio, 1); ?></div>
                    <div class="text-sm text-djpro-muted font-semibold mt-1">Rating promedio</div>
                </div>
                <div class="flex-1 min-w-[160px] p-6">
                    <span class="w-9 h-9 rounded-lg grid place-items-center text-djpro-accent-2 bg-djpro-accent-2/10 mb-2" style="color:#0091c9"><i class="bi bi-chat-quote-fill"></i></span>
                    <div class="text-3xl font-bebas leading-none"><?php echo $data['stats']['resenas'] ?? 0; ?></div>
                    <div class="text-sm text-djpro-muted font-semibold mt-1">Reseñas</div>
                </div>
            </div>
        </section>

        <!-- Alerta de Perfil Incompleto -->
        <?php
            $missing = [];
            if(empty($data['perfil']->biografia)) $missing[] = 'biografía';
            if($data['perfil']->foto_perfil == 'default_dj.png') $missing[] = 'foto';
            if(empty($data['videos'])) $missing[] = 'videos';
            if(empty($data['perfil']->precio_hora)) $missing[] = 'precio';
            if(empty($data['perfil']->ciudad)) $missing[] = 'ubicación';
            if(empty($data['perfil']->generos)) $missing[] = 'géneros';
            if(empty($data['perfil']->tipos_evento)) $missing[] = 'eventos';
            $perfilIncompleto = !empty($missing);
        ?>
        <?php if($perfilIncompleto): ?>
        <div class="mb-6 bg-amber-50 border border-amber-200 p-5 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-100 rounded-xl grid place-items-center text-amber-600 shrink-0">
                    <i class="bi bi-exclamation-triangle-fill text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-djpro-text">Tu perfil está incompleto</h4>
                    <p class="text-djpro-muted text-sm font-medium">Te falta: <span class="text-amber-700 font-bold"><?php echo implode(', ', $missing); ?></span>. Complétalo para destacar en la plataforma.</p>
                </div>
            </div>
            <a href="<?php echo URL_ROOT; ?>/djs/editar" class="btn-djpro-primary whitespace-nowrap">Completar ahora</a>
        </div>
        <?php endif; ?>

        <!-- Accesos rápidos / métricas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-djpro-surface border border-djpro-border rounded-2xl p-5 card-shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="w-11 h-11 rounded-xl grid place-items-center text-white" style="background:linear-gradient(135deg,#10B981,#34d399)"><i class="bi bi-cash-stack text-xl"></i></span>
                    <span class="text-[10px] font-bold text-djpro-success uppercase tracking-widest bg-djpro-success/10 px-2 py-1 rounded-lg">Ganancias</span>
                </div>
                <div class="text-2xl font-bebas tracking-wide">$<?php echo number_format($data['stats']['ganancias'] ?? 0, 0); ?></div>
                <p class="text-[11px] text-djpro-muted font-semibold uppercase mt-1">Total acumulado</p>
            </div>
            <div class="bg-djpro-surface border border-djpro-border rounded-2xl p-5 card-shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="w-11 h-11 rounded-xl grid place-items-center text-white" style="background:linear-gradient(135deg,#2E5BFF,#00C2FF)"><i class="bi bi-calendar-check text-xl"></i></span>
                    <span class="text-[10px] font-bold text-djpro-accent uppercase tracking-widest bg-djpro-accent/10 px-2 py-1 rounded-lg">Eventos</span>
                </div>
                <div class="text-2xl font-bebas tracking-wide"><?php echo $data['stats']['finalizados'] ?? 0; ?></div>
                <p class="text-[11px] text-djpro-muted font-semibold uppercase mt-1">Servicios finalizados</p>
            </div>
            <div class="bg-djpro-surface border border-djpro-border rounded-2xl p-5 card-shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="w-11 h-11 rounded-xl grid place-items-center text-white" style="background:linear-gradient(135deg,#7C4DFF,#a78bfa)"><i class="bi bi-lightning-charge text-xl"></i></span>
                    <span class="text-[10px] font-bold text-djpro-purple uppercase tracking-widest bg-djpro-purple/10 px-2 py-1 rounded-lg">Solicitudes</span>
                </div>
                <div class="text-2xl font-bebas tracking-wide"><?php echo $data['stats']['solicitudes'] ?? 0; ?></div>
                <p class="text-[11px] text-djpro-muted font-semibold uppercase mt-1">Propuestas totales</p>
            </div>
            <div class="bg-djpro-surface border border-djpro-border rounded-2xl p-5 card-shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="w-11 h-11 rounded-xl grid place-items-center text-white" style="background:linear-gradient(135deg,#F59E0B,#fbbf24)"><i class="bi bi-star-fill text-xl"></i></span>
                    <span class="text-[10px] font-bold text-amber-600 uppercase tracking-widest bg-amber-500/10 px-2 py-1 rounded-lg">Rating</span>
                </div>
                <div class="text-2xl font-bebas tracking-wide"><?php echo number_format($data['perfil']->calificacion_promedio, 1); ?></div>
                <p class="text-[11px] text-djpro-muted font-semibold uppercase mt-1"><?php echo $data['stats']['resenas'] ?? 0; ?> reseñas reales</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna Izquierda: Reservas -->
            <div id="reservas" class="lg:col-span-2 space-y-6">
                <div class="bg-djpro-surface rounded-[1.5rem] border border-djpro-border overflow-hidden card-shadow-sm">
                    <div class="p-6 border-b border-djpro-border flex justify-between items-center">
                        <h4 class="text-2xl font-bebas tracking-wide">Próximas Solicitudes</h4>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-djpro-surface-2">
                                    <th class="px-4 py-3 text-[10px] font-bold text-djpro-muted uppercase tracking-wider">Cliente</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-djpro-muted uppercase tracking-wider">Fecha</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-djpro-muted uppercase tracking-wider">Hora</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-djpro-muted uppercase tracking-wider">Horas</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-djpro-muted uppercase tracking-wider">Precio</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-djpro-muted uppercase tracking-wider">Estado</th>
                                    <th class="px-4 py-3 text-[10px] font-bold text-djpro-muted uppercase tracking-wider text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-djpro-border">
                                <?php if(empty($data['contrataciones'])): ?>
                                    <tr>
                                        <td colspan="7" class="px-8 py-12 text-center text-djpro-muted italic font-medium">No tienes solicitudes pendientes en este momento.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($data['contrataciones'] as $con): ?>
                                    <tr class="hover:bg-djpro-surface-2 transition-colors">
                                        <td class="px-4 py-4">
                                            <div class="flex items-center gap-2">
                                                <?php if(!empty($con->cliente_foto) && $con->cliente_foto != 'default_dj.png'): ?>
                                                    <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $con->cliente_foto; ?>" class="w-7 h-7 rounded-lg object-cover border border-djpro-border">
                                                <?php else: ?>
                                                    <div class="w-7 h-7 rounded-lg grid place-items-center text-white text-[11px] font-extrabold shrink-0" style="background:linear-gradient(135deg,#2E5BFF,#00C2FF)"><?php echo strtoupper(substr($con->cliente_nombre,0,1)); ?></div>
                                                <?php endif; ?>
                                                <span class="font-bold text-djpro-text text-sm whitespace-nowrap"><?php echo $con->cliente_nombre; ?></span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-xs font-bold text-djpro-text whitespace-nowrap">
                                            <?php echo date('d M, Y', strtotime($con->fecha_evento)); ?>
                                        </td>
                                        <td class="px-4 py-4">
                                            <?php if(!empty($con->hora_inicio)): ?>
                                            <span class="text-[10px] font-bold text-djpro-accent bg-djpro-accent/10 px-2 py-1 rounded-lg border border-djpro-accent/20 flex items-center gap-1 w-fit whitespace-nowrap">
                                                <i class="bi bi-clock-fill"></i>
                                                <?php echo date('h:i A', strtotime($con->hora_inicio)); ?>
                                            </span>
                                            <?php else: ?>
                                            <span class="text-[10px] text-djpro-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-4 text-xs font-bold text-djpro-text"><?php echo $con->horas; ?> h</td>
                                        <td class="px-4 py-4 text-sm font-bold text-djpro-accent">
                                            <div class="whitespace-nowrap">$<?php echo number_format($con->precio_total, 0); ?></div>

                                            <?php if($con->contra_oferta > 0): ?>
                                                <div class="text-[9px] <?php echo $con->quien_contraoferto == 'cliente' ? 'text-djpro-accent' : 'text-amber-600'; ?> uppercase flex items-center gap-1 font-bold mt-1 whitespace-nowrap">
                                                    <i class="bi <?php echo $con->quien_contraoferto == 'cliente' ? 'bi-lightning-fill' : 'bi-hourglass-split'; ?>"></i>
                                                    <?php echo $con->quien_contraoferto == 'cliente' ? 'Propuesta: ' : 'Oferta: '; ?>
                                                    $<?php echo number_format($con->contra_oferta, 0); ?>
                                                    <?php if($con->quien_contraoferto == 'dj'): ?>
                                                        <a href="<?php echo URL_ROOT; ?>/contrataciones/cancelar_contra_oferta/<?php echo $con->id; ?>" class="text-djpro-danger hover:text-red-600 transition-colors" title="Retirar">
                                                            <i class="bi bi-x-circle-fill"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            <?php elseif($con->precio_total > $con->presupuesto_estimado && $con->presupuesto_estimado > 0): ?>
                                                <div class="text-[9px] text-djpro-success uppercase flex items-center gap-1 font-bold mt-1 whitespace-nowrap" title="Incremento negociado">
                                                    <i class="bi bi-graph-up-arrow"></i>
                                                    + $<?php echo number_format($con->precio_total - $con->presupuesto_estimado, 0); ?> EXTRA
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-4">
                                            <?php
                                                $statusClass = 'bg-amber-100 text-amber-700 border-amber-200';
                                                if($con->estado == 'aceptada') $statusClass = 'bg-amber-100 text-amber-700 border-amber-200';
                                                if($con->estado == 'confirmada') $statusClass = 'bg-emerald-100 text-emerald-700 border-emerald-200';
                                                if($con->estado == 'confirmada_total') $statusClass = 'bg-emerald-100 text-emerald-700 border-emerald-200';
                                                if($con->estado == 'rechazada' || $con->estado == 'cancelada') $statusClass = 'bg-red-100 text-red-600 border-red-200';
                                                if($con->estado == 'terminada' || $con->estado == 'completada') $statusClass = 'bg-violet-100 text-violet-700 border-violet-200';
                                                $estadoTexto = str_replace('_', ' ', $con->estado);
                                            ?>
                                            <span class="<?php echo $statusClass; ?> px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider border"><?php echo $estadoTexto; ?></span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex justify-center gap-2">
                                                <?php if($con->estado == 'pendiente'): ?>
                                                    <?php if($con->contra_oferta > 0 && $con->quien_contraoferto == 'cliente'): ?>
                                                        <a href="<?php echo URL_ROOT; ?>/contrataciones/aceptar_contra_oferta_dj/<?php echo $con->id; ?>" class="ajax-action-btn w-8 h-8 rounded-lg bg-djpro-accent/15 text-djpro-accent hover:bg-djpro-accent hover:text-white transition-all flex items-center justify-center" title="Aceptar Propuesta del Cliente">
                                                            <i class="bi bi-check-all"></i>
                                                        </a>
                                                        <a href="<?php echo URL_ROOT; ?>/contrataciones/rechazar_contra_oferta_dj/<?php echo $con->id; ?>" class="ajax-action-btn w-8 h-8 rounded-lg bg-red-100 text-djpro-danger hover:bg-djpro-danger hover:text-white transition-all flex items-center justify-center" title="Rechazar Propuesta">
                                                            <i class="bi bi-x-lg"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/aceptada" class="ajax-action-btn w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 hover:bg-emerald-500 hover:text-white transition-all flex items-center justify-center" title="Aceptar">
                                                            <i class="bi bi-check-lg"></i>
                                                        </a>
                                                        <button onclick="openContraOfertaModal(<?php echo $con->id; ?>, <?php echo $con->precio_total; ?>)" class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-500 hover:text-white transition-all flex items-center justify-center" title="Contra-oferta">
                                                            <i class="bi bi-currency-dollar"></i>
                                                        </button>
                                                        <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/rechazada" class="ajax-action-btn w-8 h-8 rounded-lg bg-red-100 text-djpro-danger hover:bg-djpro-danger hover:text-white transition-all flex items-center justify-center" title="Rechazar">
                                                            <i class="bi bi-x-lg"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                <?php elseif($con->estado == 'aceptada'): ?>
                                                    <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/confirmada" class="ajax-action-btn w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 hover:bg-emerald-500 hover:text-white transition-all flex items-center justify-center" title="Confirmar Adelanto (50%)">
                                                        <i class="bi bi-cash-coin"></i>
                                                    </a>
                                                    <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/confirmada_total" class="ajax-action-btn w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 hover:bg-emerald-600 hover:text-white transition-all flex items-center justify-center" title="Confirmar Pago Total (100%)">
                                                        <i class="bi bi-cash-stack"></i>
                                                    </a>
                                                    <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/cancelada" class="ajax-action-btn w-8 h-8 rounded-lg bg-red-50 text-djpro-danger hover:bg-djpro-danger hover:text-white transition-all flex items-center justify-center" title="Cancelar Evento" data-confirm="¿Estás seguro de cancelar este evento? Se notificará al cliente.">
                                                        <i class="bi bi-x-circle"></i>
                                                    </a>
                                                <?php elseif($con->estado == 'confirmada' || $con->estado == 'confirmada_total'): ?>
                                                    <?php
                                                        $fechaEvento = new DateTime($con->fecha_evento);
                                                        $hoy = new DateTime();
                                                        $puedoFinalizar = true;
                                                    ?>
                                                    <?php if($puedoFinalizar): ?>
                                                        <a href="javascript:void(0)" onclick="terminarEventoConCarga('<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/terminada')" class="w-8 h-8 rounded-lg bg-violet-100 text-djpro-purple hover:bg-djpro-purple hover:text-white transition-all flex items-center justify-center" title="Marcar como Terminada">
                                                            <i class="bi bi-flag-fill"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <button class="w-8 h-8 rounded-lg bg-djpro-surface-2 text-djpro-muted opacity-50 cursor-not-allowed flex items-center justify-center" title="Podrás finalizar 24h después del evento">
                                                            <i class="bi bi-flag"></i>
                                                        </button>
                                                    <?php endif; ?>

                                                    <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/cancelada" class="ajax-action-btn w-8 h-8 rounded-lg bg-red-50 text-djpro-danger hover:bg-djpro-danger hover:text-white transition-all flex items-center justify-center" title="Cancelar Evento" data-confirm="¿Estás seguro de cancelar este evento? Se notificará al cliente.">
                                                        <i class="bi bi-x-circle"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-[9px] font-bold text-djpro-muted uppercase tracking-tighter">Cerrado</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
<?php if($con->estado == 'confirmada' || $con->estado == 'confirmada_total'): ?>
<tr>
    <td colspan="7" class="px-4 pb-5 pt-2 border-none">
        <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-2xl flex items-center gap-4">
            <i class="bi <?php echo $con->estado == 'confirmada_total' ? 'bi-patch-check-fill text-emerald-600' : 'bi-check-circle-fill text-emerald-500'; ?> text-[28px]"></i>
            <div class="flex flex-col gap-0.5">
                <span class="text-emerald-700 font-bold uppercase tracking-widest text-xs">
                    <?php echo $con->estado == 'confirmada_total' ? '¡Pago Total Confirmado por el DJ!' : '¡Pago Confirmado por el DJ!'; ?>
                </span>
                <span class="text-xs text-djpro-text/80 font-medium">
                    <?php echo $con->estado == 'confirmada_total'
                        ? 'El evento está totalmente pagado. No hay saldo pendiente para cobrar en el evento.'
                        : 'El resto del dinero se cancelará al momento de que el DJ llegue al evento.'; ?>
                </span>
            </div>
        </div>
    </td>
</tr>
<?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Galería -->
            <div class="space-y-6">
                <div class="bg-djpro-surface rounded-[1.5rem] border border-djpro-border p-6 card-shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-xl font-bebas tracking-wide">Mi Galería</h4>
                        <button class="bg-djpro-surface-2 hover:bg-djpro-accent hover:text-white text-djpro-text p-2 rounded-lg transition-all" onclick="openModal()">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <?php if(empty($data['videos'])): ?>
                            <div class="text-center py-8 border-2 border-dashed border-djpro-border rounded-2xl">
                                <i class="bi bi-play-circle text-3xl text-djpro-muted mb-2 block"></i>
                                <p class="text-[10px] text-djpro-muted font-bold uppercase tracking-widest">Sin videos aún</p>
                            </div>
                        <?php else: ?>
                            <?php foreach($data['videos'] as $video): ?>
                            <?php
                                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video->url_video, $match);
                                $youtube_id = $match[1] ?? '';
                            ?>
                            <div class="group relative rounded-xl overflow-hidden border border-djpro-border cursor-pointer" onclick="openVideoModal('<?php echo $youtube_id; ?>', '<?php echo htmlspecialchars($video->titulo, ENT_QUOTES); ?>')">
                                <img src="https://img.youtube.com/vi/<?php echo $youtube_id; ?>/mqdefault.jpg" class="w-full h-32 object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                    <div class="w-12 h-12 bg-djpro-accent/90 rounded-full flex items-center justify-center shadow-lg">
                                        <i class="bi bi-play-fill text-2xl text-white ml-1"></i>
                                    </div>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-white/90 p-2 backdrop-blur-md border-t border-djpro-border flex justify-between items-center">
                                    <span class="text-[10px] font-bold text-djpro-text truncate w-4/5 uppercase tracking-widest"><?php echo $video->titulo; ?></span>
                                    <form id="delete-video-form-<?php echo $video->id; ?>" action="<?php echo URL_ROOT; ?>/djs/eliminar_video/<?php echo $video->id; ?>" method="POST" class="inline" onclick="event.stopPropagation()">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <input type="hidden" name="from" value="panel">
                                        <button type="button" onclick="confirmDeleteForm('delete-video-form-<?php echo $video->id; ?>', '¿Quieres eliminar este video de tu portafolio?')" class="text-djpro-danger hover:text-red-600 transition-colors">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reproductor de Video -->
<div id="modalVideo" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden overflow-y-auto py-10">
    <div class="bg-djpro-surface w-full max-w-3xl rounded-3xl border border-djpro-border shadow-2xl overflow-hidden my-auto">
        <div class="p-4 border-b border-djpro-border flex justify-between items-center">
            <h5 id="modalVideoTitle" class="text-lg font-bebas tracking-wide uppercase"></h5>
            <button onclick="closeVideoModal()" class="text-djpro-muted hover:text-djpro-text transition-all text-xl"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="aspect-video bg-black">
            <iframe id="modalVideoFrame" src="" class="w-full h-full" frameborder="0" allowfullscreen allow="autoplay; encrypted-media"></iframe>
        </div>
    </div>
</div>

<!-- Modal Añadir Video -->
<div id="modalAgregarVideo" class="fixed inset-0 z-[100] flex items-start md:items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden overflow-y-auto py-10">
    <div class="bg-djpro-surface w-full max-w-md rounded-3xl border border-djpro-border shadow-2xl overflow-hidden my-auto">
        <div class="p-6 border-b border-djpro-border flex justify-between items-center">
            <h5 class="text-xl font-bebas tracking-wide uppercase">Añadir Video</h5>
            <button onclick="closeModal()" class="text-djpro-muted hover:text-djpro-text transition-all text-xl"><i class="bi bi-x-lg"></i></button>
        </div>
        <form action="<?php echo URL_ROOT; ?>/djs/agregar_video" method="POST" class="p-6 space-y-6 max-h-[75vh] overflow-y-auto scrollbar-thin">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Título del Video</label>
                <input type="text" name="titulo" placeholder="Ej: Festival Electrónica 2024" class="input-djpro" required maxlength="60">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">URL de YouTube</label>
                <input type="url" name="url_video" placeholder="https://www.youtube.com/watch?v=..." class="input-djpro" required>
                <p class="text-[9px] text-djpro-muted font-bold uppercase tracking-tighter">Copia el enlace completo del video.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <button type="button" onclick="closeModal()" class="w-full sm:flex-1 px-6 py-3 border border-djpro-border text-djpro-muted font-bold rounded-xl hover:text-djpro-text transition-all order-2 sm:order-1">CANCELAR</button>
                <button type="submit" class="w-full sm:flex-1 btn-djpro-primary order-1 sm:order-2">AGREGAR</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Contra-oferta -->
<div id="modalContraOferta" class="fixed inset-0 z-[100] flex items-start md:items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden overflow-y-auto py-10">
    <div class="bg-djpro-surface w-full max-w-md rounded-3xl border border-djpro-border shadow-2xl overflow-hidden my-auto">
        <div class="p-6 border-b border-djpro-border flex justify-between items-center">
            <h5 class="text-xl font-bebas tracking-wide uppercase">Enviar Contra-oferta</h5>
            <button onclick="closeContraOfertaModal()" class="text-djpro-muted hover:text-djpro-text transition-all text-xl"><i class="bi bi-x-lg"></i></button>
        </div>
        <form id="formContraOferta" action="<?php echo URL_ROOT; ?>/contrataciones/contra_oferta" method="POST" class="ajax-form p-6 space-y-6 max-h-[75vh] overflow-y-auto scrollbar-thin">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="contratacion_id" id="contra_contratacion_id">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Presupuesto del Cliente</label>
                <input type="text" id="cliente_budget" class="input-djpro opacity-60" readonly maxlength="30">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Tu Contra-oferta ($)</label>
                <input type="number" name="monto_contra_oferta" placeholder="Ej: 600000" class="input-djpro" required>
                <p class="text-[9px] text-djpro-muted font-bold uppercase tracking-tighter">Propón un nuevo precio total para este evento.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <button type="button" onclick="closeContraOfertaModal()" class="w-full sm:flex-1 px-6 py-3 border border-djpro-border text-djpro-muted font-bold rounded-xl hover:text-djpro-text transition-all order-2 sm:order-1">CANCELAR</button>
                <button type="submit" class="w-full sm:flex-1 btn-djpro-primary order-1 sm:order-2">ENVIAR</button>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo URL_ROOT; ?>/assets/js/main.js" defer></script>
<script>
    function openModal(){ document.getElementById('modalAgregarVideo').classList.remove('hidden'); }
    function closeModal(){ document.getElementById('modalAgregarVideo').classList.add('hidden'); }

    function openVideoModal(youtubeId, title){
        document.getElementById('modalVideoTitle').textContent = title;
        document.getElementById('modalVideoFrame').src = 'https://www.youtube.com/embed/' + youtubeId + '?autoplay=1';
        document.getElementById('modalVideo').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeVideoModal(){
        document.getElementById('modalVideo').classList.add('hidden');
        document.getElementById('modalVideoFrame').src = '';
        document.body.style.overflow = '';
    }
    document.getElementById('modalVideo').addEventListener('click', function(e){ if (e.target === this) closeVideoModal(); });

    function openContraOfertaModal(id, budget){
        document.getElementById('contra_contratacion_id').value = id;
        document.getElementById('cliente_budget').value = '$' + new Intl.NumberFormat().format(budget);
        document.getElementById('modalContraOferta').classList.remove('hidden');
    }
    function closeContraOfertaModal(){ document.getElementById('modalContraOferta').classList.add('hidden'); }

    function terminarEventoConCarga(url){
        Swal.fire({
            title: '¿Finalizar Evento?',
            text: 'Se marcará como terminado y se notificará al cliente para que te califique.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2E5BFF',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'SÍ, FINALIZAR',
            cancelButtonText: 'CANCELAR',
            background: '#ffffff',
            color: '#0F172A'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Procesando...', text: 'Notificando al cliente...',
                    allowOutsideClick: false, showConfirmButton: false,
                    background: '#ffffff', color: '#0F172A',
                    didOpen: () => {
                        Swal.showLoading();
                        const formData = new FormData();
                        formData.append('csrf_token', '<?php echo $data['csrf_token']; ?>');
                        fetch(url, { method: 'POST', body: formData })
                            .then(res => res.text())
                            .then(html => {
                                const doc = new DOMParser().parseFromString(html, 'text/html');
                                const nc = doc.getElementById('panel-dashboard-container');
                                if (nc) document.getElementById('panel-dashboard-container').innerHTML = nc.innerHTML;
                                Swal.close();
                            });
                    }
                });
            }
        });
    }

    // AJAX action buttons
    document.addEventListener('click', function(e){
        const btn = e.target.closest('.ajax-action-btn');
        if (btn) {
            e.preventDefault();
            const msg = btn.getAttribute('data-confirm');
            if (msg && !confirm(msg)) return;
            btn.innerHTML = '<i class="bi bi-hourglass-split animate-spin"></i>';
            btn.style.pointerEvents = 'none';
            const formData = new FormData();
            formData.append('csrf_token', '<?php echo $data['csrf_token']; ?>');
            fetch(btn.href, { method: 'POST', body: formData })
                .then(res => res.text())
                .then(html => {
                    const doc = new DOMParser().parseFromString(html, 'text/html');
                    const nc = doc.getElementById('panel-dashboard-container');
                    if (nc) document.getElementById('panel-dashboard-container').innerHTML = nc.innerHTML;
                });
        }
    });

    // AJAX form (contra-oferta)
    document.addEventListener('submit', function(e){
        if (e.target.classList.contains('ajax-form')) {
            e.preventDefault();
            const form = e.target;
            const btn = form.querySelector('button[type="submit"]');
            btn.innerHTML = 'ENVIANDO... <i class="bi bi-hourglass-split animate-spin"></i>';
            btn.disabled = true;
            fetch(form.action, { method: 'POST', body: new FormData(form) })
            .then(res => res.text())
            .then(html => {
                const doc = new DOMParser().parseFromString(html, 'text/html');
                const nc = doc.getElementById('panel-dashboard-container');
                if (nc) document.getElementById('panel-dashboard-container').innerHTML = nc.innerHTML;
                closeContraOfertaModal();
            });
        }
    });
</script>
</body>
</html>

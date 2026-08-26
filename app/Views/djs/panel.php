<?php
/**
 * Panel del DJ — "Command Center" (bento grid, tema oscuro azul · Unbounded/Sora).
 * Vista autónoma. Toda la lógica y los datos reales se conservan.
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
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;600;800;900&family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'djpro-bg': '#0a0a0f',
                        'djpro-surface': '#101018',
                        'djpro-surface-2': '#171724',
                        'djpro-accent': '#2E5BFF',
                        'djpro-accent-2': '#00C2FF',
                        'djpro-purple': '#7C4DFF',
                        'djpro-text': '#f4f5fb',
                        'djpro-muted': '#8b95b5',
                        'djpro-border': '#232338',
                        'djpro-success': '#10B981',
                        'djpro-danger': '#EF4444',
                    },
                    fontFamily: {
                        bebas: ['"Unbounded"', 'sans-serif'],
                        sans: ['"Sora"', 'system-ui', 'sans-serif'],
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
                radial-gradient(700px circle at 12% -5%, rgba(46,91,255,.14), transparent 55%),
                radial-gradient(600px circle at 92% 0%, rgba(0,194,255,.10), transparent 50%),
                #0a0a0f;
            font-family:'Sora',system-ui,sans-serif;
        }
        ::-webkit-scrollbar{width:9px;height:9px}
        ::-webkit-scrollbar-track{background:#0a0a0f}
        ::-webkit-scrollbar-thumb{background:#2b2b45;border-radius:10px}
        .scrollbar-thin{scrollbar-width:thin}
        .font-bebas{letter-spacing:-.02em}

        .btn-djpro-primary{
            background:linear-gradient(135deg,#2E5BFF,#00C2FF);color:#fff;font-weight:700;
            padding:.8rem 1.4rem;border-radius:.85rem;display:inline-flex;align-items:center;justify-content:center;gap:.5rem;
            transition:transform .2s, box-shadow .25s;box-shadow:0 10px 24px rgba(46,91,255,.32);border:none;cursor:pointer;
        }
        .btn-djpro-primary:hover{transform:translateY(-2px);filter:brightness(1.08)}
        .input-djpro{
            background:#171724;border:1px solid #262636;border-radius:.85rem;padding:.8rem 1rem;color:#f4f5fb;
            font-weight:500;width:100%;outline:none;transition:border-color .2s, box-shadow .2s;font-family:'Sora',sans-serif;
        }
        .input-djpro:focus{border-color:#2E5BFF;box-shadow:0 0 0 4px rgba(46,91,255,.14)}
        .bento{background:#101018;border:1px solid #232338;border-radius:1.5rem}

        @keyframes spin{to{transform:rotate(360deg)}}
        .vinyl{animation:spin 9s linear infinite}
        @keyframes eqbar{0%,100%{height:22%}50%{height:100%}}
        .eqbar{animation:eqbar 1s ease-in-out infinite}
        @media (prefers-reduced-motion: reduce){.vinyl,.eqbar{animation:none}}
    </style>
</head>
<body class="font-sans text-djpro-text">

<?php
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
            confirmButtonColor: '#2E5BFF', background: '#101018', color: '#f4f5fb'
        });
    });
</script>
<?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); endif; ?>

<!-- ═══════════════ SIDEBAR ═══════════════ -->
<aside id="sidebar" class="fixed left-0 top-0 bottom-0 w-64 bg-djpro-surface border-r border-djpro-border z-40 flex flex-col p-4 overflow-y-auto scrollbar-thin transition-transform duration-300 -translate-x-full lg:translate-x-0">
    <a href="<?php echo URL_ROOT; ?>" class="flex items-center gap-3 px-2 pb-5">
        <span class="w-10 h-10 rounded-xl grid place-items-center text-white" style="background:linear-gradient(135deg,#2E5BFF,#00C2FF);box-shadow:0 6px 16px rgba(46,91,255,.4)">
            <i class="bi bi-headphones text-xl"></i>
        </span>
        <span class="text-2xl font-bebas font-extrabold">DJ<span class="text-djpro-accent">PRO</span></span>
    </a>

    <div class="flex items-center gap-3 p-3 mb-3 bg-djpro-surface-2 border border-djpro-border rounded-2xl">
        <div class="relative">
            <?php if(isset($data['perfil']) && $data['perfil']->foto_perfil != 'default_dj.png'): ?>
                <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $data['perfil']->foto_perfil; ?>" class="w-11 h-11 rounded-full object-cover">
            <?php else: ?>
                <div class="w-11 h-11 rounded-full grid place-items-center text-white font-extrabold" style="background:linear-gradient(135deg,#2E5BFF,#00C2FF)"><?php echo strtoupper(substr($nombreCorto,0,1)); ?></div>
            <?php endif; ?>
            <span class="absolute bottom-0 right-0 w-3 h-3 bg-djpro-success border-2 border-djpro-surface rounded-full"></span>
        </div>
        <div class="min-w-0">
            <h4 class="font-bold text-sm truncate"><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></h4>
            <p class="text-xs text-djpro-muted font-semibold">DJ Profesional</p>
        </div>
    </div>

    <nav class="flex flex-col gap-1 flex-1">
        <div class="text-[11px] font-bold uppercase tracking-widest text-djpro-muted px-3 pt-3 pb-2">Explorar</div>
        <a href="<?php echo URL_ROOT; ?>/djs/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm bg-djpro-accent/15 text-djpro-accent"><i class="bi bi-grid-1x2-fill text-lg"></i> Panel Control</a>
        <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text transition-all"><i class="bi bi-search text-lg"></i> Explorar DJs</a>
        <div class="text-[11px] font-bold uppercase tracking-widest text-djpro-muted px-3 pt-4 pb-2">Mi Actividad</div>
        <a href="<?php echo URL_ROOT; ?>/clientes/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text transition-all"><i class="bi bi-calendar2-check-fill text-lg"></i> Mis Reservas</a>
        <a href="<?php echo URL_ROOT; ?>/chat" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text transition-all"><i class="bi bi-chat-dots-fill text-lg"></i> Mensajería</a>
        <a href="<?php echo URL_ROOT; ?>/djs/estadisticas" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text transition-all"><i class="bi bi-graph-up-arrow text-lg"></i> Estadísticas</a>
        <a href="<?php echo URL_ROOT; ?>/djs/editar" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text transition-all"><i class="bi bi-person-fill-gear text-lg"></i> Editar Perfil</a>
    </nav>

    <div class="pt-3 mt-3 border-t border-djpro-border">
        <a href="<?php echo URL_ROOT; ?>/usuarios/logout" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm text-djpro-danger hover:bg-red-500/10 transition-all"><i class="bi bi-box-arrow-left text-lg"></i> Cerrar Sesión</a>
    </div>
</aside>

<button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="lg:hidden fixed top-4 left-4 z-50 w-11 h-11 rounded-xl bg-djpro-surface border border-djpro-border grid place-items-center text-djpro-text"><i class="bi bi-list text-2xl"></i></button>

<div id="panel-dashboard-container" class="lg:ml-64 p-4 md:p-8">
    <div class="max-w-[1300px] mx-auto space-y-5">

        <!-- ═══ Row 1: Welcome + Earnings ═══ -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
            <!-- Welcome -->
            <div class="lg:col-span-8 bento overflow-hidden grid md:grid-cols-[1.35fr_.65fr]">
                <div class="p-7 md:p-9">
                    <span class="inline-flex items-center gap-2 bg-djpro-accent/10 text-djpro-accent font-bold text-xs px-3.5 py-1.5 rounded-full"><i class="bi bi-broadcast"></i> <?php echo $saludo; ?></span>
                    <h1 class="text-3xl md:text-[2.6rem] font-bebas font-extrabold mt-4 mb-2 leading-tight">Hola, <span class="text-djpro-accent"><?php echo htmlspecialchars($nombreCorto); ?></span></h1>
                    <p class="text-djpro-muted font-medium max-w-md mb-6 text-sm">Tu cabina está activa. Aquí el resumen de tus solicitudes y tu actividad reciente en el Caquetá.</p>
                    <div class="flex flex-wrap gap-3">
                        <a href="#reservas" class="btn-djpro-primary text-sm"><i class="bi bi-calendar2-week"></i> Ver solicitudes</a>
                        <a href="<?php echo URL_ROOT; ?>/djs/editar" class="inline-flex items-center gap-2 bg-djpro-surface-2 text-djpro-text font-bold px-5 py-3 rounded-[.85rem] border border-djpro-border hover:border-djpro-accent transition-all text-sm"><i class="bi bi-person-gear"></i> Editar perfil</a>
                    </div>
                </div>
                <div class="relative grid place-items-center overflow-hidden min-h-[200px]" style="background:radial-gradient(circle at 70% 20%,rgba(0,194,255,.35),transparent 55%),linear-gradient(140deg,#152046,#0a0a12)">
                    <span class="absolute top-4 right-4 inline-flex items-center gap-1.5 bg-djpro-bg/70 backdrop-blur border border-djpro-border text-djpro-text font-bold text-xs px-3 py-1.5 rounded-full"><i class="bi bi-geo-alt-fill text-djpro-accent-2"></i> Caquetá</span>
                    <div class="vinyl w-32 h-32 rounded-full relative" style="background:repeating-radial-gradient(circle at center,#0d0d14 0 3px,#20202c 3px 6px);box-shadow:0 20px 50px rgba(0,0,0,.6),0 0 0 8px #0b0b12">
                        <span class="absolute inset-0 m-auto w-10 h-10 rounded-full border-4 border-djpro-bg" style="background:linear-gradient(135deg,#2E5BFF,#00C2FF);box-shadow:0 0 18px rgba(46,91,255,.6)"></span>
                    </div>
                    <div class="absolute left-0 right-0 bottom-0 flex items-end gap-1 h-12 px-5 opacity-70">
                        <?php for($b=0;$b<12;$b++): ?><i class="eqbar flex-1 rounded-t" style="background:linear-gradient(to top,#2E5BFF,#00C2FF);animation-delay:-<?php echo $b*0.12; ?>s"></i><?php endfor; ?>
                    </div>
                </div>
            </div>

            <!-- Earnings -->
            <div class="lg:col-span-4 bento p-7 flex flex-col">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-widest text-djpro-success">Ganancias</span>
                    <span class="w-10 h-10 rounded-xl grid place-items-center text-white" style="background:linear-gradient(135deg,#10B981,#34d399)"><i class="bi bi-cash-stack"></i></span>
                </div>
                <div class="text-4xl font-bebas font-extrabold mt-3">$<?php echo number_format($data['stats']['ganancias'] ?? 0, 0); ?></div>
                <p class="text-djpro-muted text-xs font-semibold mt-1">Total acumulado · <?php echo $data['stats']['finalizados'] ?? 0; ?> eventos finalizados</p>
                <div class="mt-auto flex items-end gap-1.5 h-16 pt-5">
                    <?php $bh=[35,55,40,70,50,85,60,100,75]; foreach($bh as $bhh): ?>
                    <div class="flex-1 rounded-t" style="height:<?php echo $bhh; ?>%;background:linear-gradient(to top,rgba(46,91,255,.25),#00C2FF)"></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Perfil incompleto -->
        <?php
            $missing = [];
            if(empty($data['perfil']->biografia)) $missing[] = 'biografía';
            if($data['perfil']->foto_perfil == 'default_dj.png') $missing[] = 'foto';
            if(empty($data['videos'])) $missing[] = 'videos';
            if(empty($data['perfil']->precio_hora)) $missing[] = 'precio';
            if(empty($data['perfil']->ciudad)) $missing[] = 'ubicación';
            if(empty($data['perfil']->generos)) $missing[] = 'géneros';
            if(empty($data['perfil']->tipos_evento)) $missing[] = 'eventos';
        ?>
        <?php if(!empty($missing)): ?>
        <div class="bg-amber-500/10 border border-amber-500/25 p-5 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-500/15 rounded-xl grid place-items-center text-amber-400 shrink-0"><i class="bi bi-exclamation-triangle-fill text-2xl"></i></div>
                <div>
                    <h4 class="text-lg font-bold text-djpro-text">Tu perfil está incompleto</h4>
                    <p class="text-djpro-muted text-sm font-medium">Te falta: <span class="text-amber-400 font-bold"><?php echo implode(', ', $missing); ?></span>. Complétalo para destacar.</p>
                </div>
            </div>
            <a href="<?php echo URL_ROOT; ?>/djs/editar" class="btn-djpro-primary whitespace-nowrap text-sm">Completar ahora</a>
        </div>
        <?php endif; ?>

        <!-- ═══ KPIs bento ═══ -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bento p-6">
                <span class="w-11 h-11 rounded-xl grid place-items-center text-djpro-accent bg-djpro-accent/15 mb-4 inline-grid"><i class="bi bi-lightning-charge-fill text-lg"></i></span>
                <div class="text-4xl font-bebas font-extrabold leading-none"><?php echo $data['stats']['solicitudes'] ?? 0; ?></div>
                <div class="text-sm text-djpro-muted font-semibold mt-2">Total solicitudes</div>
            </div>
            <div class="bento p-6">
                <span class="w-11 h-11 rounded-xl grid place-items-center text-djpro-success bg-djpro-success/15 mb-4 inline-grid"><i class="bi bi-check2-circle text-lg"></i></span>
                <div class="text-4xl font-bebas font-extrabold leading-none"><?php echo $data['stats']['aceptadas'] ?? 0; ?></div>
                <div class="text-sm text-djpro-muted font-semibold mt-2">Aceptadas</div>
            </div>
            <div class="bento p-6">
                <span class="w-11 h-11 rounded-xl grid place-items-center text-djpro-purple bg-djpro-purple/15 mb-4 inline-grid"><i class="bi bi-star-fill text-lg"></i></span>
                <div class="text-4xl font-bebas font-extrabold leading-none"><?php echo number_format($data['perfil']->calificacion_promedio, 1); ?></div>
                <div class="text-sm text-djpro-muted font-semibold mt-2">Rating promedio</div>
            </div>
            <div class="bento p-6">
                <span class="w-11 h-11 rounded-xl grid place-items-center bg-djpro-accent-2/15 mb-4 inline-grid" style="color:#00C2FF"><i class="bi bi-chat-quote-fill text-lg"></i></span>
                <div class="text-4xl font-bebas font-extrabold leading-none"><?php echo $data['stats']['resenas'] ?? 0; ?></div>
                <div class="text-sm text-djpro-muted font-semibold mt-2">Reseñas</div>
            </div>
        </div>

        <!-- ═══ Tabla + Galería ═══ -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div id="reservas" class="lg:col-span-2">
                <div class="bento overflow-hidden">
                    <div class="p-6 border-b border-djpro-border flex justify-between items-center">
                        <h4 class="text-xl font-bebas font-extrabold">Próximas Solicitudes</h4>
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
                                    <tr><td colspan="7" class="px-8 py-12 text-center text-djpro-muted italic font-medium">No tienes solicitudes pendientes en este momento.</td></tr>
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
                                        <td class="px-4 py-4 text-xs font-bold text-djpro-text whitespace-nowrap"><?php echo date('d M, Y', strtotime($con->fecha_evento)); ?></td>
                                        <td class="px-4 py-4">
                                            <?php if(!empty($con->hora_inicio)): ?>
                                            <span class="text-[10px] font-bold text-djpro-accent bg-djpro-accent/15 px-2 py-1 rounded-lg border border-djpro-accent/25 flex items-center gap-1 w-fit whitespace-nowrap"><i class="bi bi-clock-fill"></i> <?php echo date('h:i A', strtotime($con->hora_inicio)); ?></span>
                                            <?php else: ?><span class="text-[10px] text-djpro-muted">—</span><?php endif; ?>
                                        </td>
                                        <td class="px-4 py-4 text-xs font-bold text-djpro-text"><?php echo $con->horas; ?> h</td>
                                        <td class="px-4 py-4 text-sm font-bold text-djpro-accent">
                                            <div class="whitespace-nowrap">$<?php echo number_format($con->precio_total, 0); ?></div>
                                            <?php if($con->contra_oferta > 0): ?>
                                                <div class="text-[9px] <?php echo $con->quien_contraoferto == 'cliente' ? 'text-djpro-accent' : 'text-amber-400'; ?> uppercase flex items-center gap-1 font-bold mt-1 whitespace-nowrap">
                                                    <i class="bi <?php echo $con->quien_contraoferto == 'cliente' ? 'bi-lightning-fill' : 'bi-hourglass-split'; ?>"></i>
                                                    <?php echo $con->quien_contraoferto == 'cliente' ? 'Propuesta: ' : 'Oferta: '; ?> $<?php echo number_format($con->contra_oferta, 0); ?>
                                                    <?php if($con->quien_contraoferto == 'dj'): ?>
                                                        <a href="<?php echo URL_ROOT; ?>/contrataciones/cancelar_contra_oferta/<?php echo $con->id; ?>" class="text-djpro-danger hover:text-red-400 transition-colors" title="Retirar"><i class="bi bi-x-circle-fill"></i></a>
                                                    <?php endif; ?>
                                                </div>
                                            <?php elseif($con->precio_total > $con->presupuesto_estimado && $con->presupuesto_estimado > 0): ?>
                                                <div class="text-[9px] text-djpro-success uppercase flex items-center gap-1 font-bold mt-1 whitespace-nowrap" title="Incremento negociado"><i class="bi bi-graph-up-arrow"></i> + $<?php echo number_format($con->precio_total - $con->presupuesto_estimado, 0); ?> EXTRA</div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-4">
                                            <?php
                                                $statusClass = 'bg-amber-500/15 text-amber-400 border-amber-500/25';
                                                if($con->estado == 'aceptada') $statusClass = 'bg-amber-500/15 text-amber-400 border-amber-500/25';
                                                if($con->estado == 'confirmada') $statusClass = 'bg-emerald-500/15 text-emerald-400 border-emerald-500/25';
                                                if($con->estado == 'confirmada_total') $statusClass = 'bg-emerald-500/15 text-emerald-400 border-emerald-500/25';
                                                if($con->estado == 'rechazada' || $con->estado == 'cancelada') $statusClass = 'bg-red-500/15 text-red-400 border-red-500/25';
                                                if($con->estado == 'terminada' || $con->estado == 'completada') $statusClass = 'bg-violet-500/15 text-violet-400 border-violet-500/25';
                                                $estadoTexto = str_replace('_', ' ', $con->estado);
                                            ?>
                                            <span class="<?php echo $statusClass; ?> px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider border"><?php echo $estadoTexto; ?></span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex justify-center gap-2">
                                                <?php if($con->estado == 'pendiente'): ?>
                                                    <?php if($con->contra_oferta > 0 && $con->quien_contraoferto == 'cliente'): ?>
                                                        <a href="<?php echo URL_ROOT; ?>/contrataciones/aceptar_contra_oferta_dj/<?php echo $con->id; ?>" class="ajax-action-btn w-8 h-8 rounded-lg bg-djpro-accent/15 text-djpro-accent hover:bg-djpro-accent hover:text-white transition-all flex items-center justify-center" title="Aceptar Propuesta del Cliente"><i class="bi bi-check-all"></i></a>
                                                        <a href="<?php echo URL_ROOT; ?>/contrataciones/rechazar_contra_oferta_dj/<?php echo $con->id; ?>" class="ajax-action-btn w-8 h-8 rounded-lg bg-red-500/15 text-djpro-danger hover:bg-djpro-danger hover:text-white transition-all flex items-center justify-center" title="Rechazar Propuesta"><i class="bi bi-x-lg"></i></a>
                                                    <?php else: ?>
                                                        <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/aceptada" class="ajax-action-btn w-8 h-8 rounded-lg bg-emerald-500/15 text-emerald-400 hover:bg-emerald-500 hover:text-white transition-all flex items-center justify-center" title="Aceptar"><i class="bi bi-check-lg"></i></a>
                                                        <button onclick="openContraOfertaModal(<?php echo $con->id; ?>, <?php echo $con->precio_total; ?>)" class="w-8 h-8 rounded-lg bg-amber-500/15 text-amber-400 hover:bg-amber-500 hover:text-white transition-all flex items-center justify-center" title="Contra-oferta"><i class="bi bi-currency-dollar"></i></button>
                                                        <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/rechazada" class="ajax-action-btn w-8 h-8 rounded-lg bg-red-500/15 text-djpro-danger hover:bg-djpro-danger hover:text-white transition-all flex items-center justify-center" title="Rechazar"><i class="bi bi-x-lg"></i></a>
                                                    <?php endif; ?>
                                                <?php elseif($con->estado == 'aceptada'): ?>
                                                    <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/confirmada" class="ajax-action-btn w-8 h-8 rounded-lg bg-emerald-500/15 text-emerald-400 hover:bg-emerald-500 hover:text-white transition-all flex items-center justify-center" title="Confirmar Adelanto (50%)"><i class="bi bi-cash-coin"></i></a>
                                                    <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/confirmada_total" class="ajax-action-btn w-8 h-8 rounded-lg bg-emerald-500/15 text-emerald-300 hover:bg-emerald-600 hover:text-white transition-all flex items-center justify-center" title="Confirmar Pago Total (100%)"><i class="bi bi-cash-stack"></i></a>
                                                    <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/cancelada" class="ajax-action-btn w-8 h-8 rounded-lg bg-red-500/10 text-djpro-danger hover:bg-djpro-danger hover:text-white transition-all flex items-center justify-center" title="Cancelar Evento" data-confirm="¿Estás seguro de cancelar este evento? Se notificará al cliente."><i class="bi bi-x-circle"></i></a>
                                                <?php elseif($con->estado == 'confirmada' || $con->estado == 'confirmada_total'): ?>
                                                    <a href="javascript:void(0)" onclick="terminarEventoConCarga('<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/terminada')" class="w-8 h-8 rounded-lg bg-violet-500/15 text-djpro-purple hover:bg-djpro-purple hover:text-white transition-all flex items-center justify-center" title="Marcar como Terminada"><i class="bi bi-flag-fill"></i></a>
                                                    <a href="<?php echo URL_ROOT; ?>/contrataciones/responder/<?php echo $con->id; ?>/cancelada" class="ajax-action-btn w-8 h-8 rounded-lg bg-red-500/10 text-djpro-danger hover:bg-djpro-danger hover:text-white transition-all flex items-center justify-center" title="Cancelar Evento" data-confirm="¿Estás seguro de cancelar este evento? Se notificará al cliente."><i class="bi bi-x-circle"></i></a>
                                                <?php else: ?>
                                                    <span class="text-[9px] font-bold text-djpro-muted uppercase tracking-tighter">Cerrado</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
<?php if($con->estado == 'confirmada' || $con->estado == 'confirmada_total'): ?>
<tr>
    <td colspan="7" class="px-4 pb-5 pt-2 border-none">
        <div class="bg-emerald-500/10 border border-emerald-500/25 p-4 rounded-2xl flex items-center gap-4">
            <i class="bi <?php echo $con->estado == 'confirmada_total' ? 'bi-patch-check-fill text-emerald-400' : 'bi-check-circle-fill text-emerald-400'; ?> text-[28px]"></i>
            <div class="flex flex-col gap-0.5">
                <span class="text-emerald-400 font-bold uppercase tracking-widest text-xs"><?php echo $con->estado == 'confirmada_total' ? '¡Pago Total Confirmado por el DJ!' : '¡Pago Confirmado por el DJ!'; ?></span>
                <span class="text-xs text-djpro-text/80 font-medium"><?php echo $con->estado == 'confirmada_total' ? 'El evento está totalmente pagado. No hay saldo pendiente para cobrar en el evento.' : 'El resto del dinero se cancelará al momento de que el DJ llegue al evento.'; ?></span>
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

            <!-- Galería -->
            <div>
                <div class="bento p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-xl font-bebas font-extrabold">Mi Galería</h4>
                        <button class="bg-djpro-surface-2 hover:bg-djpro-accent hover:text-white text-djpro-text p-2 rounded-lg transition-all border border-djpro-border" onclick="openModal()"><i class="bi bi-plus-lg"></i></button>
                    </div>
                    <div class="space-y-4">
                        <?php if(empty($data['videos'])): ?>
                            <div class="text-center py-8 border-2 border-dashed border-djpro-border rounded-2xl">
                                <i class="bi bi-play-circle text-3xl text-djpro-muted mb-2 block"></i>
                                <p class="text-[10px] text-djpro-muted font-bold uppercase tracking-widest">Sin videos aún</p>
                            </div>
                        <?php else: ?>
                            <?php foreach($data['videos'] as $video):
                                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video->url_video, $match);
                                $youtube_id = $match[1] ?? '';
                            ?>
                            <div class="group relative rounded-xl overflow-hidden border border-djpro-border cursor-pointer" onclick="openVideoModal('<?php echo $youtube_id; ?>', '<?php echo htmlspecialchars($video->titulo, ENT_QUOTES); ?>')">
                                <img src="https://img.youtube.com/vi/<?php echo $youtube_id; ?>/mqdefault.jpg" class="w-full h-32 object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                    <div class="w-12 h-12 bg-djpro-accent/90 rounded-full flex items-center justify-center shadow-lg"><i class="bi bi-play-fill text-2xl text-white ml-1"></i></div>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-djpro-surface/90 p-2 backdrop-blur-md border-t border-djpro-border flex justify-between items-center">
                                    <span class="text-[10px] font-bold text-djpro-text truncate w-4/5 uppercase tracking-widest"><?php echo $video->titulo; ?></span>
                                    <form id="delete-video-form-<?php echo $video->id; ?>" action="<?php echo URL_ROOT; ?>/djs/eliminar_video/<?php echo $video->id; ?>" method="POST" class="inline" onclick="event.stopPropagation()">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <input type="hidden" name="from" value="panel">
                                        <button type="button" onclick="confirmDeleteForm('delete-video-form-<?php echo $video->id; ?>', '¿Quieres eliminar este video de tu portafolio?')" class="text-djpro-danger hover:text-red-400 transition-colors"><i class="bi bi-trash"></i></button>
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
<div id="modalVideo" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm hidden overflow-y-auto py-10">
    <div class="bg-djpro-surface w-full max-w-3xl rounded-3xl border border-djpro-border shadow-2xl overflow-hidden my-auto">
        <div class="p-4 border-b border-djpro-border flex justify-between items-center">
            <h5 id="modalVideoTitle" class="text-lg font-bebas font-extrabold uppercase"></h5>
            <button onclick="closeVideoModal()" class="text-djpro-muted hover:text-djpro-text transition-all text-xl"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="aspect-video bg-black"><iframe id="modalVideoFrame" src="" class="w-full h-full" frameborder="0" allowfullscreen allow="autoplay; encrypted-media"></iframe></div>
    </div>
</div>

<!-- Modal Añadir Video -->
<div id="modalAgregarVideo" class="fixed inset-0 z-[100] flex items-start md:items-center justify-center p-4 bg-black/70 backdrop-blur-sm hidden overflow-y-auto py-10">
    <div class="bg-djpro-surface w-full max-w-md rounded-3xl border border-djpro-border shadow-2xl overflow-hidden my-auto">
        <div class="p-6 border-b border-djpro-border flex justify-between items-center">
            <h5 class="text-xl font-bebas font-extrabold uppercase">Añadir Video</h5>
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
<div id="modalContraOferta" class="fixed inset-0 z-[100] flex items-start md:items-center justify-center p-4 bg-black/70 backdrop-blur-sm hidden overflow-y-auto py-10">
    <div class="bg-djpro-surface w-full max-w-md rounded-3xl border border-djpro-border shadow-2xl overflow-hidden my-auto">
        <div class="p-6 border-b border-djpro-border flex justify-between items-center">
            <h5 class="text-xl font-bebas font-extrabold uppercase">Enviar Contra-oferta</h5>
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
            title: '¿Finalizar Evento?', text: 'Se marcará como terminado y se notificará al cliente para que te califique.',
            icon: 'question', showCancelButton: true, confirmButtonColor: '#2E5BFF', cancelButtonColor: '#334155',
            confirmButtonText: 'SÍ, FINALIZAR', cancelButtonText: 'CANCELAR', background: '#101018', color: '#f4f5fb'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Procesando...', text: 'Notificando al cliente...', allowOutsideClick: false, showConfirmButton: false,
                    background: '#101018', color: '#f4f5fb',
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

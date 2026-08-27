<?php
/**
 * Shell oscuro reutilizable para las vistas del DJ (mismo look que el Panel de Control).
 * Uso:
 *   require dj_shell_top.php;  ... contenido ...  require dj_shell_bottom.php;
 * Provee: <head> oscuro (Unbounded/Sora), sidebar del DJ, flash messages y abre el <main>.
 */
$__cur = $_GET['url'] ?? '';
$__nombreCorto = explode(' ', $_SESSION['usuario_nombre'] ?? 'DJ')[0];
$__rol = $_SESSION['usuario_rol'] ?? 'cliente';
$__rolLabel = $__rol === 'dj' ? 'DJ Profesional' : ($__rol === 'admin' ? 'Administrador' : 'Cliente');
$__act = function($needle) use ($__cur){
    return strpos($__cur, $needle) !== false
        ? 'bg-djpro-accent/15 text-djpro-accent'
        : 'text-djpro-muted hover:bg-djpro-surface-2 hover:text-djpro-text transition-all';
};
// Menú por rol: cada item = [url, icono, etiqueta, needle-activo]
if ($__rol === 'dj') {
    $__sections = [
        'Explorar' => [
            ['djs/dashboard', 'bi-grid-1x2-fill', 'Panel Control', 'djs/dashboard'],
            ['djs/explorar', 'bi-search', 'Explorar DJs', 'djs/explorar'],
        ],
        'Mi Actividad' => [
            ['clientes/dashboard', 'bi-calendar2-check-fill', 'Mis Reservas', 'clientes/dashboard'],
            ['chat', 'bi-chat-dots-fill', 'Mensajería', 'chat'],
            ['djs/estadisticas', 'bi-graph-up-arrow', 'Estadísticas', 'djs/estadisticas'],
            ['djs/editar', 'bi-person-fill-gear', 'Editar Perfil', 'djs/editar'],
        ],
    ];
} elseif ($__rol === 'admin') {
    $__sections = [
        'Administración' => [
            ['admin/dashboard', 'bi-speedometer2', 'Global KPI', 'admin/dashboard'],
            ['admin/usuarios', 'bi-people', 'Usuarios', 'admin/usuarios'],
            ['admin/reservas', 'bi-calendar-check', 'Reservas', 'admin/reservas'],
            ['admin/resenas', 'bi-star', 'Moderar Reseñas', 'admin/resenas'],
            ['admin/seguridad', 'bi-shield-lock', 'Seguridad', 'admin/seguridad'],
        ],
    ];
} else {
    $__sections = [
        'Menú' => [
            ['clientes/dashboard', 'bi-speedometer2', 'Mi Panel', 'clientes/dashboard'],
            ['djs/explorar', 'bi-search', 'Explorar DJs', 'djs/explorar'],
            ['chat', 'bi-chat-dots-fill', 'Mensajes', 'chat'],
        ],
    ];
}
$__pageTitle = $__pageTitle ?? 'DJPRO | Panel';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($__pageTitle); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;600;800;900&family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                colors: {
                    'djpro-bg': '#0a0a0f', 'djpro-surface': '#101018', 'djpro-surface-2': '#171724',
                    'djpro-accent': '#2E5BFF', 'djpro-accent-2': '#00C2FF', 'djpro-purple': '#7C4DFF',
                    'djpro-text': '#f4f5fb', 'djpro-muted': '#8b95b5', 'djpro-border': '#232338',
                    'djpro-success': '#10B981', 'djpro-danger': '#EF4444',
                },
                fontFamily: { bebas: ['"Unbounded"', 'sans-serif'], sans: ['"Sora"', 'system-ui', 'sans-serif'] }
            } }
        }
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body{ background:
            radial-gradient(700px circle at 12% -5%, rgba(46,91,255,.14), transparent 55%),
            radial-gradient(600px circle at 92% 0%, rgba(0,194,255,.10), transparent 50%),
            #0a0a0f; font-family:'Sora',system-ui,sans-serif; }
        ::-webkit-scrollbar{width:9px;height:9px}
        ::-webkit-scrollbar-track{background:#0a0a0f}
        ::-webkit-scrollbar-thumb{background:#2b2b45;border-radius:10px}
        .scrollbar-thin{scrollbar-width:thin}
        .font-bebas{letter-spacing:-.02em}
        .btn-djpro-primary{background:linear-gradient(135deg,#2E5BFF,#00C2FF);color:#fff;font-weight:700;padding:.8rem 1.4rem;border-radius:.85rem;display:inline-flex;align-items:center;justify-content:center;gap:.5rem;transition:transform .2s, filter .2s;box-shadow:0 10px 24px rgba(46,91,255,.32);border:none;cursor:pointer}
        .btn-djpro-primary:hover{transform:translateY(-2px);filter:brightness(1.08)}
        .input-djpro{background:#171724;border:1px solid #262636;border-radius:.85rem;padding:.8rem 1rem;color:#f4f5fb;font-weight:500;width:100%;outline:none;transition:border-color .2s, box-shadow .2s;font-family:'Sora',sans-serif}
        .input-djpro:focus{border-color:#2E5BFF;box-shadow:0 0 0 4px rgba(46,91,255,.14)}
        .bento{background:#101018;border:1px solid #232338;border-radius:1.5rem}
        @keyframes spin{to{transform:rotate(360deg)}}
        .vinyl{animation:spin 9s linear infinite}
        @keyframes eqbar{0%,100%{height:22%}50%{height:100%}}
        .eqbar{animation:eqbar 1s ease-in-out infinite}
        .reveal{opacity:1!important;transform:none!important}
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
        Swal.fire({ title: <?php echo json_encode($flash_title); ?>, text: <?php echo json_encode($_SESSION['flash_message']); ?>, icon: <?php echo json_encode($flash_type); ?>, confirmButtonColor: '#2E5BFF', background: '#101018', color: '#f4f5fb' });
    });
</script>
<?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); endif; ?>

<aside id="sidebar" class="fixed left-0 top-0 bottom-0 w-64 bg-djpro-surface border-r border-djpro-border z-40 flex flex-col p-4 overflow-y-auto scrollbar-thin transition-transform duration-300 -translate-x-full lg:translate-x-0">
    <a href="<?php echo URL_ROOT; ?>" class="flex items-center gap-3 px-2 pb-5">
        <span class="w-10 h-10 rounded-xl grid place-items-center text-white" style="background:linear-gradient(135deg,#2E5BFF,#00C2FF);box-shadow:0 6px 16px rgba(46,91,255,.4)"><i class="bi bi-headphones text-xl"></i></span>
        <span class="text-2xl font-bebas font-extrabold">DJ<span class="text-djpro-accent">PRO</span></span>
    </a>

    <div class="flex items-center gap-3 p-3 mb-3 bg-djpro-surface-2 border border-djpro-border rounded-2xl">
        <div class="relative">
            <?php if(isset($data['perfil']) && $data['perfil']->foto_perfil != 'default_dj.png'): ?>
                <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $data['perfil']->foto_perfil; ?>" class="w-11 h-11 rounded-full object-cover">
            <?php else: ?>
                <div class="w-11 h-11 rounded-full grid place-items-center text-white font-extrabold" style="background:linear-gradient(135deg,#2E5BFF,#00C2FF)"><?php echo strtoupper(substr($__nombreCorto,0,1)); ?></div>
            <?php endif; ?>
            <span class="absolute bottom-0 right-0 w-3 h-3 bg-djpro-success border-2 border-djpro-surface rounded-full"></span>
        </div>
        <div class="min-w-0">
            <h4 class="font-bold text-sm truncate"><?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'DJ'); ?></h4>
            <p class="text-xs text-djpro-muted font-semibold"><?php echo $__rolLabel; ?></p>
        </div>
    </div>

    <nav class="flex flex-col gap-1 flex-1">
        <?php foreach($__sections as $__secTitle => $__items): ?>
            <div class="text-[11px] font-bold uppercase tracking-widest text-djpro-muted px-3 pt-3 pb-2"><?php echo $__secTitle; ?></div>
            <?php foreach($__items as $__it): ?>
                <a href="<?php echo URL_ROOT; ?>/<?php echo $__it[0]; ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm <?php echo $__act($__it[3]); ?>"><i class="bi <?php echo $__it[1]; ?> text-lg"></i> <?php echo $__it[2]; ?></a>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </nav>

    <div class="pt-3 mt-3 border-t border-djpro-border">
        <a href="<?php echo URL_ROOT; ?>/usuarios/logout" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm text-djpro-danger hover:bg-red-500/10 transition-all"><i class="bi bi-box-arrow-left text-lg"></i> Cerrar Sesión</a>
    </div>
</aside>

<button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="lg:hidden fixed top-4 left-4 z-50 w-11 h-11 rounded-xl bg-djpro-surface border border-djpro-border grid place-items-center text-djpro-text"><i class="bi bi-list text-2xl"></i></button>

<?php if(empty($__bare)): ?>
<main class="lg:ml-64 p-4 md:p-8">
    <div class="max-w-[1300px] mx-auto">
<?php endif; ?>

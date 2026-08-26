<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DJPRO | Encuentra tu DJ en el Caquetá</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;600;800;900&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'djpro-bg': '#0a0a0f',
                        'djpro-surface': '#12121a',
                        'djpro-surface-2': '#1c1c2e',
                        'djpro-accent': '#2E5BFF',
                        'djpro-accent-2': '#00C2FF',
                        'djpro-purple': '#7c3aed',
                        'djpro-text': '#f1f5f9',
                        'djpro-muted': '#64748b',
                        'djpro-border': '#1e293b',
                    }
                }
            }
        }
    </script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/assets/css/style.css">
    
    <!-- Global JS -->
    <script src="<?php echo URL_ROOT; ?>/assets/js/main.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        @layer utilities {
            .text-glow-orange {
                text-shadow: 0 0 14px rgba(46, 91, 255, 0.55);
            }
        }

        /* ── Header / Nav mejorado ── */
        .dj-logo{font-family:'Unbounded',sans-serif;font-weight:800;letter-spacing:-.02em;color:#fff;line-height:1}
        .grad-txt{background:linear-gradient(105deg,#2E5BFF,#00C2FF);-webkit-background-clip:text;background-clip:text;color:transparent}
        .dj-navlink{font-family:'Sora',sans-serif;font-weight:600;color:#cbd5e1;position:relative;transition:color .2s}
        .dj-navlink:hover{color:#fff}
        .dj-navlink::after{content:"";position:absolute;left:0;bottom:-7px;height:2px;width:0;background:linear-gradient(90deg,#2E5BFF,#00C2FF);border-radius:2px;transition:width .28s cubic-bezier(.16,1,.3,1)}
        .dj-navlink:hover::after{width:100%}
        header.dj-header{transition:background .3s, box-shadow .3s, border-color .3s}
        header.dj-header.scrolled{background:rgba(10,10,15,.92)!important;box-shadow:0 8px 30px rgba(0,0,0,.35)}
        .dj-btn-reg{background:linear-gradient(135deg,#2E5BFF,#00C2FF);transition:transform .2s, filter .2s, box-shadow .25s}
        .dj-btn-reg:hover{filter:brightness(1.08);transform:translateY(-2px);box-shadow:0 12px 28px rgba(46,91,255,.4)}

        /* Scroll Reveal Animation */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .reveal-active {
            opacity: 1;
            transform: translateY(0);
        }

        .toast-item {
            pointer-events: auto;
            min-width: 300px;
        }

        /* Scrollbar Personalizado */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #12121a;
        }
        ::-webkit-scrollbar-thumb {
            background: #2E5BFF;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #00C2FF;
        }

        /* Firefox */
        * {
            scrollbar-width: thin;
            scrollbar-color: #2E5BFF #12121a;
        }
    </style>
</head>
<body class="bg-djpro-bg text-djpro-text font-['Rajdhani']">
    
    <!-- Header Fijo -->
    <header id="dj-header" class="dj-header fixed top-0 left-0 right-0 z-50 bg-djpro-bg/80 backdrop-blur-lg border-b border-djpro-border">
        <div class="container mx-auto px-4 h-20 flex items-center justify-between">
            <!-- Logo -->
            <a href="<?php echo URL_ROOT; ?>" class="flex items-center gap-2.5 group">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center shadow-[0_0_18px_rgba(46,91,255,0.5)] group-hover:scale-110 group-hover:rotate-3 transition-all duration-300" style="background:linear-gradient(135deg,#2E5BFF,#00C2FF)">
                    <i class="bi bi-headphones text-white text-2xl"></i>
                </div>
                <span class="dj-logo text-2xl">DJ<span class="grad-txt">PRO</span></span>
            </a>

            <!-- Nav Desktop -->
            <nav class="hidden lg:flex items-center gap-7">
                <a href="<?php echo URL_ROOT; ?>" class="dj-navlink">Inicio</a>
                <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="dj-navlink">Explorar DJs</a>

                <div class="h-6 w-[1px] bg-djpro-border mx-1"></div>

                <?php if(isset($_SESSION['usuario_id'])): ?>
                    <div class="flex items-center gap-4">
                        <a href="<?php echo URL_ROOT; ?>/chat" class="relative text-xl hover:text-djpro-accent transition-colors">
                            <i class="bi bi-chat-dots"></i>
                            <span id="msg-badge" class="absolute -top-1 -right-1 w-2 h-2 bg-djpro-accent rounded-full hidden"></span>
                        </a>
                        <a href="<?php echo URL_ROOT; ?>/<?php echo $_SESSION['usuario_rol'] == 'dj' ? 'djs/dashboard' : ($_SESSION['usuario_rol'] == 'admin' ? 'admin/dashboard' : 'clientes/dashboard'); ?>" 
                           class="flex items-center gap-2 bg-djpro-surface-2 border border-djpro-border px-4 py-2 rounded-xl hover:border-djpro-accent transition-all">
                            <span class="text-sm font-semibold"><?php echo $_SESSION['usuario_nombre']; ?></span>
                            <?php if($_SESSION['usuario_rol'] == 'dj' && isset($data['perfil']) && !empty($data['perfil']->foto_perfil) && $data['perfil']->foto_perfil != 'default_dj.png'): ?>
                                <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $data['perfil']->foto_perfil; ?>" class="w-6 h-6 rounded-full object-cover">
                            <?php else: ?>
                                <i class="bi bi-person-circle text-djpro-accent text-xl"></i>
                            <?php endif; ?>
                        </a>
                        <a href="<?php echo URL_ROOT; ?>/usuarios/logout" class="text-djpro-muted hover:text-red-400 transition-colors">
                            <i class="bi bi-box-arrow-right text-xl"></i>
                        </a>
                    </div>

                    <!-- Script de Notificaciones -->
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const badge = document.getElementById('msg-badge');
                            let lastMsgId = localStorage.getItem('djpro_last_msg_id') || 0;

                            function checkMessages() {
                                fetch('<?php echo URL_ROOT; ?>/chat/api_check_notifications')
                                    .then(res => res.json())
                                    .then(data => {
                                        // Actualizar el circulito naranja
                                        if (data.count > 0) {
                                            badge.classList.remove('hidden');
                                        } else {
                                            badge.classList.add('hidden');
                                        }

                                        // Notificación emergente (Toast)
                                        if (data.latest && data.latest.id > lastMsgId) {
                                            // Solo notificar si no estamos en la página de chat con ese usuario
                                            if (!window.location.href.includes('/chat/index/' + data.latest.emisor_id)) {
                                                djpro.toast(`Nuevo mensaje de ${data.latest.emisor}: "${data.latest.contenido.substring(0, 30)}..."`, 'warning');
                                            }
                                            
                                            // Actualizar siempre el ID para no repetir la notificación
                                            lastMsgId = data.latest.id;
                                            localStorage.setItem('djpro_last_msg_id', lastMsgId);
                                        }
                                    });
                            }

                            // Verificar cada 10 segundos
                            checkMessages();
                            setInterval(checkMessages, 10000);
                        });
                    </script>
                <?php else: ?>
                    <a href="<?php echo URL_ROOT; ?>/usuarios/login" class="dj-navlink">Iniciar sesión</a>
                    <a href="<?php echo URL_ROOT; ?>/usuarios/registro" class="dj-btn-reg inline-flex items-center gap-2 text-white px-5 py-2.5 rounded-full font-bold shadow-lg shadow-blue-500/25">
                        <i class="bi bi-person-plus-fill"></i> Registrarse
                    </a>
                <?php endif; ?>
            </nav>

            <!-- Mobile Menu Toggle -->
            <button class="lg:hidden text-3xl text-djpro-text" onclick="toggleMenu()">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </header>
    <script>
        (function(){
            var h = document.getElementById('dj-header');
            if(!h) return;
            var onScroll = function(){ h.classList.toggle('scrolled', window.scrollY > 16); };
            onScroll(); window.addEventListener('scroll', onScroll, { passive: true });
        })();
    </script>

    <!-- Mobile Menu Drawer (Hidden by default) -->
    <div id="mobile-menu" class="fixed inset-0 z-[60] bg-djpro-bg translate-x-full transition-transform duration-300 lg:hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-10">
                <span class="dj-logo text-2xl">DJ<span class="grad-txt">PRO</span></span>
                <button class="text-3xl text-djpro-text" onclick="toggleMenu()">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="flex flex-col gap-6">
                <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="text-2xl font-bebas text-djpro-text">Explorar DJs</a>

                <hr class="border-djpro-border">
                <?php if(!isset($_SESSION['usuario_id'])): ?>
                    <a href="<?php echo URL_ROOT; ?>/usuarios/login" class="text-xl font-semibold text-djpro-text">Iniciar Sesión</a>
                    <a href="<?php echo URL_ROOT; ?>/usuarios/registro" class="bg-djpro-accent text-center text-white py-4 rounded-2xl font-bold text-xl">Registrarse</a>
                <?php else: ?>
                    <a href="#" class="text-xl font-semibold text-djpro-text">Mi Perfil</a>
                    <a href="<?php echo URL_ROOT; ?>/usuarios/logout" class="text-xl font-semibold text-red-500">Cerrar Sesión</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Content Wrapper -->
    <main class="pt-20 min-h-[calc(100vh-80px)]">
        
        <!-- Flash Messages -->
        <?php if(isset($_SESSION['flash_message'])): ?>
            <?php 
                $flash_type = $_SESSION['flash_type'] ?? 'success';
                $flash_title = '¡Acción exitosa!';
                $flash_icon = 'success';
                
                if ($flash_type === 'error') {
                    $flash_title = '¡Ups! Algo salió mal';
                    $flash_icon = 'error';
                } elseif ($flash_type === 'warning') {
                    $flash_title = 'Aviso Importante';
                    $flash_icon = 'warning';
                } elseif ($flash_type === 'info') {
                    $flash_title = 'Información';
                    $flash_icon = 'info';
                }
            ?>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    Swal.fire({
                        title: <?php echo json_encode($flash_title); ?>,
                        text: <?php echo json_encode($_SESSION['flash_message']); ?>,
                        icon: <?php echo json_encode($flash_icon); ?>,
                        confirmButtonColor: '#f97316',
                        background: '#12121a',
                        color: '#fff'
                    });
                });
            </script>
            <?php 
                unset($_SESSION['flash_message']); 
                unset($_SESSION['flash_type']);
            ?>
        <?php endif; ?>

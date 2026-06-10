<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DJPRO | Encuentra tu DJ en el Caquetá</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
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
                        'djpro-accent': '#f97316',
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
                text-shadow: 0 0 10px rgba(249, 115, 22, 0.5);
            }
        }

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
            background: #f97316;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #ea580c;
        }

        /* Firefox */
        * {
            scrollbar-width: thin;
            scrollbar-color: #f97316 #12121a;
        }
    </style>
</head>
<body class="bg-djpro-bg text-djpro-text font-['Rajdhani']">
    
    <!-- Header Fijo -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-djpro-bg/80 backdrop-blur-lg border-b border-djpro-border">
        <div class="container mx-auto px-4 h-20 flex items-center justify-between">
            <!-- Logo -->
            <a href="<?php echo URL_ROOT; ?>" class="flex items-center gap-2 group">
                <div class="w-10 h-10 bg-djpro-accent rounded-lg flex items-center justify-center shadow-[0_0_15px_rgba(249,115,22,0.4)] group-hover:scale-110 transition-transform">
                    <i class="bi bi-headphones text-white text-2xl"></i>
                </div>
                <span class="text-3xl font-bebas text-djpro-accent tracking-wider">DJPRO</span>
            </a>

            <!-- Nav Desktop -->
            <nav class="hidden lg:flex items-center gap-8">
                <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="text-djpro-text hover:text-djpro-accent transition-colors font-medium">Explorar DJs</a>

                
                <div class="h-6 w-[1px] bg-djpro-border mx-2"></div>
                
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
                    <a href="<?php echo URL_ROOT; ?>/usuarios/login" class="text-djpro-text hover:text-djpro-accent transition-colors font-semibold">Iniciar sesión</a>
                    <a href="<?php echo URL_ROOT; ?>/usuarios/registro" class="bg-djpro-accent hover:bg-orange-600 text-white px-6 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-orange-500/20">
                        Registrarse
                    </a>
                <?php endif; ?>
            </nav>

            <!-- Mobile Menu Toggle -->
            <button class="lg:hidden text-3xl text-djpro-text" onclick="toggleMenu()">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </header>

    <!-- Mobile Menu Drawer (Hidden by default) -->
    <div id="mobile-menu" class="fixed inset-0 z-[60] bg-djpro-bg translate-x-full transition-transform duration-300 lg:hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-10">
                <span class="text-3xl font-bebas text-djpro-accent tracking-wider">DJPRO</span>
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

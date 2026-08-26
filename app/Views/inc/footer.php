    </main>
    
    <?php 
        // Detectar si el sidebar está presente (usuario logueado)
        // Si el usuario está logueado, casi todas las páginas muestran sidebar (excepto auth que no llegan aquí)
        $has_sidebar = isset($_SESSION['usuario_id']);
    ?>

    <!-- Footer -->
    <footer class="bg-djpro-surface border-t border-djpro-border pt-16 pb-8 mt-20 <?php echo $has_sidebar ? 'lg:ml-64' : ''; ?> transition-all duration-300 relative">
        <!-- Accent Line -->
        <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-djpro-accent to-transparent opacity-50"></div>
        
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 mb-14">
                <!-- Brand Section -->
                <div class="col-span-2 lg:col-span-4">
                    <a href="<?php echo URL_ROOT; ?>" class="flex items-center gap-3 mb-5 group w-fit">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-[0_0_20px_rgba(46,91,255,0.4)] group-hover:scale-110 group-hover:rotate-3 transition-all duration-500" style="background:linear-gradient(135deg,#2E5BFF,#00C2FF)">
                            <i class="bi bi-headphones text-white text-2xl"></i>
                        </div>
                        <span class="dj-logo text-3xl">DJ<span class="grad-txt">PRO</span></span>
                    </a>
                    <p class="text-djpro-muted text-sm leading-relaxed max-w-xs mb-6" style="font-family:'Sora',sans-serif">
                        La plataforma de DJs del Caquetá. Conecta con el mejor talento local y lleva tu evento a otro nivel.
                    </p>
                    <!-- Redes -->
                    <div class="flex items-center gap-3">
                        <a href="#" aria-label="Instagram" class="w-10 h-10 rounded-xl bg-djpro-surface-2 border border-djpro-border flex items-center justify-center text-djpro-muted hover:text-white hover:border-djpro-accent hover:-translate-y-1 transition-all"><i class="bi bi-instagram"></i></a>
                        <a href="#" aria-label="Facebook" class="w-10 h-10 rounded-xl bg-djpro-surface-2 border border-djpro-border flex items-center justify-center text-djpro-muted hover:text-white hover:border-djpro-accent hover:-translate-y-1 transition-all"><i class="bi bi-facebook"></i></a>
                        <a href="#" aria-label="TikTok" class="w-10 h-10 rounded-xl bg-djpro-surface-2 border border-djpro-border flex items-center justify-center text-djpro-muted hover:text-white hover:border-djpro-accent hover:-translate-y-1 transition-all"><i class="bi bi-tiktok"></i></a>
                        <a href="#" aria-label="WhatsApp" class="w-10 h-10 rounded-xl bg-djpro-surface-2 border border-djpro-border flex items-center justify-center text-djpro-muted hover:text-white hover:border-djpro-accent hover:-translate-y-1 transition-all"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Explorar -->
                <div class="lg:col-span-2">
                    <h4 class="text-white text-xs mb-5 uppercase tracking-[0.2em] flex items-center gap-2" style="font-family:'Unbounded',sans-serif;font-weight:600">
                        <span class="w-1.5 h-1.5 bg-djpro-accent rounded-full"></span> Explorar
                    </h4>
                    <ul class="space-y-3" style="font-family:'Sora',sans-serif">
                        <li><a href="<?php echo URL_ROOT; ?>/djs/explorar" class="text-djpro-muted hover:text-djpro-accent hover:translate-x-1 inline-block transition-all text-sm font-semibold">Todos los DJs</a></li>
                        <li><a href="<?php echo URL_ROOT; ?>/djs/explorar?genero=Electrónica" class="text-djpro-muted hover:text-djpro-accent hover:translate-x-1 inline-block transition-all text-sm font-semibold">Electrónica</a></li>
                        <li><a href="<?php echo URL_ROOT; ?>/djs/explorar?genero=Guaracha" class="text-djpro-muted hover:text-djpro-accent hover:translate-x-1 inline-block transition-all text-sm font-semibold">Guaracha</a></li>
                        <li><a href="<?php echo URL_ROOT; ?>/djs/explorar?genero=Urbano" class="text-djpro-muted hover:text-djpro-accent hover:translate-x-1 inline-block transition-all text-sm font-semibold">Urbano / Reggaetón</a></li>
                    </ul>
                </div>

                <!-- Plataforma -->
                <div class="lg:col-span-2">
                    <h4 class="text-white text-xs mb-5 uppercase tracking-[0.2em] flex items-center gap-2" style="font-family:'Unbounded',sans-serif;font-weight:600">
                        <span class="w-1.5 h-1.5 bg-djpro-accent rounded-full"></span> Plataforma
                    </h4>
                    <ul class="space-y-3" style="font-family:'Sora',sans-serif">
                        <li><a href="<?php echo URL_ROOT; ?>/usuarios/registro" class="text-djpro-muted hover:text-djpro-accent hover:translate-x-1 inline-block transition-all text-sm font-semibold">Ser DJ</a></li>
                        <li><a href="<?php echo URL_ROOT; ?>/usuarios/login" class="text-djpro-muted hover:text-djpro-accent hover:translate-x-1 inline-block transition-all text-sm font-semibold">Iniciar sesión</a></li>
                        <li><a href="<?php echo URL_ROOT; ?>/usuarios/registro" class="text-djpro-muted hover:text-djpro-accent hover:translate-x-1 inline-block transition-all text-sm font-semibold">Crear cuenta</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="col-span-2 lg:col-span-4">
                    <h4 class="text-white text-xs mb-3 uppercase tracking-[0.2em] flex items-center gap-2" style="font-family:'Unbounded',sans-serif;font-weight:600">
                        <span class="w-1.5 h-1.5 bg-djpro-accent rounded-full"></span> Novedades
                    </h4>
                    <p class="text-djpro-muted text-sm mb-4" style="font-family:'Sora',sans-serif">Recibe los mejores DJs y eventos del Caquetá en tu correo.</p>
                    <form class="flex gap-2" onsubmit="event.preventDefault(); this.reset(); Swal.fire({icon:'success',title:'¡Gracias por suscribirte!',confirmButtonColor:'#2E5BFF',background:'#12121a',color:'#fff'});">
                        <input type="email" required placeholder="Tu correo" class="flex-1 min-w-0 bg-djpro-surface-2 border border-djpro-border rounded-xl px-4 py-3 text-sm text-djpro-text outline-none focus:border-djpro-accent transition-colors" style="font-family:'Sora',sans-serif">
                        <button type="submit" class="text-white px-5 py-3 rounded-xl font-bold text-sm shadow-lg shadow-blue-500/25 hover:brightness-110 transition-all whitespace-nowrap" style="background:linear-gradient(135deg,#2E5BFF,#00C2FF);font-family:'Sora',sans-serif">Unirme</button>
                    </form>
                </div>
            </div>

            <!-- Bottom Line -->
            <div class="border-t border-djpro-border pt-8 flex flex-col md:flex-row justify-between items-center gap-4" style="font-family:'Sora',sans-serif">
                <div class="flex flex-col md:flex-row items-center gap-2 md:gap-6">
                    <p class="text-djpro-muted text-[11px] font-semibold">&copy; <?php echo date('Y'); ?> DJPRO Platform. Todos los derechos reservados.</p>
                    <div class="h-4 w-[1px] bg-djpro-border hidden md:block"></div>
                    <span class="text-[11px] font-semibold text-djpro-muted">Hecho con <span class="text-djpro-accent">♪</span> en el Caquetá</span>
                </div>
                <span class="flex items-center gap-2 text-[11px] font-bold text-green-500 uppercase tracking-[0.15em]">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    Sistemas operativos
                </span>
            </div>
        </div>
    </footer>

    <script>
        // SweetAlert2 Global Configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#1c1c2e',
            color: '#fff',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Global confirmation for delete actions
        function confirmDelete(url, message = '¿Estás seguro de eliminar este elemento?') {
            Swal.fire({
                title: '¿Confirmar Acción?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#312e81',
                confirmButtonText: 'SÍ, ELIMINAR',
                cancelButtonText: 'CANCELAR',
                background: '#1c1c2e',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }

        // Generic confirmation for any action
        function confirmAction(url, title, text, icon = 'question', confirmText = 'SÍ, CONTINUAR') {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#312e81',
                confirmButtonText: confirmText,
                cancelButtonText: 'CANCELAR',
                background: '#1c1c2e',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    form.style.display = 'none';
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = 'csrf_token';
                    csrf.value = '<?php echo $_SESSION['csrf_token'] ?? ''; ?>';
                    form.appendChild(csrf);
                    document.body.appendChild(form);
                    form.submit();
                }
            })
        }

        // Global confirmation for form submission (like delete user)
        function confirmDeleteForm(formId, message = '¿Estás seguro de que quieres eliminar este registro? Esta acción no se puede deshacer.') {
            Swal.fire({
                title: '¿Confirmar Eliminación?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#312e81',
                confirmButtonText: 'SÍ, ELIMINAR AHORA',
                cancelButtonText: 'CANCELAR',
                background: '#1c1c2e',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            })
        }

        // Mobile Menu Logic
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const closeMenuBtn = document.getElementById('close-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if(mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.remove('translate-x-full');
            });
        }

        if(closeMenuBtn) {
            closeMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.add('translate-x-full');
            });
        }

        document.addEventListener('click', function (e) {
            if (e.defaultPrevented) return;

            const link = e.target.closest('a[href]');
            if (!link) return;

            const protectedActions = [
                '/contrataciones/responder/',
                '/contrataciones/cancelar_cliente/',
                '/contrataciones/aceptar_contra_oferta/',
                '/contrataciones/rechazar_contra_oferta/',
                '/contrataciones/aceptar_contra_oferta_dj/',
                '/contrataciones/rechazar_contra_oferta_dj/',
                '/contrataciones/cancelar_contra_oferta/'
            ];

            if (!protectedActions.some(action => link.href.includes(action))) return;

            e.preventDefault();
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = link.href;
            form.style.display = 'none';
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = 'csrf_token';
            csrf.value = '<?php echo $_SESSION['csrf_token'] ?? ''; ?>';
            form.appendChild(csrf);
            document.body.appendChild(form);
            form.submit();
        });

        // =========================================================
        // PROTECCION GLOBAL ANTI-DOBLE-ENVIO
        // Se aplica a TODOS los formularios POST del sitio
        // excepto los de busqueda (GET) y los marcados con data-no-protect
        // =========================================================
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('form[method="POST"]:not([data-no-protect])').forEach(function (form) {
                // Excluir formularios que ya tienen su propio manejo AJAX (booking en perfil.php)
                if (form.id === 'bookingForm' || form.id === 'formAgregarVideo') return;

                form.addEventListener('submit', function (e) {
                    // Si ya está en proceso, bloquear
                    if (form.dataset.submitting === 'true') {
                        e.preventDefault();
                        return false;
                    }

                    const btn = form.querySelector('button[type="submit"]');
                    if (!btn) return;

                    // Marcar como en proceso
                    form.dataset.submitting = 'true';

                    // Guardar texto original y mostrar cargando
                    const originalHTML = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = '<span style="display:inline-flex;align-items:center;gap:8px"><svg style="animation:spin 1s linear infinite;width:16px;height:16px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle style="opacity:.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path style="opacity:.75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg> PROCESANDO...</span>';
                    btn.style.opacity = '0.75';
                    btn.style.cursor = 'not-allowed';

                    // Salvaguarda: si el servidor tarda mucho o hay error, reactivar el botón tras 15s
                    setTimeout(function () {
                        if (form.dataset.submitting === 'true') {
                            form.dataset.submitting = 'false';
                            btn.disabled = false;
                            btn.innerHTML = originalHTML;
                            btn.style.opacity = '';
                            btn.style.cursor = '';
                        }
                    }, 15000);
                });
            });
        });
    </script>
    <style>
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</body>
</html>

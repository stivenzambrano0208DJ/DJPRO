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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-12 mb-16">
                <!-- Brand Section -->
                <div class="col-span-1">
                    <a href="<?php echo URL_ROOT; ?>" class="flex items-center gap-3 mb-6 group">
                        <div class="w-12 h-12 bg-djpro-accent rounded-2xl flex items-center justify-center shadow-[0_0_20px_rgba(249,115,22,0.3)] group-hover:scale-110 transition-transform duration-500">
                            <i class="bi bi-headphones text-white text-2xl"></i>
                        </div>
                        <span class="text-3xl font-bebas text-djpro-accent tracking-widest">DJPRO</span>
                    </a>
                    <p class="text-djpro-muted text-sm leading-relaxed max-w-xs">
                        La plataforma definitiva en el Caquetá para conectar con el mejor talento musical. Elevamos tus eventos a una experiencia sensorial única.
                    </p>
                </div>

                <!-- Navigation Links -->
                <div class="lg:pl-8">
                    <h4 class="text-white font-bebas text-xl mb-6 uppercase tracking-[0.2em] flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-djpro-accent rounded-full"></span>
                        Explorar
                    </h4>
                    <ul class="space-y-4">
                        <li><a href="<?php echo URL_ROOT; ?>/djs/explorar" class="text-djpro-muted hover:text-djpro-accent hover:translate-x-1 inline-block transition-all text-xs font-bold uppercase tracking-widest">Todos los DJs</a></li>
                        <li><a href="<?php echo URL_ROOT; ?>/djs/explorar?genero=Electrónica" class="text-djpro-muted hover:text-djpro-accent hover:translate-x-1 inline-block transition-all text-xs font-bold uppercase tracking-widest">Electrónica</a></li>
                        <li><a href="<?php echo URL_ROOT; ?>/djs/explorar?genero=Urbano" class="text-djpro-muted hover:text-djpro-accent hover:translate-x-1 inline-block transition-all text-xs font-bold uppercase tracking-widest">Urbano / Reggaetón</a></li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Line -->
            <div class="border-t border-djpro-border pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex flex-col md:flex-row items-center gap-2 md:gap-8">
                    <p class="text-djpro-muted text-[9px] font-bold uppercase tracking-[0.2em]">&copy; <?php echo date('Y'); ?> DJPRO PLATFORM. ALL RIGHTS RESERVED.</p>
                    <div class="h-4 w-[1px] bg-djpro-border hidden md:block"></div>
                    <span class="text-[9px] font-bold text-djpro-muted uppercase tracking-[0.2em]">Coded with ❤️ in Caquetá</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-2 text-[9px] font-bold text-djpro-accent uppercase tracking-[0.2em]">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        Sistemas Operativos
                    </span>
                </div>
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
                    window.location.href = url;
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

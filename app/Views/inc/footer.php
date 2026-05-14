    </main>
    
    <?php 
        // BUG-006 FIX: Detectar si estamos en un dashboard real (con sidebar activo) para ajustar el margen del footer
        // No aplicamos el margen en páginas públicas como perfil o explorar, incluso si hay sesión iniciada.
        $current_url = $_GET['url'] ?? '';
        $is_dashboard = (isset($_SESSION['usuario_rol']) && 
                        ($_SESSION['usuario_rol'] == 'dj' || $_SESSION['usuario_rol'] == 'admin' || $_SESSION['usuario_rol'] == 'cliente') &&
                        !strpos($current_url, 'perfil') && 
                        !strpos($current_url, 'explorar'));
    ?>

    <!-- Footer -->
    <footer class="bg-djpro-surface border-t border-djpro-border pt-16 pb-8 mt-20 <?php echo $is_dashboard ? 'lg:ml-64' : ''; ?> transition-all duration-300">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <!-- Brand -->
                <div class="col-span-1">
                    <a href="<?php echo URL_ROOT; ?>" class="flex items-center gap-2 mb-6">
                        <div class="w-10 h-10 bg-djpro-accent rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/20">
                            <i class="bi bi-headphones text-white text-xl"></i>
                        </div>
                        <span class="text-3xl font-bebas text-djpro-accent tracking-wider">DJPRO</span>
                    </a>
                    <p class="text-djpro-muted text-sm leading-relaxed">
                        La plataforma líder en el Caquetá para conectar con los mejores DJs y elevar tus eventos al siguiente nivel. Siente el ritmo, vive la experiencia.
                    </p>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="text-white font-bebas text-lg mb-6 uppercase tracking-widest">Plataforma</h4>
                    <ul class="space-y-4">
                        <li><a href="<?php echo URL_ROOT; ?>/djs/explorar" class="text-djpro-muted hover:text-djpro-accent transition-colors text-sm font-medium">Explorar DJs</a></li>
                        <li><a href="<?php echo URL_ROOT; ?>/djs/explorar?genero=" class="text-djpro-muted hover:text-djpro-accent transition-colors text-sm font-medium">Géneros Populares</a></li>
                        <li><a href="<?php echo URL_ROOT; ?>/djs/explorar?evento=" class="text-djpro-muted hover:text-djpro-accent transition-colors text-sm font-medium">Próximos Eventos</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bebas text-lg mb-6 uppercase tracking-widest">Soporte</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-djpro-muted hover:text-djpro-accent transition-colors text-sm font-medium">Términos de Servicio</a></li>
                        <li><a href="#" class="text-djpro-muted hover:text-djpro-accent transition-colors text-sm font-medium">Privacidad</a></li>
                        <li><a href="#" class="text-djpro-muted hover:text-djpro-accent transition-colors text-sm font-medium">Preguntas Frecuentes</a></li>
                    </ul>
                </div>

                <!-- Social -->
                <div>
                    <h4 class="text-white font-bebas text-lg mb-6 uppercase tracking-widest">Síguenos</h4>
                    <div class="flex gap-4">
                        <a href="#" class="w-12 h-12 rounded-xl bg-djpro-surface-2 border border-djpro-border flex items-center justify-center text-djpro-text hover:border-djpro-accent hover:text-djpro-accent hover:scale-110 transition-all">
                            <i class="bi bi-instagram text-xl"></i>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-xl bg-djpro-surface-2 border border-djpro-border flex items-center justify-center text-djpro-text hover:border-djpro-accent hover:text-djpro-accent hover:scale-110 transition-all">
                            <i class="bi bi-facebook text-xl"></i>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-xl bg-djpro-surface-2 border border-djpro-border flex items-center justify-center text-djpro-text hover:border-djpro-accent hover:text-djpro-accent hover:scale-110 transition-all">
                            <i class="bi bi-youtube text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-djpro-border pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-djpro-muted text-[10px] font-bold uppercase tracking-widest">&copy; <?php echo date('Y'); ?> DJPRO Caquetá. Handcrafted for the rhythm.</p>
                <div class="flex gap-6">
                    <span class="text-[10px] font-bold text-djpro-accent uppercase tracking-widest">Florencia, Caquetá</span>
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
    </script>
</body>
</html>

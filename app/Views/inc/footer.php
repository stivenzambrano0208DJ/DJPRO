    </main>

    <!-- Footer -->
    <footer class="bg-djpro-surface border-t border-djpro-border pt-16 pb-8 mt-20">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-1">
                    <a href="<?php echo URL_ROOT; ?>" class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-djpro-accent rounded flex items-center justify-center">
                            <i class="bi bi-headphones text-white"></i>
                        </div>
                        <span class="text-2xl font-bebas text-djpro-accent tracking-wider">DJPRO</span>
                    </a>
                    <p class="text-djpro-muted leading-relaxed">
                        La plataforma líder en el Caquetá para conectar con los mejores DJs y elevar tus eventos al siguiente nivel.
                    </p>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="text-white font-bold mb-6 uppercase tracking-widest text-sm">Plataforma</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-djpro-muted hover:text-djpro-accent transition-colors">Explorar DJs</a></li>
                        <li><a href="#" class="text-djpro-muted hover:text-djpro-accent transition-colors">Géneros Populares</a></li>
                        <li><a href="#" class="text-djpro-muted hover:text-djpro-accent transition-colors">Próximos Eventos</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-6 uppercase tracking-widest text-sm">Legal</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-djpro-muted hover:text-djpro-accent transition-colors">Términos de Servicio</a></li>
                        <li><a href="#" class="text-djpro-muted hover:text-djpro-accent transition-colors">Privacidad</a></li>
                        <li><a href="#" class="text-djpro-muted hover:text-djpro-accent transition-colors">Contacto</a></li>
                    </ul>
                </div>

                <!-- Social -->
                <div>
                    <h4 class="text-white font-bold mb-6 uppercase tracking-widest text-sm">Síguenos</h4>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-djpro-surface-2 border border-djpro-border flex items-center justify-center text-djpro-text hover:border-djpro-accent hover:text-djpro-accent transition-all">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-djpro-surface-2 border border-djpro-border flex items-center justify-center text-djpro-text hover:border-djpro-accent hover:text-djpro-accent transition-all">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-djpro-surface-2 border border-djpro-border flex items-center justify-center text-djpro-text hover:border-djpro-accent hover:text-djpro-accent transition-all">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-djpro-border pt-8 text-center text-djpro-muted text-sm">
                <p>&copy; <?php echo date('Y'); ?> DJPRO Caquetá. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile Menu Logic
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const closeMenuBtn = document.getElementById('close-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.remove('translate-x-full');
        });

        closeMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.add('translate-x-full');
        });
    </script>
</body>
</html>

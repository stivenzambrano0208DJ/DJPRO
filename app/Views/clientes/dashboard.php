<?php require APPROOT . '/app/Views/inc/header.php'; ?>
<?php require APPROOT . '/app/Views/inc/sidebar_cliente.php'; ?>

<div class="lg:ml-64 p-8">
    <div class="container mx-auto">
        <!-- Header del Dashboard -->
        <div class="mb-12">
            <h1 class="text-4xl font-bebas text-white tracking-wider mb-2">BUSCA TU <span class="text-djpro-accent">RITMO PERFECTO</span></h1>
            <p class="text-djpro-muted tracking-wide font-medium italic">"Explora los mejores talentos del Caquetá para tu evento."</p>
        </div>

        <!-- Filtros Rápidos (Pills) -->
        <div class="mb-10">
            <h4 class="text-xs font-bold text-djpro-text uppercase tracking-widest mb-4 ml-1">Filtros Populares</h4>
            <div class="flex flex-wrap gap-3">
                <button class="px-6 py-2 bg-djpro-accent text-white rounded-full text-sm font-bold shadow-lg shadow-orange-500/20">Todos</button>
                <button class="px-6 py-2 bg-djpro-surface-2 border border-djpro-border text-djpro-muted hover:border-djpro-accent hover:text-white rounded-full text-sm font-bold transition-all">Reggaetón</button>
                <button class="px-6 py-2 bg-djpro-surface-2 border border-djpro-border text-djpro-muted hover:border-djpro-accent hover:text-white rounded-full text-sm font-bold transition-all">Electrónica</button>
                <button class="px-6 py-2 bg-djpro-surface-2 border border-djpro-border text-djpro-muted hover:border-djpro-accent hover:text-white rounded-full text-sm font-bold transition-all">Tropical</button>
                <button class="px-6 py-2 bg-djpro-surface-2 border border-djpro-border text-djpro-muted hover:border-djpro-accent hover:text-white rounded-full text-sm font-bold transition-all">Bodas</button>
                <button class="px-6 py-2 bg-djpro-surface-2 border border-djpro-border text-djpro-muted hover:border-djpro-accent hover:text-white rounded-full text-sm font-bold transition-all">XV Años</button>
            </div>
        </div>

        <!-- Buscador e Info de Resultados -->
        <div class="flex flex-col md:row md:flex-row justify-between items-center gap-6 mb-8">
            <div class="w-full md:w-1/2 relative">
                <i class="bi bi-search absolute left-5 top-1/2 -translate-y-1/2 text-djpro-accent"></i>
                <input type="text" placeholder="Busca por nombre o palabra clave..." class="input-djpro w-full pl-14 py-4">
            </div>
            <div class="text-sm text-djpro-muted font-bold tracking-widest">
                MOSTRANDO <span class="text-white">12</span> DJS ENCONTRADOS
            </div>
        </div>

        <!-- Grid de DJs -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php for($i=1; $i<=6; $i++): ?>
            <div class="dj-card group rounded-2xl overflow-hidden relative">
                <div class="h-32 bg-gradient-to-br from-violet-900 to-slate-900"></div>
                <div class="p-6 pt-0 relative">
                    <div class="w-20 h-20 rounded-full border-4 border-djpro-surface bg-djpro-surface-2 mx-auto -mt-10 overflow-hidden group-hover:border-djpro-accent transition-all duration-300">
                        <img src="https://images.unsplash.com/photo-1598387181032-a3103a2db5b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="DJ" class="w-full h-full object-cover">
                    </div>
                    <div class="text-center mt-4">
                        <h3 class="text-2xl font-bebas text-white group-hover:text-djpro-accent transition-colors tracking-widest">DJ STEVEN MIX</h3>
                        <div class="flex items-center justify-center gap-1 text-djpro-muted text-[10px] uppercase font-bold tracking-widest mb-4">
                            <i class="bi bi-geo-alt-fill text-djpro-accent"></i>
                            <span>Florencia, Caquetá</span>
                        </div>
                        <div class="flex flex-wrap justify-center gap-2 mb-6">
                            <span class="badge-genre">Urbano</span>
                            <span class="badge-event">Bodas</span>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-djpro-border">
                            <div class="text-left">
                                <span class="block text-[10px] text-djpro-muted uppercase font-bold tracking-tighter">Desde</span>
                                <span class="text-lg font-bold text-white">$450k</span>
                            </div>
                            <div class="text-right">
                                <div class="flex text-yellow-500 text-[10px] mb-1">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                                </div>
                                <span class="text-[10px] text-djpro-muted uppercase font-bold">4.9 (128)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Action Hover -->
                <div class="absolute inset-0 bg-djpro-bg/80 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center gap-3 p-6">
                    <a href="<?php echo URL_ROOT; ?>/djs/perfil/1" class="btn-djpro-primary w-full text-center py-3">VER PERFIL</a>
                    <button class="w-full py-3 border border-djpro-purple text-djpro-purple font-bold rounded-xl hover:bg-djpro-purple hover:text-white transition-all">AGREGAR AL LINEUP</button>
                </div>
            </div>
            <?php endfor; ?>
        </div>

        <!-- Paginación -->
        <div class="mt-16 flex justify-center gap-2">
            <button class="w-10 h-10 rounded-xl border border-djpro-border bg-djpro-surface-2 flex items-center justify-center text-djpro-muted hover:border-djpro-accent hover:text-white transition-all"><i class="bi bi-chevron-left"></i></button>
            <button class="w-10 h-10 rounded-xl bg-djpro-accent text-white flex items-center justify-center font-bold">1</button>
            <button class="w-10 h-10 rounded-xl border border-djpro-border bg-djpro-surface-2 flex items-center justify-center text-djpro-muted hover:border-djpro-accent hover:text-white transition-all font-bold">2</button>
            <button class="w-10 h-10 rounded-xl border border-djpro-border bg-djpro-surface-2 flex items-center justify-center text-djpro-muted hover:border-djpro-accent hover:text-white transition-all"><i class="bi bi-chevron-right"></i></button>
        </div>
    </div>
</div>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

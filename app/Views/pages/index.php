<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<!-- Hero Section -->
<section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden">
    <!-- Background Gradient Overlay -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-djpro-accent/20 via-djpro-bg to-djpro-bg z-0"></div>
    
    <!-- Pattern -->
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] z-0"></div>

    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-6xl md:text-8xl font-bebas text-white mb-6 tracking-tighter leading-none reveal">
            ENCUENTRA TU <span class="text-djpro-accent">DJ PERFECTO</span> <br> EN EL CAQUETÁ
        </h1>
        <p class="text-xl md:text-2xl text-djpro-muted font-light mb-12 max-w-2xl mx-auto tracking-wide reveal">
            La red profesional de DJs más grande de la región. Calidad, energía y profesionalismo para tu próximo evento.
        </p>

        <!-- Barra de Búsqueda Prominente -->
        <div class="max-w-4xl mx-auto bg-djpro-surface p-2 rounded-3xl border border-djpro-border shadow-2xl shadow-black/50 reveal">
            <form action="<?php echo URL_ROOT; ?>/djs/explorar" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-2">
                <div class="flex items-center px-4 py-3 bg-djpro-surface-2 rounded-2xl">
                    <i class="bi bi-calendar-event text-djpro-accent mr-3"></i>
                    <select name="evento" class="bg-transparent border-none text-djpro-text focus:ring-0 w-full cursor-pointer font-semibold outline-none">
                        <option value="" class="bg-djpro-surface-2">Tipo de Evento</option>
                        <?php foreach($data['tipos_evento'] as $ev): ?>
                            <option value="<?php echo $ev->nombre; ?>" class="bg-djpro-surface-2"><?php echo $ev->nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex items-center px-4 py-3 bg-djpro-surface-2 rounded-2xl">
                    <i class="bi bi-music-note-beamed text-djpro-accent mr-3"></i>
                    <select name="genero" class="bg-transparent border-none text-djpro-text focus:ring-0 w-full cursor-pointer font-semibold outline-none">
                        <option value="" class="bg-djpro-surface-2">Género Musical</option>
                        <?php foreach($data['generos'] as $gen): ?>
                            <option value="<?php echo $gen->nombre; ?>" class="bg-djpro-surface-2"><?php echo $gen->nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex items-center px-4 py-3 bg-djpro-surface-2 rounded-2xl">
                    <i class="bi bi-geo-alt text-djpro-accent mr-3"></i>
                    <select name="ciudad" class="bg-transparent border-none text-djpro-text focus:ring-0 w-full cursor-pointer font-semibold outline-none">
                        <option value="" class="bg-djpro-surface-2">Toda la región</option>
                        <option value="Florencia" class="bg-djpro-surface-2">Florencia</option>
                        <option value="Morelia" class="bg-djpro-surface-2">Morelia</option>
                        <option value="Belén de los Andaquíes" class="bg-djpro-surface-2">Belén</option>
                        <option value="San Vicente del Caguán" class="bg-djpro-surface-2">San Vicente</option>
                        <option value="Puerto Rico" class="bg-djpro-surface-2">Puerto Rico</option>
                        <option value="El Doncello" class="bg-djpro-surface-2">El Doncello</option>
                        <option value="El Paujil" class="bg-djpro-surface-2">El Paujil</option>
                        <option value="Cartagena del Chairá" class="bg-djpro-surface-2">Cartagena del Chairá</option>
                        <option value="Curillo" class="bg-djpro-surface-2">Curillo</option>
                        <option value="Albania" class="bg-djpro-surface-2">Albania</option>
                        <option value="San José del Fragua" class="bg-djpro-surface-2">San José del Fragua</option>
                        <option value="Valparaíso" class="bg-djpro-surface-2">Valparaíso</option>
                        <option value="Solita" class="bg-djpro-surface-2">Solita</option>
                        <option value="Solano" class="bg-djpro-surface-2">Solano</option>
                        <option value="La Montañita" class="bg-djpro-surface-2">La Montañita</option>
                        <option value="Milan" class="bg-djpro-surface-2">Milán</option>
                    </select>
                </div>
                <button type="submit" class="bg-djpro-accent hover:bg-orange-600 text-white font-bold py-4 rounded-2xl transition-all flex items-center justify-center gap-2 group shadow-lg shadow-orange-500/20">
                    <i class="bi bi-search group-hover:scale-110 transition-transform"></i>
                    BUSCAR DJ
                </button>
            </form>
        </div>

        <!-- Stats -->
        <div class="mt-16 flex flex-wrap justify-center gap-8 md:gap-16 relative">
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 flex items-center gap-2 bg-green-500/10 border border-green-500/20 px-3 py-1 rounded-full">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-[9px] font-bold text-green-500 uppercase tracking-widest">Live Updates</span>
            </div>
            
            <div class="text-center">
                <span id="stat-djs" class="block text-4xl font-bebas text-white"><?php echo $data['total_djs'] ?? '25'; ?>+</span>
                <span class="text-sm text-djpro-muted uppercase tracking-widest font-bold">DJs Registrados</span>
            </div>
            <div class="text-center">
                <span id="stat-eventos" class="block text-4xl font-bebas text-white"><?php echo $data['total_eventos'] ?? '150'; ?>+</span>
                <span class="text-sm text-djpro-muted uppercase tracking-widest font-bold">Eventos Realizados</span>
            </div>
            <div class="text-center">
                <span class="block text-4xl font-bebas text-white">12</span>
                <span class="text-sm text-djpro-muted uppercase tracking-widest font-bold">Ciudades Cubiertas</span>
            </div>
        </div>
    </div>
</section>

<script>
    // Real-time Stats Polling
    function updateStats() {
        fetch('<?php echo URL_ROOT; ?>/pages/api_stats')
            .then(response => response.json())
            .then(data => {
                document.getElementById('stat-djs').innerText = data.total_djs + '+';
                document.getElementById('stat-eventos').innerText = data.total_eventos + '+';
                console.log('Stats updated at ' + data.timestamp);
            })
            .catch(error => console.error('Error fetching stats:', error));
    }

    // Update every 10 seconds
    setInterval(updateStats, 10000);
</script>

<!-- Catálogo Destacado -->
<section class="py-24 bg-djpro-bg">
    <div class="container mx-auto px-4">
        <div class="flex items-end justify-between mb-12">
            <div>
                <h2 class="text-5xl font-bebas text-white mb-2">DJs <span class="text-djpro-accent">Destacados</span></h2>
                <p class="text-djpro-muted tracking-wide">Los perfiles más solicitados y mejor calificados de la semana.</p>
            </div>
            <a href="<?php echo URL_ROOT; ?>/djs/explorar" class="hidden md:flex items-center gap-2 text-djpro-accent font-bold hover:underline">
                Ver todos los DJs <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <!-- Grid de DJs -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php if(empty($data['djs'])): ?>
                <div class="col-span-full text-center py-12 border-2 border-dashed border-djpro-border rounded-3xl">
                    <p class="text-djpro-muted uppercase font-bold tracking-widest">No hay DJs registrados todavía.</p>
                </div>
            <?php else: ?>
                <?php foreach($data['djs'] as $dj): ?>
                <div class="dj-card group rounded-2xl overflow-hidden relative">
                    <div class="h-32 bg-gradient-to-br from-djpro-purple to-slate-900 overflow-hidden">
                        <?php if($dj->foto_perfil != 'default_dj.png'): ?>
                            <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $dj->foto_perfil; ?>" class="w-full h-full object-cover opacity-50 group-hover:scale-110 transition-transform duration-700">
                        <?php endif; ?>
                    </div>
                    <div class="p-6 pt-0 relative">
                        <div class="w-20 h-20 rounded-2xl border-4 border-djpro-surface bg-djpro-surface-2 mx-auto -mt-10 overflow-hidden shadow-2xl group-hover:border-djpro-accent transition-all duration-300">
                            <?php if($dj->foto_perfil != 'default_dj.png'): ?>
                                <img src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $dj->foto_perfil; ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($dj->nombre); ?>&background=12121a&color=f97316" class="w-full h-full object-cover">
                            <?php endif; ?>
                        </div>
                        <div class="text-center mt-4">
                            <h3 class="text-2xl font-bebas text-white group-hover:text-djpro-accent transition-colors tracking-widest uppercase truncate"><?php echo $dj->nombre; ?></h3>
                            <div class="flex items-center justify-center gap-1 text-djpro-muted text-[10px] uppercase font-bold tracking-widest mb-4">
                                <i class="bi bi-geo-alt-fill text-djpro-accent"></i>
                                <span><?php echo $dj->ciudad ? $dj->ciudad : 'Caquetá'; ?></span>
                            </div>
                            
                            <div class="flex flex-wrap justify-center gap-1 mb-6">
                                <?php 
                                $generos = explode(',', $dj->generos);
                                foreach(array_slice($generos, 0, 2) as $gen): if(!empty($gen)):
                                ?>
                                <span class="bg-djpro-surface-2 text-djpro-muted text-[8px] font-bold px-2 py-1 rounded-md border border-djpro-border uppercase tracking-tighter"><?php echo $gen; ?></span>
                                <?php endif; endforeach; ?>
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-djpro-border">
                                <div class="text-left">
                                    <span class="block text-[10px] text-djpro-muted uppercase font-bold tracking-tighter">Status</span>
                                    <span class="text-[10px] font-bold text-green-500 uppercase">Disponible</span>
                                </div>
                                <div class="text-right">
                                    <div class="flex text-yellow-500 text-[10px] mb-1">
                                        <i class="bi bi-star-fill"></i>
                                        <span class="ml-1 text-white"><?php echo number_format($dj->calificacion_promedio, 1); ?></span>
                                    </div>
                                    <span class="text-[9px] text-djpro-muted uppercase font-bold">PRO DJ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Hover Layer -->
                    <div class="absolute inset-0 bg-djpro-bg/90 backdrop-blur-md opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center gap-4 p-6">
                        <p class="text-white text-xs font-medium text-center line-clamp-3">
                            <?php echo $dj->biografia ?: 'Experimenta lo mejor del talento local con '.$dj->nombre.'.'; ?>
                        </p>
                        <?php if(isset($_SESSION['usuario_id'])): ?>
                            <a href="<?php echo URL_ROOT; ?>/djs/perfil/<?php echo $dj->id; ?>?reservar=1" class="btn-djpro-primary w-full text-center py-2.5">RESERVAR AHORA</a>
                        <?php else: ?>
                            <a href="<?php echo URL_ROOT; ?>/usuarios/login?redirect=djs/perfil/<?php echo $dj->id; ?>" class="btn-djpro-primary w-full text-center py-2.5">RESERVAR AHORA</a>
                        <?php endif; ?>
                        <a href="<?php echo URL_ROOT; ?>/djs/perfil/<?php echo $dj->id; ?>" class="text-[10px] text-djpro-muted hover:text-white font-bold uppercase tracking-widest">Ver Perfil</a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>


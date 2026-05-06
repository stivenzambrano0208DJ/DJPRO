<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<section class="py-12 px-4">
    <div class="max-w-4xl mx-auto">
        
        <!-- Stepper Header -->
        <div class="mb-12">
            <h1 class="text-4xl font-bebas text-white tracking-widest text-center mb-8">COMPLETA TU <span class="text-djpro-accent">PERFIL PROFESIONAL</span></h1>
            
            <div class="relative">
                <!-- Progress Line -->
                <div class="absolute top-1/2 left-0 w-full h-1 bg-djpro-surface-2 -translate-y-1/2 z-0"></div>
                <div id="progress-bar" class="absolute top-1/2 left-0 w-0 h-1 bg-djpro-accent -translate-y-1/2 z-0 transition-all duration-500"></div>
                
                <!-- Steps Dots -->
                <div class="flex justify-between relative z-10">
                    <?php for($i=1; $i<=4; $i++): ?>
                    <div class="step-dot group flex flex-col items-center gap-3">
                        <div class="w-10 h-10 rounded-full border-2 border-djpro-surface-2 bg-djpro-bg flex items-center justify-center font-bold text-djpro-muted transition-all duration-300">
                            <?php echo $i; ?>
                        </div>
                        <span class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest group-hover:text-white transition-colors">
                            <?php echo ['Identidad', 'Ubicación', 'Música', 'Videos'][$i-1]; ?>
                        </span>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <!-- Form Stepper Container -->
        <div class="bg-djpro-surface p-8 md:p-12 rounded-3xl border border-djpro-border shadow-2xl relative overflow-hidden">
            
            <form id="profile-stepper-form">
                
                <!-- Paso 1: Identidad -->
                <div class="step-content animate-fade-in" data-step="1">
                    <h3 class="text-2xl font-bebas text-white mb-8 tracking-widest">PASO 1: Tu Identidad Visual</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <!-- Foto Perfil -->
                        <div class="space-y-4">
                            <label class="text-sm font-bold text-djpro-text uppercase tracking-widest">Foto de Perfil</label>
                            <div class="relative group cursor-pointer border-2 border-dashed border-djpro-border rounded-full w-48 h-48 mx-auto flex items-center justify-center overflow-hidden hover:border-djpro-accent transition-all">
                                <input type="file" class="absolute inset-0 opacity-0 cursor-pointer z-20">
                                <div class="text-center group-hover:scale-110 transition-transform">
                                    <i class="bi bi-camera text-3xl text-djpro-muted mb-1 block"></i>
                                    <span class="text-[10px] font-bold text-djpro-muted uppercase">Subir Foto</span>
                                </div>
                            </div>
                            <p class="text-[10px] text-djpro-muted text-center">JPG, PNG. Máx 5MB. Formato circular.</p>
                        </div>

                        <!-- Banner -->
                        <div class="space-y-4">
                            <label class="text-sm font-bold text-djpro-text uppercase tracking-widest">Banner de Perfil</label>
                            <div class="relative group cursor-pointer border-2 border-dashed border-djpro-border rounded-2xl w-full h-48 flex items-center justify-center overflow-hidden hover:border-djpro-accent transition-all">
                                <input type="file" class="absolute inset-0 opacity-0 cursor-pointer z-20">
                                <div class="text-center group-hover:scale-110 transition-transform">
                                    <i class="bi bi-image text-3xl text-djpro-muted mb-1 block"></i>
                                    <span class="text-[10px] font-bold text-djpro-muted uppercase">Subir Banner</span>
                                </div>
                            </div>
                            <p class="text-[10px] text-djpro-muted text-center">Recomendado: 1200x400px</p>
                        </div>
                    </div>

                    <div class="mt-10 space-y-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-djpro-text uppercase tracking-widest ml-1">Nombre Artístico</label>
                            <input type="text" placeholder="Ej: DJ STEVEN MIX" class="input-djpro w-full">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-djpro-text uppercase tracking-widest ml-1">Sobre Mí (Biografía)</label>
                            <textarea rows="4" placeholder="Cuéntanos tu trayectoria..." class="input-djpro w-full resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Paso 2: Ubicación y Precio (Oculto) -->
                <div class="step-content hidden animate-fade-in" data-step="2">
                    <h3 class="text-2xl font-bebas text-white mb-8 tracking-widest">PASO 2: Ubicación y Tarifas</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-djpro-text uppercase tracking-widest ml-1">Departamento</label>
                            <select class="input-djpro w-full outline-none appearance-none cursor-pointer">
                                <option class="bg-djpro-surface-2">Caquetá</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-djpro-text uppercase tracking-widest ml-1">Ciudad / Municipio</label>
                            <input type="text" placeholder="Ej: Florencia" class="input-djpro w-full">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-djpro-text uppercase tracking-widest ml-1">Precio Base</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-djpro-accent font-bold">$</span>
                                <input type="number" placeholder="450.000" class="input-djpro w-full pl-8">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-djpro-text uppercase tracking-widest ml-1">Tipo de Cobro</label>
                            <select class="input-djpro w-full outline-none appearance-none cursor-pointer">
                                <option class="bg-djpro-surface-2">Por Evento (Cerrado)</option>
                                <option class="bg-djpro-surface-2">Por Hora</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Paso 3: Especialidad (Oculto) -->
                <div class="step-content hidden animate-fade-in" data-step="3">
                    <h3 class="text-2xl font-bebas text-white mb-8 tracking-widest">PASO 3: Géneros y Eventos</h3>
                    
                    <div class="space-y-8">
                        <div>
                            <label class="block text-sm font-bold text-djpro-muted uppercase tracking-widest mb-4">Géneros Musicales (Selecciona los que manejas)</label>
                            <div class="flex flex-wrap gap-3">
                                <?php foreach(['Urbano', 'Electrónica', 'Tropical', 'Popular', 'Rock', 'Jazz', 'Crossover'] as $g): ?>
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="generos[]" value="<?php echo $g; ?>" class="hidden peer">
                                    <div class="px-6 py-2 border border-djpro-border rounded-full text-sm font-bold text-djpro-muted peer-checked:bg-djpro-accent peer-checked:border-djpro-accent peer-checked:text-white transition-all">
                                        <?php echo $g; ?>
                                    </div>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-djpro-muted uppercase tracking-widest mb-4">Tipos de Evento</label>
                            <div class="flex flex-wrap gap-3">
                                <?php foreach(['Bodas', 'Quince Años', 'Corporativos', 'Bares/Clubes', 'Cumpleaños', 'Festivales'] as $e): ?>
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="eventos[]" value="<?php echo $e; ?>" class="hidden peer">
                                    <div class="px-6 py-2 border border-djpro-border rounded-full text-sm font-bold text-djpro-muted peer-checked:bg-djpro-purple peer-checked:border-djpro-purple peer-checked:text-white transition-all">
                                        <?php echo $e; ?>
                                    </div>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paso 4: Videos (Oculto) -->
                <div class="step-content hidden animate-fade-in" data-step="4">
                    <h3 class="text-2xl font-bebas text-white mb-8 tracking-widest">PASO 4: Tu Showcase (YouTube)</h3>
                    
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="flex-1 relative">
                                <i class="bi bi-youtube absolute left-4 top-1/2 -translate-y-1/2 text-red-500"></i>
                                <input type="url" placeholder="Pega el link de YouTube aquí..." class="input-djpro w-full pl-12">
                            </div>
                            <button type="button" class="bg-djpro-surface-2 border border-djpro-border text-white px-6 py-3 rounded-xl hover:border-djpro-accent transition-all font-bold">AGREGAR</button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="video-preview-list">
                            <p class="col-span-full text-center text-djpro-muted py-8 italic border-2 border-dashed border-djpro-border rounded-2xl">Aún no has agregado videos.</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center mt-12 pt-8 border-t border-djpro-border">
                    <button type="button" id="prev-btn" class="text-djpro-muted font-bold hover:text-white transition-all invisible">
                        <i class="bi bi-chevron-left mr-2"></i> ANTERIOR
                    </button>
                    
                    <button type="button" id="next-btn" class="btn-djpro-primary px-10 py-4 flex items-center gap-3">
                        SIGUIENTE <i class="bi bi-chevron-right"></i>
                    </button>
                </div>

            </form>

        </div>
    </div>
</section>

<script>
    let currentStep = 1;
    const totalSteps = 4;
    const nextBtn = document.getElementById('next-btn');
    const prevBtn = document.getElementById('prev-btn');
    const progressBar = document.getElementById('progress-bar');
    const stepDots = document.querySelectorAll('.step-dot');
    const stepContents = document.querySelectorAll('.step-content');

    function updateStepper() {
        // Update dots
        stepDots.forEach((dot, index) => {
            const circle = dot.querySelector('div');
            const span = dot.querySelector('span');
            if (index + 1 < currentStep) {
                circle.classList.add('bg-djpro-accent', 'border-djpro-accent', 'text-white');
                circle.innerHTML = '<i class="bi bi-check-lg"></i>';
                span.classList.add('text-djpro-accent');
            } else if (index + 1 === currentStep) {
                circle.classList.add('border-djpro-accent', 'text-white', 'shadow-[0_0_15px_rgba(249,115,22,0.4)]');
                circle.classList.remove('text-djpro-muted', 'bg-djpro-accent');
                circle.innerHTML = index + 1;
                span.classList.add('text-white');
                span.classList.remove('text-djpro-accent');
            } else {
                circle.classList.remove('bg-djpro-accent', 'border-djpro-accent', 'text-white', 'shadow-[0_0_15px_rgba(249,115,22,0.4)]');
                circle.classList.add('text-djpro-muted');
                circle.innerHTML = index + 1;
                span.classList.remove('text-white', 'text-djpro-accent');
            }
        });

        // Update Progress Bar
        const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
        progressBar.style.width = `${progress}%`;

        // Update Visibility
        stepContents.forEach(content => {
            content.classList.add('hidden');
            if (parseInt(content.dataset.step) === currentStep) {
                content.classList.remove('hidden');
            }
        });

        // Update Buttons
        prevBtn.classList.toggle('invisible', currentStep === 1);
        if (currentStep === totalSteps) {
            nextBtn.innerHTML = 'FINALIZAR PERFIL <i class="bi bi-check-circle-fill ml-2"></i>';
        } else {
            nextBtn.innerHTML = 'SIGUIENTE <i class="bi bi-chevron-right ml-2"></i>';
        }
    }

    nextBtn.addEventListener('click', () => {
        if (currentStep < totalSteps) {
            currentStep++;
            updateStepper();
        } else {
            alert('¡Perfil completado con éxito!');
            window.location.href = '<?php echo URL_ROOT; ?>/djs/dashboard';
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentStep > 1) {
            currentStep--;
            updateStepper();
        }
    });

    // Init
    updateStepper();
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

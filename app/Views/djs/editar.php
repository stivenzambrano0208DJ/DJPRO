<?php require APPROOT . '/app/Views/inc/header.php'; ?>
<?php require APPROOT . '/app/Views/inc/sidebar_dj.php'; ?>

<div class="lg:ml-64 p-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-4xl font-bebas text-white tracking-widest uppercase">EDITAR <span class="text-djpro-accent">MI PERFIL</span></h1>
                <p class="text-djpro-muted tracking-wide font-medium">Mantén tu información actualizada para atraer más clientes.</p>
            </div>
            <a href="<?php echo URL_ROOT; ?>/djs/dashboard" class="text-djpro-muted hover:text-white transition-all font-bold text-sm flex items-center gap-2">
                <i class="bi bi-arrow-left"></i> VOLVER AL PANEL
            </a>
        </div>

        <?php if(!empty($data['success'])): ?>
            <div class="bg-djpro-success/10 border border-djpro-success/20 text-djpro-success p-4 rounded-xl mb-8 flex items-center gap-3">
                <i class="bi bi-check-circle-fill"></i>
                <span class="font-bold text-sm tracking-wide uppercase"><?php echo $data['success']; ?></span>
            </div>
        <?php endif; ?>

        <div class="bg-djpro-surface rounded-3xl border border-djpro-border p-8 md:p-12 shadow-2xl">
            <form action="<?php echo URL_ROOT; ?>/djs/editar" method="POST" enctype="multipart/form-data" class="space-y-10">
                <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
                
                <!-- Identidad Visual -->
                <div class="flex flex-col items-center justify-center space-y-6 pb-10 border-b border-djpro-border/50">
                    <div class="relative group">
                        <div class="w-36 h-36 rounded-full border-4 border-djpro-accent p-1 shadow-[0_0_30px_rgba(249,115,22,0.15)] overflow-hidden transition-transform duration-500 group-hover:scale-105">
                            <?php if($data['perfil']->foto_perfil != 'default_dj.png'): ?>
                                <img id="img-preview" src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $data['perfil']->foto_perfil; ?>" class="w-full h-full rounded-full object-cover">
                            <?php else: ?>
                                <img id="img-preview" src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['usuario_nombre']); ?>&background=12121a&color=f97316" class="w-full h-full rounded-full object-cover">
                            <?php endif; ?>
                        </div>
                        <label class="absolute bottom-1 right-1 w-11 h-11 bg-djpro-accent text-white rounded-full flex items-center justify-center cursor-pointer hover:scale-110 active:scale-95 transition-all border-4 border-djpro-surface shadow-xl">
                            <i class="bi bi-camera-fill text-lg"></i>
                            <input type="file" name="foto_perfil" id="foto-input" class="hidden" accept="image/*">
                        </label>
                    </div>

                    <div class="max-w-xs w-full space-y-3">
                        <label class="text-[10px] font-bold text-white uppercase tracking-[0.2em] flex items-center justify-center gap-2">
                            <i class="bi bi-person-badge"></i> Nombre de Usuario (URL Pública)
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-djpro-muted font-bold">@</span>
                            <input type="text" name="username" value="<?php echo $data['perfil']->username; ?>" 
                                placeholder="tu_nombre_dj" 
                                class="input-djpro w-full pl-10 text-center border-djpro-accent/30 font-bold tracking-wider focus:border-djpro-accent" 
                                required pattern="[a-zA-Z0-9_]+" 
                                title="Solo letras, números y guiones bajos (sin espacios ni emojis)">
                        </div>
                        <p class="text-[9px] text-djpro-muted text-center font-bold uppercase tracking-tight opacity-70">Sin espacios, sin emojis. Solo letras, números y guiones bajos.</p>
                    </div>
                </div>

                <!-- Información Profesional Principal -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                    
                    <!-- Columna Izquierda: Bio y Ubicación -->
                    <div class="lg:col-span-7 space-y-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1 flex items-center gap-2">
                                    <i class="bi bi-map text-djpro-accent"></i> Departamento
                                </label>
                                <select id="select-departamento" name="departamento" class="input-djpro w-full cursor-pointer outline-none">
                                    <option value="<?php echo $data['perfil']->departamento; ?>"><?php echo $data['perfil']->departamento ?: 'Seleccionar Departamento'; ?></option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1 flex items-center gap-2">
                                    <i class="bi bi-geo-alt text-djpro-accent"></i> Ciudad / Municipio
                                </label>
                                <select id="select-ciudad" name="ciudad" class="input-djpro w-full cursor-pointer outline-none">
                                    <option value="<?php echo $data['perfil']->ciudad; ?>"><?php echo $data['perfil']->ciudad ?: 'Seleccionar Ciudad'; ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1 flex items-center gap-2">
                                <i class="bi bi-card-text text-djpro-accent"></i> Biografía Profesional
                            </label>
                            <textarea name="biografia" rows="8" placeholder="Cuéntale a tus clientes sobre tu trayectoria..." class="input-djpro w-full resize-none leading-relaxed"><?php echo $data['perfil']->biografia; ?></textarea>
                            <p class="text-[10px] text-djpro-muted font-bold uppercase tracking-tighter opacity-60">Describe tu estilo, equipo y trayectoria musical.</p>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1 flex items-center gap-2">
                                <i class="bi bi-geo-fill text-djpro-accent"></i> Cobertura de Trabajo
                            </label>
                            <div id="municipios-container" class="grid grid-cols-2 sm:grid-cols-3 gap-3 bg-djpro-surface-2 p-6 rounded-2xl border border-djpro-border max-h-48 overflow-y-auto custom-scrollbar">
                                <p class="text-djpro-muted text-[10px] uppercase font-bold col-span-full opacity-50">Selecciona un departamento para ver municipios...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Columna Derecha: Precio, Géneros y Eventos -->
                    <div class="lg:col-span-5 space-y-10">
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1 flex items-center gap-2">
                                <i class="bi bi-currency-dollar text-djpro-accent"></i> Tarifa por Hora
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-djpro-muted font-bold">$</span>
                                <input type="number" name="precio_hora" value="<?php echo $data['perfil']->precio_hora; ?>" placeholder="Ej: 150000" class="input-djpro w-full pl-8 font-bebas text-xl tracking-widest">
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-4">
                                <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1 flex items-center gap-2">
                                    <i class="bi bi-music-note-beamed text-djpro-accent"></i> Géneros Musicales
                                </label>
                                <div class="grid grid-cols-2 gap-2 bg-djpro-surface-2 p-5 rounded-2xl border border-djpro-border">
                                    <?php 
                                    $generos_actuales = explode(',', $data['perfil']->generos_ids ?? '');
                                    foreach($data['generos_lista'] as $gen): 
                                    ?>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <div class="relative flex items-center">
                                            <input type="checkbox" name="generos[]" value="<?php echo $gen->id; ?>" class="peer hidden" <?php echo in_array($gen->id, $generos_actuales) ? 'checked' : ''; ?>>
                                            <div class="w-4 h-4 border-2 border-djpro-border rounded peer-checked:bg-djpro-accent peer-checked:border-djpro-accent transition-all"></div>
                                            <i class="bi bi-check absolute text-white text-xs opacity-0 peer-checked:opacity-100 left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2"></i>
                                        </div>
                                        <span class="text-[10px] font-bold text-djpro-muted group-hover:text-white uppercase tracking-tight transition-colors"><?php echo $gen->nombre; ?></span>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <label class="text-[10px] font-bold text-white uppercase tracking-widest ml-1 flex items-center gap-2">
                                    <i class="bi bi-calendar-event text-djpro-purple"></i> Tipos de Evento
                                </label>
                                <div class="grid grid-cols-2 gap-2 bg-djpro-surface-2 p-5 rounded-2xl border border-djpro-border">
                                    <?php 
                                    $eventos_actuales = explode(',', $data['perfil']->eventos_ids ?? '');
                                    foreach($data['tipos_evento_lista'] as $ev): 
                                    ?>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <div class="relative flex items-center">
                                            <input type="checkbox" name="eventos[]" value="<?php echo $ev->id; ?>" class="peer hidden" <?php echo in_array($ev->id, $eventos_actuales) ? 'checked' : ''; ?>>
                                            <div class="w-4 h-4 border-2 border-djpro-border rounded peer-checked:bg-djpro-purple peer-checked:border-djpro-purple transition-all"></div>
                                            <i class="bi bi-check absolute text-white text-xs opacity-0 peer-checked:opacity-100 left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2"></i>
                                        </div>
                                        <span class="text-[10px] font-bold text-djpro-muted group-hover:text-white uppercase tracking-tight transition-colors"><?php echo $ev->nombre; ?></span>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bot Auto-respuesta (Full Width al Final) -->
                <div class="bg-gradient-to-r from-djpro-surface-2 to-djpro-surface p-8 rounded-3xl border border-djpro-border shadow-inner">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-djpro-accent/10 text-djpro-accent rounded-xl flex items-center justify-center text-2xl">
                                <i class="bi bi-robot"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bebas text-white tracking-widest uppercase">Bot de Auto-respuesta</h3>
                                <p class="text-[10px] text-djpro-muted font-bold uppercase tracking-widest">Responde automáticamente a tus clientes</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="bot_activo" class="sr-only peer" <?php echo ($data['perfil']->bot_activo == 1) ? 'checked' : ''; ?>>
                            <div class="w-14 h-7 bg-djpro-surface border border-djpro-border peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-djpro-muted peer-checked:after:bg-djpro-accent after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-djpro-accent/20"></div>
                        </label>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest ml-1">Mensaje de Auto-respuesta</label>
                        <textarea name="auto_respuesta" rows="3" placeholder="Ej: Hola! Gracias por escribirme. En un momento te responderé..." class="input-djpro w-full resize-none"><?php echo $data['perfil']->auto_respuesta; ?></textarea>
                        <p class="text-[9px] text-djpro-muted font-bold uppercase tracking-tighter">Este mensaje se enviará automáticamente cuando un cliente te escriba por primera vez.</p>
                    </div>
                </div>



                <!-- Galería de Videos -->
                <div class="bg-djpro-surface-2 p-8 rounded-3xl border border-djpro-border">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-xl font-bebas text-white tracking-widest uppercase">Mi Galería de Videos</h3>
                            <p class="text-[10px] text-djpro-muted font-bold uppercase tracking-widest">Añade links de YouTube para mostrar tu trabajo</p>
                        </div>
                        <button type="button" class="bg-djpro-accent hover:bg-orange-600 text-white px-4 py-2 rounded-xl font-bold text-xs transition-all flex items-center gap-2" onclick="openModal()">
                            <i class="bi bi-plus-lg"></i> AÑADIR VIDEO
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php if(empty($data['videos'])): ?>
                            <div class="col-span-full text-center py-10 border-2 border-dashed border-djpro-border rounded-2xl">
                                <i class="bi bi-play-circle text-4xl text-djpro-muted mb-3 block"></i>
                                <p class="text-xs text-djpro-muted font-bold uppercase tracking-widest">No has añadido videos aún</p>
                            </div>
                        <?php else: ?>
                            <?php foreach($data['videos'] as $video): ?>
                            <div class="group relative rounded-xl overflow-hidden border border-djpro-border bg-djpro-surface">
                                <?php 
                                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video->url_video, $match);
                                    $youtube_id = $match[1] ?? '';
                                ?>
                                <img src="https://img.youtube.com/vi/<?php echo $youtube_id; ?>/mqdefault.jpg" class="w-full h-32 object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                    <i class="bi bi-play-fill text-4xl text-white"></i>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-djpro-surface/90 p-3 backdrop-blur-md border-t border-djpro-border flex justify-between items-center">
                                    <span class="text-[10px] font-bold text-white truncate w-4/5 uppercase tracking-widest"><?php echo $video->titulo; ?></span>
                                    <form id="delete-video-form-<?php echo $video->id; ?>" action="<?php echo URL_ROOT; ?>/djs/eliminar_video/<?php echo $video->id; ?>" method="POST" class="inline">
                                        <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
                                        <input type="hidden" name="from" value="editar">
                                        <button type="button" onclick="confirmDeleteForm('delete-video-form-<?php echo $video->id; ?>', '¿Eliminar video?')" class="text-red-400 hover:text-red-500 transition-colors">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="pt-6 border-t border-djpro-border flex justify-end">
                    <button type="submit" class="btn-djpro-primary px-12 py-4 text-lg">
                        GUARDAR CAMBIOS <i class="bi bi-save2 ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // 1. Vista previa de imagen
    const fotoInput = document.getElementById('foto-input');
    const imgPreview = document.getElementById('img-preview');

    fotoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // 2. Selects de Colombia (API)
    const selectDept = document.getElementById('select-departamento');
    const selectCity = document.getElementById('select-ciudad');

    // Cargar Departamentos
    fetch('https://api-colombia.com/api/v1/Department')
        .then(res => res.json())
        .then(depts => {
            depts.sort((a, b) => a.name.localeCompare(b.name)).forEach(dept => {
                const option = document.createElement('option');
                option.value = dept.name;
                option.dataset.id = dept.id;
                option.textContent = dept.name;
                if(dept.name === "<?php echo $data['perfil']->departamento; ?>") option.selected = true;
                selectDept.appendChild(option);
            });
        });

    // Cargar Ciudades al cambiar departamento
    selectDept.addEventListener('change', function() {
        const deptId = this.options[this.selectedIndex].dataset.id;
        if (!deptId) return;

        selectCity.innerHTML = '<option value="">Cargando municipios...</option>';
        const municipiosContainer = document.getElementById('municipios-container');
        municipiosContainer.innerHTML = '<p class="text-djpro-muted text-[10px] uppercase font-bold col-span-full animate-pulse">Cargando municipios...</p>';

        fetch(`https://api-colombia.com/api/v1/Department/${deptId}/cities`)
            .then(res => res.json())
            .then(cities => {
                // Actualizar Select de Ciudad (Ubicación actual)
                selectCity.innerHTML = '<option value="">Seleccionar Ciudad</option>';
                
                // Limpiar Contenedor de Checkboxes
                municipiosContainer.innerHTML = '';
                
                // Obtener municipios ya guardados
                const guardados = "<?php echo $data['perfil']->lugares_trabajo; ?>".split(',').map(s => s.trim());

                cities.sort((a, b) => a.name.localeCompare(b.name)).forEach(city => {
                    // Llenar Select
                    const option = document.createElement('option');
                    option.value = city.name;
                    option.textContent = city.name;
                    if(city.name === "<?php echo $data['perfil']->ciudad; ?>") option.selected = true;
                    selectCity.appendChild(option);

                    // Crear Checkbox para Lugares de Trabajo
                    const isChecked = guardados.includes(city.name) ? 'checked' : '';
                    const checkboxHtml = `
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative flex items-center">
                                <input type="checkbox" name="lugares_trabajo[]" value="${city.name}" class="peer hidden" ${isChecked}>
                                <div class="w-4 h-4 border-2 border-djpro-border rounded-md peer-checked:bg-djpro-accent peer-checked:border-djpro-accent transition-all"></div>
                                <i class="bi bi-check absolute text-white text-xs opacity-0 peer-checked:opacity-100 left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2"></i>
                            </div>
                            <span class="text-[10px] font-bold text-djpro-muted group-hover:text-white uppercase tracking-wider transition-colors">${city.name}</span>
                        </label>
                    `;
                    municipiosContainer.insertAdjacentHTML('beforeend', checkboxHtml);
                });
            });
    });

    // Cargar ciudades iniciales si hay departamento seleccionado
    window.addEventListener('load', () => {
        setTimeout(() => {
            if (selectDept.value) {
                selectDept.dispatchEvent(new Event('change'));
            }
        }, 1000);
    });

    // Funciones del Modal de Video
    function openModal() {
        document.getElementById('modalVideo').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('modalVideo').classList.add('hidden');
    }
</script>

<!-- Modal Añadir Video -->
<div id="modalVideo" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-djpro-bg/80 backdrop-blur-sm hidden">
    <div class="bg-djpro-surface w-full max-w-md rounded-3xl border border-djpro-border shadow-2xl overflow-hidden">
        <div class="p-6 border-b border-djpro-border flex justify-between items-center bg-djpro-surface-2/50">
            <h5 class="text-xl font-bebas text-white tracking-widest uppercase">Añadir Video</h5>
            <button onclick="closeModal()" class="text-djpro-muted hover:text-white transition-all text-xl"><i class="bi bi-x-lg"></i></button>
        </div>
        <form action="<?php echo URL_ROOT; ?>/djs/agregar_video" method="POST" class="p-6 space-y-6">
            <input type="hidden" name="from" value="editar">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Título del Video</label>
                <input type="text" name="titulo" placeholder="Ej: Festival Electrónica 2024" class="input-djpro w-full" required>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">URL de YouTube</label>
                <input type="url" name="url_video" placeholder="https://www.youtube.com/watch?v=..." class="input-djpro w-full" required>
                <p class="text-[9px] text-djpro-muted font-bold uppercase tracking-tighter">Copia el enlace completo del video.</p>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeModal()" class="flex-1 px-6 py-3 border border-djpro-border text-djpro-muted font-bold rounded-xl hover:text-white transition-all">CANCELAR</button>
                <button type="submit" class="flex-1 btn-djpro-primary">AGREGAR</button>
            </div>
        </form>
    </div>
</div>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>


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
                
                <!-- Foto de Perfil -->
                <div class="flex flex-col items-center">
                    <div class="relative group">
                        <div class="w-32 h-32 rounded-full border-4 border-djpro-accent p-1 shadow-[0_0_20px_rgba(249,115,22,0.2)] overflow-hidden">
                            <?php if($data['perfil']->foto_perfil != 'default_dj.png'): ?>
                                <img id="img-preview" src="<?php echo URL_ROOT; ?>/assets/uploads/<?php echo $data['perfil']->foto_perfil; ?>" class="w-full h-full rounded-full object-cover">
                            <?php else: ?>
                                <img id="img-preview" src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['usuario_nombre']); ?>&background=12121a&color=f97316" class="w-full h-full rounded-full object-cover">
                            <?php endif; ?>
                        </div>
                        <label class="absolute bottom-0 right-0 w-10 h-10 bg-djpro-accent text-white rounded-full flex items-center justify-center cursor-pointer hover:scale-110 transition-all border-2 border-djpro-surface">
                            <i class="bi bi-camera-fill"></i>
                            <input type="file" name="foto_perfil" id="foto-input" class="hidden" accept="image/*">
                        </label>
                    </div>
                    <span class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest mt-4">Foto de Perfil</span>
                </div>

                <!-- Ubicación -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Departamento</label>
                        <select id="select-departamento" name="departamento" class="input-djpro w-full cursor-pointer outline-none">
                            <option value="<?php echo $data['perfil']->departamento; ?>"><?php echo $data['perfil']->departamento ?: 'Seleccionar Departamento'; ?></option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Ciudad / Municipio</label>
                        <select id="select-ciudad" name="ciudad" class="input-djpro w-full cursor-pointer outline-none">
                            <option value="<?php echo $data['perfil']->ciudad; ?>"><?php echo $data['perfil']->ciudad ?: 'Seleccionar Ciudad'; ?></option>
                        </select>
                    </div>
                </div>

                <!-- Biografía -->
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1">Biografía Profesional</label>
                    <textarea name="biografia" rows="6" class="input-djpro w-full resize-none"><?php echo $data['perfil']->biografia; ?></textarea>
                    <p class="text-[10px] text-djpro-muted uppercase font-bold tracking-tighter">Describe tu estilo, equipo y trayectoria musical.</p>
                </div>

                <!-- Lugares de Trabajo (Municipios Dinámicos) -->
                <div class="space-y-4">
                    <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1 block">Municipios donde has trabajado</label>
                    <div id="municipios-container" class="grid grid-cols-2 md:grid-cols-4 gap-3 bg-djpro-surface-2 p-6 rounded-2xl border border-djpro-border max-h-60 overflow-y-auto custom-scrollbar">
                        <p class="text-djpro-muted text-[10px] uppercase font-bold col-span-full">Selecciona un departamento para ver los municipios...</p>
                    </div>
                    <p class="text-[10px] text-djpro-muted uppercase font-bold tracking-tighter">Selecciona todos los municipios donde ofreces tus servicios.</p>
                </div>

                <!-- Géneros y Eventos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1 mb-4 block">Géneros Musicales</label>
                        <div class="grid grid-cols-2 gap-3 bg-djpro-surface-2 p-6 rounded-2xl border border-djpro-border">
                            <?php 
                            $generos_actuales = explode(',', $data['perfil']->generos);
                            foreach($data['generos_lista'] as $gen): 
                            ?>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative flex items-center">
                                    <input type="checkbox" name="generos[]" value="<?php echo $gen->nombre; ?>" class="peer hidden" <?php echo in_array($gen->nombre, $generos_actuales) ? 'checked' : ''; ?>>
                                    <div class="w-5 h-5 border-2 border-djpro-border rounded-md peer-checked:bg-djpro-accent peer-checked:border-djpro-accent transition-all"></div>
                                    <i class="bi bi-check absolute text-white text-sm opacity-0 peer-checked:opacity-100 left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2"></i>
                                </div>
                                <span class="text-[11px] font-bold text-djpro-muted group-hover:text-white uppercase tracking-wider transition-colors"><?php echo $gen->nombre; ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-djpro-text uppercase tracking-widest ml-1 mb-4 block">Tipos de Evento</label>
                        <div class="grid grid-cols-2 gap-3 bg-djpro-surface-2 p-6 rounded-2xl border border-djpro-border">
                            <?php 
                            $eventos_actuales = explode(',', $data['perfil']->tipos_evento);
                            foreach($data['tipos_evento_lista'] as $ev): 
                            ?>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative flex items-center">
                                    <input type="checkbox" name="eventos[]" value="<?php echo $ev->nombre; ?>" class="peer hidden" <?php echo in_array($ev->nombre, $eventos_actuales) ? 'checked' : ''; ?>>
                                    <div class="w-5 h-5 border-2 border-djpro-border rounded-md peer-checked:bg-djpro-purple peer-checked:border-djpro-purple transition-all"></div>
                                    <i class="bi bi-check absolute text-white text-sm opacity-0 peer-checked:opacity-100 left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2"></i>
                                </div>
                                <span class="text-[11px] font-bold text-djpro-muted group-hover:text-white uppercase tracking-wider transition-colors"><?php echo $ev->nombre; ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
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
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>


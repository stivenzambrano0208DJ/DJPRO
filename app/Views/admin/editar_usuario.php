<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<div class="flex">
    <!-- Sidebar Admin -->
    <aside class="w-64 bg-djpro-surface border-r border-djpro-border h-[calc(100vh-80px)] hidden lg:block">
        <div class="p-6">
            <h2 class="text-xl font-bebas text-djpro-accent tracking-widest mb-10 uppercase">Admin Panel</h2>
            <nav class="space-y-4">
                <a href="<?php echo URL_ROOT; ?>/admin/dashboard" class="flex items-center gap-3 text-djpro-muted hover:text-white px-4 py-3 transition-all">
                    <i class="bi bi-speedometer2"></i> Global KPI
                </a>
                <a href="<?php echo URL_ROOT; ?>/admin/usuarios" class="flex items-center gap-3 text-white font-bold px-4 py-3 bg-djpro-accent/10 border-l-4 border-djpro-accent rounded-r-xl">
                    <i class="bi bi-people"></i> Usuarios
                </a>
                <a href="<?php echo URL_ROOT; ?>/admin/reservas" class="flex items-center gap-3 text-djpro-muted hover:text-white px-4 py-3 transition-all">
                    <i class="bi bi-calendar-check"></i> Reservas
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto custom-scrollbar h-[calc(100vh-80px)]">
        <div class="container max-w-2xl mx-auto">
            <a href="<?php echo URL_ROOT; ?>/admin/usuarios" class="text-djpro-muted hover:text-djpro-accent mb-6 inline-flex items-center gap-2 transition-colors">
                <i class="bi bi-arrow-left"></i> Volver a Usuarios
            </a>
            
            <h1 class="text-4xl font-bebas text-white tracking-widest mb-10">EDITAR <span class="text-djpro-accent">USUARIO</span></h1>

            <div class="bg-djpro-surface p-8 rounded-3xl border border-djpro-border shadow-2xl">
                <form action="<?php echo URL_ROOT; ?>/admin/editar_usuario/<?php echo $data['usuario']->id; ?>" method="POST" class="space-y-6">
                    
                    <div>
                        <label class="block text-[10px] font-bold text-djpro-muted uppercase tracking-widest mb-2">Nombre Completo</label>
                        <input type="text" name="nombre" value="<?php echo $data['usuario']->nombre; ?>" required
                               class="w-full bg-djpro-bg border border-djpro-border rounded-xl px-4 py-3 text-white focus:border-djpro-accent outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-djpro-muted uppercase tracking-widest mb-2">Correo Electrónico</label>
                        <input type="email" name="correo" value="<?php echo $data['usuario']->correo; ?>" required
                               class="w-full bg-djpro-bg border border-djpro-border rounded-xl px-4 py-3 text-white focus:border-djpro-accent outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-djpro-muted uppercase tracking-widest mb-2">Rol del Usuario</label>
                        <select name="rol" class="w-full bg-djpro-bg border border-djpro-border rounded-xl px-4 py-3 text-white focus:border-djpro-accent outline-none transition-all">
                            <option value="cliente" <?php echo $data['usuario']->rol == 'cliente' ? 'selected' : ''; ?>>Cliente</option>
                            <option value="dj" <?php echo $data['usuario']->rol == 'dj' ? 'selected' : ''; ?>>DJ</option>
                            <option value="admin" <?php echo $data['usuario']->rol == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-djpro-accent hover:bg-orange-600 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-orange-500/20 uppercase tracking-widest">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

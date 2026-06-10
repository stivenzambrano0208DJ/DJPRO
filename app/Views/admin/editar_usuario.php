<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<div class="flex">
<?php 
    $activePage = 'usuarios';
    require APPROOT . '/app/Views/inc/admin_sidebar.php'; 
?>

    <!-- Main Content -->
    <div class="flex-1 p-8 overflow-y-auto custom-scrollbar h-[calc(100vh-80px)]">
        <div class="container max-w-2xl mx-auto">
            <a href="<?php echo URL_ROOT; ?>/admin/usuarios" class="text-djpro-muted hover:text-djpro-accent mb-6 inline-flex items-center gap-2 transition-colors">
                <i class="bi bi-arrow-left"></i> Volver a Usuarios
            </a>
            
            <h1 class="text-4xl font-bebas text-white tracking-widest mb-10">EDITAR <span class="text-djpro-accent">USUARIO</span></h1>

            <div class="bg-djpro-surface p-8 rounded-3xl border border-djpro-border shadow-2xl">
                <form action="<?php echo URL_ROOT; ?>/admin/editar_usuario/<?php echo $data['usuario']->id; ?>" method="POST" class="space-y-6">
                    <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
                    
                    <div>
                        <label class="block text-[10px] font-bold text-djpro-accent uppercase tracking-widest mb-2 ml-1">Nombre Completo</label>
                        <input type="text" name="nombre" maxlength="30" value="<?php echo $data['usuario']->nombre; ?>" required
                               class="input-djpro w-full border-djpro-accent/30 outline-none">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-djpro-accent uppercase tracking-widest mb-2 ml-1">Correo Electrónico</label>
                        <input type="email" name="correo" maxlength="30" value="<?php echo $data['usuario']->correo; ?>" required
                               class="input-djpro w-full border-djpro-accent/30 outline-none">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-djpro-accent uppercase tracking-widest mb-2 ml-1">Rol del Usuario</label>
                        <select name="rol" class="input-djpro w-full border-djpro-accent/30 outline-none cursor-pointer">
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
    </div>
</div>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

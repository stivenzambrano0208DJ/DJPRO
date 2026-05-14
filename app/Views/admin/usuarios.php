<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<div class="flex">
<?php 
    $activePage = 'usuarios';
    require APPROOT . '/app/Views/inc/admin_sidebar.php'; 
?>

    <!-- Main Content -->
    <div class="flex-1 p-8 overflow-y-auto custom-scrollbar h-[calc(100vh-80px)]">
        <div class="container mx-auto">
            <h1 class="text-4xl font-bebas text-white tracking-widest mb-10">GESTIÓN DE <span class="text-djpro-accent">USUARIOS</span></h1>

            <div class="bg-djpro-surface rounded-2xl border border-djpro-border overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-djpro-surface-2">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-djpro-muted uppercase tracking-widest">Nombre</th>
                            <th class="px-6 py-4 text-xs font-bold text-djpro-muted uppercase tracking-widest">Correo</th>
                            <th class="px-6 py-4 text-xs font-bold text-djpro-muted uppercase tracking-widest">Rol</th>
                            <th class="px-6 py-4 text-xs font-bold text-djpro-muted uppercase tracking-widest">Registro</th>
                            <th class="px-6 py-4 text-xs font-bold text-djpro-muted uppercase tracking-widest text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-djpro-border">
                        <?php foreach($data['usuarios'] as $user): ?>
                        <tr class="hover:bg-djpro-surface-2/30 transition-colors">
                            <td class="px-6 py-4 font-bold text-white flex items-center gap-2">
                                <?php echo $user->nombre; ?>
                                <?php if($user->verificado): ?>
                                    <i class="bi bi-patch-check-fill text-djpro-accent" title="Usuario Verificado"></i>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-djpro-muted"><?php echo $user->correo; ?></td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest <?php echo $user->rol == 'dj' ? 'bg-orange-500/10 text-orange-500' : 'bg-purple-500/10 text-purple-500'; ?>">
                                    <?php echo $user->rol; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-djpro-muted"><?php echo date('d M, Y', strtotime($user->fecha_registro)); ?></td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-4">
                                    <?php if($user->rol == 'dj'): ?>
                                        <form action="<?php echo URL_ROOT; ?>/admin/<?php echo $user->verificado ? 'desverificar_dj' : 'verificar_dj'; ?>/<?php echo $user->id; ?>" method="POST">
                                            <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
                                            <button type="submit" class="<?php echo $user->verificado ? 'text-djpro-muted' : 'text-green-500'; ?> hover:text-white transition-all" title="<?php echo $user->verificado ? 'Quitar verificación' : 'Verificar DJ'; ?>">
                                                <i class="bi <?php echo $user->verificado ? 'bi-patch-minus' : 'bi-patch-check'; ?>"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    
                                    <a href="<?php echo URL_ROOT; ?>/admin/editar_usuario/<?php echo $user->id; ?>" class="text-djpro-accent hover:text-orange-400">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <?php if($user->id != $_SESSION['usuario_id']): ?>
                                    <form id="delete-user-<?php echo $user->id; ?>" action="<?php echo URL_ROOT; ?>/admin/eliminar_usuario/<?php echo $user->id; ?>" method="POST" class="inline">
                                        <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
                                        <button type="button" onclick="confirmDeleteForm('delete-user-<?php echo $user->id; ?>', '¿Estás seguro de eliminar al usuario <?php echo $user->nombre; ?>?')" class="text-red-500 hover:text-red-400 transition-colors">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

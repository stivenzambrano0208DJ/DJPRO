<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<div class="flex">
<?php 
    $activePage = 'resenas';
    require APPROOT . '/app/Views/inc/admin_sidebar.php'; 
?>

    <!-- Main Content -->
    <div class="flex-1 p-8 overflow-y-auto custom-scrollbar h-[calc(100vh-80px)]">
        <div class="container mx-auto">
            <h1 class="text-4xl font-bebas text-white tracking-widest mb-10">MODERACIÓN DE <span class="text-djpro-accent">RESEÑAS</span></h1>

            <?php if(empty($data['resenas'])): ?>
                <div class="bg-djpro-surface p-20 rounded-3xl border border-djpro-border text-center">
                    <i class="bi bi-chat-left-text text-5xl text-djpro-muted mb-4 block"></i>
                    <p class="text-djpro-muted font-bold uppercase tracking-widest">No hay reseñas registradas aún.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 gap-4">
                    <?php foreach($data['resenas'] as $resena): ?>
                    <div class="bg-djpro-surface p-6 rounded-2xl border border-djpro-border flex flex-col md:flex-row justify-between items-center gap-6">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="flex text-yellow-500 text-xs">
                                    <?php for($i=0; $i<5; $i++): ?>
                                        <i class="bi bi-star<?php echo ($i < $resena->puntuacion) ? '-fill' : ''; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="text-[10px] text-djpro-muted font-bold uppercase tracking-widest"><?php echo date('d M, Y', strtotime($resena->fecha_creacion)); ?></span>
                            </div>
                            <p class="text-white text-sm italic mb-4">"<?php echo $resena->comentario; ?>"</p>
                            <div class="flex items-center gap-4 text-[9px] font-bold uppercase tracking-widest">
                                <span class="text-djpro-muted">De: <span class="text-white"><?php echo $resena->cliente_nombre; ?></span></span>
                                <span class="text-djpro-muted">Para DJ: <span class="text-djpro-accent"><?php echo $resena->dj_nombre; ?></span></span>
                            </div>
                        </div>
                        <div>
                            <form action="<?php echo URL_ROOT; ?>/admin/eliminar_resena/<?php echo $resena->id; ?>" method="POST" onsubmit="return confirm('¿Eliminar esta reseña permanentemente?');">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <button type="submit" class="bg-red-500/10 text-red-500 px-4 py-2 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all">
                                    Eliminar Reseña
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

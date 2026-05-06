<?php require APPROOT . '/app/Views/inc/header.php'; ?>
<?php require APPROOT . '/app/Views/inc/sidebar_cliente.php'; ?>

<div class="lg:ml-64 p-8">
    <div class="container mx-auto">
        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-4xl font-bebas text-white tracking-wider mb-2">LINEUP <span class="text-djpro-purple">BUILDER</span></h1>
            <p class="text-djpro-muted tracking-wide font-medium">Diseña el cronograma musical perfecto para tu evento.</p>
        </div>

        <div class="flex flex-col lg:row lg:flex-row gap-8 h-[calc(100vh-250px)]">
            
            <!-- Panel Izquierdo: Mi Selección (DJs guardados) -->
            <div class="w-full lg:w-1/3 flex flex-col bg-djpro-surface rounded-3xl border border-djpro-border overflow-hidden">
                <div class="p-6 border-b border-djpro-border">
                    <h4 class="text-sm font-bold text-white uppercase tracking-widest mb-1">Mi Selección</h4>
                    <p class="text-[10px] text-djpro-muted uppercase font-bold tracking-tighter">DJs agregados a tu lista</p>
                </div>
                
                <div class="flex-1 overflow-y-auto p-4 space-y-4 custom-scrollbar">
                    <?php for($i=1; $i<=3; $i++): ?>
                    <div class="bg-djpro-surface-2 p-4 rounded-2xl border border-djpro-border group hover:border-djpro-purple transition-all flex items-center gap-4">
                        <img src="https://ui-avatars.com/api/?name=DJ+<?php echo $i; ?>&background=12121a&color=7c3aed" class="w-12 h-12 rounded-xl">
                        <div class="flex-1">
                            <h5 class="text-white font-bold text-sm">DJ STEVEN MIX</h5>
                            <span class="text-[10px] text-djpro-muted font-bold tracking-widest uppercase">Crossover | $450k</span>
                        </div>
                        <button class="w-10 h-10 rounded-xl bg-djpro-purple/10 text-djpro-purple hover:bg-djpro-purple hover:text-white transition-all flex items-center justify-center">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                    <?php endfor; ?>
                    
                    <a href="<?php echo URL_ROOT; ?>/clientes/dashboard" class="block p-4 border-2 border-dashed border-djpro-border rounded-2xl text-center text-djpro-muted hover:border-djpro-accent hover:text-white transition-all">
                        <i class="bi bi-plus-circle mb-1 block text-xl"></i>
                        <span class="text-xs font-bold uppercase tracking-widest">Explorar más DJs</span>
                    </a>
                </div>
            </div>

            <!-- Panel Derecho: Constructor -->
            <div class="flex-1 flex flex-col bg-djpro-surface rounded-3xl border border-djpro-border overflow-hidden">
                <div class="p-8 border-b border-djpro-border">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest ml-1">Nombre del Evento</label>
                            <input type="text" placeholder="Mi Boda Soñada" class="input-djpro w-full">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest ml-1">Fecha del Evento</label>
                            <input type="date" class="input-djpro w-full cursor-pointer">
                        </div>
                    </div>

                    <!-- Timeline Visual -->
                    <div class="space-y-4">
                        <div class="flex justify-between text-[10px] font-bold text-djpro-muted uppercase tracking-widest px-1">
                            <span>08:00 PM</span>
                            <span>10:00 PM</span>
                            <span>12:00 AM</span>
                            <span>02:00 AM</span>
                            <span>04:00 AM</span>
                        </div>
                        <div class="h-10 bg-djpro-surface-2 rounded-xl border border-djpro-border relative overflow-hidden flex">
                            <!-- Segmentos del Lineup -->
                            <div class="h-full bg-djpro-purple/40 border-r border-white/20 flex items-center justify-center text-[10px] font-bold text-white uppercase tracking-tighter" style="width: 30%">STEVEN MIX</div>
                            <div class="h-full bg-orange-500/40 border-r border-white/20 flex items-center justify-center text-[10px] font-bold text-white uppercase tracking-tighter" style="width: 40%">DJ INVITADO</div>
                            <div class="h-full bg-djpro-purple/40 border-r border-white/20 flex items-center justify-center text-[10px] font-bold text-white uppercase tracking-tighter" style="width: 30%">STEVEN MIX</div>
                        </div>
                    </div>
                </div>

                <!-- Lista de DJs Agregados -->
                <div class="flex-1 overflow-y-auto p-8 space-y-4 custom-scrollbar">
                    <h4 class="text-sm font-bold text-djpro-muted uppercase tracking-widest mb-4">Cronograma Detallado</h4>
                    
                    <div class="bg-djpro-surface-2 p-6 rounded-2xl border border-djpro-border flex flex-col md:row md:flex-row items-center gap-6">
                        <div class="flex items-center gap-4 flex-1">
                            <img src="https://ui-avatars.com/api/?name=DJ+1&background=12121a&color=7c3aed" class="w-12 h-12 rounded-xl border border-djpro-border">
                            <div>
                                <h5 class="text-white font-bold tracking-wider">DJ STEVEN MIX</h5>
                                <span class="text-[10px] text-djpro-purple font-bold tracking-widest uppercase">Opening Set</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="space-y-1">
                                <label class="text-[9px] font-bold text-djpro-muted uppercase tracking-tighter ml-1">Inicio</label>
                                <input type="time" value="20:00" class="bg-djpro-surface border border-djpro-border text-white text-xs rounded-lg px-3 py-2 outline-none focus:border-djpro-purple transition-all">
                            </div>
                            <div class="text-djpro-muted"><i class="bi bi-arrow-right"></i></div>
                            <div class="space-y-1">
                                <label class="text-[9px] font-bold text-djpro-muted uppercase tracking-tighter ml-1">Fin</label>
                                <input type="time" value="22:00" class="bg-djpro-surface border border-djpro-border text-white text-xs rounded-lg px-3 py-2 outline-none focus:border-djpro-purple transition-all">
                            </div>
                        </div>
                        <button class="text-red-400 hover:text-red-500 transition-colors p-2"><i class="bi bi-trash3 text-lg"></i></button>
                    </div>
                </div>

                <!-- Footer Summary -->
                <div class="p-8 bg-djpro-surface-2 border-t border-djpro-border flex flex-col md:row md:flex-row justify-between items-center gap-6">
                    <div class="text-center md:text-left">
                        <span class="text-[10px] font-bold text-djpro-muted uppercase tracking-widest block mb-1">Precio Total Estimado</span>
                        <span class="text-3xl font-bebas text-white tracking-widest">$900.000 <span class="text-djpro-muted text-xs font-sans font-normal uppercase tracking-tighter">COP</span></span>
                    </div>
                    <button class="btn-djpro-primary px-12 py-5 text-xl tracking-widest w-full md:w-auto">
                        CONFIRMAR LINEUP <i class="bi bi-check-all ml-2"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

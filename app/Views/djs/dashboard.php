<?php require APPROOT . '/app/Views/inc/header.php'; ?>
<?php require APPROOT . '/app/Views/inc/sidebar_dj.php'; ?>

<div class="lg:ml-64 p-8">
    <div class="container mx-auto">
        <!-- Header del Dashboard -->
        <div class="flex flex-col md:row md:flex-row justify-between items-start md:items-center gap-4 mb-10">
            <div>
                <h1 class="text-4xl font-bebas text-white tracking-wider">¡HOLA, <span class="text-djpro-accent">STEVEN MIX</span>!</h1>
                <p class="text-djpro-muted tracking-wide font-medium">Aquí tienes un resumen de tu actividad reciente.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-djpro-surface-2 border border-djpro-border px-4 py-2 rounded-xl flex items-center gap-3">
                    <span class="text-xs font-bold text-djpro-muted uppercase tracking-widest">Estado:</span>
                    <span class="flex items-center gap-2 text-green-500 font-bold text-sm">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        DISPONIBLE
                    </span>
                </div>
                <button class="bg-djpro-accent hover:bg-orange-600 text-white p-3 rounded-xl transition-all shadow-lg shadow-orange-500/20">
                    <i class="bi bi-gear-fill"></i>
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="bg-djpro-surface p-6 rounded-2xl border border-djpro-border group hover:border-djpro-accent transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-djpro-accent/10 rounded-xl flex items-center justify-center text-djpro-accent">
                        <i class="bi bi-calendar-check text-2xl"></i>
                    </div>
                    <span class="text-[10px] font-bold text-djpro-success bg-djpro-success/10 px-2 py-1 rounded-lg">+12%</span>
                </div>
                <h3 class="text-4xl font-bebas text-white mb-1">156</h3>
                <p class="text-sm text-djpro-muted font-bold uppercase tracking-widest">Total Reservas</p>
            </div>

            <div class="bg-djpro-surface p-6 rounded-2xl border border-djpro-border group hover:border-djpro-accent transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-500/10 rounded-xl flex items-center justify-center text-yellow-500">
                        <i class="bi bi-clock-history text-2xl"></i>
                    </div>
                    <span class="text-[10px] font-bold text-yellow-500 bg-yellow-500/10 px-2 py-1 rounded-lg">8 Nuevas</span>
                </div>
                <h3 class="text-4xl font-bebas text-white mb-1">12</h3>
                <p class="text-sm text-djpro-muted font-bold uppercase tracking-widest">Pendientes</p>
            </div>

            <div class="bg-djpro-surface p-6 rounded-2xl border border-djpro-border group hover:border-djpro-accent transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-djpro-purple/10 rounded-xl flex items-center justify-center text-djpro-purple">
                        <i class="bi bi-star-fill text-2xl"></i>
                    </div>
                    <span class="text-[10px] font-bold text-djpro-purple bg-djpro-purple/10 px-2 py-1 rounded-lg">Top 5%</span>
                </div>
                <h3 class="text-4xl font-bebas text-white mb-1">4.9</h3>
                <p class="text-sm text-djpro-muted font-bold uppercase tracking-widest">Rating Promedio</p>
            </div>

            <div class="bg-djpro-surface p-6 rounded-2xl border border-djpro-border group hover:border-djpro-accent transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-500">
                        <i class="bi bi-eye-fill text-2xl"></i>
                    </div>
                    <span class="text-[10px] font-bold text-blue-500 bg-blue-500/10 px-2 py-1 rounded-lg">+45 hoy</span>
                </div>
                <h3 class="text-4xl font-bebas text-white mb-1">1.2K</h3>
                <p class="text-sm text-djpro-muted font-bold uppercase tracking-widest">Visitas Perfil</p>
            </div>
        </div>

        <!-- Stories Row (Instagram Style) -->
        <div class="mb-12">
            <h4 class="text-sm font-bold text-djpro-text uppercase tracking-widest mb-6 ml-1">Mis Historias de Eventos</h4>
            <div class="flex gap-6 overflow-x-auto pb-4 custom-scrollbar">
                <!-- Add Story Button -->
                <button class="flex-shrink-0 group flex flex-col items-center gap-2">
                    <div class="w-20 h-20 rounded-full border-2 border-dashed border-djpro-border flex items-center justify-center group-hover:border-djpro-accent transition-all">
                        <i class="bi bi-plus-lg text-2xl text-djpro-muted group-hover:text-djpro-accent"></i>
                    </div>
                    <span class="text-[10px] font-bold text-djpro-muted uppercase tracking-tighter">Nueva</span>
                </button>
                
                <?php for($i=1; $i<=5; $i++): ?>
                <div class="flex-shrink-0 flex flex-col items-center gap-2">
                    <div class="w-20 h-20 rounded-full p-1 bg-gradient-to-tr from-djpro-accent to-djpro-purple">
                        <div class="w-full h-full rounded-full border-2 border-djpro-bg overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1598387181032-a3103a2db5b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80" alt="Story" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-white uppercase tracking-tighter">Boda VIP</span>
                </div>
                <?php endfor; ?>

                <!-- Expired Story -->
                <div class="flex-shrink-0 flex flex-col items-center gap-2 opacity-50">
                    <div class="w-20 h-20 rounded-full p-1 bg-djpro-border">
                        <div class="w-full h-full rounded-full border-2 border-djpro-bg overflow-hidden grayscale">
                            <img src="https://images.unsplash.com/photo-1598387181032-a3103a2db5b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80" alt="Story" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-djpro-muted uppercase tracking-tighter">Expirada</span>
                </div>
            </div>
        </div>

        <!-- Recent Bookings Table -->
        <div class="bg-djpro-surface rounded-3xl border border-djpro-border overflow-hidden shadow-xl">
            <div class="p-8 border-b border-djpro-border flex justify-between items-center">
                <h4 class="text-2xl font-bebas text-white tracking-widest">Reservas Recientes</h4>
                <a href="#" class="text-djpro-accent font-bold text-sm hover:underline">Ver todas <i class="bi bi-chevron-right ml-1"></i></a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-djpro-surface-2">
                            <th class="px-8 py-4 text-[10px] font-bold text-djpro-muted uppercase tracking-widest">Cliente</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-djpro-muted uppercase tracking-widest">Evento</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-djpro-muted uppercase tracking-widest">Fecha</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-djpro-muted uppercase tracking-widest">Estado</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-djpro-muted uppercase tracking-widest text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-djpro-border">
                        <!-- Pendiente -->
                        <tr class="hover:bg-djpro-surface-2 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name=Laura+Gomez&background=1c1c2e&color=f97316" class="w-8 h-8 rounded-lg">
                                    <span class="font-bold text-white">Laura Gómez</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-sm font-semibold text-djpro-muted">Boda Civil - Finca San José</span>
                            </td>
                            <td class="px-8 py-6 text-sm font-bold text-white">15 Dic, 2024</td>
                            <td class="px-8 py-6">
                                <span class="bg-yellow-500/15 text-yellow-400 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border border-yellow-500/20">Pendiente</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-center gap-2">
                                    <button class="w-8 h-8 rounded-lg bg-djpro-success/20 text-djpro-success hover:bg-djpro-success hover:text-white transition-all flex items-center justify-center">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                    <button class="w-8 h-8 rounded-lg bg-djpro-danger/20 text-djpro-danger hover:bg-djpro-danger hover:text-white transition-all flex items-center justify-center">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Confirmado -->
                        <tr class="hover:bg-djpro-surface-2 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name=Carlos+Rios&background=1c1c2e&color=f97316" class="w-8 h-8 rounded-lg">
                                    <span class="font-bold text-white">Carlos Ríos</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-sm font-semibold text-djpro-muted">XV Años - Salón Real</span>
                            </td>
                            <td class="px-8 py-6 text-sm font-bold text-white">20 Dic, 2024</td>
                            <td class="px-8 py-6">
                                <span class="bg-green-500/15 text-green-400 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border border-green-500/20">Confirmado</span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <button class="text-djpro-muted hover:text-white transition-colors"><i class="bi bi-three-dots-vertical"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

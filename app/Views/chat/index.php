<?php require APPROOT . '/app/Views/inc/header.php'; ?>
<?php 
    if($_SESSION['usuario_rol'] == 'dj') {
        require APPROOT . '/app/Views/inc/sidebar_dj.php';
    } else if($_SESSION['usuario_rol'] == 'cliente') {
        require APPROOT . '/app/Views/inc/sidebar_cliente.php';
    }
?>

<section class="lg:ml-64 h-[calc(100vh-80px)] flex overflow-hidden">
    
    <!-- Sidebar de Conversaciones -->
    <div class="w-full md:w-80 lg:w-96 bg-djpro-surface border-r border-djpro-border flex flex-col">
        <!-- Search -->
        <div class="p-6">
            <h2 class="text-3xl font-bebas text-white tracking-widest mb-6">MENSAJES</h2>
            <div class="relative">
                <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-djpro-muted"></i>
                <input type="text" placeholder="Buscar chat..." class="input-djpro w-full pl-10 text-xs py-3">
            </div>
        </div>

        <!-- Chat List -->
        <div id="conversations-list" class="flex-1 overflow-y-auto custom-scrollbar">
            <?php if(empty($data['conversaciones'])): ?>
                <div class="p-8 text-center text-djpro-muted text-xs font-bold uppercase tracking-widest">No hay chats activos</div>
            <?php else: ?>
                <?php foreach($data['conversaciones'] as $con): ?>
                <a href="<?php echo URL_ROOT; ?>/chat/index/<?php echo $con->contacto_id; ?>" class="w-full p-6 flex items-center gap-4 hover:bg-djpro-surface-2 transition-all border-l-4 <?php echo ($data['contacto_id'] == $con->contacto_id) ? 'border-djpro-accent bg-djpro-accent/5' : 'border-transparent'; ?>">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($con->contacto_nombre); ?>&background=1c1c2e&color=f97316" class="w-12 h-12 rounded-xl">
                        <?php if($con->no_leidos > 0): ?>
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-djpro-accent border-2 border-djpro-surface rounded-full"></span>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1 text-left overflow-hidden">
                        <div class="flex justify-between items-center mb-1">
                            <h5 class="text-white font-bold text-sm truncate uppercase"><?php echo $con->contacto_nombre; ?></h5>
                            <span class="text-[9px] text-djpro-muted font-bold uppercase"><?php echo date('H:i', strtotime($con->fecha_envio)); ?></span>
                        </div>
                        <p class="text-[11px] text-djpro-muted truncate"><?php echo $con->contenido; ?></p>
                    </div>
                    <?php if($con->no_leidos > 0): ?>
                    <span class="w-5 h-5 bg-djpro-accent text-white text-[10px] font-bold flex items-center justify-center rounded-lg shadow-lg shadow-orange-500/30"><?php echo $con->no_leidos; ?></span>
                    <?php endif; ?>
                </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Área de Chat Activo -->
    <?php if($data['contacto_actual']): ?>
    <div class="flex flex-1 flex-col bg-djpro-bg relative">
        <!-- Chat Header -->
        <div class="h-24 bg-djpro-surface border-b border-djpro-border px-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($data['contacto_actual']->nombre); ?>&background=1c1c2e&color=f97316" class="w-12 h-12 rounded-xl">
                    <span class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 border-2 border-djpro-surface rounded-full"></span>
                </div>
                <div>
                    <h4 class="text-white font-bold tracking-widest text-lg uppercase"><?php echo $data['contacto_actual']->nombre; ?></h4>
                    <span class="text-[10px] text-green-500 font-bold uppercase tracking-widest">En línea ahora</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 rounded-xl bg-djpro-surface-2 text-djpro-muted hover:text-white transition-all flex items-center justify-center"><i class="bi bi-telephone"></i></button>
                <button class="w-10 h-10 rounded-xl bg-djpro-surface-2 text-djpro-muted hover:text-white transition-all flex items-center justify-center"><i class="bi bi-info-circle"></i></button>
            </div>
        </div>

        <!-- Chat Area (Scrollable) -->
        <div id="chat-messages-area" class="flex-1 overflow-y-auto p-8 space-y-6 custom-scrollbar bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
            <?php foreach($data['chat_actual'] as $msg): ?>
                <?php if($msg->emisor_id == $_SESSION['usuario_id']): ?>
                    <!-- Mensaje Enviado -->
                    <div class="flex justify-end ml-auto max-w-[80%]">
                        <div class="flex flex-col gap-1 items-end">
                            <div class="bg-djpro-accent p-4 rounded-2xl rounded-tr-none text-white text-sm leading-relaxed shadow-lg shadow-orange-500/20">
                                <?php echo $msg->contenido; ?>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[9px] text-djpro-muted font-bold uppercase"><?php echo date('H:i', strtotime($msg->fecha_envio)); ?></span>
                                <?php if($msg->leido): ?>
                                    <i class="bi bi-check2-all text-djpro-accent"></i>
                                <?php else: ?>
                                    <i class="bi bi-check2 text-djpro-muted"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Mensaje Recibido -->
                    <div class="flex justify-start max-w-[80%]">
                        <div class="flex flex-col gap-1">
                            <div class="bg-djpro-surface-2 p-4 rounded-2xl rounded-tl-none border border-djpro-border text-djpro-text text-sm leading-relaxed">
                                <?php echo $msg->contenido; ?>
                            </div>
                            <span class="text-[9px] text-djpro-muted font-bold uppercase ml-1"><?php echo date('H:i', strtotime($msg->fecha_envio)); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Chat Input Area -->
        <div class="p-8 bg-djpro-surface border-t border-djpro-border">
            <form id="chat-form" class="flex gap-4">
                <input type="hidden" id="receptor_id" value="<?php echo $data['contacto_id']; ?>">
                <button type="button" class="w-12 h-12 flex-shrink-0 bg-djpro-surface-2 text-djpro-muted hover:text-white transition-all rounded-xl border border-djpro-border flex items-center justify-center">
                    <i class="bi bi-plus-lg text-xl"></i>
                </button>
                <div class="flex-1 relative">
                    <input type="text" id="chat-input" placeholder="Escribe un mensaje aquí..." class="input-djpro w-full py-3 pl-6 pr-12" autocomplete="off">
                    <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-djpro-accent hover:scale-110 transition-transform">
                        <i class="bi bi-emoji-smile text-xl"></i>
                    </button>
                </div>
                <button type="submit" class="w-12 h-12 flex-shrink-0 bg-djpro-accent text-white rounded-xl shadow-lg shadow-orange-500/20 hover:scale-105 transition-all flex items-center justify-center">
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        </div>
    </div>
    <?php else: ?>
    <!-- Empty State -->
    <div class="flex-1 flex flex-col items-center justify-center bg-djpro-bg text-center p-12">
        <div class="w-32 h-32 bg-djpro-surface-2 rounded-full flex items-center justify-center mb-6 border-2 border-djpro-border">
            <i class="bi bi-chat-heart text-5xl text-djpro-accent"></i>
        </div>
        <h3 class="text-3xl font-bebas text-white tracking-widest mb-2 uppercase">Tus Conversaciones</h3>
        <p class="text-djpro-muted max-w-sm">Selecciona un chat de la izquierda para empezar a coordinar tu próximo gran evento.</p>
    </div>
    <?php endif; ?>

</section>

<script>
    const chatArea = document.getElementById('chat-messages-area');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const receptorId = document.getElementById('receptor_id')?.value;

    if (chatArea) {
        chatArea.scrollTop = chatArea.scrollHeight;
    }

    if (chatForm) {
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const content = chatInput.value.trim();
            if (!content) return;

            const formData = new FormData();
            formData.append('receptor_id', receptorId);
            formData.append('contenido', content);
            formData.append('csrf_token', '<?php echo $_SESSION['csrf_token']; ?>');

            fetch('<?php echo URL_ROOT; ?>/chat/api_send', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    chatInput.value = '';
                    fetchMessages(); // Actualizar inmediatamente
                }
            });
        });
    }

    function fetchMessages() {
        if (!receptorId) return;
        
        fetch('<?php echo URL_ROOT; ?>/chat/api_get_messages/' + receptorId)
            .then(res => res.json())
            .then(data => {
                const currentUserId = '<?php echo $_SESSION['usuario_id']; ?>';
                let html = '';

                // Función para escapar HTML y prevenir XSS
                const escapeHTML = (str) => {
                    const p = document.createElement('p');
                    p.textContent = str;
                    return p.innerHTML;
                };
                
                data.mensajes.forEach(msg => {
                    const isMe = msg.emisor_id == currentUserId;
                    const date = new Date(msg.fecha_envio).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                    const sanitizedContent = escapeHTML(msg.contenido);
                    
                    if (isMe) {
                        html += `
                            <div class="flex justify-end ml-auto max-w-[80%]">
                                <div class="flex flex-col gap-1 items-end">
                                    <div class="bg-djpro-accent p-4 rounded-2xl rounded-tr-none text-white text-sm leading-relaxed shadow-lg shadow-orange-500/20">
                                        ${sanitizedContent}
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[9px] text-djpro-muted font-bold uppercase">${date}</span>
                                        ${msg.leido ? '<i class="bi bi-check2-all text-djpro-accent"></i>' : '<i class="bi bi-check2 text-djpro-muted"></i>'}
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        html += `
                            <div class="flex justify-start max-w-[80%]">
                                <div class="flex flex-col gap-1">
                                    <div class="bg-djpro-surface-2 p-4 rounded-2xl rounded-tl-none border border-djpro-border text-djpro-text text-sm leading-relaxed">
                                        ${sanitizedContent}
                                    </div>
                                    <span class="text-[9px] text-djpro-muted font-bold uppercase ml-1">${date}</span>
                                </div>
                            </div>
                        `;
                    }
                });

                const shouldScroll = chatArea.scrollTop + chatArea.clientHeight === chatArea.scrollHeight;
                chatArea.innerHTML = html;
                if (shouldScroll) {
                    chatArea.scrollTop = chatArea.scrollHeight;
                }
            });
    }

    // Polling cada 3 segundos para el chat
    if (receptorId) {
        setInterval(fetchMessages, 3000);
    }
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

<?php require APPROOT . '/app/Views/inc/header.php'; ?>

<style>
  .auth{font-family:'Sora',system-ui,sans-serif}
  .auth .grad{background:linear-gradient(105deg,#2E5BFF,#00C2FF);-webkit-background-clip:text;background-clip:text;color:transparent}
  .auth-card{max-width:64rem;width:100%;background:#101018;border:1px solid #232338;border-radius:32px;overflow:hidden;box-shadow:0 40px 90px -30px rgba(0,0,0,.8);display:flex;flex-direction:column}
  @media(min-width:768px){.auth-card{flex-direction:row;min-height:680px}}

  .auth-visual{position:relative;overflow:hidden;display:none;
    background:radial-gradient(600px circle at 70% 20%,rgba(0,194,255,.3),transparent 60%),radial-gradient(500px circle at 20% 90%,rgba(46,91,255,.3),transparent 60%),linear-gradient(160deg,#0c1430,#0a0a14)}
  @media(min-width:768px){.auth-visual{display:flex;width:44%;align-items:center;justify-content:center;padding:3rem;order:2}}
  .auth-visual .txt{position:relative;z-index:3;text-align:center}
  .auth-disc{width:150px;height:150px;border-radius:50%;margin:0 auto 2rem;position:relative;
    background:repeating-radial-gradient(circle at center,#0d0d14 0 4px,#191922 4px 8px);
    box-shadow:0 24px 60px rgba(0,0,0,.55),0 0 0 8px #0b0b12,0 0 0 9px #24304d;animation:audisc 9s linear infinite}
  .auth-disc::after{content:"";position:absolute;inset:0;margin:auto;width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,#2E5BFF,#00C2FF);border:6px solid #0a0a14;box-shadow:0 0 20px rgba(46,91,255,.6)}
  @keyframes audisc{to{transform:rotate(360deg)}}
  .auth-visual h2{font-family:'Unbounded',sans-serif;font-weight:800;font-size:2.2rem;line-height:1;letter-spacing:-.02em;color:#fff;margin:0 0 1rem}
  .auth-visual p{color:#8b95b5;font-size:1rem;max-width:26ch;margin:0 auto;line-height:1.55}
  .auth-eq{position:absolute;left:0;right:0;bottom:0;display:flex;align-items:flex-end;gap:5px;height:70px;padding:0 2rem;opacity:.4;z-index:1}
  .auth-eq i{flex:1;background:linear-gradient(to top,#2E5BFF,#00C2FF);border-radius:4px 4px 0 0;animation:aueq 1s ease-in-out infinite}
  @keyframes aueq{0%,100%{height:20%}50%{height:100%}}
  .auth-pill{position:absolute;z-index:2;background:rgba(16,16,24,.85);backdrop-filter:blur(8px);border:1px solid #2b3352;border-radius:14px;padding:.6rem .9rem;display:flex;align-items:center;gap:.5rem;font-weight:600;color:#fff;font-size:.78rem;box-shadow:0 12px 30px rgba(0,0,0,.4);animation:aufloat 4s ease-in-out infinite}
  .auth-pill i{color:#00C2FF}
  .ap1{top:2rem;right:2rem}.ap2{bottom:5rem;left:1.5rem;animation-delay:1.4s}
  @keyframes aufloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-9px)}}

  .auth-form{width:100%;padding:2.5rem 2rem;display:flex;flex-direction:column;justify-content:center}
  @media(min-width:768px){.auth-form{width:56%;padding:3rem 3.2rem}}
  .auth-form h3{font-family:'Unbounded',sans-serif;font-weight:800;font-size:1.9rem;letter-spacing:-.02em;color:#fff;margin:0 0 .4rem}
  .auth-form .kick{color:#00C2FF;font-size:.72rem;font-weight:700;letter-spacing:.2em;text-transform:uppercase;margin-bottom:1.8rem}
  .auth-lbl{font-size:.7rem;font-weight:700;color:#cbd5e1;text-transform:uppercase;letter-spacing:.1em;margin-left:.15rem;display:block;margin-bottom:.4rem}
  .auth-field{position:relative}
  .auth-input{width:100%;background:#171724;border:1px solid #262636;border-radius:14px;padding:.85rem 1rem;color:#f4f5fb;font-family:'Sora',sans-serif;font-weight:500;outline:none;transition:border-color .2s,box-shadow .2s}
  .auth-input:focus{border-color:#2E5BFF;box-shadow:0 0 0 4px rgba(46,91,255,.14)}
  .pw-toggle{position:absolute;right:1rem;top:50%;transform:translateY(-50%);color:#64748b;cursor:pointer;background:none;border:none;padding:0}
  .pw-toggle:hover{color:#00C2FF}
  .auth-btn{width:100%;margin-top:1.4rem;background:linear-gradient(135deg,#2E5BFF,#00C2FF);color:#fff;font-family:'Sora';font-weight:700;font-size:1.05rem;border:none;border-radius:14px;padding:1rem;cursor:pointer;box-shadow:0 12px 30px rgba(46,91,255,.32);transition:transform .2s,filter .2s;display:flex;align-items:center;justify-content:center;gap:.5rem}
  .auth-btn:hover{transform:translateY(-2px);filter:brightness(1.08)}
  .auth-link{color:#00C2FF;font-weight:700;text-decoration:none}
  .auth-link:hover{text-decoration:underline}
  .auth-err{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);color:#f87171;padding:.9rem 1rem;border-radius:12px;margin-bottom:1.2rem;display:flex;align-items:center;gap:.6rem;font-size:.85rem;font-weight:600}
  .role-card{padding:1rem;border:1px solid #262636;border-radius:14px;text-align:center;cursor:pointer;transition:.2s;background:#171724}
  .role-card i{font-size:1.5rem;color:#64748b;display:block;margin-bottom:.35rem;transition:.2s}
  .role-card span{font-size:.68rem;font-weight:700;color:#8b95b5;text-transform:uppercase;letter-spacing:.1em}
  .peer:checked + .role-card{border-color:#2E5BFF;background:rgba(46,91,255,.1)}
  .peer:checked + .role-card i,.peer:checked + .role-card span{color:#fff}
  .role-card:hover i{color:#00C2FF}
</style>

<section class="auth min-h-[calc(100vh-80px)] flex items-center justify-center p-4">
  <div class="auth-card">
    <!-- Lado Visual -->
    <div class="auth-visual">
      <div class="auth-pill ap1"><i class="bi bi-headphones"></i> Crea tu perfil de DJ</div>
      <div class="auth-pill ap2"><i class="bi bi-calendar2-check"></i> Recibe reservas</div>
      <div class="txt">
        <div class="auth-disc"></div>
        <h2>Únete a <span class="grad">DJPRO</span></h2>
        <p>Crea tu cuenta en segundos y empieza a vibrar con la mejor música del Caquetá.</p>
      </div>
      <div class="auth-eq">
        <?php for($i=0;$i<20;$i++): ?><i style="height:<?php echo rand(20,90); ?>%;animation-delay:-<?php echo $i*0.1; ?>s;animation-duration:<?php echo (8+rand(0,8))/10; ?>s"></i><?php endfor; ?>
      </div>
    </div>

    <!-- Formulario -->
    <div class="auth-form">
      <h3>Crear cuenta</h3>
      <p class="kick">Tu acceso a la fiesta empieza aquí</p>

      <?php if(!empty($data['error'])): ?>
        <div class="auth-err"><i class="bi bi-exclamation-triangle-fill"></i> <?php echo $data['error']; ?></div>
      <?php endif; ?>

      <form action="<?php echo URL_ROOT; ?>/usuarios/registro" method="POST" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div id="nombre-container" class="<?php echo $data['rol'] != 'dj' ? 'md:col-span-2' : ''; ?>">
            <label class="auth-lbl">Nombre completo</label>
            <input type="text" name="nombre" value="<?php echo $data['nombre']; ?>" maxlength="30" placeholder="Ej: Steven Mix" class="auth-input" required>
          </div>
          <div id="username-container" class="<?php echo $data['rol'] != 'dj' ? 'hidden' : ''; ?>">
            <label class="auth-lbl">Username (ID público)</label>
            <input type="text" name="username" id="username-input" value="<?php echo $data['username'] ?? ''; ?>" maxlength="30" placeholder="stiven_mix_2026" class="auth-input" <?php echo $data['rol'] == 'dj' ? 'required' : ''; ?> pattern="[a-zA-Z0-9_]+" title="Solo letras, números y guiones bajos">
          </div>
        </div>

        <div>
          <label class="auth-lbl">Correo electrónico</label>
          <input type="email" name="correo" value="<?php echo $data['correo']; ?>" maxlength="100" placeholder="tu@ejemplo.com" class="auth-input" required>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="auth-lbl">Contraseña</label>
            <div class="auth-field">
              <input type="password" name="password" id="pw1" placeholder="••••••••" class="auth-input" required maxlength="30" style="padding-right:2.9rem">
              <button type="button" class="pw-toggle" onclick="togglePw('pw1', this)" aria-label="Mostrar"><i class="bi bi-eye"></i></button>
            </div>
          </div>
          <div>
            <label class="auth-lbl">Confirmar</label>
            <div class="auth-field">
              <input type="password" name="confirm_password" id="pw2" placeholder="••••••••" class="auth-input" required maxlength="30" style="padding-right:2.9rem">
              <button type="button" class="pw-toggle" onclick="togglePw('pw2', this)" aria-label="Mostrar"><i class="bi bi-eye"></i></button>
            </div>
          </div>
        </div>

        <div>
          <label class="auth-lbl">¿Qué perfil buscas?</label>
          <div class="flex gap-4">
            <label class="flex-1 cursor-pointer">
              <input type="radio" name="rol" value="cliente" class="hidden peer" <?php echo $data['rol'] == 'cliente' ? 'checked' : ''; ?>>
              <div class="role-card"><i class="bi bi-person-heart"></i><span>Soy Cliente</span></div>
            </label>
            <label class="flex-1 cursor-pointer">
              <input type="radio" name="rol" value="dj" class="hidden peer" <?php echo $data['rol'] == 'dj' ? 'checked' : ''; ?>>
              <div class="role-card"><i class="bi bi-headphones"></i><span>Soy DJ</span></div>
            </label>
          </div>
        </div>

        <button type="submit" class="auth-btn">Registrarme <i class="bi bi-person-plus-fill"></i></button>
      </form>

      <div class="mt-6 text-center border-t border-djpro-border pt-5">
        <p style="color:#8b95b5;font-size:.85rem;font-weight:500">¿Ya tienes una cuenta? <a href="<?php echo URL_ROOT; ?>/usuarios/login" class="auth-link">Inicia sesión</a></p>
      </div>
    </div>
  </div>
</section>

<script>
  function togglePw(id, btn){
    var inp = document.getElementById(id);
    var ic = btn.querySelector('i');
    if(inp.type === 'password'){ inp.type = 'text'; ic.className = 'bi bi-eye-slash'; }
    else { inp.type = 'password'; ic.className = 'bi bi-eye'; }
  }

  document.addEventListener('DOMContentLoaded', function() {
    const rolRadios = document.querySelectorAll('input[name="rol"]');
    const usernameContainer = document.getElementById('username-container');
    const usernameInput = document.getElementById('username-input');
    const nombreContainer = document.getElementById('nombre-container');

    function toggleUsername() {
      const selectedRadio = document.querySelector('input[name="rol"]:checked');
      if (!selectedRadio) return;
      if (selectedRadio.value === 'dj') {
        usernameContainer.classList.remove('hidden');
        usernameInput.setAttribute('required', 'required');
        nombreContainer.classList.remove('md:col-span-2');
      } else {
        usernameContainer.classList.add('hidden');
        usernameInput.removeAttribute('required');
        nombreContainer.classList.add('md:col-span-2');
      }
    }
    rolRadios.forEach(radio => radio.addEventListener('change', toggleUsername));
    toggleUsername();
  });
</script>

<?php require APPROOT . '/app/Views/inc/footer.php'; ?>

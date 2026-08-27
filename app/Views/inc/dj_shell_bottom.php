<?php if(empty($__bare)): ?>
    </div>
</main>
<?php endif; ?>
<script>
    /* Toast global (antes definido en footer.php) para las vistas con shell oscuro */
    if (typeof Swal !== 'undefined' && typeof window.Toast === 'undefined') {
        window.Toast = Swal.mixin({
            toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true,
            background: '#101018', color: '#f4f5fb'
        });
    }
</script>
<script src="<?php echo URL_ROOT; ?>/assets/js/main.js" defer></script>
</body>
</html>

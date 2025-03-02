<script src="admin/lib/js/minified.js" crossorigin="anonymous"></script>
<script src="admin/lib/js/function.js"></script>
<script src="admin/lib/js/fontawesome.js"></script>

<script>
    alertify.set('notifier', 'position', 'bottom-right');
    <?php
    if (isset($_SESSION['message'])) {
    ?>
        alertify.success('<?= $_SESSION['message']; ?>');
    <?php
        unset($_SESSION['message']);
    }
    ?>
</script>

<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_SESSION['message'])) : ?>
            alertify.success("<?php echo $_SESSION['message']; ?>");
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])) : ?>
            alertify.error("<?php echo $_SESSION['error_message']; ?>");
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    });
</script>

</body>

</html>
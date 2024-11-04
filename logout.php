<?php

unset($_SESSION['user']);
unset($_SESSION['login']);
echo "<script>
document.location='index.php?page=loginUser';
</script>";
<?php

setcookie('remembered_name', '', time() - 3600, '/');
header('Location: remember_name.php');
exit;

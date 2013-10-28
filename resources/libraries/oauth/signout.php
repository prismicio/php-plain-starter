<?php
    require_once '../resources/config.php';
    setcookie('ACCESS_TOKEN', "", time() - 1);
    header('Location: ' . Routes::index());

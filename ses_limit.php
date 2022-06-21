<?php
$now = time();
if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
    // this session has worn out its welcome; kill it and start a brand new one
    exit(header('Location: ./func/logout.php'));
    // session_unset();
    // session_destroy();
    // session_start();
}

// either new or old, it should live at most for another hour
$_SESSION['discard_after'] = $now + 3600;


<?php

$core->Session->logout();
header('Location: index.php?p=login');
exit;
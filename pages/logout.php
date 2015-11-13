<?php

WebInterface\Session::destroy();
header('Location: index.php?p=login');
exit;

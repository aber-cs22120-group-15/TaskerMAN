<?php

Session::destroy();
header('Location: index.php?p=login');
exit;

<?php

echo $api->response(array('uid' => $api->uid, 'admin' => $api->is_admin));
exit;
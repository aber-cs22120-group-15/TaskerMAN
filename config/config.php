<?php

$config['DEBUG'] = true;

$config['DB_HOST'] = 'localhost';
$config['DB_USERNAME'] = 'taskerman';
$config['DB_PASSWORD'] = 'abercs';
$config['DB_DATABASE'] = 'taskerman';


Registry::loadConfig($config);
unset($config);

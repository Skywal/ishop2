<?php
require_once dirname(__DIR__) . '/config/init.php';

new \ishop\App();
var_dump(\ishop\App::$app->getProperties());

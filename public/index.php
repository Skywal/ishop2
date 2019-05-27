<?php
/**
 * Фронт контроллер на який йдуть всі запити з сервера
 */


require_once dirname(__DIR__) . '/config/init.php';
require_once LIBS . '/functions.php';
require_once CONFIG . '/routes.php';

new \ishop\App();  // підключення класу через composer

<?php

use ishop\Router;

/**
 * всі користувацькі правила повинні знаходитися вище за дефолтні для того щоб першими опрацьовувалися вони
 */



/**
 * ---------------------------------------------
 * default routes
 * ---------------------------------------------
 */
/// адмінка
Router::add('^admin$', [
	'controller' => 'Main',
	'action' => 'index',
	'prefix' => 'admin'
]);
Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', [
	'prefix' => 'admin'
]);

/// шаблон який співпадає з пустою строкою або з головною сторінкою сайту
Router::add('^$', [
	'controller' => 'Main',
	'action' => 'index'
]);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

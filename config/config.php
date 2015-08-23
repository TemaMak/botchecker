<?php
/**
 * Конфиг
 */

$config = array();

Config::Set('db.table.botchecker_action_counter','___db.table.prefix___botchecker_action_counter');
Config::Set('db.table.botchecker_user_score','___db.table.prefix___botchecker_user_score');

/*
 * Связки sAction_sEvent, которые не нужно логировать для счетчика
 */
$config['ignore_action_id'] = array(
	'error_404',
	'geoajax_geo',
	'popupinfo_getbloginfo'
);

/*
 * Тип подключения правил проверки "бот - человек"
 * folder - инклудятся все правила из директории
 * list - инклудятся конкретные правила
 */
$config['rule_enabled_method'] = 'folder';
$config['rule_enabled_method_list'] = array();

/*
 * Настройка правил проверки "бот - человек"
 */
$config['rules'] = array();
$config['rules']['onlytopicaddrule'] = array(
	'only_add_counter_min' => 10, 			//Количество повторов действия topic_add, 
											//при условии, что других действий не было
	'only_add_bot_score' => 100,			//Количество очков "бот" при срабатывании метрики
											//"только topic_add"
										
	'not_only_add_action_count' => 5, 		//Максимальное количество различных действий
											//при котором проверятеся кол-во действий
											//topic_add
	'not_only_add_counter_min' => 20,		//Количество действий topic_add, при котором метрика 
											//not_only_add срабатывает
	'only_add_bot_score' => 100,			//Количество очков "бот" при срабатывании метрики
											//"not_only_add"

	'different_action_count' => 10,			//КОличество различных действий, при которых не проверяется
											//кол-во повторений topic_add
	'different_action_human_score' => 100,	//Количество очков "человек" при срабатывании метрики
											//different_action
);

/*
 * Уровень очков "бот" и "человек" для получения пользователем определенного статуса
 */
$config['bot_score_level'] = 100;
$config['human_score_level'] = 100;

/*
 * Писать или нет счетчики для пользователей, которые уже признаны людьми.
 */
$config['human_write_counter'] = false;

/*
 * Что делать с пользователями, которых система признала ботом
 * notify - уведомить администратора о присвоении статуса "бот"
 * delete - удаление пользователя, если у него нет топиков, комментариев и т.д.
 * force_delete - удаление пользователя со всеми его топиками, комментариями и т.д. 
 * password_ban - изменение пароля и email для предотвращения входа пользователя
 * url_ban - при любом входе пользователя он переправляется на определенную страницу
 */
$config['bot_after_check_action'] = 'delete';

/*
 * E-mail для отправки отчета работы checker'а
 */
$config['notify_email'] = '---'; 

return $config;
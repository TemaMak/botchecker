<?php

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
    die('Hacking attemp!');
}

class PluginBotchecker extends Plugin {

    // Объявление делегирований (нужны для того, чтобы назначить свои экшны и шаблоны)
    public $aDelegates = array(

    );

    public $aInherits = array(
    
	);

    // Активация плагина
    public function Activate() {
		if (
			!$this->isTableExists('prefix_botchecker_action_counter')
			&& !$this->isTableExists('prefix_botchecker_user_score')
		) {
            $resutls = $this->ExportSQL(dirname(__FILE__) . '/activate.sql');
            return $resutls['result'];
        }    	
        return true;
    }

    // Деактивация плагина
    public function Deactivate(){

    	return true;
    }


    // Инициализация плагина
    public function Init() {    	
		return true;
    }
}
?>

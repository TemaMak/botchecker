<?php

class PluginBotchecker_HookBotchecker extends Hook
{

    /**
     * Register hooks
     */
    public function RegisterHook(){
        $this->AddHook('init_action', 'WriteActionCounter');
    }

    public function WriteActionCounter($aParams){        
 		$sAction = Router::GetAction();
 		$sEvent = Router::GetActionEvent();
 		if(!$sEvent){
 			$sEvent = 'default';
 		}
 		$oUser = $this->User_GetUserCurrent();
 		if($oUser){
 			$this->PluginBotchecker_Botchecker_writeActionCounter($oUser,$sAction,$sEvent);
 		}
    }    
}

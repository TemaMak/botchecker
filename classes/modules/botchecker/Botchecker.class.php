<?php

class PluginBotchecker_ModuleBotchecker extends Module
{
	protected $oMapper;
	protected $oUserCurrent = null;
	
    public function Init(){
        $this->oMapper = Engine::GetMapper(__CLASS__);
    }
	
    public function writeActionCounter($oUser,$sAction,$sEvent){ 
    	$sActionId = $sAction.'_'.$sEvent;
    	if(!in_array($sActionId,Config::Get('plugin.botchecker.ignore_action_id'))){
    		$this->oMapper->writeActionCounter($oUser,$sActionId);
    	}		
    }  

	public function GetUserLogIds(){
		return $this->oMapper->GetUserLogIds();
	}
	
	public function GetActionCounter($oUser){
		return $this->oMapper->GetActionCounter($oUser);
	}
	
	public function saveScore($iUserId,$aData){
		return $this->oMapper->saveScore($iUserId,$aData);
	}
}

?>
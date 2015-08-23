<?php

class PluginBotchecker_ModuleBotchecker extends Module
{
	protected $oMapper;
	protected $oUserCurrent = null;
	
    public function Init(){
        $this->oMapper = Engine::GetMapper(__CLASS__);
    }
	
    public function writeActionCounter($oUser,$sAction,$sEvent){ 
    	$sState = $this->getState($oUser);
    	if($sState == 'human' && Config::Get('plugin.botchecker.human_write_counter') == false){
    		return;
    	}
    	
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
	
	public function saveScore($iUserId,$aData,$sState){
		return $this->oMapper->saveScore($iUserId,$aData,$sState);
	}
	
	public function getState($oUser){
		$sKey = 'bot_checker_state_'.$oUser->GetId();
		if (false === ($sState = $this->Cache_Get($sKey))) {
			if ($sState = $this->oMapper->getState($oUser)) {
				$this->Cache_Set($sState, $sKey, array('bot_checker'), 60*60*24*1);
			}
		}
		return $sState;
	}
	
	public function deleteUser($iUserId){
		$oUser = $this->User_GetUserById($iUserId);
		$this->User_DeleteAvatar($oUser);
		$this->User_DeleteFoto($oUser);

		$this->clearBotcheckerByUserId($iUserId);
		
		return $this->oMapper->deleteUser($iUserId);
	}
	
	public function clearBotcheckerByUserId($iUserId){
		return $this->oMapper->clearBotcheckerByUserId($iUserId);
	}
}

?>
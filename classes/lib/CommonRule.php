<?php 

Class CommonRule{
	
	protected $aUserIds;
	protected $oEngine;
	protected $aConfig; 
	protected $iHumanScore;
	protected $iBotScore;
	
	public function __construct(){
		$this->aUserIds = array();
		$this->oEngine = Engine::GetInstance();
		
		$sId = strtolower(get_class($this));
		$this->aConfig = Config::Get('plugin.botchecker.rules.'.$sId);
				
		$this->iHumanScore = 0;
		$this->iBotScore = 0;
	}
	
	public function getCurrentUser(){
		$iUserId = current($this->aUserIds);
		if($iUserId){
			next($this->aUserIds);
			$oUser = $this->oEngine->User_GetUserById($iUserId);
			return $oUser;
		} else {
			return false;
		}
	}
	
	public function getConfigValue($sKey,$sDefault){
		if(isset($this->aConfig[$sKey])){
			return $this->aConfig[$sKey];
		} else {
			$sDefault;
		}
	}
	
	protected function addBotScore($iScore){
		$this->iBotScore = $this->iBotScore + $iScore;
	}
	
	protected function addHumanScore($iScore){
		$this->iHumanScore = $this->iHumanScore + $iScore;
	}	
	
	public function getHumanScore(){
		return $this->iHumanScore;
	}
	
	public function getBotScore(){
		return $this->iBotScore;
	}
	
	public function InitUsers(){
		//common InitUserCode
	}
	
	public function Validate($oUser){
		$this->iHumanScore = 0;
		$this->iBotScore = 0;
	}
}


?>
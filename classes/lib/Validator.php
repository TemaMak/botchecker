<?php 

class Validator{
	protected $aRules;
	
	public function __construct(){
		$sRuleInitMethod = Config::Get('plugin.botchecker.rule_enabled_method');
		switch($sRuleInitMethod){
			case 'list':
				
				break;							
			case 'folder':
			default:
				$sPath = Config::Get('path.root.server').'/plugins/botchecker/classes/rules/';
				$files = scandir($sPath);
				foreach($files as $sName){
					if(preg_match('/.*Rule/',$sName,$matches)){
						$sRuleName = $matches[0];
						$sFileName = $sPath.'/'.$sName;
						require_once($sFileName);
						
						$this->aRules[] = new $sRuleName();
					}
				}
				break;
		}
		reset($this->aRules);
	}

	public function getCurrentRule(){
		$oCurrentRule = current($this->aRules);
		next($this->aRules);
		
		return $oCurrentRule;
	}

	public function getUserState($iBotScore,$iHumanScore){
		if($iBotScore >= Config::Get('plugin.botchecker.bot_score_level')){
			return 'bot';
		}
		
		if($iHumanScore >= Config::Get('plugin.botchecker.human_score_level')){
			return 'human';
		}

		return 'unknown';
	}
	
}

?>
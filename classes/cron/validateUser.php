<?php 
$sDirRoot=dirname(dirname(dirname(__FILE__)));
set_include_path(get_include_path().PATH_SEPARATOR.$sDirRoot);
set_include_path($sDirRoot . '/classes/lib/'.PATH_SEPARATOR.get_include_path());
chdir($sDirRoot);

require_once($sDirRoot."/../../config/loader.php");
require_once($sDirRoot."/../../engine/classes/Cron.class.php");

require_once("CommonRule.php");
require_once("Validator.php");

ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);

class validateUser extends Cron {
	
	public function Client() {
		$oValidator = new Validator();		
		$aResult = array();
		
		while($oRule = $oValidator->getCurrentRule()){
			$oRule->InitUsers();
			while($oUser = $oRule->getCurrentUser()){
				$sValidateState = $oRule->Validate($oUser);
				if(!isset($aResult[$oUser->GetId()])){
					$aResult[$oUser->GetId()] = array(
						'bot' => 0,
						'human' => 0
					);
				}
				
				$aResult[$oUser->GetId()]['bot'] += $oRule->GetBotScore();
				$aResult[$oUser->GetId()]['human'] += $oRule->GetHumanScore();
			}
			
		}
		
		foreach($aResult as $iUserId => $aData){
			$this->PluginBotchecker_Botchecker_saveScore($iUserId,$aData);
		}
	}
	
}

$sLockFilePath=Config::Get('sys.cache.dir').'validate_user.lock';

$app = new validateUser($sLockFilePath);
print $app->Exec();

?>
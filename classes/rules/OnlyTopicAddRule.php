<?php 
class OnlyTopicAddRule extends CommonRule {

	/*
	 * Получение списка пользователей, по которым есть записи в логах
	 */
	public function InitUsers(){
		$this->aUserIds = $this->oEngine->PluginBotchecker_Botchecker_GetUserLogIds();
		reset($this->aUserIds);
	}
	
	public function Validate($oUser){
		parent::Validate($oUser);
		
		$aActions = $this->oEngine->PluginBotchecker_Botchecker_GetActionCounter($oUser);
		$iRangeActions = $this->getConfigValue('not_only_add_action_count',5);
		$iDifferentAction = $this->getConfigValue('different_action_count',5); 
				
		if(count($aActions) == 1){
			$sActionName = key($aActions);
			$iCounter = $aActions[$sActionName];
			$iCounterMin = $this->getConfigValue('only_add_counter_min',5);
			if($sActionName == 'topic_add' && $iCounter > $iCounterMin){
				$this->addBotScore($this->getConfigValue('only_add_bot_score',100));
			}
		}
		
		if(count($aActions) > 0 && count($aActions) <= $iRangeActions){
			foreach($aActions as $sActionId => $iActionCounter){
				if($sActionId == 'topic_add'){
					$iCounterMin = $this->getConfigValue('not_only_add_counter_min',20);
					if($aActions[$sActionId] > $iCounterMin){
						$this->addBotScore($this->getConfigValue('only_add_bot_score',100));
					}
				}
			}
		}
		
		if(count($aActions) > $iDifferentAction ){
			$this->addHumanScore($this->getConfigValue('different_action_human_score',100));
		}
	}
}
?>
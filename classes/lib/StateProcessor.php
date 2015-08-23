<?php 

class StateProcessor{
	
	const BOT_STATE = 'bot';
	const HUMAN_STATE = 'human';
	const UNKNOWN_STATE = 'unknown';
	
	static public function getUserState($iBotScore,$iHumanScore){
		if($iBotScore >= Config::Get('plugin.botchecker.bot_score_level')){
			return self::BOT_STATE;
		}
		
		if($iHumanScore >= Config::Get('plugin.botchecker.human_score_level')){
			return self::HUMAN_STATE;
		}

		return self::UNKNOWN_STATE;
	}
	
	static public function processUserState($iUserId,$sState){
		switch($sState){
			case self::BOT_STATE:
				$sBotProcessAction = Config::Get('plugin.botchecker.bot_after_check_action');
				switch($sBotProcessAction){
					case 'delete':
						return self::deleteUser($iUserId);
						break;
					case 'notify':
						return '[notify] User id='.$iUserId.' get bot state.';
						break;						
				}
				break;
		}
	}
	
	static public function deleteUser($iUserId){
		$aFilter = array('user_id' => $iUserId);
		
		$iTopicCount = Engine::GetInstance()->Topic_GetCountTopicsByFilter($aFilter);
		$iCommentCount = Engine::GetInstance()->Comment_GetCountCommentsByUserId($iUserId,'topic');
		if($iTopicCount == 0 && $iCommentCount == 0){
			Engine::GetInstance()->PluginBotchecker_Botchecker_deleteUser($iUserId);
			return '[delete] Simple delete user with id='.$iUserId;
		} else {
			return '[skip] User with id='.$iUserId.' has '.$iTopicCount.' topics and '.$iCommentCount.' commants';
		}
	}
}

?>
<?php


class PluginBotchecker_ModuleBotchecker_MapperBotchecker extends Mapper
{

    
	public function writeActionCounter($oUser,$sActionId){
		$sql="
			INSERT INTO 
				".Config::Get('db.table.botchecker_action_counter')."
			VALUES (?d,?,1)
			ON DUPLICATE KEY
				UPDATE counter = counter + 1;
		";
		
		return $this->oDb->query(
			$sql,
			$oUser->GetId(),
			$sActionId
		);		
		
	}
	
	public function GetUserLogIds(){
		$sql = "SELECT
					user_id
				FROM
					".Config::Get('db.table.botchecker_action_counter')."
				GROUP BY user_id
		";
		
		$aUserIds = array();
		if ($aRows=$this->oDb->select($sql)) {
			foreach ($aRows as $aRow) {
				$aUserIds[] = $aRow['user_id'];
			}
		}
		
		return $aUserIds;		
	}
	
	public function GetActionCounter($oUser){
		$sql = "SELECT
					*
				FROM
					".Config::Get('db.table.botchecker_action_counter')."
				WHERE user_id = ?d
		";
		
		$aCounters = array();
		if ($aRows=$this->oDb->select($sql,$oUser->GetId())) {
			foreach ($aRows as $aRow) {
				$aCounters[$aRow['action_id']] = $aRow['counter'];
			}
		}
		
		return $aCounters;		
	}	
	
	public function saveScore($iUserId,$aData){
		$sql="
			INSERT INTO 
				".Config::Get('db.table.botchecker_user_score')."
			VALUES (?d,?d,?d)
			ON DUPLICATE KEY
				UPDATE 
					bot_score = ?d,
					human_score = ?d
		";
		
		return $this->oDb->query(
			$sql,
			$iUserId,
			$aData['bot'],
			$aData['human'],
			/* ON DUPLICATE */
			$aData['bot'],
			$aData['human']			
		);		
		
	}
	
}
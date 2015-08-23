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
	
	public function saveScore($iUserId,$aData,$sState){
		$sql="
			INSERT INTO 
				".Config::Get('db.table.botchecker_user_score')."
			VALUES (?d,?d,?d,?)
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
			$sState,
			/* ON DUPLICATE */
			$aData['bot'],
			$aData['human']			
		);		
		
	}

	
	public function getState($oUser){
		$sql = "SELECT
					botchecker_state
				FROM
					".Config::Get('db.table.botchecker_user_score')."
				WHERE user_id = ?d
		";
		
		if ($aRows=$this->oDb->select($sql,$oUser->GetId())) {
			return $aRows[0]['botchecker_state'];
		}
		
		return 'unknown';			
	}
	
	public function deleteUser($iUserId){
		$sql = "DELETE FROM 
					".Config::Get('db.table.user')."
				WHERE 
					user_id = ?d
				";
		
		return $this->oDb->query($sql,$iUserId);
	}
	
	public function clearBotcheckerByUserId($iUserId){
			$sql = "DELETE FROM 
					".Config::Get('db.table.botchecker_user_score')."
				WHERE 
					user_id = ?d
				";
		
		 	$this->oDb->query($sql,$iUserId);	
		 	
			$sql = "DELETE FROM 
					".Config::Get('db.table.botchecker_action_counter')."
				WHERE 
					user_id = ?d
				";
		
		 	$this->oDb->query($sql,$iUserId);		 	
	}
	
}
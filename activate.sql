CREATE TABLE IF NOT EXISTS `prefix_botchecker_action_counter` (
  `user_id` int(11) NOT NULL,
  `action_id` varchar(255) NOT NULL,
  `counter` int(11) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`,`action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `prefix_botchecker_user_score` (
  `user_id` int(11) NOT NULL,
  `bot_score` int(11) NOT NULL,
  `human_score` int(11) NOT NULL,
  `botchecker_state` enum('unknown','bot','human') NOT NULL DEFAULT 'unknown',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
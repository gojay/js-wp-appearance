CREATE TABLE `options` (
  `option_id` bigint(20) unsigned NOT NULL auto_increment,
  `option_name` varchar(255) NOT NULL,
  `option_value` text NOT NULL,
  PRIMARY KEY  (`option_id`,`option_name`),
  UNIQUE KEY `option_id` (`option_id`)
);
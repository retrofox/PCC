	ALTER TABLE `articles`
ADD (	`extraid` varchar(8) default NULL,
	`page_extra` varchar(8) default NULL,
	`show_on_home` enum('YES','NO') default 'YES',
	`show_in_subcats` enum('YES','NO') default 'NO',
	`artorder` smallint(6) NOT NULL default '0',
	`visible` varchar(6) default 'YES',
	`default_page` varchar(6) default 'NO'
	);

CREATE TABLE `extras` (
	`id` int(8) primary key auto_increment,
	`name` varchar(40) NOT NULL,
	`seftitle` varchar(100) default NULL,
	`description` varchar(100) NOT NULL
);

INSERT INTO `extras` VALUES (1, 'Extra', 'extra', 'The default extra');

ALTER TABLE `categories`
ADD (`subcat` int(8) NOT NULL default '0' );

ALTER TABLE `settings`
 MODIFY `value` varchar(255) not null;
	INSERT INTO `settings` VALUES ('', 'show_cat_names', '');
	INSERT INTO `settings` VALUES ('', 'mail_on_comments', '');
	INSERT INTO `settings` VALUES ('', 'comment_repost_timer', '20');
	INSERT INTO `settings` VALUES ('', 'enable_comments', 'NO');
	INSERT INTO `settings` VALUES ('', 'enable_extras', 'NO');
	INSERT INTO `settings` VALUES ('', 'last_date', NOW());
	INSERT INTO `settings` VALUES ('', 'file_extensions', 'phps,php,txt,inc,htm,html');
	INSERT INTO `settings` VALUES ('', 'allowed_files', 'php,htm,html,txt,inc,css,js,swf');
	INSERT INTO `settings` VALUES ('', 'allowed_images', 'gif,jpg,jpeg,png');

			-- SPECIAL KEYS

	ALTER TABLE `articles` ADD INDEX ( `show_on_home` );
	ALTER TABLE `comments` ADD INDEX ( `articleid` );
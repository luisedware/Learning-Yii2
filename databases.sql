# 创建管理员表
DROP TABLE
IF EXISTS `shop_admin`;

CREATE TABLE
IF NOT EXISTS `shop_admin`(
	`adminId` INT UNSIGNED NOT NULL auto_increment COMMENT '主键 ID' ,
	`adminUser` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '管理员账号' ,
	`adminPass` CHAR(32) NOT NULL DEFAULT '' COMMENT '管理员密码' ,
	`adminEmail` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '管理员电子邮箱' ,
	`loginTime` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '登录时间' ,
	`loginIP` BIGINT NOT NULL DEFAULT 0 COMMENT '登录 IP' ,
	`createdAt` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间' ,
	PRIMARY KEY(`adminId`) ,
	UNIQUE shop_admin_adminUser_adminPass(`adminuser` , `adminPass`) ,
	UNIQUE shop_admin_adminUser_adminEmail(`adminuser` , `adminEmail`)
) ENGINE = INNODB DEFAULT charset = utf8;

INSERT INTO `shop_admin`(
	adminUser ,
	adminPass ,
	adminEmail ,
	createdAt
)
VALUE
	(
		'admin' ,
		md5(123456) ,
		'506510463@qq.com' ,
		unix_timestamp()
	);

# 创建会员表
DROP TABLE
IF EXISTS shop_user;

CREATE TABLE
IF NOT EXISTS shop_user(
	userId BIGINT UNSIGNED NOT NULL auto_increment COMMENT '主键 ID' ,
	userName VARCHAR(32) NOT NULL DEFAULT '' ,
	userPass CHAR(32) NOT NULL DEFAULT '' ,
	userEmail VARCHAR(100) NOT NULL DEFAULT '' ,
	createdAt INT UNSIGNED NOT NULL DEFAULT 0 ,
	UNIQUE shop_user_username_userpass(userName , userPass) ,
	UNIQUE shop_user_useremail_userpass(userEmail , userPass) ,
	PRIMARY KEY(userId)
) ENGINE = INNODB DEFAULT charset = utf8;

# 创建会员详情表
DROP TABLE
IF EXISTS shop_profile;

CREATE TABLE
IF NOT EXISTS shop_profile(
	id BIGINT UNSIGNED NOT NULL auto_increment COMMENT '主键 ID' ,
	trueName VARCHAR(32) NOT NULL DEFAULT '' ,
	age TINYINT UNSIGNED NOT NULL DEFAULT 0 ,
	sex ENUM('0' , '1' , '2') NOT NULL DEFAULT '0' ,
	birthday date NOT NULL DEFAULT '2016-01-01' ,
	nickname VARCHAR(32) NOT NULL DEFAULT '' ,
	company VARCHAR(100) NOT NULL DEFAULT '' ,
	userId BIGINT UNSIGNED NOT NULL DEFAULT 0 ,
	createdAt INT UNSIGNED NOT NULL DEFAULT 0 ,
	PRIMARY KEY(id) ,
	UNIQUE shop_profile_userid(userId)
) ENGINE = INNODB DEFAULT charset = utf8;
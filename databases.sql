# 创建管理员表
DROP TABLE
IF EXISTS `shop_admin`;

CREATE TABLE
IF NOT EXISTS `shop_admin` (
  `adminId`    INT UNSIGNED NOT NULL AUTO_INCREMENT
  COMMENT '主键 ID',
  `adminUser`  VARCHAR(32)  NOT NULL DEFAULT ''
  COMMENT '管理员账号',
  `adminPass`  CHAR(32)     NOT NULL DEFAULT ''
  COMMENT '管理员密码',
  `adminEmail` VARCHAR(50)  NOT NULL DEFAULT ''
  COMMENT '管理员电子邮箱',
  `loginTime`  INT UNSIGNED NOT NULL DEFAULT 0
  COMMENT '登录时间',
  `loginIP`    BIGINT       NOT NULL DEFAULT 0
  COMMENT '登录 IP',
  `createdAt`  INT UNSIGNED NOT NULL DEFAULT 0
  COMMENT '创建时间',
  PRIMARY KEY (`adminId`),
  UNIQUE shop_admin_adminUser_adminPass(`adminuser`, `adminPass`),
  UNIQUE shop_admin_adminUser_adminEmail(`adminuser`, `adminEmail`)
)
  ENGINE = INNODB
  DEFAULT CHARSET = utf8;

INSERT INTO `shop_admin` (
  adminUser,
  adminPass,
  adminEmail,
  createdAt
)
  VALUE
  (
    'admin',
    md5(123456),
    '506510463@qq.com',
    unix_timestamp()
  );

# 创建会员表
DROP TABLE
IF EXISTS shop_user;

CREATE TABLE
IF NOT EXISTS shop_user (
  userId    BIGINT UNSIGNED NOT NULL AUTO_INCREMENT
  COMMENT '主键 ID',
  userName  VARCHAR(32)     NOT NULL DEFAULT ''
  COMMENT '用户名称',
  userPass  CHAR(32)        NOT NULL DEFAULT ''
  COMMENT '用户密码',
  userEmail VARCHAR(100)    NOT NULL DEFAULT ''
  COMMENT '用户邮箱',
  createdAt INT UNSIGNED    NOT NULL DEFAULT 0
  COMMENT '用户创建时间',
  UNIQUE shop_user_userName_userPass(userName, userPass),
  UNIQUE shop_user_userEmail_userPass(userEmail, userPass),
  PRIMARY KEY (userId)
)
  ENGINE = INNODB
  DEFAULT CHARSET = utf8;

# 创建会员详情表
DROP TABLE
IF EXISTS shop_profile;

CREATE TABLE
IF NOT EXISTS shop_profile (
  id        BIGINT UNSIGNED     NOT NULL AUTO_INCREMENT
  COMMENT '主键 ID',
  trueName  VARCHAR(32)         NOT NULL DEFAULT ''
  COMMENT '真实姓名',
  age       TINYINT UNSIGNED    NOT NULL DEFAULT 0
  COMMENT '命令',
  sex       ENUM('0', '1', '2') NOT NULL DEFAULT '0'
  COMMENT '性别',
  birthday  DATE                NOT NULL DEFAULT '2016-01-01'
  COMMENT '生日',
  nickName  VARCHAR(32)         NOT NULL DEFAULT ''
  COMMENT '昵称',
  company   VARCHAR(100)        NOT NULL DEFAULT ''
  COMMENT '公司',
  userId    BIGINT UNSIGNED     NOT NULL DEFAULT 0
  COMMENT '用户 ID',
  createdAt INT UNSIGNED        NOT NULL DEFAULT 0
  COMMENT '创建时间',
  PRIMARY KEY (id),
  UNIQUE shop_profile_userId(userId)
)
  ENGINE = INNODB
  DEFAULT CHARSET = utf8;

# 创建分类表
DROP TABLE
IF EXISTS shop_category;

CREATE TABLE
IF NOT EXISTS shop_category (
  cateId    BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  title     VARCHAR(32)     NOT NULL DEFAULT '',
  parentId  BIGINT UNSIGNED NOT NULL DEFAULT 0,
  createdAt INT UNSIGNED    NOT NULL DEFAULT 0,
  PRIMARY KEY (cateId),
  KEY shop_category_parentId(parentId)
)
  ENGINE = INNODB
  DEFAULT CHARSET = utf8;

# 创建商品表
DROP TABLE
IF EXISTS shop_product;

CREATE TABLE
IF NOT EXISTS shop_product(
  productId BIGINT UNSIGNED NOT NULL auto_increment COMMENT "商品主键 ID" ,
  cateId BIGINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "分类 ID" ,
  title VARCHAR(200) NOT NULL DEFAULT '' COMMENT "商品标题" ,
  descr text COMMENT "商品描述" ,
  num BIGINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "商品库存" ,
  price DECIMAL(10 , 2) NOT NULL DEFAULT 00000000.00 COMMENT "商品售价" ,
  cover VARCHAR(200) NOT NULL DEFAULT '' COMMENT "商品封面图片" ,
  pics text COMMENT "商品所有图片" ,
  isSale ENUM('0' , '1') NOT NULL DEFAULT '0' COMMENT "是否促销" ,
  salePrice DECIMAL(10 , 2) NOT NULL DEFAULT 00000000.00 COMMENT "促销价格" ,
  isHot ENUM('0' , '1') NOT NULL DEFAULT '0' COMMENT "是否热卖" ,
  createdAt INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "商品创建时间" ,
  PRIMARY KEY(productId) ,
  KEY shop_product_cateId(cateId)
) ENGINE = INNODB DEFAULT CHARSET = utf8;
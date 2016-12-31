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
IF NOT EXISTS shop_product (
  productId BIGINT UNSIGNED NOT NULL AUTO_INCREMENT
  COMMENT '商品主键 ID',
  cateId    BIGINT UNSIGNED NOT NULL DEFAULT 0
  COMMENT '分类 ID',
  title     VARCHAR(200)    NOT NULL DEFAULT ''
  COMMENT '商品标题',
  descr     TEXT COMMENT '商品描述',
  num       BIGINT UNSIGNED NOT NULL DEFAULT 0
  COMMENT '商品库存',
  price     DECIMAL(10, 2)  NOT NULL DEFAULT 00000000.00
  COMMENT '商品售价',
  cover     VARCHAR(200)    NOT NULL DEFAULT ''
  COMMENT '商品封面图片',
  pics      TEXT COMMENT '商品所有图片',
  isSale    ENUM('0', '1')  NOT NULL DEFAULT '0'
  COMMENT '是否促销',
  salePrice DECIMAL(10, 2)  NOT NULL DEFAULT 00000000.00
  COMMENT '促销价格',
  isHot     ENUM('0', '1')  NOT NULL DEFAULT '0'
  COMMENT '是否热卖',
  createdAt INT UNSIGNED    NOT NULL DEFAULT 0
  COMMENT '商品创建时间',
  PRIMARY KEY (productId),
  KEY shop_product_cateId(cateId)
)
  ENGINE = INNODB
  DEFAULT CHARSET = utf8;

INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('前端开发', '0', '1482391487');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('后端开发', '0', '1482391492');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('移动开发', '0', '1483151192');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('数据库', '0', '1483151199');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('云计算&大数据', '0', '1483151212');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('运维&测试', '0', '1483151220');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('视觉设计', '0', '1483151227');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('HTML 5 + CSS 3', '1', '1483151274');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('JavaScript', '1', '1483151281');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('jQuery', '1', '1483151286');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('Node.js', '1', '1483151315');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('AngularJS', '1', '1483151321');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('Bootstrap', '1', '1483151326');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('React', '1', '1483151331');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('Sass', '1', '1483151337');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('Vue.js', '1', '1483151347');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('WebApp', '1', '1483151353');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('PHP', '2', '1483151434');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('Java', '2', '1483151442');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('Python', '2', '1483151447');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('C', '2', '1483151452');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('C++', '2', '1483151457');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('Go', '2', '1483151464');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('C#', '2', '1483151471');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('Ruby', '2', '1483151480');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('Android', '3', '1483152015');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('iOS', '3', '1483152027');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('Unity 3D', '3', '1483152034');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('Cocos2d-x', '3', '1483152040');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('MySQL', '4', '1483152073');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('MongoDB', '4', '1483152077');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('Oracle', '4', '1483152082');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('SQL Serve', '4', '1483152088');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('Photoshop', '7', '1483152263');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('Maya', '7', '1483152268');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('Premiere', '7', '1483152273');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('ZBrush', '7', '1483152279');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('测试', '6', '1483152288');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('Linux', '6', '1483152294');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('大数据', '5', '1483152304');
INSERT INTO `shop_category` (`title`, `parentId`, `createdAt`) VALUES ('云计算', '5', '1483152311');

# 创建购物车
DROP TABLE
IF EXISTS shop_cart;

CREATE TABLE
IF NOT EXISTS shop_cart(
  cartId BIGINT UNSIGNED NOT NULL auto_increment PRIMARY KEY ,
  productId BIGINT UNSIGNED NOT NULL DEFAULT 0 ,
  price DECIMAL(10 , 2) NOT NULL DEFAULT '0.00' ,
  userId BIGINT UNSIGNED NOT NULL DEFAULT '0' ,
  createdAt INT UNSIGNED NOT NULL DEFAULT '0' ,
  KEY shop_cart_productId(productId) ,
  KEY shop_cart_userId(userId)
) ENGINE = INNODB DEFAULT CHARSET = utf8;
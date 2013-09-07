CREATE TABLE IF NOT EXISTS `modules` (
  `id`               INT(5)       NOT NULL AUTO_INCREMENT,
  `key`              VARCHAR(100) NOT NULL,
  `namespace`        VARCHAR(100) NOT NULL,
  `fc_action`        VARCHAR(100) NOT NULL,
  `menu_template`    VARCHAR(100) NOT NULL,
  `content_template` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
)
  ENGINE =MyISAM
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =2;

INSERT INTO `modules` (`id`, `key`, `namespace`, `fc_action`, `menu_template`, `content_template`) VALUES
(1, 'news', 'mano::modules::news', 'NewsAction', 'navi', 'content');


CREATE TABLE IF NOT EXISTS `property` (
  `property_UUID` char(48) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `property_name` varchar(48) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `property_type` tinyint(1) NOT NULL,
  `add_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`property_UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `thing_property` (
  `thing_UUID` char(48) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `property_UUID` char(48) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `add_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `thing_time` (
  `uuid` char(48) COLLATE utf8_unicode_ci NOT NULL,
  `time` bigint(8) NOT NULL,
  `time_type` tinyint(1) NOT NULL,
  `time_limit` int(4) DEFAULT NULL,
  `time_limit_type` tinyint(1) DEFAULT NULL,
  `thing` text COLLATE utf8_unicode_ci NOT NULL,
  `related_number1` int(4) DEFAULT NULL,
  `related_number2` int(4) DEFAULT NULL,
  `related_number3` int(4) DEFAULT NULL,
  `related_number4` int(4) DEFAULT NULL,
  `add_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `public_tag` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



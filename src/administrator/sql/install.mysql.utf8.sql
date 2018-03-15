CREATE TABLE IF NOT EXISTS `#__sv_events_lite_events` (
  `event_id` int(11) UNSIGNED NOT NULL,
  `ordering` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `text2` text NOT NULL,
  `datetime_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `datetime_end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `datetime_end_application` datetime DEFAULT NULL,
  `show_time` int(2) NOT NULL DEFAULT '1',
  `datetime_start_from` int(2) NOT NULL DEFAULT '0',
  `language` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '*',
  `categories` text CHARACTER SET utf8mb4 NOT NULL,
  `application_form` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `featured` int(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__sv_events_lite_categories` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `image` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `color` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'nur Themencats',
  `type` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `ordering` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `state` int(3) NOT NULL DEFAULT '1',
  `language` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '*',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8_general_ci;

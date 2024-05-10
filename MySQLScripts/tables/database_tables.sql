/* schema creating for testing (optional)*/
drop schema if exists crowdcrowd;
create schema crowdcrowd;
use crowdcrowd;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
);
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
);
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_user_id_foreign` (`user_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);
DROP TABLE IF EXISTS `workshop`;
CREATE TABLE `workshop` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `nbparticipantsmax` int(11) NOT NULL,
  `nbparticipants` int(11) NOT NULL DEFAULT '0',
  `monitor_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workshop_key_index` (`key`)
);
DROP TABLE IF EXISTS `participant_workshop`;
CREATE TABLE `participant_workshop` (
  `participant_id` bigint(20) unsigned NOT NULL,
  `workshop_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `participant_workshop_participant_id_index` (`participant_id`),
  KEY `participant_workshop_workshop_id_index` (`workshop_id`),
  CONSTRAINT `participant_workshop_participant_id_foreign` FOREIGN KEY (`participant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `participant_workshop_workshop_id_foreign` FOREIGN KEY (`workshop_id`) REFERENCES `workshop` (`id`) ON DELETE CASCADE
);
DROP TABLE IF EXISTS `ideas`;
CREATE TABLE `ideas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `participant_id` int(11) NOT NULL,
  `workshop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idea` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  `voted` int(11) NOT NULL DEFAULT '0',
  `score` int(11) NOT NULL,
  `taken` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);
DROP TABLE IF EXISTS `idea_participant`;
CREATE TABLE `idea_participant` (
  `participants_id` bigint(20) unsigned NOT NULL,
  `idea_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `idea_participant_participants_id_index` (`participants_id`),
  KEY `idea_participant_idea_id_index` (`idea_id`),
  CONSTRAINT `idea_participant_idea_id_foreign` FOREIGN KEY (`idea_id`) REFERENCES `ideas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `idea_participant_participants_id_foreign` FOREIGN KEY (`participants_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);
DROP TABLE IF EXISTS `participant_idea_original`;
CREATE TABLE `participant_idea_original` (
  `id_participant` bigint(20) unsigned NOT NULL,
  `id_idea` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `participant_idea_original_id_participant_index` (`id_participant`),
  KEY `participant_idea_original_id_idea_index` (`id_idea`),
  CONSTRAINT `participant_idea_original_id_idea_foreign` FOREIGN KEY (`id_idea`) REFERENCES `ideas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `participant_idea_original_id_participant_foreign` FOREIGN KEY (`id_participant`) REFERENCES `users` (`id`) ON DELETE CASCADE
);
DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idea_id` bigint(20) unsigned NOT NULL,
  `monitor_id` bigint(20) unsigned NOT NULL,
  `workshop_id` bigint(20) unsigned NOT NULL,
  `nbParticipants` bigint(20) unsigned NOT NULL,
  `nbParticipantsmax` bigint(20) unsigned NOT NULL,
  `full` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);


DROP TABLE IF EXISTS `users_group`;
CREATE TABLE `users_group` (
  `user_id` bigint(20) unsigned NOT NULL,
  `group_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `users_group_user_id_index` (`user_id`),
  KEY `users_group_group_id_index` (`group_id`),
  CONSTRAINT `users_group_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `users_group_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `preferences`;
CREATE TABLE `preferences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enable` tinyint(1) DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripton` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `preferences_id_unique` (`id`),
  UNIQUE KEY `preferences_name_unique` (`name`)
);
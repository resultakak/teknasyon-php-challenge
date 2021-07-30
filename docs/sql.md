Mobile Application Subscription Managment API
=======

## SQL Structure

```sql

CREATE TABLE `api_migrations` (
  `version` bigint NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `app_credentials` (
  `acid` int NOT NULL AUTO_INCREMENT,
  `aid` int NOT NULL,
  `username` varchar(70) NOT NULL,
  `password` varchar(70) NOT NULL,
  `platform` enum('IOS','ANDROID') NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`acid`),
  UNIQUE KEY `acid_aid` (`aid`,`username`),
  CONSTRAINT `app_credentials_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `apps` (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `apps` (
  `aid` int NOT NULL AUTO_INCREMENT,
  `app_id` varchar(70) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`aid`),
  UNIQUE KEY `aid_app_id` (`app_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `credentials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `password` varchar(120) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `device_apps` (
  `daid` int NOT NULL AUTO_INCREMENT,
  `did` int NOT NULL,
  `aid` int NOT NULL,
  `token` varchar(70) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`daid`),
  KEY `daid_did_aid` (`did`,`aid`),
  KEY `aid` (`aid`),
  CONSTRAINT `device_apps_ibfk_1` FOREIGN KEY (`did`) REFERENCES `devices` (`did`),
  CONSTRAINT `device_apps_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `apps` (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `devices` (
  `did` int NOT NULL AUTO_INCREMENT,
  `uid` varchar(70) NOT NULL,
  `language` varchar(20) NOT NULL,
  `platform` enum('IOS','ANDROID') NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`did`),
  UNIQUE KEY `did_uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `mock_migrations` (
  `version` bigint NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `subscriptions` (
  `sid` int NOT NULL AUTO_INCREMENT,
  `daid` int NOT NULL,
  `did` int NOT NULL,
  `aid` int NOT NULL,
  `receipt` varchar(70) NOT NULL,
  `status` tinyint DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `event` enum('started','renewed','canceled') NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sid`),
  KEY `sid_daid` (`daid`),
  KEY `sid_did_aid` (`did`,`aid`),
  KEY `sid_receipt` (`receipt`),
  KEY `aid` (`aid`),
  CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`daid`) REFERENCES `device_apps` (`daid`),
  CONSTRAINT `subscriptions_ibfk_2` FOREIGN KEY (`did`) REFERENCES `devices` (`did`),
  CONSTRAINT `subscriptions_ibfk_3` FOREIGN KEY (`aid`) REFERENCES `apps` (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

```

---
### [Index](index)

Mobile Application Subscription Managment API
=======

## SQL Structure

```sql
         
CREATE TABLE `apps` (
  `id` int NOT NULL AUTO_INCREMENT,
  `app_id` varchar(60) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `name` varchar(60) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `credentials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `password` varchar(120) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `devices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` varchar(60) NOT NULL,
  `app_id` varchar(60) NOT NULL,
  `language` varchar(10) NOT NULL,
  `os` varchar(30) NOT NULL,
  `token` varchar(35) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` bigint DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `phinxlog` (
  `version` bigint NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `subscriptions` (
  `subscribe_id` int NOT NULL AUTO_INCREMENT,
  `device_id` bigint NOT NULL,
  `receipt` varchar(60) NOT NULL,
  `status` tinyint DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`subscribe_id`),
  KEY `subs_receipt_hash` (`receipt`),
  KEY `subs_device_id` (`device_id` DESC)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;
       
```

---
### [Index](index)

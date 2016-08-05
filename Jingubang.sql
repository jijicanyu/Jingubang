--
-- Database: `Jingubang`
--
CREATE DATABASE Jingubang DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
-- --------------------------------------------------------

--
-- 表的结构 `jingubang_admin`
--

CREATE TABLE IF NOT EXISTS `jingubang_admin` (
  `id` SMALLINT(5) unsigned AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `created_time` DATETIME DEFAULT NULL,
  `last_login_time` DATETIME DEFAULT NULL,
  `last_login_ip` VARCHAR(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `jingubang_task`
--

CREATE TABLE IF NOT EXISTS `jingubang_task` (
  `id` INTEGER(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `uid` INTEGER(10) UNSIGNED DEFAULT NULL, # user id
  `url` VARCHAR(512) DEFAULT NULL,          # target url
  `inject_method` VARCHAR(20) DEFAULT NULL, # GET/POST/COOKIE/REFERER
  `params` VARCHAR(512) DEFAULT NULL        # POST params
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `jingubang_result`
--

CREATE TABLE IF NOT EXISTS `jingubang_result` (
  `id` INTEGER(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `task_id` INTEGER(10) UNSIGNED DEFAULT NULL,
  `is_inject` BOOL DEFAULT FALSE,
  `type` varchar(64) DEFAULT NULL,
  `payloads` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `jingubang_user`
--

CREATE TABLE IF NOT EXISTS `jingubang_user` (
  `id` INTEGER(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `created_time` DATETIME DEFAULT NULL,
  `last_login_time` DATETIME DEFAULT NULL,
  `last_login_ip` VARCHAR(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

# TODO: 考虑增加LOG表，记录注入时的log
-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2022 at 12:41 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `npmsdb`
--
CREATE DATABASE IF NOT EXISTS `npmsdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci;
USE `npmsdb`;

-- --------------------------------------------------------

--
-- Table structure for table `alarms`
--

DROP TABLE IF EXISTS `alarms`;
CREATE TABLE IF NOT EXISTS `alarms` (
  `NidAlarm` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `NidMaster` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `AlarmSubject` varchar(50) COLLATE utf8mb4_persian_ci NOT NULL,
  `AlarmStatus` tinyint(4) NOT NULL,
  `Description` varchar(8000) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  PRIMARY KEY (`NidMaster`,`AlarmSubject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `alarms`
--

TRUNCATE TABLE `alarms`;
-- --------------------------------------------------------

--
-- Table structure for table `data_files`
--

DROP TABLE IF EXISTS `data_files`;
CREATE TABLE IF NOT EXISTS `data_files` (
  `NidFile` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `NidMaster` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `MasterType` int(11) NOT NULL,
  `FilePath` text COLLATE utf8mb4_persian_ci NOT NULL,
  `FileName` varchar(8000) COLLATE utf8mb4_persian_ci NOT NULL,
  `FileExtension` varchar(25) COLLATE utf8mb4_persian_ci NOT NULL,
  `IsDeleted` tinyint(1) NOT NULL,
  `CreateDate` datetime NOT NULL,
  `DeleteDate` datetime DEFAULT NULL,
  PRIMARY KEY (`NidFile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `data_files`
--

TRUNCATE TABLE `data_files`;
-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `NidLog` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `UserId` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `Username` varchar(50) COLLATE utf8mb4_persian_ci NOT NULL,
  `LogDate` varchar(10) COLLATE utf8mb4_persian_ci NOT NULL,
  `IP` varchar(20) COLLATE utf8mb4_persian_ci NOT NULL,
  `LogTime` varchar(8) COLLATE utf8mb4_persian_ci NOT NULL,
  `ActionId` int(11) NOT NULL,
  `Description` text COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `LogStatus` tinyint(4) NOT NULL,
  `ImportanceLevel` tinyint(4) NOT NULL,
  `ConfidentialLevel` tinyint(4) NOT NULL,
  PRIMARY KEY (`NidLog`),
  KEY `logs_logdate_logtime_index` (`LogDate`,`LogTime`),
  KEY `logs_userid_index` (`UserId`),
  KEY `logs_actionid_index` (`ActionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `logs`
--

TRUNCATE TABLE `logs`;
-- --------------------------------------------------------

--
-- Table structure for table `log_action_types`
--

DROP TABLE IF EXISTS `log_action_types`;
CREATE TABLE IF NOT EXISTS `log_action_types` (
  `NidAction` int(11) NOT NULL,
  `Title` varchar(100) COLLATE utf8mb4_persian_ci NOT NULL,
  PRIMARY KEY (`NidAction`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `log_action_types`
--

TRUNCATE TABLE `log_action_types`;
--
-- Dumping data for table `log_action_types`
--

INSERT INTO `log_action_types` (`NidAction`, `Title`) VALUES
(1, 'بازدید صفحه'),
(2, 'ایجاد طرح'),
(3, 'ویرایش طرح'),
(4, 'ایجاد اطلاعات پایه'),
(5, 'ویرایش اطلاعات پایه'),
(6, 'حذف اطلاعات پایه'),
(7, 'ایجاد محقق'),
(8, 'ویرایش محقق'),
(9, 'حذف محقق'),
(10, 'ایجاد کاربر'),
(11, 'ویرایش کاربر'),
(12, 'حذف کاربر'),
(13, 'تغییر کلمه عبور کاربر'),
(14, 'اعمال دسترسی کاربر'),
(15, 'ورود موفق'),
(16, 'ورود ناموفق'),
(17, 'خروج'),
(18, 'خط مشی کلمه عبور'),
(19, 'ایجاد نقش'),
(20, 'حذف نقش'),
(21, 'ایجاد دسترسی نقش'),
(22, 'ویرایش دسترسی نقش'),
(23, 'حذف دسترسی نقش'),
(24, 'اجرای آماری'),
(25, 'ایجاد گزارش آماری'),
(26, 'حذف گزارش آماری'),
(27, 'ارسال پیام موفق'),
(28, 'ارسال پیام ناموفق'),
(29, 'دانلود خروجی پی دی اف گزارش'),
(30, 'پرینت گزارش'),
(31, 'دانلود خروجی پی دی اف گزارش عملکرد کاربران'),
(32, 'پرینت گزارش عملکرد کاربران'),
(33, 'اجرای جستجو پیشرفته'),
(34, 'دانلود خروجی پی دی اف جستجو'),
(35, 'پرینت جستجو'),
(36, 'خارج کردن کاربر'),
(37, 'ویرایش نشست'),
(38, 'ایجاد دسترسی کاربر'),
(39, 'حذف دسترسی کاربر'),
(40, 'پرینت جزییات طرح'),
(100, 'exceptions');

-- --------------------------------------------------------

--
-- Table structure for table `majors`
--

DROP TABLE IF EXISTS `majors`;
CREATE TABLE IF NOT EXISTS `majors` (
  `NidMajor` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `Title` varchar(100) COLLATE utf8mb4_persian_ci NOT NULL,
  PRIMARY KEY (`NidMajor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `majors`
--

TRUNCATE TABLE `majors`;
-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `NidMessage` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `SenderId` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `RecieverId` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `Title` varchar(200) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `MessageContent` varchar(8000) COLLATE utf8mb4_persian_ci NOT NULL,
  `IsRead` tinyint(1) NOT NULL,
  `IsRecieved` tinyint(1) NOT NULL,
  `IsDeleted` tinyint(1) NOT NULL,
  `CreateDate` datetime NOT NULL,
  `ReadDate` datetime DEFAULT NULL,
  `DeleteDate` datetime DEFAULT NULL,
  `IsConfident` tinyint(1) DEFAULT 0,
  `RelatedId` char(38) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  PRIMARY KEY (`NidMessage`),
  KEY `FK_MessageMessage2` (`RelatedId`),
  KEY `messages_senderid_index` (`SenderId`),
  KEY `messages_recieverid_index` (`RecieverId`),
  KEY `messages_createdate_index` (`CreateDate`),
  KEY `messages_nidmessage_relatedid_index` (`NidMessage`,`RelatedId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `messages`
--

TRUNCATE TABLE `messages`;
-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `migrations`
--

TRUNCATE TABLE `migrations`;
--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2021_09_22_101539_create_alarms_table', 1),
(3, '2021_09_22_110242_create_settings_table', 1),
(4, '2021_09_22_133601_create_reports_table', 1),
(5, '2021_09_22_134514_create_report_parameters_table', 1),
(6, '2021_09_22_144547_create_majors_table', 1),
(7, '2021_09_22_144638_create_oreintations_table', 1),
(8, '2021_09_22_144704_create_scholars_table', 1),
(9, '2021_09_22_144736_create_units_table', 1),
(10, '2021_09_22_144751_create_unit_groups_table', 1),
(11, '2021_10_11_192058_create_user_table', 1),
(12, '2021_10_11_192913_create_messages_table', 1),
(13, '2021_10_11_193042_create_resources_table', 1),
(14, '2021_10_11_193143_create_user_permissions_table', 1),
(15, '2021_10_11_193243_create_projects_table', 1),
(16, '2021_10_13_175231_update_setting_table_primary', 2),
(17, '2021_10_13_194517_create_roles_table', 3),
(18, '2021_10_14_093458_add_isadmin_to_roles_table', 4),
(19, '2021_10_14_105310_create_role_permissions_table', 5),
(20, '2021_10_14_160444_add_foreignkey_for_user_in_role_table', 6),
(21, '2021_10_14_161637_drop_isadmin_from_user_table', 7),
(23, '2021_10_15_110030_create_log_action_types_table', 8),
(25, '2021_10_15_115947_create_logs_table', 9),
(26, '2021_12_25_123749_add_columns_to_user_table', 10),
(27, '2021_12_25_184312_create_password_histories_table', 11),
(28, '2021_12_29_171310_add_last_seen_to_user_table', 12),
(29, '2021_12_29_181846_add__force__logout_to_user_table', 13),
(30, '2022_01_03_141448_add_is_confident_to__projects_table', 14),
(31, '2022_01_03_142142_add_is_confident_to_scholars_table', 14),
(32, '2022_01_03_142830_add_is_confident_to_messages_table', 14),
(33, '2022_01_03_152829_add_confident_to_role_permission_table', 15),
(34, '2022_01_07_150753_update_descrription_in_logs_table', 16),
(35, '2022_01_16_162217_update__is_related_column_in_messages_table', 17),
(36, '2022_01_17_150230_add_is_disabled_column_to_project_table', 18),
(37, '2022_02_04_155141_create_data_files_table', 19),
(39, '2022_02_11_104235_update_primary_in_role_permissions_table', 20),
(40, '2022_02_12_061812_update_user_permissions_table', 21),
(41, '2022_02_12_063528_update__resouce_id_in_user_permissions_table', 21),
(42, '2022_02_12_150254_set_default_for__final__approve_in__project_table', 22),
(43, '2022_02_12_154237_set_default_for_incorrectpaswordcount_in_user_table', 23),
(44, '2022_02_14_153715_add_index_to_logs_table', 24),
(45, '2022_02_14_154505_add_index_to_messages_table', 25),
(46, '2022_02_14_154940_add_index_to_password_histories_table', 26),
(47, '2022_02_14_155328_add_index_to_projects_table', 27),
(48, '2022_02_14_155929_add_index_to_reports_table', 28),
(49, '2022_02_14_160447_add_index_to_report_parameters_table', 29),
(50, '2022_02_14_162532_add_index_to_scholars_table', 30),
(51, '2022_02_14_163140_add_index_to_settings_table', 31),
(52, '2022_02_14_163430_add_index_to_user_table', 32);

-- --------------------------------------------------------

--
-- Table structure for table `oreintations`
--

DROP TABLE IF EXISTS `oreintations`;
CREATE TABLE IF NOT EXISTS `oreintations` (
  `NidOreintation` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `MajorId` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `Title` varchar(100) COLLATE utf8mb4_persian_ci NOT NULL,
  PRIMARY KEY (`NidOreintation`),
  KEY `FK_MajorOreintation` (`MajorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `oreintations`
--

TRUNCATE TABLE `oreintations`;
-- --------------------------------------------------------

--
-- Table structure for table `password_histories`
--

DROP TABLE IF EXISTS `password_histories`;
CREATE TABLE IF NOT EXISTS `password_histories` (
  `NidUser` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `Password` varchar(8000) COLLATE utf8mb4_persian_ci NOT NULL,
  `CreateDate` datetime NOT NULL,
  KEY `password_histories_createdate_index` (`CreateDate`),
  KEY `password_histories_password_index` (`Password`(768))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `password_histories`
--

TRUNCATE TABLE `password_histories`;
--
-- Dumping data for table `password_histories`
--

INSERT INTO `password_histories` (`NidUser`, `Password`, `CreateDate`) VALUES
('04daa07c-7a98-4b7e-9ae8-fa59b8f8e743', '$2y$10$Vxll5JAvPv.3oV69iDUpQ.uPMRvf73pXLmrY2OtbOEiXBQGe9VBNu', '2022-03-01 08:58:29');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `personal_access_tokens`
--

TRUNCATE TABLE `personal_access_tokens`;
-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `NidProject` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `ProjectNumber` bigint(20) NOT NULL,
  `Subject` varchar(2500) COLLATE utf8mb4_persian_ci NOT NULL,
  `ProjectStatus` tinyint(4) NOT NULL,
  `ScholarId` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `UnitId` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `GroupId` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `Supervisor` varchar(150) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `SupervisorMobile` varchar(25) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `Advisor` varchar(150) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `AdvisorMobile` varchar(25) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `Referee1` varchar(150) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `Referee2` varchar(150) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `Editor` varchar(150) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `CreateDate` datetime NOT NULL,
  `PersianCreateDate` varchar(25) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `TenPercentLetterDate` varchar(25) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `PreImploymentLetterDate` varchar(25) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `ImploymentDate` varchar(25) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `SecurityLetterDate` varchar(25) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `ThesisDefenceDate` varchar(25) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `ThesisDefenceLetterDate` varchar(25) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `ReducePeriod` tinyint(4) DEFAULT NULL,
  `Commision` varchar(8000) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `HasBookPublish` tinyint(1) DEFAULT NULL,
  `UserId` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `TitleApproved` tinyint(1) DEFAULT NULL,
  `ThirtyPercentLetterDate` varchar(25) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `SixtyPercentLetterDate` varchar(25) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `ATFLetterDate` varchar(25) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `FinalApprove` tinyint(1) NOT NULL DEFAULT 0,
  `IsConfident` tinyint(1) DEFAULT 0,
  `IsDisabled` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`NidProject`),
  KEY `FK_UnitProject` (`UnitId`),
  KEY `FK_UnitGroupProject` (`GroupId`),
  KEY `projects_scholarid_index` (`ScholarId`),
  KEY `projects_userid_index` (`UserId`),
  KEY `projects_createdate_index` (`CreateDate`),
  KEY `projects_persiancreatedate_index` (`PersianCreateDate`),
  KEY `projects_nidproject_isdisabled_index` (`NidProject`,`IsDisabled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `projects`
--

TRUNCATE TABLE `projects`;
-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `NidReport` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `ReportName` varchar(50) COLLATE utf8mb4_persian_ci NOT NULL,
  `ContextId` int(11) NOT NULL,
  `FieldId` int(11) NOT NULL,
  PRIMARY KEY (`NidReport`),
  KEY `reports_contextid_fieldid_index` (`ContextId`,`FieldId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `reports`
--

TRUNCATE TABLE `reports`;
-- --------------------------------------------------------

--
-- Table structure for table `report_parameters`
--

DROP TABLE IF EXISTS `report_parameters`;
CREATE TABLE IF NOT EXISTS `report_parameters` (
  `NidParameter` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `ReportId` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `ParameterKey` varchar(8000) COLLATE utf8mb4_persian_ci NOT NULL,
  `ParameterValue` varchar(8000) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `IsDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `Type` tinyint(4) NOT NULL,
  PRIMARY KEY (`NidParameter`),
  KEY `report_parameters_reportid_index` (`ReportId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `report_parameters`
--

TRUNCATE TABLE `report_parameters`;
-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
CREATE TABLE IF NOT EXISTS `resources` (
  `NidResource` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `ResourceName` varchar(50) COLLATE utf8mb4_persian_ci NOT NULL,
  `ParentId` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `ClassLevel` int(11) DEFAULT NULL,
  `SortNumber` int(11) NOT NULL,
  PRIMARY KEY (`NidResource`),
  KEY `FK_ResourceResource` (`ParentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `resources`
--

TRUNCATE TABLE `resources`;
-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `NidRole` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `Title` varchar(100) COLLATE utf8mb4_persian_ci NOT NULL,
  `CreateDate` datetime NOT NULL,
  `IsAdmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`NidRole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `roles`
--

TRUNCATE TABLE `roles`;
--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`NidRole`, `Title`, `CreateDate`, `IsAdmin`) VALUES
('8bf2698f-77a8-4e4e-bf92-7cd55dd50f3c', 'مدیر سیستم', '2021-10-14 10:41:54', 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `NidPermission` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `RoleId` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `EntityId` int(11) NOT NULL,
  `Create` tinyint(1) NOT NULL DEFAULT 0,
  `Edit` tinyint(1) NOT NULL DEFAULT 0,
  `Delete` tinyint(1) NOT NULL DEFAULT 0,
  `Detail` tinyint(1) NOT NULL DEFAULT 0,
  `List` tinyint(1) NOT NULL DEFAULT 0,
  `Print` tinyint(1) NOT NULL DEFAULT 0,
  `Confident` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`RoleId`,`EntityId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `role_permissions`
--

TRUNCATE TABLE `role_permissions`;
-- --------------------------------------------------------

--
-- Table structure for table `scholars`
--

DROP TABLE IF EXISTS `scholars`;
CREATE TABLE IF NOT EXISTS `scholars` (
  `NidScholar` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `ProfilePicture` varchar(8000) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `FirstName` varchar(75) COLLATE utf8mb4_persian_ci NOT NULL,
  `LastName` varchar(75) COLLATE utf8mb4_persian_ci NOT NULL,
  `NationalCode` varchar(12) COLLATE utf8mb4_persian_ci NOT NULL,
  `BirthDate` varchar(25) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `FatherName` varchar(75) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `Mobile` varchar(25) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `MillitaryStatus` tinyint(4) DEFAULT NULL,
  `GradeId` tinyint(4) NOT NULL,
  `MajorId` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `OreintationId` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `college` tinyint(4) DEFAULT NULL,
  `CollaborationType` tinyint(4) NOT NULL,
  `IsDeleted` tinyint(1) DEFAULT NULL,
  `DeleteDate` datetime DEFAULT NULL,
  `DeleteUser` char(38) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `UserId` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `IsConfident` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`NidScholar`),
  KEY `FK_MajorScholar` (`MajorId`),
  KEY `FK_OreintationScholar` (`OreintationId`),
  KEY `scholars_nidscholar_isdeleted_index` (`NidScholar`,`IsDeleted`),
  KEY `scholars_firstname_lastname_index` (`FirstName`,`LastName`),
  KEY `scholars_userid_index` (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `scholars`
--

TRUNCATE TABLE `scholars`;
-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `NidSetting` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `SettingKey` varchar(100) COLLATE utf8mb4_persian_ci NOT NULL,
  `SettingValue` varchar(250) COLLATE utf8mb4_persian_ci NOT NULL,
  `SettingTitle` varchar(100) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `IsDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`NidSetting`),
  KEY `settings_settingkey_index` (`SettingKey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `settings`
--

TRUNCATE TABLE `settings`;
-- --------------------------------------------------------

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
CREATE TABLE IF NOT EXISTS `units` (
  `NidUnit` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `Title` varchar(100) COLLATE utf8mb4_persian_ci NOT NULL,
  PRIMARY KEY (`NidUnit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `units`
--

TRUNCATE TABLE `units`;
-- --------------------------------------------------------

--
-- Table structure for table `unit_groups`
--

DROP TABLE IF EXISTS `unit_groups`;
CREATE TABLE IF NOT EXISTS `unit_groups` (
  `NidGroup` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `UnitId` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `Title` varchar(100) COLLATE utf8mb4_persian_ci NOT NULL,
  PRIMARY KEY (`NidGroup`),
  KEY `FK_UnitUnitGroup` (`UnitId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `unit_groups`
--

TRUNCATE TABLE `unit_groups`;
-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `NidUser` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `UserName` varchar(100) COLLATE utf8mb4_persian_ci NOT NULL,
  `Password` varchar(8000) COLLATE utf8mb4_persian_ci NOT NULL,
  `FirstName` varchar(100) COLLATE utf8mb4_persian_ci NOT NULL,
  `LastName` varchar(100) COLLATE utf8mb4_persian_ci NOT NULL,
  `CreateDate` datetime NOT NULL,
  `LastLoginDate` datetime DEFAULT NULL,
  `IncorrectPasswordCount` tinyint(1) NOT NULL DEFAULT 0,
  `IsLockedOut` tinyint(1) NOT NULL,
  `IsDisabled` tinyint(1) NOT NULL,
  `ProfilePicture` text COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `RoleId` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `LockoutDeadLine` datetime DEFAULT NULL,
  `LastPasswordChangeDate` datetime DEFAULT NULL,
  `last_seen` timestamp NULL DEFAULT NULL,
  `Force_logout` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`NidUser`),
  KEY `user_username_index` (`UserName`),
  KEY `user_createdate_index` (`CreateDate`),
  KEY `user_lastlogindate_index` (`LastLoginDate`),
  KEY `user_roleid_index` (`RoleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `user`
--

TRUNCATE TABLE `user`;
--
-- Dumping data for table `user`
--

INSERT INTO `user` (`NidUser`, `UserName`, `Password`, `FirstName`, `LastName`, `CreateDate`, `LastLoginDate`, `IncorrectPasswordCount`, `IsLockedOut`, `IsDisabled`, `ProfilePicture`, `RoleId`, `LockoutDeadLine`, `LastPasswordChangeDate`, `last_seen`, `Force_logout`) VALUES
('04daa07c-7a98-4b7e-9ae8-fa59b8f8e743', 'sa', '$2y$10$fEsXJ8jWL4Ext55PY7gYn.qXzlXSKPGPpNJYBtJt1gO5e.0IAnz76', 'system', 'admin', '2022-03-01 08:56:02', '2022-03-01 08:58:39', 0, 0, 0, '', '8bf2698f-77a8-4e4e-bf92-7cd55dd50f3c', NULL, '2022-03-01 08:58:29', '2022-03-01 05:38:36', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
CREATE TABLE IF NOT EXISTS `user_permissions` (
  `NidPermission` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `UserId` char(38) COLLATE utf8mb4_persian_ci NOT NULL,
  `ResourceId` char(255) COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `EntityId` int(11) NOT NULL,
  `Create` tinyint(1) NOT NULL DEFAULT 0,
  `Edit` tinyint(1) NOT NULL DEFAULT 0,
  `Delete` tinyint(1) NOT NULL DEFAULT 0,
  `Detail` tinyint(1) NOT NULL DEFAULT 0,
  `List` tinyint(1) NOT NULL DEFAULT 0,
  `Print` tinyint(1) NOT NULL DEFAULT 0,
  `Confident` tinyint(1) NOT NULL DEFAULT 0,
  KEY `FK_UserUserPermission` (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Truncate table before insert `user_permissions`
--

TRUNCATE TABLE `user_permissions`;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `FK_LogLogAction` FOREIGN KEY (`ActionId`) REFERENCES `log_action_types` (`NidAction`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `FK_MessageMessage2` FOREIGN KEY (`RelatedId`) REFERENCES `messages` (`NidMessage`),
  ADD CONSTRAINT `FK_UserMessage` FOREIGN KEY (`SenderId`) REFERENCES `user` (`NidUser`),
  ADD CONSTRAINT `FK_UserMessage2` FOREIGN KEY (`RecieverId`) REFERENCES `user` (`NidUser`);

--
-- Constraints for table `oreintations`
--
ALTER TABLE `oreintations`
  ADD CONSTRAINT `FK_MajorOreintation` FOREIGN KEY (`MajorId`) REFERENCES `majors` (`NidMajor`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `FK_ScholarProject` FOREIGN KEY (`ScholarId`) REFERENCES `scholars` (`NidScholar`),
  ADD CONSTRAINT `FK_ScholarProject3` FOREIGN KEY (`ScholarId`) REFERENCES `scholars` (`NidScholar`),
  ADD CONSTRAINT `FK_UnitGroupProject` FOREIGN KEY (`GroupId`) REFERENCES `unit_groups` (`NidGroup`),
  ADD CONSTRAINT `FK_UnitProject` FOREIGN KEY (`UnitId`) REFERENCES `units` (`NidUnit`),
  ADD CONSTRAINT `FK_UserProject` FOREIGN KEY (`UserId`) REFERENCES `user` (`NidUser`);

--
-- Constraints for table `report_parameters`
--
ALTER TABLE `report_parameters`
  ADD CONSTRAINT `FK_ReportReportParameter` FOREIGN KEY (`ReportId`) REFERENCES `reports` (`NidReport`) ON DELETE CASCADE;

--
-- Constraints for table `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `FK_ResourceResource` FOREIGN KEY (`ParentId`) REFERENCES `resources` (`NidResource`);

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `FK_RoleRolePermission` FOREIGN KEY (`RoleId`) REFERENCES `roles` (`NidRole`);

--
-- Constraints for table `scholars`
--
ALTER TABLE `scholars`
  ADD CONSTRAINT `FK_MajorScholar` FOREIGN KEY (`MajorId`) REFERENCES `majors` (`NidMajor`),
  ADD CONSTRAINT `FK_OreintationScholar` FOREIGN KEY (`OreintationId`) REFERENCES `oreintations` (`NidOreintation`);

--
-- Constraints for table `unit_groups`
--
ALTER TABLE `unit_groups`
  ADD CONSTRAINT `FK_UnitUnitGroup` FOREIGN KEY (`UnitId`) REFERENCES `units` (`NidUnit`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_UserRole` FOREIGN KEY (`RoleId`) REFERENCES `roles` (`NidRole`);

--
-- Constraints for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `FK_UserUserPermission` FOREIGN KEY (`UserId`) REFERENCES `user` (`NidUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

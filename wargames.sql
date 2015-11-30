-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Generation Time: Nov 28, 2015 at 09:26 PM
-- Server version: 5.6.25
-- PHP Version: 5.6.10



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Table structure for table `Friend`
--

CREATE TABLE IF NOT EXISTS "Friend" (
  "UserGuid" binary(16) NOT NULL,
  "FriendGuid" binary(16) NOT NULL,
  PRIMARY KEY ("UserGuid","FriendGuid"),
  KEY "FriendGuid" ("FriendGuid")
);

-- --------------------------------------------------------

--
-- Table structure for table `Game`
--

CREATE TABLE IF NOT EXISTS "Game" (
  "Guid" binary(16) NOT NULL,
  "SystemGuid" binary(16) NOT NULL,
  "Name" varchar(50) NOT NULL,
  "MaxUsers" tinyint(4) NOT NULL,
  "Public" tinyint(1) NOT NULL,
  PRIMARY KEY ("Guid"),
  UNIQUE KEY "Name" ("Name")
);

-- --------------------------------------------------------

--
-- Table structure for table `Game_User`
--

CREATE TABLE IF NOT EXISTS "Game_User" (
  "GameGuid" binary(16) NOT NULL,
  "UserGuid" binary(16) NOT NULL,
  "Forfeit" tinyint(1) NOT NULL,
  PRIMARY KEY ("GameGuid","UserGuid"),
  KEY "UserGuid" ("UserGuid")
);

-- --------------------------------------------------------

--
-- Table structure for table `Message`
--

CREATE TABLE IF NOT EXISTS "Message" (
  "GameGuid" binary(16) NOT NULL,
  "Index" int(11) NOT NULL AUTO_INCREMENT,
  "UserGuid" binary(16) NOT NULL,
  "Content" text NOT NULL,
  PRIMARY KEY ("GameGuid","Index"),
  UNIQUE KEY "Index" ("Index"),
  KEY "UserGuid" ("UserGuid")
) AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `System`
--

CREATE TABLE IF NOT EXISTS "System" (
  "Guid" binary(16) NOT NULL,
  "Name" varchar(128) NOT NULL,
  PRIMARY KEY ("Guid"),
  UNIQUE KEY "Name" ("Name")
);

-- --------------------------------------------------------

--
-- Table structure for table `Unit`
--

CREATE TABLE IF NOT EXISTS "Unit" (
  "Guid" binary(16) NOT NULL,
  "GameGuid" binary(16) NOT NULL,
  "UserGuid" binary(16) NOT NULL,
  "X" double NOT NULL,
  "Y" double NOT NULL,
  "Z" double NOT NULL,
  "Rotation" double NOT NULL,
  "JsonData" text NOT NULL,
  PRIMARY KEY ("Guid"),
  KEY "GameGuid" ("GameGuid"),
  KEY "UserGuid" ("UserGuid")
);

--
-- Triggers `Unit`
--
DROP TRIGGER IF EXISTS `DefaultUnitGuid`;
DELIMITER //
CREATE TRIGGER `DefaultUnitGuid` BEFORE INSERT ON `Unit`
 FOR EACH ROW SET new.Guid = ordered_uuid(uuid())
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS "User" (
  "Guid" binary(16) NOT NULL,
  "AuthToken" binary(64) DEFAULT NULL,
  "AuthTokenExpires" datetime DEFAULT NULL,
  "Name" varchar(50) NOT NULL,
  "Password" varchar(255) NOT NULL,
  "Email" char(254) NOT NULL,
  PRIMARY KEY ("Guid"),
  UNIQUE KEY "Name" ("Name"),
  UNIQUE KEY "Email" ("Email"),
  UNIQUE KEY "AuthToken" ("AuthToken")
);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Friend`
--
ALTER TABLE `Friend`
  ADD CONSTRAINT "Friend_ibfk_3" FOREIGN KEY ("UserGuid") REFERENCES "User" ("Guid") ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT "Friend_ibfk_4" FOREIGN KEY ("FriendGuid") REFERENCES "User" ("Guid") ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Game_User`
--
ALTER TABLE `Game_User`
  ADD CONSTRAINT "Game_User_ibfk_1" FOREIGN KEY ("GameGuid") REFERENCES "Game" ("Guid") ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT "Game_User_ibfk_2" FOREIGN KEY ("UserGuid") REFERENCES "User" ("Guid") ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Unit`
--
ALTER TABLE `Unit`
  ADD CONSTRAINT "Unit_ibfk_1" FOREIGN KEY ("GameGuid") REFERENCES "Game" ("Guid") ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT "Unit_ibfk_2" FOREIGN KEY ("UserGuid") REFERENCES "User" ("Guid") ON DELETE CASCADE ON UPDATE CASCADE;

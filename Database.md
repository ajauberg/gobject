# Introduction #

  * gClasses - Stores icons and graphical representation
  * gObjects - Stores physical instances
  * gLinks - Stores links between gObjects
  * gStatuses - Stores status parameters controlling the node status, color and inactivity timeouts
  * gPerformances - Stores performance parameters controlling the color and width of the links
  * gProperties - Stores optional gObject parameters
  * gUsers - Stores users with username and password

  * gLogs - Stores logs from status changes

  * gLogTRXDays - Stores transmission data on a 36 hours basis
  * gLogTRXWeeks - Stores transmission data on a 10 days basis
  * gLogTRXMonths - Stores transmission data on a 6 weeks basis
  * gLogTRXYears - Stores transmission data on a 18 months basis

  * gLogSNRDays - Stores Signal, Noise and Quality data on a 36 hours basis
  * gLogSNRWeeks - Stores Signal, Noise and Quality data on a 10 days basis
  * gLogSNRMonths - Stores Signal, Noise and Quality data on a 6 weeks basis
  * gLogTRXYears - Stores Signal, Noise and Quality data on a 18 months basis

# gClasses #

```
-- phpMyAdmin SQL Dump
-- version 2.11.1
-- http://www.phpmyadmin.net
--
-- Tjenerversjon: 5.0.27
-- PHP-Versjon: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `gClasses`
--

CREATE TABLE IF NOT EXISTS `gClasses` (
  `id` int(11) NOT NULL auto_increment,
  `Name` varchar(30) NOT NULL,
  `Icon` varchar(80) NOT NULL COMMENT 'Pathname to graphic icon',
  `Image` varchar(80) NOT NULL COMMENT 'Pathname to graphic file',
  `Shadow` varchar(80) NOT NULL COMMENT 'Pathname to graphic file',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dataark for tabell `gClasses`
--

INSERT INTO `gClasses` (`id`, `Name`, `Icon`, `Image`, `Shadow`) VALUES
(1, 'Base Class', 'icon.php', 'markers/pushpins/webhues/', 'markers/pushpins/templates/shadow50.png');
```


# gPerformances #

```
-- phpMyAdmin SQL Dump
-- version 2.11.1
-- http://www.phpmyadmin.net
--
-- Tjenerversjon: 5.0.27
-- PHP-Versjon: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `gPerformances`
--

CREATE TABLE IF NOT EXISTS `gPerformances` (
  `id` int(11) NOT NULL auto_increment,
  `Name` varchar(30) NOT NULL,
  `HTMLColorCode` varchar(20) NOT NULL,
  `Width` int(11) NOT NULL,
  `Opacity` float NOT NULL,
  `Rate` int(11) NOT NULL,
  `SNR` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dataark for tabell `gPerformances`
--

INSERT INTO `gPerformances` (`id`, `Name`, `HTMLColorCode`, `Width`, `Opacity`, `Rate`, `SNR`) VALUES
(1, 'No Connection', '#FF0000', 3, 0.1, 0, 0),
(2, 'Very Low', '#FF0000', 3, 0.5, 1000000, 6),
(3, 'Very Low', '#FF9900', 6, 0.75, 2000000, 8),
(4, 'Very Low', '#FF9900', 8, 0.75, 11000000, 10),
(5, 'Low', '#FFFF00', 8, 0.75, 11000000, 15),
(6, 'Good', '#FFFF00', 10, 0.75, 11000000, 20),
(7, 'Very Good', '#00FF00', 12, 0.75, 11000000, 25),
(8, 'Excellent', '#00FF00', 15, 0.75, 11000000, 96);
```


# gStatuses #

```
-- phpMyAdmin SQL Dump
-- version 2.11.1
-- http://www.phpmyadmin.net
--
-- Tjenerversjon: 5.0.27
-- PHP-Versjon: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `gStatuses`
--

CREATE TABLE IF NOT EXISTS `gStatuses` (
  `id` int(11) NOT NULL auto_increment,
  `Name` varchar(30) NOT NULL,
  `Color` varchar(20) NOT NULL,
  `HTMLColorCode` varchar(20) NOT NULL,
  `MarkerColorCode` varchar(20) NOT NULL,
  `InactivityThreshold` varchar(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dataark for tabell `gStatuses`
--

INSERT INTO `gStatuses` (`id`, `Name`, `Color`, `HTMLColorCode`, `MarkerColorCode`, `InactivityThreshold`) VALUES
(1, 'Normal', 'Green', '#00FF00', '070', '600'),
(2, 'Warning', 'Violet', '#FF00FF', '165', '1800'),
(3, 'Minor', 'Yellow', '#FFFF00', '036', '3600'),
(4, 'Major', 'Orange', '#FF9900', '022', '7200'),
(5, 'Critical', 'Red', '#FF0000', '010', '86400'),
(6, 'Down', 'Blue', '#000000', '149', '604800');
```
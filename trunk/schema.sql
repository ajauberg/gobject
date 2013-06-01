
--
-- Table structure for table `gClasses`
--

CREATE TABLE IF NOT EXISTS `gClasses` (
  `id` int(11) NOT NULL auto_increment,
  `Name` varchar(30) NOT NULL,
  `Icon` varchar(80) NOT NULL COMMENT 'Pathname to graphic icon',
  `Image` varchar(80) NOT NULL COMMENT 'Pathname to graphic file',
  `Shadow` varchar(80) NOT NULL COMMENT 'Pathname to graphic file',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

--
-- Dumping data for table `gClasses`
--

INSERT INTO `gClasses` (`id`, `Name`, `Icon`, `Image`, `Shadow`) VALUES
(1, 'Base Class', 'icon.php', 'markers/pushpins/webhues/', 'markers/pushpins/templates/shadow50.png'),
(2, 'Template', 'markers/pushpins/templates/marker.png', 'markers/pushpins/templates/marker.png', 'markers/pushpins/templates/shadow50.png');

-- --------------------------------------------------------

--
-- Table structure for table `gLinks`
--

CREATE TABLE IF NOT EXISTS `gLinks` (
  `id` int(11) NOT NULL auto_increment,
  `Name` varchar(30) NOT NULL,
  `refOid1` int(11) NOT NULL COMMENT 'First Object reference',
  `Signal1` tinyint(4) NOT NULL,
  `Noise1` tinyint(4) NOT NULL,
  `Quality1` tinyint(4) NOT NULL,
  `refOid2` int(11) NOT NULL COMMENT 'Second Object reference',
  `Signal2` tinyint(4) NOT NULL,
  `Noise2` tinyint(4) NOT NULL,
  `Quality2` tinyint(4) NOT NULL,
  `refPid` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `refOid1` (`refOid1`,`refOid2`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gLogDays`
--

CREATE TABLE IF NOT EXISTS `gLogDays` (
  `id` int(11) NOT NULL auto_increment,
  `refOid` int(11) NOT NULL,
  `Timestamp` datetime NOT NULL,
  `MAC` varchar(17) NOT NULL,
  `SIG` tinyint(4) NOT NULL,
  `NOISE` tinyint(4) NOT NULL,
  `QUAL` varchar(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gLogMonths`
--

CREATE TABLE IF NOT EXISTS `gLogMonths` (
  `id` int(11) NOT NULL auto_increment,
  `refOid` int(11) NOT NULL,
  `Timestamp` datetime NOT NULL,
  `MAC` varchar(17) NOT NULL,
  `SIG` tinyint(4) NOT NULL,
  `NOISE` tinyint(4) NOT NULL,
  `QUAL` varchar(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gLogs`
--

CREATE TABLE IF NOT EXISTS `gLogs` (
  `id` int(11) NOT NULL auto_increment,
  `refOid` int(11) NOT NULL,
  `Timestamp` datetime NOT NULL,
  `Message` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gLogTRXDays`
--

CREATE TABLE IF NOT EXISTS `gLogTRXDays` (
  `id` int(11) NOT NULL auto_increment,
  `refOid` int(11) NOT NULL,
  `Timestamp` datetime NOT NULL,
  `RATE` int(11) NOT NULL,
  `UPTIME` int(11) NOT NULL,
  `CLI` int(11) NOT NULL,
  `RXP` int(11) NOT NULL,
  `RXe` int(11) NOT NULL,
  `RXd` int(11) NOT NULL,
  `RXo` int(11) NOT NULL,
  `RXf` int(11) NOT NULL,
  `RXb` int(11) NOT NULL,
  `TXP` int(11) NOT NULL,
  `TXe` int(11) NOT NULL,
  `TXd` int(11) NOT NULL,
  `TXo` int(11) NOT NULL,
  `TXc` int(11) NOT NULL,
  `TXco` int(11) NOT NULL,
  `TXq` int(11) NOT NULL,
  `TXb` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gLogTRXMonths`
--

CREATE TABLE IF NOT EXISTS `gLogTRXMonths` (
  `id` int(11) NOT NULL auto_increment,
  `refOid` int(11) NOT NULL,
  `Timestamp` datetime NOT NULL,
  `RATE` int(11) NOT NULL,
  `UPTIME` int(11) NOT NULL,
  `CLI` int(11) NOT NULL,
  `RXP` int(11) NOT NULL,
  `RXe` int(11) NOT NULL,
  `RXd` int(11) NOT NULL,
  `RXo` int(11) NOT NULL,
  `RXf` int(11) NOT NULL,
  `RXb` int(11) NOT NULL,
  `TXP` int(11) NOT NULL,
  `TXe` int(11) NOT NULL,
  `TXd` int(11) NOT NULL,
  `TXo` int(11) NOT NULL,
  `TXc` int(11) NOT NULL,
  `TXco` int(11) NOT NULL,
  `TXq` int(11) NOT NULL,
  `TXb` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gLogTRXWeeks`
--

CREATE TABLE IF NOT EXISTS `gLogTRXWeeks` (
  `id` int(11) NOT NULL auto_increment,
  `refOid` int(11) NOT NULL,
  `Timestamp` datetime NOT NULL,
  `RATE` int(11) NOT NULL,
  `UPTIME` int(11) NOT NULL,
  `CLI` int(11) NOT NULL,
  `RXP` int(11) NOT NULL,
  `RXe` int(11) NOT NULL,
  `RXd` int(11) NOT NULL,
  `RXo` int(11) NOT NULL,
  `RXf` int(11) NOT NULL,
  `RXb` int(11) NOT NULL,
  `TXP` int(11) NOT NULL,
  `TXe` int(11) NOT NULL,
  `TXd` int(11) NOT NULL,
  `TXo` int(11) NOT NULL,
  `TXc` int(11) NOT NULL,
  `TXco` int(11) NOT NULL,
  `TXq` int(11) NOT NULL,
  `TXb` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=199022 ;

-- --------------------------------------------------------

--
-- Table structure for table `gLogTRXYears`
--

CREATE TABLE IF NOT EXISTS `gLogTRXYears` (
  `id` int(11) NOT NULL auto_increment,
  `refOid` int(11) NOT NULL,
  `Timestamp` datetime NOT NULL,
  `RATE` int(11) NOT NULL,
  `UPTIME` int(11) NOT NULL,
  `CLI` int(11) NOT NULL,
  `RXP` int(11) NOT NULL,
  `RXe` int(11) NOT NULL,
  `RXd` int(11) NOT NULL,
  `RXo` int(11) NOT NULL,
  `RXf` int(11) NOT NULL,
  `RXb` int(11) NOT NULL,
  `TXP` int(11) NOT NULL,
  `TXe` int(11) NOT NULL,
  `TXd` int(11) NOT NULL,
  `TXo` int(11) NOT NULL,
  `TXc` int(11) NOT NULL,
  `TXco` int(11) NOT NULL,
  `TXq` int(11) NOT NULL,
  `TXb` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gLogWeeks`
--

CREATE TABLE IF NOT EXISTS `gLogWeeks` (
  `id` int(11) NOT NULL auto_increment,
  `refOid` int(11) NOT NULL,
  `Timestamp` datetime NOT NULL,
  `MAC` varchar(17) NOT NULL,
  `SIG` tinyint(4) NOT NULL,
  `NOISE` tinyint(4) NOT NULL,
  `QUAL` varchar(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `gLogYears`
--

CREATE TABLE IF NOT EXISTS `gLogYears` (
  `id` int(11) NOT NULL auto_increment,
  `refOid` int(11) NOT NULL,
  `Timestamp` datetime NOT NULL,
  `MAC` varchar(17) NOT NULL,
  `SIG` tinyint(4) NOT NULL,
  `NOISE` tinyint(4) NOT NULL,
  `QUAL` varchar(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gObjects`
--

CREATE TABLE IF NOT EXISTS `gObjects` (
  `id` int(11) NOT NULL auto_increment,
  `Name` varchar(30) NOT NULL,
  `MAC` varchar(17) NOT NULL COMMENT 'MAC Address',
  `IP` varchar(15) NOT NULL,
  `REMOTE_ADDR` varchar(15) NOT NULL,
  `ESSID` varchar(30) NOT NULL,
  `RATE` smallint(6) NOT NULL,
  `UPTIME` int(6) NOT NULL,
  `CLI` tinyint(4) NOT NULL,
  `LastContact` datetime default NULL,
  `Reboot` tinyint(1) NOT NULL default '0',
  `Lat` float(16,12) NOT NULL COMMENT 'Map Latitude',
  `Long` float(16,12) NOT NULL COMMENT 'Map Longitude',
  `refCid` int(11) NOT NULL default '1' COMMENT 'Class reference',
  `refUid` int(11) NOT NULL default '1' COMMENT 'User reference',
  `refSid` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `Ethernet` (`MAC`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gPerformances`
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
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

--
-- Dumping data for table `gPerformances`
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

-- --------------------------------------------------------

--
-- Table structure for table `gProperties`
--

CREATE TABLE IF NOT EXISTS `gProperties` (
  `id` int(11) NOT NULL auto_increment,
  `refOid` int(11) NOT NULL COMMENT 'Object reference',
  `Name` varchar(30) NOT NULL,
  `Value` varchar(80) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gStatuses`
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
-- Dumping data for table `gStatuses`
--

INSERT INTO `gStatuses` (`id`, `Name`, `Color`, `HTMLColorCode`, `MarkerColorCode`, `InactivityThreshold`) VALUES
(1, 'Normal', 'Green', '#00FF00', '070', '600'),
(2, 'Warning', 'Violet', '#FF00FF', '165', '1800'),
(3, 'Minor', 'Yellow', '#FFFF00', '036', '3600'),
(4, 'Major', 'Orange', '#FF9900', '022', '7200'),
(5, 'Critical', 'Red', '#FF0000', '010', '86400'),
(6, 'Down', 'Blue', '#000000', '149', '604800');

-- --------------------------------------------------------

--
-- Table structure for table `gUsers`
--

CREATE TABLE IF NOT EXISTS `gUsers` (
  `id` int(11) NOT NULL auto_increment,
  `Name` varchar(30) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Password` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `gUsers`
--

INSERT INTO `gUsers` (`id`, `Name`, `Username`, `Password`) VALUES
(1, 'Test', 'Test', 'Test');


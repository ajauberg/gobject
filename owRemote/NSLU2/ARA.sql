/*
# res_mysql.conf 
#

[general] 
dbhost = 127.0.0.1 
dbname = asterisk 
dbuser = myuser 
dbpass = mypass 
dbport = 3306 

#
# extconfig.conf
#

sip.conf => mysql,asterisk,ast_config
iaxusers => mysql,asterisk,ast_iax_buddies 
iaxpeers => mysql,asterisk,ast_iax_buddies 
sipusers => mysql,asterisk,ast_sip_buddies 
sippeers => mysql,asterisk,ast_sip_buddies 
extensions => mysql,asterisk,ast_extensions 
voicemail => mysql,asterisk,voicemail_users 
meetme => mysql,asterisk,ast_meetme 
h323 => mysql,asterisk,ast_h323_peers 
queues => mysql,asterisk,ast_queue_table 
queue_members => mysql,asterisk,ast_queue_member_table
*/
# 
# Table structure for table `ast_config` 
# 

CREATE TABLE `ast_config` ( 
 `id` int(11) NOT NULL auto_increment, 
 `cat_metric` int(11) NOT NULL default '0', 
 `var_metric` int(11) NOT NULL default '0', 
 `commented` int(11) NOT NULL default '0', 
 `filename` varchar(128) NOT NULL default '', 
 `category` varchar(128) NOT NULL default 'default', 
 `var_name` varchar(128) NOT NULL default '', 
 `var_val` varchar(128) NOT NULL default '', 
 PRIMARY KEY  (`id`), 
 KEY `filename_comment` (`filename`,`commented`) 
) TYPE=MyISAM; 


# 
# Table structure for table `ast_iax_buddies` 
# 

CREATE TABLE ast_iax_buddies ( 
       name varchar(30) primary key NOT NULL, 
       username varchar(30),  
       type varchar(6) NOT NULL,  
       secret varchar(50),  
       md5secret varchar(32),  
       dbsecret varchar(100),  
       notransfer varchar(10),  
       inkeys varchar(100), 
       outkey varchar(100), 
       auth varchar(100),  
       accountcode varchar(100),  
       amaflags varchar(100),  
       callerid varchar(100),  
       context varchar(100),  
       defaultip varchar(15),  
       host varchar(31) NOT NULL default 'dynamic',  
       language char(5),  
       mailbox varchar(50),  
       deny varchar(95), 
       permit varchar(95),   
       qualify varchar(4),  
       disallow varchar(100),  
       allow varchar(100),  
       ipaddr varchar(15),  
       port integer default 0, 
       regseconds integer default 0 
); 
CREATE UNIQUE INDEX ast_iax_buddies_username_idx ON ast_iax_buddies(username); 


# 
# Table structure for table `ast_sip_buddies` 
# 

CREATE TABLE `ast_sip_buddies` ( 
 `id` int(11) NOT NULL auto_increment, 
 `name` varchar(80) NOT NULL default '', 
 `host` varchar(31) NOT NULL default '', 
 `nat` varchar(5) NOT NULL default 'no', 
 `type` enum('user','peer','friend') NOT NULL default 'friend', 
 `accountcode` varchar(20) default NULL, 
 `amaflags` varchar(13) default NULL, 
 `call-limit` smallint(5) unsigned default NULL, 
 `callgroup` varchar(10) default NULL, 
 `callerid` varchar(80) default NULL, 
 `cancallforward` char(3) default 'yes', 
 `canreinvite` char(3) default 'yes', 
 `context` varchar(80) default NULL, 
 `defaultip` varchar(15) default NULL, 
 `dtmfmode` varchar(7) default NULL, 
 `fromuser` varchar(80) default NULL, 
 `fromdomain` varchar(80) default NULL, 
 `insecure` varchar(4) default NULL, 
 `language` char(2) default NULL, 
 `mailbox` varchar(50) default NULL, 
 `md5secret` varchar(80) default NULL, 
 `deny` varchar(95) default NULL, 
 `permit` varchar(95) default NULL, 
 `mask` varchar(95) default NULL, 
 `musiconhold` varchar(100) default NULL, 
 `pickupgroup` varchar(10) default NULL, 
 `qualify` char(3) default NULL, 
 `regexten` varchar(80) default NULL, 
 `restrictcid` char(3) default NULL, 
 `rtptimeout` char(3) default NULL, 
 `rtpholdtimeout` char(3) default NULL, 
 `secret` varchar(80) default NULL, 
 `setvar` varchar(100) default NULL, 
 `disallow` varchar(100) default 'all', 
 `allow` varchar(100) default 'g729;ilbc;gsm;ulaw;alaw', 
 `fullcontact` varchar(80) NOT NULL default '', 
 `ipaddr` varchar(15) NOT NULL default '', 
 `port` smallint(5) unsigned NOT NULL default '0', 
 `regserver` varchar(100) default NULL, 
 `regseconds` int(11) NOT NULL default '0', 
 `username` varchar(80) NOT NULL default '', 
 `defaultuser` varchar(80) NOT NULL default '', 
 `subscribecontext` varchar(80) default NULL, 
 PRIMARY KEY  (`id`), 
 UNIQUE KEY `name` (`name`), 
 KEY `name_2` (`name`) 
) ENGINE=MyISAM ROW_FORMAT=DYNAMIC; 

INSERT INTO ast_sip_buddies (name, host, secret, context, ipaddr, port, allow) VALUES ('1051', 'dynamic', '12345', 'default', '127.0.0.1', '4569', 'gsm;ulaw'); 

# 
# Table structure for table `ast_extensions` 
# 

CREATE TABLE ast_extensions ( 
 id int(11) NOT NULL auto_increment, 
 context varchar(20) NOT NULL default '', 
 exten varchar(20) NOT NULL default '', 
 priority tinyint(4) NOT NULL default '0', 
 app varchar(20) NOT NULL default '', 
 appdata varchar(255) NOT NULL default '', 
 KEY id (id) 
) TYPE=MyISAM;

INSERT INTO ast_extensions (id, context, exten, priority, app, appdata) VALUES (1,'sip_ps','_1XXXXXXXXXX',1,'Dial','IAX2/user@xxxx/${EXTEN}'); 
INSERT INTO ast_extensions (id, context, exten, priority, app, appdata) VALUES (3,'sip_ps','4000',2,'Playback','vm-goodbye'); 
INSERT INTO ast_extensions (id, context, exten, priority, app, appdata) VALUES (3,'sip_ps','4000',3,'Hangup',''); 

INSERT INTO `ast_extensions` (`id`, `context`, `exten`, `priority`, `app`, `appdata`) VALUES (5, 'cytel', '8322008630', '1', 'Dial', 'SIP/3044,30'); 
INSERT INTO `ast_extensions` (`id`, `context`, `exten`, `priority`, `app`, `appdata`) VALUES (7, 'cytel', '80', '1', 'Voicemailmain', '@cytel'); 
INSERT INTO `ast_extensions` (`id`, `context`, `exten`, `priority`, `app`, `appdata`) VALUES (8, 'cytel', '_832.', '1', 'Dial', 'SIP/${EXTEN}@66.88.74.85|30'); 
INSERT INTO `ast_extensions` (`id`, `context`, `exten`, `priority`, `app`, `appdata`) VALUES (9, 'cytel', '_9X.', '1', 'Dial', 'IAX2/devasterisk:asterisk@asterisk-alpha/${EXTEN}@cytel-internal'); 
INSERT INTO `ast_extensions` (`id`, `context`, `exten`, `priority`, `app`, `appdata`) VALUES (10, 'cytel', '3013', '1', 'Dial', 'SIP/3013|30'); 
INSERT INTO `ast_extensions` (`id`, `context`, `exten`, `priority`, `app`, `appdata`) VALUES (11, 'cytel', '_3XXX', '1', 'Dial', 'IAX2/devasterisk:asterisk@asterisk-alpha/${EXTEN}@cytel-internal'); 

# 
# Table structure for table `ast_voicemail_users` 
# 

CREATE TABLE `ast_voicemail_users` ( 
 `uniqueid` int(11) NOT NULL auto_increment, 
 `customer_id` varchar(11) NOT NULL default '0', 
 `context` varchar(50) NOT NULL default '', 
 `mailbox` varchar(11) NOT NULL default '0', 
 `password` varchar(5) NOT NULL default '0', 
 `fullname` varchar(150) NOT NULL default '', 
 `email` varchar(50) NOT NULL default '', 
 `pager` varchar(50) NOT NULL default '', 
 `tz` varchar(10) NOT NULL default 'central', 
 `attach` varchar(4) NOT NULL default 'yes', 
 `saycid` varchar(4) NOT NULL default 'yes', 
 `dialout` varchar(10) NOT NULL default '', 
 `callback` varchar(10) NOT NULL default '', 
 `review` varchar(4) NOT NULL default 'no', 
 `operator` varchar(4) NOT NULL default 'no', 
 `envelope` varchar(4) NOT NULL default 'no', 
 `sayduration` varchar(4) NOT NULL default 'no', 
 `saydurationm` tinyint(4) NOT NULL default '1', 
 `sendvoicemail` varchar(4) NOT NULL default 'no', 
 `delete` varchar(4) NOT NULL default 'no', 
 `nextaftercmd` varchar(4) NOT NULL default 'yes', 
 `forcename` varchar(4) NOT NULL default 'no', 
 `forcegreetings` varchar(4) NOT NULL default 'no', 
 `hidefromdir` varchar(4) NOT NULL default 'yes', 
 `stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, 
 PRIMARY KEY  (`uniqueid`), 
 KEY `mailbox_context` (`mailbox`,`context`) 
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ; 


# 
# Table structure for table `ast_meetme` 
# 

CREATE TABLE `ast_meetme` ( 
 `confno` varchar(80) DEFAULT '0' NOT NULL, 
 `username` varchar(64) DEFAULT '' NOT NULL, 
 `domain` varchar(128) DEFAULT '' NOT NULL, 
 `pin` varchar(20) NULL, 
 `adminpin` varchar(20) NULL, 
 `members` integer DEFAULT 0 NOT NULL, 
 PRIMARY KEY (confno) 
); 


# 
# Table structure for table `ast_h323_peers` 
# 

CREATE TABLE ast_h323_peers ( 
 id BIGINT AUTO_INCREMENT PRIMARY KEY, 
 name VARCHAR(128) NOT NULL UNIQUE, 
 host VARCHAR(15) DEFAULT NULL , 
 secret VARCHAR(64) DEFAULT NULL, 
 context VARCHAR(64) NOT NULL, 
 type VARCHAR(6) NOT NULL, 
 port INT DEFAULT NULL, 
 permit VARCHAR(128) DEFAULT NULL, 
 deny VARCHAR(128) DEFAULT NULL, 
 mailbox VARCHAR(128) DEFAULT NULL, 
 e164 VARCHAR(128) DEFAULT NULL, 
 prefix VARCHAR(128) DEFAULT NULL, 
 allow VARCHAR(128) DEFAULT NULL, 
 disallow VARCHAR(128) DEFAULT NULL, 
 dtmfmode VARCHAR(128) DEFAULT NULL, 
 accountcode INT DEFAULT NULL,  
 amaflags varchar(13) DEFAULT NULL, 
 INDEX idx_name(name),  
 INDEX idx_host(host) 
);


# 
# Table structure for table `ast_queue_table` 
# 

CREATE TABLE ast_queue_table ( 
 name VARCHAR(128) PRIMARY KEY, 
 musiconhold VARCHAR(128), 
 announce VARCHAR(128), 
 context VARCHAR(128), 
 timeout INT(11), 
 monitor_join BOOL, 
 monitor_format VARCHAR(128), 
 queue_youarenext VARCHAR(128), 
 queue_thereare VARCHAR(128), 
 queue_callswaiting VARCHAR(128), 
 queue_holdtime VARCHAR(128), 
 queue_minutes VARCHAR(128), 
 queue_seconds VARCHAR(128), 
 queue_lessthan VARCHAR(128), 
 queue_thankyou VARCHAR(128), 
 queue_reporthold VARCHAR(128), 
 announce_frequency INT(11), 
 announce_round_seconds INT(11), 
 announce_holdtime VARCHAR(128), 
 retry INT(11), 
 wrapuptime INT(11), 
 maxlen INT(11), 
 servicelevel INT(11), 
 strategy VARCHAR(128), 
 joinempty VARCHAR(128), 
 leavewhenempty VARCHAR(128), 
 eventmemberstatus BOOL, 
 eventwhencalled BOOL, 
 reportholdtime BOOL, 
 memberdelay INT(11), 
 weight INT(11), 
 timeoutrestart BOOL, 
 periodic_announce VARCHAR(50), 
 periodic_announce_frequency INT(11), 
 ringinuse BOOL 
);


# 
# Table structure for table `ast_queue_member_table` 
# 

CREATE TABLE ast_queue_member_table ( 
 uniqueid INT(10) UNSIGNED PRIMARY KEY AUTO_INCREMENT, 
 membername varchar(40), 
 queue_name varchar(128), 
 interface varchar(128), 
 penalty INT(11), 
 paused BOOL, 
 UNIQUE KEY queue_interface (queue_name, interface) 
);


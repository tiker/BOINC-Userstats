-- DB Schema Version2:
-- Create databases for local badge support

-- List of known badges issued by projects:
-- "BadgeGUID" = GUID value (unique identifier) for the badge and image file .png
-- "InternalProjectID" = internal short name for the project badge is associated with
-- "own" = True / False value indicating if we've received this badge or not
CREATE TABLE IF NOT EXISTS `project_badges` (
	`badgeid` varchar(36) NOT NULL,
	`internal_projectid` varchar(15) NOT NULL,
	`own` boolean DEFAULT false,
	PRIMARY KEY `badgeid` (`badgeid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Reference table to lookup internal short project names (used in code) to our "project_shortname" from the "boinc_grundwerte" table
-- For example, code may use "wcg" for "World Community Grid" while we added it as "worldcg" in the "boinc_grundwerte" table.
-- This allows us to add a row:
-- "internal_projectid", "custom_shortname"
-- "wcg", "worldcg"
-- Each badge processing module will add a default entry (hopefully).
CREATE TABLE IF NOT EXISTS `projectid_link` (
	`internal_projectid` varchar(15) NOT NULL,
	`custom_shortname` varchar(15) NOT NULL,
	PRIMARY KEY `internal_projectid` (`internal_projectid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Default badge check delays set to 2880 minutes (2 days)
INSERT INTO `settings` (`key`, `value`) VALUES ('badge_update_delay', '2880');

-- Set database schema to 2
UPDATE `settings` SET `value`='2' WHERE `key`='db_schema';

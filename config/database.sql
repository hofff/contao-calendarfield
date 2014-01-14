-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

--
-- Table `tl_form_field`
--

CREATE TABLE `tl_form_field` (
  `dateDirection` varchar(2) NOT NULL default '',
  `dateFormat` varchar(32) NOT NULL default '',
  `dateParseValue` char(1) NOT NULL default '',
  `dateExcludeCSS` char(1) NOT NULL default '',
  `dateImage` char(1) NOT NULL default '1',
  `dateImageSRC` char(255) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


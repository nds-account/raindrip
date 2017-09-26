#
#<?php die('Forbidden.'); ?>
#Date: 2014-02-21 12:29:51 UTC
#Software: Joomla Platform 13.1.0 Stable [ Curiosity ] 24-Apr-2013 00:00 GMT

#Fields: datetime	priority	category	message
2014-02-21T12:29:51+00:00	INFO	update	Update started by user Super User (284). Old version is 3.2.1.
2014-02-21T12:29:51+00:00	INFO	update	Downloading update file from .
2014-02-21T12:30:09+00:00	INFO	update	File Joomla_3.2.1_to_3.2.2-Stable-Patch_Package.zip successfully downloaded.
2014-02-21T12:30:09+00:00	INFO	update	Starting installation of new version.
2014-02-21T12:30:18+00:00	INFO	update	Finalising installation.
2014-02-21T12:30:20+00:00	INFO	update	Ran query from file 3.2.2-2013-12-22. Query text: ALTER TABLE `#__update_sites` ADD COLUMN `extra_query` VARCHAR(1000) DEFAULT '';.
2014-02-21T12:30:22+00:00	INFO	update	Ran query from file 3.2.2-2013-12-22. Query text: ALTER TABLE `#__updates` ADD COLUMN `extra_query` VARCHAR(1000) DEFAULT '';.
2014-02-21T12:30:22+00:00	INFO	update	Ran query from file 3.2.2-2013-12-28. Query text: UPDATE `#__menu` SET `component_id` = (SELECT `extension_id` FROM `#__extensions.
2014-02-21T12:30:23+00:00	INFO	update	Ran query from file 3.2.2-2014-01-08. Query text: INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`.
2014-02-21T12:30:23+00:00	INFO	update	Ran query from file 3.2.2-2014-01-15. Query text: INSERT INTO `#__postinstall_messages` (`extension_id`, `title_key`, `description.
2014-02-21T12:30:25+00:00	INFO	update	Ran query from file 3.2.2-2014-01-18. Query text: /* Update updates version length */ ALTER TABLE `#__updates` MODIFY `version` va.
2014-02-21T12:30:25+00:00	INFO	update	Ran query from file 3.2.2-2014-01-23. Query text: INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`.
2014-02-21T12:30:26+00:00	INFO	update	Deleting removed files and folders.
2014-02-21T12:30:42+00:00	INFO	update	Cleaning up after installation.
2014-02-21T12:30:42+00:00	INFO	update	Update to version 3.2.2 is complete.

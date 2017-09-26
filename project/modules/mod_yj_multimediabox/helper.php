<?php
/*======================================================================*\
|| #################################################################### ||
|| # Multi Media Box - 3.0                                            # ||	
|| # Copyright ©2006-2011 Youjoomla.com. All Rights Reserved.         # ||
|| # ----------------     JOOMLA TEMPLATES CLUB      -----------      # ||
|| # ----------------       www.youjoomla.com	     -----------      # ||
|| # @license http://www.gnu.org/copyleft/gpl.html GNU/GPL            # ||
|| #################################################################### ||
\*======================================================================*/

/// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_content'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'route.php');

class modMultimediaBoxHelper
{
	public static function getList(&$params)
	{
		JFactory::getApplication(); 
		
		$row = new stdClass();
		$row->id = false;
		$row->text = $params->get( 'code', '' );
		
		if (JPluginHelper::getPlugin('content', 'bot_mb')) :
			$row->text = JHtml::_('content.prepare', $row->text);
			$context='';
			$dispatcher	= JDispatcher::getInstance();
			JPluginHelper::importPlugin('content','pop_box_media');
			$results = $dispatcher->trigger('onContentAfterDisplay', array ($context,& $row, & $params, ''));
			return $row;
		elseif(!JFolder::exists(JPATH_SITE.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR.'bot_mb')):
			echo 'Multimedia Box plugin is not installed';
		else:
			echo 'Multimedia Box plugin is not published';
		endif;
		
	}
}

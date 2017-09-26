<?php

/**
 * @version     1.0.0
 * @package     com_ice_video_manager3
 * @copyright   Copyright (C) 2014 SDS International. All rights reserved worldwide.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      SDS International <info@sdsinternational.com> - http://www.sdsinternational.com
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Ice_video_manager3 helper.
 */
class Ice_video_manager3BackendHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        		JHtmlSidebar::addEntry(
			JText::_('COM_ICE_VIDEO_MANAGER3_TITLE_CATEGORIES'),
			'index.php?option=com_ice_video_manager3&view=categories',
			$vName == 'categories'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_ICE_VIDEO_MANAGER3_TITLE_VIDEOS'),
			'index.php?option=com_ice_video_manager3&view=videos',
			$vName == 'videos'
		);

    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_ice_video_manager3';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }


}

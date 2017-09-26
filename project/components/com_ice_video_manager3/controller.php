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

jimport('joomla.application.component.controller');

class Ice_video_manager3Controller extends JControllerLegacy {

    /**
     * Method to display a view.
     *
     * @param	boolean			$cachable	If true, the view output will be cached
     * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return	JController		This object to support chaining.
     * @since	1.5
     */
    public function display($cachable = false, $urlparams = false) {
        require_once JPATH_COMPONENT . '/helpers/ice_video_manager3.php';

        $view = JFactory::getApplication()->input->getCmd('view', 'categories');
        JFactory::getApplication()->input->set('view', $view);

        parent::display($cachable, $urlparams);

        return $this;
    }

}

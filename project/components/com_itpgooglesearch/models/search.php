<?php
/**
 * @package      ITPGoogleSearch 
 * @subpackage   Components
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2014 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * This model contains method used for managing search functionality.
 * 
 */
class ItpGoogleSearchModelSearch extends JModelList {
    
    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @param string $ordering
     * @param string $direction
     *
     * @return  void
     * @since   1.6
     */
    protected function populateState($ordering = 'ordering', $direction = 'ASC'){
        
        $app = JFactory::getApplication();
        /** @var $app JApplicationSite **/
        
        $params = $app->getParams();
        $this->setState('params', $params);
        
        $this->setState('itpgsq', $app->input->get('itpgsq'));

    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param   string      $id A prefix for the store id.
     *
     * @return  string      A store id.
     * @since   1.6
     */
    protected function getStoreId($id = '') {
        
        // Compile the store id.
        $id .= ':' . $this->getState('itpgsq');
        
        return parent::getStoreId($id);
    }
    
}
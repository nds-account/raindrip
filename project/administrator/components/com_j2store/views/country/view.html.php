<?php
/*------------------------------------------------------------------------
 # com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Sasi varna kumar - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2012 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

// import Joomla view library
jimport('joomla.application.component.view');

class J2StoreViewCountry extends J2StoreView
{
	 
	protected $item;
	protected $state;
	protected $form;


	function display($tpl = null)
	{
		$this->form	= $this->get('Form');
		// Get data from the model
		$this->item = $this->get('Item');
		// inturn calls getState in parent class and populateState() in model
		$this->state = $this->get('State');
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		//add toolbar
		$this->addToolBar();

		// Display the template
		parent::display($tpl);
		// Set the document
		$this->setDocument();
	}
	 
	protected function addToolBar() {
		// setting the title for the toolbar string as an argument
		JToolBarHelper::title(JText::_('J2STORE_COUNTRIES'),'j2store-logo');
		JToolBarHelper::save('country.save', 'JTOOLBAR_SAVE');
		if (empty($this->item->id))  {
			JToolBarHelper::cancel('country.cancel','JTOOLBAR_CANCEL');
		}
		else {
			JToolBarHelper::cancel('country.cancel', 'JTOOLBAR_CLOSE');
		};
	}

	protected function setDocument() {
		// get the document instance
		$document = JFactory::getDocument();
		// setting the title of the document
		$document->setTitle(JText::_('J2STORE_COUNTRY'));

	}
}

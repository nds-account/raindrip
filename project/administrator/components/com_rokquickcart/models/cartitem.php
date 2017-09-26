<?php
/**
 * @version   $Id: cartitem.php 6852 2013-01-28 18:51:50Z btowles $
 * @author    RocketTheme, LLC http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');


if (version_compare(JVERSION, '3.0', '<')) {
	abstract class RokQuickCartModelModuleIntermediate extends JModelAdmin
	{
		protected function prepareTable(&$table)
		{
			$this->rsPrepareTable($table);
		}

		abstract protected function rsPrepareTable($table);
	}
} else {
	abstract class RokQuickCartModelModuleIntermediate extends JModelAdmin
	{
		protected function prepareTable($table)
		{
			$this->rsPrepareTable($table);
		}

		abstract protected function rsPrepareTable($table);
	}
}
/**
 * Item Model for a Contact.
 *
 * @package        Joomla.Administrator
 * @subpackage     com_contact
 * @since          1.6
 */
class RokQuickCartModelCartItem extends RokQuickCartModelModuleIntermediate
{
	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param    object    $record    A record object.
	 *
	 * @return    boolean    True if allowed to delete the record. Defaults to the permission set in the component.
	 * @since    1.6
	 */
	protected function canDelete($record)
	{
		return JFactory::getUser()->authorise('core.delete', 'com_rokgallery');
	}

	/**
	 * Method to test whether a record can have its state edited.
	 *
	 * @param    object    $record    A record object.
	 *
	 * @return    boolean    True if allowed to change the state of the record. Defaults to the permission set in the component.
	 * @since    1.6
	 */
	protected function canEditState($record)
	{
		return JFactory::getUser()->authorise('core.edit.state', 'com_rokgallery');
	}

	/**
	 * Returns a Table object, always creating it
	 *
	 * @param    type      $type      The table type to instantiate
	 * @param    string    $prefix    A prefix for the table class name. Optional.
	 * @param    array     $config    Configuration array for model. Optional.
	 *
	 * @return    JTable    A database object
	 * @since    1.6
	 */
	public function getTable($type = 'CartItem', $prefix = 'RokQuickCartTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the row form.
	 *
	 * @param    array      $data        Data for the form.
	 * @param    boolean    $loadData    True if the form is to load its own data (default case), false if not.
	 *
	 * @return    mixed    A JForm object on success, false on failure
	 * @since    1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		jimport('joomla.form.form');
		JForm::addFieldPath('JPATH_ADMINISTRATOR/components/com_rokquickcart/models/fields');

		// Get the form.
		$form = $this->loadForm('com_rokquickcart.cartitem', 'cartitem', array('control'  => 'jform',
		                                                                      'load_data' => $loadData
		                                                                 ));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param    integer    $pk    The id of the primary key.
	 *
	 * @return    mixed    Object on success, false on failure.
	 * @since    1.6
	 */
	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk)) {
			//NOTE This will break the custom field
			// Convert the params field to an array.
			//            if (isset($item->params) && is_array($item->params)) {
			//                $registry = new JRegistry();
			//                $registry->loadArray($item->params);
			//                $item->params = (string) $registry;
			//		    }
		}

		return $item;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return    mixed    The data for the form.
	 * @since    1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_rokquickcart.edit.cartitem.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}

	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @param   JTable  &$table  The database object
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function rsPrepareTable($table)
	{
		jimport('joomla.filter.output');

		$table->name = htmlspecialchars_decode($table->name, ENT_QUOTES);

		if (empty($table->id)) {

			// Set ordering to the last item if not set
			if (empty($table->ordering)) {
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__rokquickcart');
				$max = $db->loadResult();

				$table->ordering = $max + 1;
			}
		}
	}
}
<?php/** * @package Spider Catalog * @author Web-Dorado * @copyright (C) 2012 Web-Dorado. All rights reserved. * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html **/ 
defined('_JEXEC') or die('Restricted access');
class Tableparams extends JTable
{
var $id = null;
var $name = null;
var $title = null;
var $description = null;
var $value = null;


	function __construct(&$db)
	{
	parent::__construct('#__spidercatalog_params','id',$db);
	}
}
?>
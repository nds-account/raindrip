<?php/** * @package Spider Catalog * @author Web-Dorado * @copyright (C) 2012 Web-Dorado. All rights reserved. * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html **/ 
defined('_JEXEC') or die('Restricted access');
class Tablereviews extends JTable
{
var $id = null;
var $name = null;
var $content = null;
var $product_id = null;
var $remote_ip = null;
	function __construct(&$db)
	{
	parent::__construct('#__spidercatalog_product_reviews','id',$db);
	}
}
?>
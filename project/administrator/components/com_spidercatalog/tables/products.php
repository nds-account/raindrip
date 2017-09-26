<?php/** * @package Spider Catalog * @author Web-Dorado * @copyright (C) 2012 Web-Dorado. All rights reserved. * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html **/ 
defined('_JEXEC') or die('Restricted access');
class Tableproducts extends JTable
{
var $id = null;
var $name = null;
var $description = null;
var $image_url = null;
var $cost = null;
var $market_cost = null;
var $category_id = null;
var $param = null;
var $ordering = null;var $published_in_parent = null;
var $published = null;
		function __construct(&$db)
		{
		parent::__construct('#__spidercatalog_products','id',$db);
		}
}
?>
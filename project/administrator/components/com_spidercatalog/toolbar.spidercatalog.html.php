 <?php
 /**
 * @package Spider Catalog
 * @author Web-Dorado
 * @copyright (C) 2012 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');
class TOOLBAR_spidercatalog
  {
	  
   public static  function _NEW($controller, $op_type)
      {
		  $input=JFactory::getApplication()->input;
		  
			switch ($controller)
			{
				case 'category':
				{
					JToolbarHelper::title('Spider Catalog');
					JToolBarHelper::save();
					JToolBarHelper::apply();
					JToolBarHelper::cancel();
					break;
				}
				case 'products':
				{
				    $params = new jsshparams;
			//	print_r($params);
					
					if($input->get("task","")=="edit") {
						JToolBarHelper::title(	'Spider Catalog');
					
					if($params->get('enable_rating'))
					{
						//echo 'toolbar';
						JToolBarHelper::custom( 'product_rating', 'edit.png', '', 'Edit Ratings', '', '' );
					}
					if($params->get('enable_review'))
					{
						JToolBarHelper::custom( 'product_reviews', 'edit.png', '', 'Edit Reviews', '', '' );
					}
						}
						else JToolBarHelper::title(	'Spider Catalog');
						
					JToolBarHelper::save();
					JToolBarHelper::apply();
					JToolBarHelper::cancel();
					break;
				}
				case 'product_reviews':
				{
					JToolBarHelper::title('Spider Catalog');
					JToolBarHelper::deleteList();
					JToolBarHelper::cancel();
					break;
				}
				case 'product_rating':
				{
					JToolBarHelper::title('Spider Catalog');
					JToolBarHelper::save();
					JToolBarHelper::apply();
					JToolBarHelper::deleteList();
					JToolBarHelper::cancel();
					break;
				}
				default:
				{
					JToolBarHelper::title('Spider Catalog');
					JToolBarHelper::save();
					JToolBarHelper::apply();
					JToolBarHelper::cancel();
					break;
				}
			}
       }
      
  public static   function _DEFAULT($controller, $op_type)
    {
		$input=JFactory::getApplication()->input;
        if ($controller == 'show_links')
		{
			JToolBarHelper::title('Spider Catalog');
		}
        else
		{
			if ($controller == 'options')
			{
				if(isset($op_type) and $op_type!='')
				{
					JToolBarHelper::title('Spider Catalog');
					JToolBarHelper::save();
					JToolBarHelper::apply();
					JToolBarHelper::cancel();
				}
				else 
				JToolBarHelper::title('Spider Catalog');
			}
			else
			{
				JToolBarHelper::addNew();
				JToolBarHelper::title('Spider Catalog');
				JToolBarHelper::publishList();
				JToolBarHelper::unpublishList();
				JToolBarHelper::editList();
				JToolBarHelper::deleteList();
				
			}
		}
	}
     
  }
?>
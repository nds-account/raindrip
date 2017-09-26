<?php
/**
 * YoutubeGallery Joomla! 3.0 Native Component
 * @version 3.8.4
 * @author DesignCompass corp< <support@joomlaboat.com>
 * @link http://www.joomlaboat.com
 * @GNU General Public License
 **/

// No direct access
defined('_JEXEC') or die('Restricted access');
 
// import Joomla table library
jimport('joomla.database.table');
 
/**
 * Youtube Gallery - Categories Table class
 */
class YoutubeGalleryTableCategories extends JTable
{
        /**
         * Constructor
         *
         * @param object Database connector object
         */
       	var $id = null;
        var $categoryname = null;
       
        function __construct(&$db) 
        {
                parent::__construct('#__youtubegallery_categories', 'id', $db);
        }

}

?>
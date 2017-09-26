<?php
 
 /**
 * @package SpiderBox
 * @author Web-Dorado
 * @copyright (C) 2011 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );

class JElementDonate extends JElement
{
 
        function fetchElement($name, $value, &$node, $control_name)
        {
                        return '<a href="http://web-dorado.com/files/donate_redirect.php" target="_blank"><img src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" alt="Donate using PayPal - The safer, easier way to pay online!" style="border:none;"></a>';
        }
}
?>
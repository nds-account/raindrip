<?php
/**
 * @package      ITPGoogleSearch 
 * @subpackage   Components
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2014 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// No direct access
defined('_JEXEC') or die;
?>

<?php if(!$this->params->get("display_search_form", 1)) {?>
<style>
#___gcse_0 {
    display: none !important;
}
</style>
<?php }?>

<div class="gcse-searchbox" data-gname="gselement" data-queryParameterName="gsquery" ><?php echo JText::_("COM_ITPGOOGLESEARCH_LOADING")?></div>
<div class="gcse-searchresults" data-linktarget="<?php echo $this->params->get("link_target", "_blank");?>" data-gname="gselement" ></div>

<script>

var initGoogleSearchBox = function() {
	
  if (document.readyState == 'complete') {
	  
	  var element = google.search.cse.element.getElement("___gcse_0");
  } else {
	  
    // Document is not ready yet, when CSE element is initialized.
    google.setOnLoadCallback(function() {

       var element = google.search.cse.element.getElement("gselement");
       <?php if(!empty($this->phrase)) {?>
       element.execute('<?php echo htmlspecialchars($this->phrase, ENT_QUOTES, "UTF-8");?>');
       <?php }?>
       console.log(element);
       
    }, true);
    
  }
};

// Insert it before the CSE code snippet so that cse.js can take the script
// parameters, like parsetags, callbacks.
window.__gcse = {
  callback: initGoogleSearchBox
};


(function() {
  var cx = '<?php echo $this->params->get("search_engine_id");?>'; // Insert your own Custom Search engine ID here
  var gcse = document.createElement('script'); gcse.type = 'text/javascript';
  gcse.async = true;
  gcse.src = (document.location.protocol == 'https' ? 'https:' : 'http:') +
      '//www.google.com/cse/cse.js?cx=' + cx;
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(gcse, s);
})();

</script>

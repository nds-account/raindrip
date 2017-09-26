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
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');


require_once(JPATH_SITE.DS.'components'.DS.'com_youtubegallery'.DS.'includes'.DS.'misc.php');
?>

<form id="adminForm" action="<?php echo JRoute::_('index.php?option=com_youtubegallery'); ?>" method="post" class="form-inline">



				<h2 style="text-align:left;">Settings</h2>
				
				
				<h4>General</h4>
				
				<br/>
				
				<?php
								$allowsef=YouTubeGalleryMisc::getSettingValue('allowsef');
								if($allowsef!=1)
												$allowsef=0;
								
				?>
				<table style="border:none;">
                                <tbody>
                                        <tr><td><?php echo JText::_( 'Allow SEF Links' ); ?></td><td>:</td>
								
						<td>
								
								
								<fieldset id="jform_attribs_link_titles" class="radio btn-group">
								<fieldset id="jform_allowsef" class="radio inputbox">
								<input type="radio" id="jform_allowsef1" name="jform[allowsef]" value="1"<?php echo ($allowsef=='1' ? 'checked="checked"' : ''); ?> />
								<label for="jform_allowsef1">Yes</label>
								<input type="radio" id="jform_allowsef0" name="jform[allowsef]" value="0"<?php echo ($allowsef=='0' ? 'checked="checked"' : ''); ?> />
								<label for="jform_allowsef0">No</label>
								</fieldset>
								</fieldset>
								
								</td>
								
                                        
					</tr>
				</tbody>
				</table>
				
				
				
				<hr/>
				<p><br/></p>
				<p>How to get Video information:</p>
				<?php
								$getinfomethod=YouTubeGalleryMisc::getSettingValue('getinfomethod');
								
				?>
				<table style="border:none;">
                                <tbody>
                                        <tr><td><?php echo JText::_( 'Use' ); ?></td><td>:</td>
								
						<td>

								
								<fieldset id="jform_attribs_link_titles" class="radio btn-group">
								<fieldset id="jform_getinfomethod" class="radio inputbox">
												<?php /*
								<input type="radio" id="jform_getinfomethodjs" name="jform[getinfomethod]" value="js"<?php echo ($getinfomethod=='js' ? 'checked="checked"' : ''); ?> />
								<label for="jform_getinfomethodjs">Javascript</label>
								*/ ?>
								
								<input type="radio" id="jform_getinfomethodjsmanual" name="jform[getinfomethod]" value="jsmanual"<?php echo ($getinfomethod=='jsmanual' ? 'checked="checked"' : ''); ?> />
								<label for="jform_getinfomethodjsmanual">Javascript (Back-end/Manual)</label>
								
								<input type="radio" id="jform_getinfomethodphp" name="jform[getinfomethod]" value="php"<?php echo (($getinfomethod=='php' or $getinfomethod=='') ? 'checked="checked"' : ''); ?> />
								<label for="jform_getinfomethodphp">cURL/file_get_contents</label>
								</fieldset>
								</fieldset>

								</td>
								
                                        
					</tr>
				</tbody>
				</table>
				
				
				
				<hr/>
				<p><br/></p>
				
				
				<h4>SoundCloud Specific</h4>
				<p>In order to allow Youtube Gallery to fetch metadata (title,description etc) of the SoundCloud track you have to register your own instance of Youtube Gallery.</p>
				<p><a href="http://soundcloud.com/you/apps/new" target="_blank">http://soundcloud.com/you/apps/new</a></p>
				<p>Type "YoutubeGallery Your Site/Name" into "Name of your app" field during registration.</p>
				
				
				<hr/>
				<p>When you finish you will get Client ID and Client Secret. Paste it into fields below:<br/></p>
				<p>
				Client ID:<br/>
				<input name="soundcloud_api_client_id" style="width:400px;" value="<?php echo YouTubeGalleryMisc::getSettingValue('soundcloud_api_client_id'); ?>" />
				</p>
				
				<p>
				Client Secret:<br/>
				<input name="soundcloud_api_client_secret" style="width:400px;" value="<?php echo YouTubeGalleryMisc::getSettingValue('soundcloud_api_client_secret'); ?>" />
				</p>
				
				
				<hr/>
				<p><br/></p>
				
				
				
				<h4>Vimeo Specific</h4>
				<p>In order to allow Youtube Gallery to fetch metadata (title,description etc) of the Vimeo Video you have to register your own instance of Youtube Gallery.</p>
				<p><a href="https://developer.vimeo.com/apps/new" target="_blank">https://developer.vimeo.com/apps/new</a></p>
				<p>Type "YoutubeGallery Your Site/Name" into "App Name" field during registration.</p>
				
				
				<hr/>
				<p>When you finish you get Client ID and Secret information. Paste it into fields below:<br/></p>
				<p>
				Client ID (Also known as Consumer Key or API Key):<br/>
				<input name="vimeo_api_client_id" style="width:400px;" value="<?php echo YouTubeGalleryMisc::getSettingValue('vimeo_api_client_id'); ?>" />
				</p>
				
				<p>
				Client Secret (Also known as Consumer Secret or API Secret):<br/>
				<input name="vimeo_api_client_secret" style="width:400px;" value="<?php echo YouTubeGalleryMisc::getSettingValue('vimeo_api_client_secret'); ?>" />
				</p>
				
				<hr/>
				<p><br/></p>
				
				
				<?php
								$errorreporting=YouTubeGalleryMisc::getSettingValue('errorreporting');
								if($errorreporting!=1)
												$errorreporting=0;
								
				?>
				<table style="border:none;">
                                <tbody>
                                        <tr><td><?php echo JText::_( 'Error Reporting' ); ?></td><td>:</td>
								
						<td>
								
								
								<fieldset id="jform_attribs_link_titles" class="radio btn-group">
								<fieldset id="jform_errorreporting" class="radio inputbox">
								<input type="radio" id="jform_errorreporting1" name="jform[errorreporting]" value="1"<?php echo ($errorreporting=='1' ? 'checked="checked"' : ''); ?> />
								<label for="jform_errorreporting1">Yes</label>
								<input type="radio" id="jform_errorreporting0" name="jform[errorreporting]" value="0"<?php echo ($errorreporting=='0' ? 'checked="checked"' : ''); ?> />
								<label for="jform_errorreporting0">No</label>
								</fieldset>
								</fieldset>
								
								</td>
								
                                        
					</tr>
				</tbody>
				</table>
				
				
                <input type="hidden" name="task" value="" />

				
                <?php echo JHtml::_('form.token'); ?>

</form>
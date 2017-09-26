<?php
/**
 * YoutubeGallery
 * @version 3.8.4
 * @author DesignCompass corp< <support@joomlaboat.com>
 * @link http://www.joomlaboat.com
 * @GNU General Public License
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

if(!defined('DS'))
	define('DS',DIRECTORY_SEPARATOR);
	
require_once(JPATH_SITE.DS.'components'.DS.'com_youtubegallery'.DS.'includes'.DS.'misc.php');


class VideoSource_YouTube
{
	public static function extractYouTubeID($youtubeURL)
	{
		if(!(strpos($youtubeURL,'://youtu.be')===false) or !(strpos($youtubeURL,'://www.youtu.be')===false))
		{
			//youtu.be
			$list=explode('/',$youtubeURL);
			if(isset($list[3]))
				return $list[3];
			else
				return '';
		}
		else
		{
			//youtube.com
			$arr=YouTubeGalleryMisc::parse_query($youtubeURL);
			return $arr['v'];	
		}
		
	}
	
	public static function getVideoData($videoid,$customimage,$customtitle,$customdescription, $thumbnailcssstyle, $getinfomethod)
	{
		
		
		//blank	array
		$blankArray=array(
				'videosource'=>'youtube',
				'videoid'=>$videoid,
				'imageurl'=>'',
				'title'=>'',
				'description'=>'',
				'publisheddate'=>'',
				'duration'=>0,
				'rating_average'=>0,
				'rating_max'=>0,
				'rating_min'=>0,
				'rating_numRaters'=>0,
				'statistics_favoriteCount'=>0,
				'statistics_viewCount'=>0,
				'keywords'=>'',
				'likes'=>0,
				'dislikes'=>'',
				'commentcount'=>'',
				'channel_username'=>'',
				'channel_title'=>'',
				'channel_subscribers'=>0,
				'channel_subscribed'=>0,
				'channel_location'=>'',
				'channel_commentcount'=>0,
				'channel_viewcount'=>0,
				'channel_videocount'=>0,
				'channel_description'=>''
				);
		
		$answer=VideoSource_YouTube::getYouTubeVideoData($videoid,$blankArray, $getinfomethod);
		
		if($answer!='')
		{
			$blankArray['title']='***Video not found*** ('.$answer.')';
			$blankArray['description']=$answer;
			return $blankArray;
		}
		
		if($customtitle!='')
			$blankArray['title']=$customtitle;

		if($customdescription!='')
			$blankArray['description']=$customdescription;
		
		if($customimage!='' and strpos($customimage, '#')===false)
		{
			$blankArray['imageurl']=$customimage;
		}
		else
		{
			if($blankArray['imageurl']=='')
				$blankArray['imageurl']=VideoSource_YouTube::getYouTubeImageURL($videoid,$thumbnailcssstyle);
			
		}
	
		return $blankArray;
	}
	
	public static function getYouTubeImageURL($videoid,$thumbnailcssstyle)
	{
		
		
		if($thumbnailcssstyle == null)
			return 'http://img.youtube.com/vi/'.$videoid.'/default.jpg';
		
		//get bigger image if size of the thumbnail set;
		
		$a=str_replace(' ','',$thumbnailcssstyle);
		if(strpos($a,'width:')===false and strpos($a,'height:')===false)
			return 'http://img.youtube.com/vi/'.$videoid.'/default.jpg';
		else
			return 'http://img.youtube.com/vi/'.$videoid.'/0.jpg';
		
	}
	
	public static function getYouTubeVideoData($videoid, &$blankArray, $getinfomethod)
	{
		if(phpversion()<5)
			return "Update to PHP 5+";
				
		try{
			


			$url = 'http://gdata.youtube.com/feeds/api/videos/'.$videoid.'?v=2'; //v=2to get likes and dislikes
			
			$blankArray['datalink']=$url;
			
			
			/*
			if($getinfomethod=='js' or $getinfomethod=='jsmanual')
			{
				$rd=YouTubeGalleryMisc::getRawData($videoid);
				if($rd=='')
				{
					YouTubeGalleryMisc::setDelayedRequest($videoid,$url);
					return '';
				}
				elseif($rd=='' or $rd=='*youtubegallery_request*')
					return '';
				else $htmlcode=$rd;
			}
			else
			*/
			
			$htmlcode=YouTubeGalleryMisc::getURLData($url);
			
			if(($getinfomethod=='js' or $getinfomethod=='jsmanual' ) and $htmlcode=='')
				return '';
			
			
			//	return 'Get info method not set, go to Settings.';

			if(strpos($htmlcode,'<?xml version')===false)
			{
				if(strpos($htmlcode,'Invalid id')===false)
					return 'Cannot Connect to Youtube Server';
				else
					return 'Invalid id';

				//return $pair;
			}
			$doc = new DOMDocument;
			$doc->loadXML($htmlcode);
			
			
			if(!isset($doc->getElementsByTagName("title")->item(0)->nodeValue))
			{
				return '<p>Youtube Video "'.$videoid.'" not found.</p>';
			}
			
			$blankArray['title']=$doc->getElementsByTagName("title")->item(0)->nodeValue;
			$blankArray['description']=$doc->getElementsByTagName("description")->item(0)->nodeValue;
			$blankArray['publisheddate']=$doc->getElementsByTagName("published")->item(0)->nodeValue;
			
			if($doc->getElementsByTagName("duration"))
			{
				if($doc->getElementsByTagName("duration")->item(0))
					$blankArray['duration']=$doc->getElementsByTagName("duration")->item(0)->getAttribute("seconds");	
			}
			
			$MediaElement=$doc->getElementsByTagName("thumbnail");
			if($MediaElement->length>0)
			{
				$images=array();
				foreach($MediaElement as $me)
					$images[]=$me->getAttribute("url");
					
				$blankArray['imageurl']=implode(',',$images);
			}
			
			
			$FeedElement=$doc->getElementsByTagName("feedLink");
			if($FeedElement->length>0)
			{
				$fe0=$FeedElement->item(0);
				$blankArray['commentcount']=$fe0->getAttribute("countHint");
			}
			
			$RatingElement=$doc->getElementsByTagName("rating");
			if($RatingElement->length>0)
			{
				
				
				$re0=$RatingElement->item(0);
				$blankArray['rating_average']=$re0->getAttribute("average");
				$blankArray['rating_max']=$re0->getAttribute("max");
				$blankArray['rating_min']=$re0->getAttribute("min");
				$blankArray['rating_numRaters']=$re0->getAttribute("numRaters");
				
				
				
				if($RatingElement->length>1)
				{
					$re1=$RatingElement->item(1);

				
					$blankArray['likes']=$re1->getAttribute("numLikes");
					$blankArray['dislikes']=$re1->getAttribute("numDislikes");
				}
				else
				{
					$blankArray['likes']=0;
					$blankArray['dislikes']=0;
				}
			}
			
			$StatElement=$doc->getElementsByTagName("statistics");
			if($StatElement->length>0)
			{
				$se0=$StatElement->item(0);
				$blankArray['statistics_favoriteCount']=$se0->getAttribute("favoriteCount");
				$blankArray['statistics_viewCount']=$se0->getAttribute("viewCount");
			}	

			$blankArray['keywords']=$doc->getElementsByTagName("keywords")->item(0)->nodeValue;
		}
		catch(Exception $e)
		{
			return 'Cannot get youtube video data.';
		}
		
	
		return '';
	}
	


	
	public static function renderYouTubePlayer($options, $width, $height, &$videolist_row, &$theme_row,$startsecond,$endsecond)
	{
		
		$videoidkeyword='****youtubegallery-video-id****';
		
		$settings=array();
		
		$settings[]=array('autoplay',(int)$options['autoplay']);
		
		$settings[]=array('hl','en');
		
		
		if($options['fullscreen']!=0)
			$settings[]=array('fs','1');
		else
			$settings[]=array('fs','0');
			
			
		$settings[]=array('showinfo',$options['showinfo']);
		$settings[]=array('iv_load_policy','3');
		$settings[]=array('rel',$options['relatedvideos']);
		$settings[]=array('loop',(int)$options['repeat']);
		$settings[]=array('border',(int)$options['border']);
		
		if($options['color1']!='')
			$settings[]=array('color1',$options['color1']);
			
		if($options['color2']!='')
			$settings[]=array('color2',$options['color2']);

		if($options['controls']!='')
		{
			$settings[]=array('controls',$options['controls']);
			if($options['controls']==0)
				$settings[]=array('version',3);
			
		}
		if($startsecond!='')
			$settings[]=array('start',$startsecond);
			
		if($endsecond!='')
			$settings[]=array('end',$endsecond);
		
		$initial_volume=(int)$theme_row->volume;
		
		if($options['playertype']==100)
		{
			if(YouTubeGalleryMisc::check_user_agent_for_apple())
			{
				$options['playertype']=1;
				//1 = HTML5
			}
			else
			{
				if($theme_row->muteonplay or $initial_volume!=-1)
				{
					$options['playertype']=2; //because other types of player doesn't support this functionality.
					//2 = FLASH3_WITH_CHECK
				}
				else
					$options['playertype']=1;
			}
		}
		else
		{
			if(($theme_row->muteonplay or $initial_volume!=-1) and $options['playertype']!=5)
					$options['playertype']=2; //because other types of player doesn't support this functionality.
					//2 = FLASH3_WITH_CHECK
		}
		
		$playerapiid='ygplayerapiid_'.$videolist_row->id;
		$playerid='youtubegalleryplayerid_'.$videolist_row->id;
		
		
		
		
		if($options['playertype']==2)
		{
			//Player with Flash availability check
			$settings[]=array('playerapiid','ygplayerapiid_'.$playerapiid);
			$settings[]=array('enablejsapi','1');
		}
		
		$playlist='';
		$youtubeparams=$options['youtubeparams'];
		$p=explode(';',$youtubeparams);
		
		
		if($options['allowplaylist']==1)
		{
			foreach($p as $v)
			{
				$pair=explode('=',$v);
				if($pair[0]=='playlist')
					$playlist=$pair[1];
			}
		}
		else
		{
			$p_new=array();
			foreach($p as $v)
			{
				$pair=explode('=',$v);
				if($pair[0]!='playlist')
					$p_new[]=$v;
			}
			$youtubeparams=implode(';',$p_new);
		}
		
		
	
		YouTubeGalleryMisc::ApplyPlayerParameters($settings,$youtubeparams);
		
		$settingline=YouTubeGalleryMisc::CreateParamLine($settings);
		
		
		
		if (isset($_SERVER["HTTPS"]) and $_SERVER["HTTPS"] == "on")
			$http='https://';
		else
			$http='http://';
			
		$result='';
		
		
		
		if($theme_row->nocookie)
			$youtubeserver=$http.'www.youtube-nocookie.com/';
		else
			$youtubeserver=$http.'www.youtube.com/';
		
		
		
		if($options['playertype']==1) //new HTML 5 player
		{
			//new player
			$result.='<iframe width="'.$width.'" height="'.$height.'"'
				.' src="'.$youtubeserver.'embed/'.$videoidkeyword.'?'.$settingline.'"'
				.' frameborder="'.(int)$options['border'].'"'
				.' id="'.$playerid.'"'
				.($theme_row->responsive==1 ? ' onLoad="YoutubeGalleryAutoResizePlayer'.$videolist_row->id.'();"' : '')
				.($options['fullscreen']==0 ? '' : ' allowfullscreen')
				.'>'
			.'</iframe>';
		}
		elseif($options['playertype']==5) //new HTML 5 player
		{
			// IFrame API Player
			$result.='
			
			<div id="'.$playerapiid.'"></div>
		';
		
		$AdoptedPlayerVars=str_replace('&amp;','", "',$settingline);
		$AdoptedPlayerVars='"'.str_replace('=','":"',$AdoptedPlayerVars).'", "enablejsapi":"1"';
		
		
		
			/*
			events: {
					\'onReady\': \'onPlayerReady'.$videolist_row->id.'\',
					\'onStateChange\': \'onPlayerStateChange'.$videolist_row->id.'\'
				}
			*/
		$result_head='
		
		
		<script>
			var tag = document.createElement(\'script\');
			tag.src = "//www.youtube.com/iframe_api";
			var firstScriptTag = document.getElementsByTagName(\'script\')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	
			function onPlayerReady'.$videolist_row->id.'(event)
			{
				'.($initial_volume!=-1 ? 'event.target.setVolume('.$initial_volume.');' : '').'
				'.($theme_row->muteonplay ? 'event.target.mute();' : '').'
			}	
			';
			/*
			function onPlayerStateChange'.$videolist_row->id.'(event) {
				alert("State changed");
				//if (event.data == YT.PlayerState.PLAYING && !done) {
					//setTimeout(stopVideo, 6000);
					//done = true;
				//}
				//setTimeout("ytapi_player'.$videolist_row->id.'.addEventListener(\'onStateChange\', onPlayerStateChange'.$videolist_row->id.')", 1000);
			}
			*/
			$result_head.='
			var ytapi_player'.$videolist_row->id.';
		
			function onYouTubeIframeAPIReady()
			{
				ytapi_player'.$videolist_row->id.' = new YT.Player("'.$playerapiid.'", {
					width: "'.$width.'",
					id: "abrakadabra",
					height: "'.$height.'",
					playerVars: {'.$AdoptedPlayerVars.'},	
					videoId: "'.$options['videoid'].'",
				});
				
				setTimeout("ytapi_player'.$videolist_row->id.'.addEventListener(\'onReady\', \'onPlayerReady'.$videolist_row->id.'\')", 500);
			}
			
			
		
			</script>
		';
		
			$result.=$result_head;
		/*
			if($options['videoid']!='****youtubegallery-video-id****')
			{
				$document = JFactory::getDocument();
				$document->addCustomTag($result_head);
			}
			*/
		
		}
		elseif($options['playertype']==0 or $options['playertype']==3) //Flash AS3.0 Player
		{
			//Old player
			$pVersion=($options['playertype']==0 ? '3': '2');
			$result.='<object '
				.' id="'.$playerid.'"'
				.' width="'.$width.'"'
				.' height="'.$height.'"'
				.' data="'.$youtubeserver.'v/'.$videoidkeyword.'?version='.$pVersion.'&amp;'.$settingline.'"'
				.' type="application/x-shockwave-flash"'
				.($theme_row->responsive==1 ? ' onLoad="YoutubeGalleryAutoResizePlayer'.$videolist_row->id.'();"' : '').'>'
				.'<param name="id" value="'.$playerid.'" />'
				.'<param name="movie" value="'.$youtubeserver.'v/'.$videoidkeyword.'?version='.$pVersion.'&amp;'.$settingline.'" />'
				.'<param name="wmode" value="transparent" />'
				.'<param name="allowFullScreen" value="'.($options['fullscreen'] ? 'true' : 'false').'" />'
				.'<param name="allowscriptaccess" value="always" />'
				.($playlist!='' ? '<param name="playlist" value="'.$playlist.'" />' : '');
			$result.='</object>';
		}
		elseif($options['playertype']==2 or $options['playertype']==4) //Flash Player with detection 3 and 2
		{
			$pVersion=($options['playertype']==2 ? '3': '2');
			
			
			$alternativecode='You need Flash player 8+ and JavaScript enabled to view this video.';
			
			if($initial_volume>100)
				$initial_volume=100;
			if($initial_volume<-1)
				$initial_volume=-1;
	
			//Old player
			/*
			 *'.($theme_row->autoplay ? 'ytplayer.playVideo();' : '
			 * ').'
			 */
			$result_head='
			<!-- Youtube Gallery - Youtube Flash Player With Detection -->
			<script src="'.$http.'www.google.com/jsapi" type="text/javascript"></script>
			<script src="'.$http.'ajax.googleapis.com/ajax/libs/swfobject/2/swfobject.js" type="text/javascript"></script>
			<script type="text/javascript">
			//<![CDATA[
				google.load("swfobject", "2");
				function onYouTubePlayerReady(PlayerId)
				{
					YGYouTubePlayerReady'.$videolist_row->id.'('.($theme_row->autoplay ? 'true' : 'false').');
				}
				
				function YGYouTubePlayerReady'.$videolist_row->id.'(playVideo)
				{
					//alert("Play");
					ytplayer = document.getElementById("'.$playerid.'");
					'.($theme_row->muteonplay ? 'ytplayer.mute();' : '').'
					'.(
					   $initial_volume!=-1
					   ?
					'
					setTimeout("changeVolumeAndPlay'.$videolist_row->id.'("+playVideo+")", 750);'
					   :
					'
					if(playVideo)
						ytplayer.playVideo();
					'
					).'
				}
				
				'.($initial_volume!=-1 ? '
				function changeVolumeAndPlay'.$videolist_row->id.'(playVideo)
				{
					ytplayer = document.getElementById("'.$playerid.'");
					if(ytplayer)
					{
						ytplayer.setVolume('.$initial_volume.');
				        
						if(playVideo)
							ytplayer.playVideo();
					  
					}
				}   
				' : '').'
				
				function youtubegallery_updateplayer_youtube_'.$videolist_row->id.'(videoid,playVideo)
				{
					var playerVersion = swfobject.getFlashPlayerVersion();
					if (playerVersion.major>0)
					{
						var params = { allowScriptAccess: "always", wmode: "transparent"'.($options['fullscreen'] ? ', allowFullScreen: "true"' : '').' };
						var atts = { id: "'.$playerid.'" '
						.' };
						
						
						var playerLink="'.$youtubeserver.'v/"+videoid+"?version='.$pVersion.'&amp;'.$settingline.'";
						
						if(playVideo)
							playerLink=playerLink.replace("autoplay=0","autoplay=1");
							
						swfobject.embedSWF(playerLink,"'.$playerapiid.'", "'.$width.'", "'.$height.'", "8", null, null, params, atts);
					}
					else
						document.getElementById("YoutubeGallerySecondaryContainer'.$videolist_row->id.'").innerHTML="'.$alternativecode.'";
					
					
				}
			//]]>
			</script>
			<!-- end of Youtube Gallery - Youtube Flash Player With Detection -->
			';
//.($theme_row->responsive==2 ? ', style:"width: '.$width.'px !important;height: '.$height.'px !important;"' : '')
			//if($options['videoid']!='****youtubegallery-video-id****')
			//{
				$document = JFactory::getDocument();
				$document->addCustomTag($result_head);
			//}
			
			$result='<div id="'.$playerapiid.'"></div>';
			
			if($options['videoid']!='****youtubegallery-video-id****')
			{
				$result.='
			<script type="text/javascript">
			//<![CDATA[
				youtubegallery_updateplayer_youtube_'.$videolist_row->id.'("'.$options['videoid'].'",false);
			//]]>
			</script>
			';
			
			}
			else
				$result.='<!--DYNAMIC PLAYER-->';
			
		}

		return '<!-- YG test -->'.$result;
	}
	
	
	
	
}


?>
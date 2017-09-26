<?php
/**
 * YoutubeGallery for Joomla!
 * @version 3.8.4
 * @author DesignCompass corp< <support@joomlaboat.com>
 * @link http://www.joomlaboat.com
 * @GNU General Public License
 **/
if(isset($_GET['task']))
{
    $task=$_GET['task'];
 
    switch($task)
    {
        case 'getyoutubeshowowner' :
            if(isset($_GET['link']))
                echo getYoutubeGalleryShowOwner($_GET['link']);
            else
                echo 'link parameter not set';
        break;
        
        case 'getyoutubeshowsbyowner' :
            if(isset($_GET['owner']))
            {
                $username=$_GET['owner'];
                $username=trim(preg_replace("/[^a-zA-Z0-9_]/", "", $username));
                
                if(isset($_GET['max-results']))
                    $max_results=(int)$_GET['max-results'];
                else
                    $max_results=10;
                    
                if(isset($_GET['start-index']))
                    $start_index=(int)$_GET['start-index'];
                else
                    $start_index=1;
                
                
                $arr=getYoutubeShowsByUser($username,$max_results,$start_index);
                echo json_encode($arr);
            }
            else
                echo 'owner parameter not set';
        break;
    
        case 'getyoutubeseasonsbyshowid' :
            if(isset($_GET['showid']))
            {
                $showid=$_GET['showid'];
                $showid=trim(preg_replace("/[^a-zA-Z0-9_]/", "", $showid));
                
                if(isset($_GET['max-results']))
                    $max_results=(int)$_GET['max-results'];
                else
                    $max_results=10;
                    
                if(isset($_GET['start-index']))
                    $start_index=(int)$_GET['start-index'];
                else
                    $start_index=1;
                
                
                $arr=getYoutubeSeasonsByShowID($showid,$max_results,$start_index);
                echo json_encode($arr);
            }
            else
                echo 'owner parameter not set';
        break;
        
        case 'getyoutubeshowownershows' :
            if(isset($_GET['link']))
            {
                $u=getYoutubeGalleryShowOwner($_GET['link']);
                if(isset($_GET['max-results']))
                    $max_results=(int)$_GET['max-results'];
                else
                    $max_results=10;
                    
                if(isset($_GET['start-index']))
                    $start_index=(int)$_GET['start-index'];
                else
                    $start_index=1;
                
                $ua=json_decode($u);
                if($ua==false)
                    echo $ua;

                $arr=getYoutubeShowsByUser($ua->username,$max_results,$start_index);
                print_r($arr);
            }
            else
                echo 'link parameter not set';
        
        
        break;
  
        default:
            echo 'unknown task';
    }
}
else
    echo '<html><body></body></html>';

    function getYoutubeSeasonsByShowID($showid,$max_results,$start_index)
    {
             if($max_results==0)
            $max_results=10;
            
        if($start_index==0)
            $start_index=1;
        
        $url='http://gdata.youtube.com/feeds/api/shows/'.$showid.'/content?v=2&max-results='.$max_results.'&start-index='.$start_index;
        
        $a=getURLData($url);
        if($a=='')
            return 'cannot load seasons page';
        
        if(strpos($a,'<?xml version')===false)
            return 'Cannot load data, no connection';

            
        $xml = simplexml_load_string($a);
        
	
        if($xml)
        {
            
            $arr=array();
            foreach ($xml->entry as $entry)
            {
                $p=explode(':',$entry->id);
                if(count($p)==6)
                {
                    $id=$p[5];
                    $arr[]=array('id'=>$id, 'title'=>$entry->title);
                }
            }

            return $arr;
        }
        return 'xml format corrupted';
    }
 
    function getYoutubeShowsByUser($username,$max_results,$start_index)
    {
        if($max_results==0)
            $max_results=10;
            
        if($start_index==0)
            $start_index=1;
        
        $url='http://gdata.youtube.com/feeds/api/users/'.$username.'/shows?v=2&max-results='.$max_results.'&start-index='.$start_index;
        
        $a=getURLData($url);
        if($a=='')
            return 'cannot load user shows page';
        
        if(strpos($a,'<?xml version')===false)
            return 'Cannot load data, no connection';

        $xml = simplexml_load_string($a);
	
        if($xml)
        {
            $arr=array();
            foreach ($xml->entry as $entry)
            {
                $alternate_link='';
                foreach ($entry->link as $link)
                {
                    $l=$link->attributes();
                    if($l['rel']=='alternate')
                    {
                        $alternate_link=$l['href'];
                        break;
                    }
                }
                $arr[]=array('id'=>$entry->id, 'title'=>$entry->title, 'link'=>$alternate_link);
            }
            return $arr;
        }
        return 'xml format corrupted';
        
    }
 
    function getYoutubeGalleryShowOwner($url)
    {
        if(strpos($url,'://www.youtube.com/show/')===false)
            return 'wrong link format';
        
        $a=getURLData($url);
        if($a=='')
            return 'cannot load show page';
        
        $gdata=getValueOfParameter($a,'<link rel="alternate" type="application/rss+xml" title="RSS" href="');

        if(!$gdata)
            return 'cannot find the owner';
        
        $username=getValueOfParameter($a,'http://gdata.youtube.com/feeds/base/users/','/');

        if(!$gdata)
            return 'cannot find username';
        
        $arr=array('username'=>$username);
        
        return json_encode($arr);
        
    
    }
    
    //---------------- useful functions
    
    function getValueOfParameter($r,$p,$f='"')
    {
	$i=strpos($r,$p);
        if($i===false)
            return false;
        
        $l=strlen($p);
	$a=strpos($r,$f,$i+$l);
	if($a===false)
            return false;
        
        return substr($r,$i+$l, $a-$i-$l); 
				
    }
                        
    function getURLData($url)
    {
			$htmlcode='';
		
			if (function_exists('curl_init'))
			{
				$ch = curl_init();
				$timeout = 180;
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				$htmlcode = curl_exec($ch);
				curl_close($ch);
			}
			elseif (ini_get('allow_url_fopen') == true)
			{
				$htmlcode = file_get_contents($url);
			}
			else
			{
				echo '<p style="color:red;">Cannot load data, enable "allow_url_fopen" or install cURL<br/>
				<a href="http://joomlaboat.com/youtube-gallery/f-a-q/why-i-see-allow-url-fopen-message" target="_blank">Here</a> is what to do.
				</p>
				';
			}

			return $htmlcode;

    }
	

?>
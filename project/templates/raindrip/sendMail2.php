<?

//attach a file to email (1) or add a link to it(0)
define(ATTACHMENT, 1);

//checking input vars
if (!isset($_REQUEST['rp-email']) || !isset($_REQUEST['rp-name']) || !isset($_REQUEST['rp-task']) )
	die('No direct access!');

//Removing block from content from a given pointer and params
function remove_block($pointer, $start_tag, $end_tag, $block) {
	$pos = strpos($block, $pointer);
	if ($pos === false)
		return false;
	$start = strrpos($block, $start_tag, $pos - strlen($block));
	if ($start === false)
		return false;
	$end = strpos($block, $end_tag, $pos);
	if ($end === false)
		return false;
	$end += strlen($end_tag);
	$block = substr($block, 0, $start) . substr($block, $end);

	return $block;
}

if (ATTACHMENT)
	require_once 'mailfile.php';

//setting default vars
$task = $_REQUEST['rp-task'];
$subject = 'Raindrip.com has sent you an instructions and material list.';
$from = '"Raindrip.com" <no-reply@raindrip.com>';
$attachment = 'images/downloads/Raindrip-Instructions.pdf';
$p_n = array('t' => 'Trees', 's' => 'Shrubs', 'c' => "Container Plants", 'p' => 'Planter Boxes', 'g' => 'Ground Cover & Flower Beds'); //product names array
$p_t = array('t' => 'Tubing', 'e' => 'Emitters', 's' => 'Stakes'); //product types array
$pr = array(); 

//getting all input vars
$to = $_REQUEST['rp-email'];
$name = $_REQUEST['rp-name'];
$pr['t'] = array('t' => $_REQUEST["rp-t-t"], 's' => $_REQUEST["rp-t-s"], 'c' => $_REQUEST["rp-t-c"], 'p' => $_REQUEST["rp-t-p"], 'g' => $_REQUEST["rp-t-g"]);
$pr['e']['t'] = $_REQUEST["rp-e-t"];
$pr['e']['s'] = $_REQUEST["rp-e-s"];
$pr['e']['c'] = $_REQUEST["rp-e-c"];
$pr['e']['p'] = $_REQUEST["rp-e-p"];
$pr['e']['g'] = $_REQUEST["rp-e-g"];
$pr['s']['t'] = $_REQUEST["rp-s-t"];
$pr['s']['s'] = $_REQUEST["rp-s-s"];
$pr['s']['c'] = $_REQUEST["rp-s-c"];
$pr['s']['p'] = $_REQUEST["rp-s-p"];
$pr['s']['g'] = false;

//loading params
require_once '../../configuration.php';
$config = new JConfig();

$content = '';
try {
	//creating connection
	$dbh = new PDO('mysql:host='.$config->host.';dbname='.$config->db, $config->user, $config->password);

	//getting content
	$query = "SELECT id, title, introtext, metakey, metadesc FROM #__content WHERE id='275';";
	$query = str_replace('#__', $config->dbprefix, $query);
	foreach($dbh->query($query, PDO::FETCH_ASSOC) as $row) {
		$content = $row['introtext'];
		$from = $row['metakey'];
		$subject = $row['metadesc'];
	}

	//closing connection
	$dbh = null;
}
catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
}

//creating message
$msg = '<html><body>';

if ($content) {
	$content = str_replace('&amp;n', $name, $content);
	foreach ($p_n as $k => $v) {
		//check quantities
		if ($pr['t'][$k] || $pr['e'][$k] || $pr['s'][$k]) {
			foreach ($p_t as $k2 => $v2) {
				if ($pr[$k2][$k] != false)
					$content = str_replace("&amp;$k2$k", $pr[$k2][$k], $content);
				else
					$content = remove_block("&amp;$k2$k", '<td', '</td>', $content);
			}
		}
		// remove table from content
		else {
			$content = remove_block("&amp;t$k", '<table', '</table>', $content);
		}
	}

	$msg .= $content;
}

$msg .= '</body></html>';

if ($attachment && $task == 'send-email') {
	$zip_url = 'http://' . $_SERVER['SERVER_NAME'] .'/'. $attachment;
	$zip_file = $_SERVER['DOCUMENT_ROOT'] .'/'. $attachment;
	$zip_newfile = 'Raindrip_Instructions.pdf';
}

//showing email if don't need to send it
if ($task == 'show-email') {
	echo $msg;
	return;
}

//attach zip-archive and sending message
if (ATTACHMENT && $attachment) {
	$sendmail = new CMailFile($subject, $to, $from, $msg, $zip_file, "application/octet-stream", $zip_newfile);
	$result = $sendmail->sendfile();
}

if (!$result)
	echo 'ERROR';
else
	echo 'SUCCESS';

<?php 
require_once "common.php";

if(!isset($argv[1])) {
	echo "\nError: Missing parameter!\n";
	echo "Use mode:\n";
	echo $argv[0]." (game data folder)\n\n";
	exit;
}

$folder = $argv[1];

if(!file_exists($folder) || !is_dir($folder)) {
	echo "\nError: Not a folder!\n";
	echo "Use mode:\n";
	echo $argv[0]." (game data folder)\n\n";
	exit;
}

$xmlFile = $folder.'/strings.xml'; 

if(!file_exists($xmlFile)) {
	echo "\nError: Invalid folder!\nGame data folder must contain a file names string.xml (containing your translations downloaded from iCanLocalize)\n\n";
	echo "Use mode:\n";
	echo $argv[0]." (game data folder)\n\n";
	exit;
}

require_once $folder.'/database.php';

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

$xmlData = file_get_contents($xmlFile); 
$dom = str_get_html( $xmlData );

foreach($dom->find('string') as $elem){
	$data[$elem->attr['label']]=buildMap($elem,$amazonLangMap);
}

$data=expand($data);
echo buildAmazonLeaderboards();
//print_r($data);
//echo buildLeaderBoard('leaderboard_completed_levels','level_singular','level_plural',$data);
//print_r($data);
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
$data = array();

foreach($dom->find('string') as $elem){
	$data[$elem->attr['label']]=buildMap($elem);
}


for($i=1; $i<=6; $i++){
	$tmp=buildAchievement('complete_stage_X','complete_stage_X_description','completed_stage_X_description',$data,$i);
	file_put_contents('complete_stage_'.$i.'.xml', $tmp);
}

for($i=2; $i<=6; $i++){
	$tmp = buildAchievement('unlock_stage_X','unlock_stage_X_description','unlocked_stage_X_description',$data,$i);
	file_put_contents('unlock_stage_'.$i.'.xml', $tmp);
}

//echo buildLeaderBoard('leaderboard_completed_levels','level_singular','level_plural',$data);
//print_r($data);
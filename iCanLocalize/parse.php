<?php 
require_once "common.php";

if(!file_exists($argv[1])) {
	echo "Error... modo de uso:\n";
	echo $argv[0]." (xml file)\n\n";
	exit;
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

$xmlData = file_get_contents($argv[1]); 
$dom = str_get_html( $xmlData );
$data = array();

foreach($dom->find('string') as $elem){
	//echo $elem->attr['label']."\n";
	if(in_array( $elem->attr['label'], $useful)){
		$data[$elem->attr['label']]=buildMap($elem);
	}
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
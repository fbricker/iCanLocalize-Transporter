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


function buildAmazon(){
	global $data, $achievements;
	$res='';
	//DisplayTitle_en_US,UnlockedDescription_en_US,LockedDescription_en_US,DisplayTitle_en_GB,UnlockedDescription_en_GB,LockedDescription_en_GB,DisplayTitle_de_DE,UnlockedDescription_de_DE,LockedDescription_de_DE,DisplayTitle_fr_FR,UnlockedDescription_fr_FR,LockedDescription_fr_FR,DisplayTitle_it_IT,UnlockedDescription_it_IT,LockedDescription_it_IT,DisplayTitle_es_ES,UnlockedDescription_es_ES,LockedDescription_es_ES,DisplayTitle_ja_JP,UnlockedDescription_ja_JP,LockedDescription_ja_JP,DisplayTitle_zh_CN,UnlockedDescription_zh_CN,LockedDescription_zh_CN,DisplayTitle_ko_KR,UnlockedDescription_ko_KR,LockedDescription_ko_KR,DisplayTitle_pt_BR,UnlockedDescription_pt_BR,LockedDescription_pt_BR,DisplayTitle_ru_RU,UnlockedDescription_ru_RU,LockedDescription_ru_RU'."\n";
	$res='AchievementId,unlockedIconId,lockedIconId,pointValue,isHidden';
	foreach($data[$achievements[0]['title_id']] as $lang=>$v){
		$res.=',DisplayTitle_'.$lang.',UnlockedDescription_'.$lang.',LockedDescription_'.$lang;
	}

	//AchievementID,UnlockedIconId,LockedIconId,50,TRUE,Displayed Achievement Title,Unlocked Achievement Description,Locked Achievement Description,Displayed Achievement Title,Unlocked Achievement Description,Locked Achievement Description,Displayed Achievement Title,Unlocked Achievement Description,Locked Achievement Description,Displayed Achievement Title,Unlocked Achievement Description,Locked Achievement Description,Displayed Achievement Title,Unlocked Achievement Description,Locked Achievement Description,Displayed Achievement Title,Unlocked Achievement Description,Locked Achievement Description,Displayed Achievement Title,Unlocked Achievement Description,Locked Achievement Description,Displayed Achievement Title,Unlocked Achievement Description,Locked Achievement Description,Displayed Achievement Title,Unlocked Achievement Description,Locked Achievement Description,Displayed Achievement Title,Unlocked Achievement Description,Locked Achievement Description,Displayed Achievement Title,Unlocked Achievement Description,Locked Achievement Description
	foreach($achievements as $ach){
	//	if(!empty($data[$ach['id']])) ;
		$res .= "\n".$ach['id'].','.$ach['icon'].','.$ach['icon'].','.$ach['points'].','.($ach['hidden']?'TRUE':'FALSE');
		foreach($data[$ach['title_id']] as $lang=>$title){
			$locked = $data[$ach['description_id']][$lang];
			$unlocked = $data[$ach['unlocked_id']][$lang];
			$res.=',"'.$title.'","'.$unlocked.'","'.$locked.'"'; // add to every achievement, his description for before and after achieved
		}
	}

	$res = str_replace('&apos;',"'",$res);
	$res = str_replace('&amp;',"&",$res);
	return $res;
}

$data=expand($data);
echo buildAmazon();
//print_r($data);
//echo buildLeaderBoard('leaderboard_completed_levels','level_singular','level_plural',$data);
//print_r($data);
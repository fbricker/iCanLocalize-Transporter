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

require_once $folder.'/database.php';

if(!file_exists($xmlFile)) {
	echo "\nError: Invalid folder!\nGame data folder must contain a file names string.xml (containing your translations downloaded from iCanLocalize)\n\n";
	echo "Use mode:\n";
	echo $argv[0]." (game data folder)\n\n";
	exit;
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

$xmlData = file_get_contents($xmlFile); 
$dom = str_get_html( $xmlData );

// TO PARSE ICANLOCALIZE XML
/*
foreach($dom->find('string') as $elem){
	$data[$elem->attr['label']]=buildICLMap($elem,$amazonLangMap);
}
*/



// TO PARSE iTunesTransporter XML
$leads = $dom->find('leaderboards');
foreach ($leads[0]->find('leaderboard') as $l){
	$id = $l->find('leaderboard_id')[0]->innertext;
	$locales = $l->find('locale');
	foreach($locales as $locale){
		$lang = getLangName($locale->attr['name'],$appleLangMap);
		foreach($amazonLangMap[$lang] as $amazonLang){
			$data[$id.'_title'][$amazonLang] = $locale->find('title')[0]->innertext;
			$data[$id.'_unit'][$amazonLang] = $locale->find('formatter_suffix')[0]->innertext;
			$data[$id.'_unit_singular'][$amazonLang] = $locale->find('formatter_suffix_singular')[0]->innertext;
		}
	}
	$position = $l->attr['position'];
	$highest_scores_first = ($l->find('sort_ascending')[0]->plaintext)=='false';
	$score_limit = $l->find('score_range_max')[0]->plaintext;
	$points = $l->find('points')[0]->plaintext;
	$img  = substr($l->find('file_name')[0]->plaintext,0,-4);
	$leaderboards[]=buildLeaderboard($id,$id.'_title',$id.'_title',$img,$id.'_unit',$id.'_unit_singular',$highest_scores_first,$score_limit);
}

$data=expand($data);
echo buildAmazonLeaderboards();
//print_r($data);
//echo buildLeaderBoard('leaderboard_completed_levels','level_singular','level_plural',$data);
//print_r($data);
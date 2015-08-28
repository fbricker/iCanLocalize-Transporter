<?php
define('SKU','1958');
$xmlFile = $folder.'/metadata.xml'; 


// This function is optional (it expands the translations that are generic to this game)
function expand($data){
	return $data;
}

function buildLeaderboard($id,$title_id,$description_id,$icon,$units_id,$singular_units_id,$highest_scores_first,$score_limit){
	return array('id'=>$id,
				'title_id'=>$title_id,
				'description_id'=>$description_id,
				'icon'=>$icon,
				'highest_scores_first'=>$highest_scores_first,
				'score_limit'=>$score_limit,
				'units_id'=>$units_id,
				'singular_units_id'=>$singular_units_id);
}

$leaderboards=array();
/*$leaderboards[0] = array('id'=>'leaderboard_completed_levels',
					'title_id'=>'leaderboard_completed_levels',
					'description_id'=>'leaderboard_completed_levels',
					'icon'=>'puralax_icon','highest_scores_first'=>true,'score_limit'=>1000,
					'units_id'=>'level_plural','singular_units_id'=>'level_singular');

*/
/*
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
	$highest_scores_first = $l->find('sort_ascending')[0]->plaintext;
	$score_limit = $l->find('score_range_max')[0]->plaintext;
	$points = $l->find('points')[0]->plaintext;
	$img  = substr($l->find('file_name')[0]->plaintext,0,-4);
	$leaderboards[]=buildLeaderboard($id,$id.'_title',$id.'_title',$img,$id.'_unit',$id.'_unit_singular',$highest_scores_first,$score_limit);
}
*/


function buildAch($id,$points,$hidden,$icon,$titleID,$descriptionID,$completedID){
	return array('id'=>$id,
				'points'=>$points,'hidden'=>$hidden,
				'icon'=>$icon,
				'title_id' => $titleID, 'description_id'=>$descriptionID, 'unlocked_id'=>$completedID);
}

$achievements=array();
/*
// TO PARSE iTunesTransporter XML
$achs = $dom->find('achievements');
foreach ($achs[0]->find('achievement') as $a){
	$id = $a->find('achievement_id')[0]->innertext;
	$locales = $a->find('locale');
	foreach($locales as $locale){
		$lang = getLangName($locale->attr['name'],$appleLangMap);
		foreach($amazonLangMap[$lang] as $amazonLang){
			$data[$id.'_title'][$amazonLang] = $locale->find('title')[0]->innertext;
			$data[$id.'_before'][$amazonLang] = $locale->find('before_earned_description')[0]->innertext;
			$data[$id.'_after'][$amazonLang] = $locale->find('after_earned_description')[0]->innertext;			
		}
	}
	$position = $a->attr['position'];
	$points = $a->find('points')[0]->plaintext;
	$img  = substr($a->find('file_name')[0]->plaintext,0,-4);
	$achievements[$position-1]= buildAch($id, $points, false, $img, $id.'_title', $id.'_before', $id.'_after');

}

*/
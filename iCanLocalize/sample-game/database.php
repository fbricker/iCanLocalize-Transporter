<?php
define('SKU','0777');
global $forcedTranslations;
$xmlFile = $folder.'/strings.xml'; 


function buildLine($str,$number){
	$lines = explode("\n",str_replace("\n\n","\n",$str));
	if($number=='1') return $lines[0];
	$aux = explode("!",$lines[0],2);
	if(count($aux)==1) $aux = explode("！",$lines[0],2);
	return trim(str_replace('...','',$lines[($number-1)])).$aux[1];
}

function doReplaces($string,$lang,$r1,$r2){
	global $forcedTranslations;
	$lang=str_replace("_","-",$lang);
	if(!empty($forcedTranslations[$lang][$r1])) $r1 = $forcedTranslations[$lang][$r1];
	if(!empty($forcedTranslations[$lang][$r2])) $r2 = $forcedTranslations[$lang][$r2];

	$string = str_replace('%1', $r1, $string);
	$string = str_replace('%2', $r2, $string);
	return str_replace("\r","",trim($string));
}

function expandTemplate($data,$r1,$r2,$line=null){
	$aux=array();
	foreach($data as $lang=>$v){
		$aux[$lang]=doReplaces($v,$lang,$r1,$r2);
		if($line!=null){
			$aux[$lang]=buildLine($aux[$lang],$line);
		}
	}
	return $aux;
}

// This function is optional (it expands the translations that are generic to this game)
function expand($data){
	for ($i=1; $i<=6; $i++) {
		$data['complete_stage_'.$i] = expandTemplate($data['complete_stage_X'],$i,$i);
		$data['complete_stage_'.$i.'_description'] = expandTemplate($data['complete_stage_X_description'],$i,$i);
		$data['completed_stage_'.$i.'_description'] = expandTemplate($data['completed_stage_X_description'],$i,$i,$i);
	}

	for ($i=2; $i<=6; $i++) {
		$data['unlock_stage_'.$i] = expandTemplate($data['unlock_stage_X'],$i,$i);
		$data['unlock_stage_'.$i.'_description'] = expandTemplate($data['unlock_stage_X_description'],$i-1,$i);
		$data['unlocked_stage_'.$i.'_description'] = expandTemplate($data['unlocked_stage_X_description'],$i,$i);
	}

	return $data;
}

$forcedTranslations = array();

$forcedTranslations['ko-KR']['1'] = '일';
$forcedTranslations['ko-KR']['2'] = '이';
$forcedTranslations['ko-KR']['3'] = '삼';
$forcedTranslations['ko-KR']['4'] = '사';
$forcedTranslations['ko-KR']['5'] = '오';
$forcedTranslations['ko-KR']['6'] = '육';
$forcedTranslations['ko-KR']['7'] = '칠';
$forcedTranslations['ko-KR']['8'] = '팔';
$forcedTranslations['ko-KR']['9'] = '구';

$forcedTranslations['ja-JP']['1'] = '一';
$forcedTranslations['ja-JP']['2'] = '二';
$forcedTranslations['ja-JP']['3'] = '三';
$forcedTranslations['ja-JP']['4'] = '四';
$forcedTranslations['ja-JP']['5'] = '五';
$forcedTranslations['ja-JP']['6'] = '六';
$forcedTranslations['ja-JP']['7'] = '七';
$forcedTranslations['ja-JP']['8'] = '八';
$forcedTranslations['ja-JP']['9'] = '九';

$forcedTranslations['cmn-Hans'] = $forcedTranslations['ja-JP'];
$forcedTranslations['cmn-Hant'] = $forcedTranslations['ja-JP'];
$forcedTranslations['zh-CN'] = $forcedTranslations['ja-JP'];
$forcedTranslations['zh-TW'] = $forcedTranslations['ja-JP'];

$leaderboards=array();
$leaderboards[0] = array('id'=>'leaderboard_completed_levels',
					'title_id'=>'leaderboard_completed_levels',
					'description_id'=>'leaderboard_completed_levels',
					'icon'=>'puralax_icon','highest_scores_first'=>true,'score_limit'=>1000,
					'units_id'=>'level_plural','singular_units_id'=>'level_singular');

function buildAch($id,$points,$hidden,$icon,$titleID,$descriptionID,$completedID){
	return array('id'=>$id,
				'points'=>$points,'hidden'=>$hidden,
				'icon'=>$icon,
				'title_id' => $titleID, 'description_id'=>$descriptionID, 'unlocked_id'=>$completedID);
}

$achievements=array();
$achievements[0] = buildAch('achievement_complete_stage_1',   5, false, 'puralax_1_completed', 'complete_stage_1', 'complete_stage_1_description', 'completed_stage_1_description');
$achievements[1] = buildAch('achievement_unlock_stage_2'  ,  10, false, 'puralax_2_unlocked' , 'unlock_stage_2'  , 'unlock_stage_2_description'  , 'unlocked_stage_2_description' );
$achievements[2] = buildAch('achievement_complete_stage_2',  15, true , 'puralax_2_completed', 'complete_stage_2', 'complete_stage_2_description', 'completed_stage_2_description');
$achievements[3] = buildAch('achievement_unlock_stage_3'  ,  10, true , 'puralax_3_unlocked' , 'unlock_stage_3'  , 'unlock_stage_3_description'  , 'unlocked_stage_3_description' );
$achievements[4] = buildAch('achievement_complete_stage_3',  30, true , 'puralax_3_completed', 'complete_stage_3', 'complete_stage_3_description', 'completed_stage_3_description');
$achievements[5] = buildAch('achievement_unlock_stage_4'  ,  10, true , 'puralax_4_unlocked' , 'unlock_stage_4'  , 'unlock_stage_4_description'  , 'unlocked_stage_4_description' );
$achievements[6] = buildAch('achievement_complete_stage_4',  60, true , 'puralax_4_completed', 'complete_stage_4', 'complete_stage_4_description', 'completed_stage_4_description');
$achievements[7] = buildAch('achievement_unlock_stage_5'  ,  10, true , 'puralax_5_unlocked' , 'unlock_stage_5'  , 'unlock_stage_5_description'  , 'unlocked_stage_5_description' );
$achievements[8] = buildAch('achievement_complete_stage_5',  80, true , 'puralax_5_completed', 'complete_stage_5', 'complete_stage_5_description', 'completed_stage_5_description');
$achievements[9] = buildAch('achievement_unlock_stage_6'  ,  10, true , 'puralax_6_unlocked' , 'unlock_stage_6'  , 'unlock_stage_6_description'  , 'unlocked_stage_6_description' );
$achievements[10]= buildAch('achievement_complete_stage_6', 100, true , 'puralax_6_completed', 'complete_stage_6', 'complete_stage_6_description', 'completed_stage_6_description');


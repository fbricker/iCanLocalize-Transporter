<?php
define('SKU','0777');
global $forcedTranslations;


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
$leaderboards[0] = array('id'=>'leaderboard_completed_levels');

function buildAch($id,$points,$hidden){
	return array('id'=>$id,'points'=>$points,'hidden'=>$hidden);
}

$achievements=array();
$achievements[0] = buildAch('complete_stage_1',50,false);
$achievements[1] = buildAch('unlock_stage_2',  50,false);
$achievements[2] = buildAch('complete_stage_2',50,true);
$achievements[3] = buildAch('unlock_stage_3',  50,true);
$achievements[4] = buildAch('complete_stage_3',50,true);
$achievements[5] = buildAch('unlock_stage_4',  50,true);
$achievements[6] = buildAch('complete_stage_4',50,true);
$achievements[7] = buildAch('unlock_stage_5',  50,true);
$achievements[8] = buildAch('complete_stage_5',50,true);
$achievements[9] = buildAch('unlock_stage_6'  ,50,true);
$achievements[10]= buildAch('complete_stage_6',50,true);


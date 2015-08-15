<?php
define('SKU','0777');

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


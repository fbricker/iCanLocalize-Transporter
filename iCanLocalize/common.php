<?php 
require_once "simple_html_dom.php";
global $appleLangMap,$nonSingularLanguages,$achievements,$leaderboards,$data,$amazonLangMap;

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

function buildICLMap($dom,$langMap){
	$res = array();
	$eng=explode("<translation",$dom->innertext,2);
	
	foreach($langMap['English'] as $lang) $res[$lang]=$eng[0];
	foreach($dom->find('translation') as $elem){
		foreach($langMap[$elem->attr['language']] as $lang) $res[$lang]=$elem->innertext;
	}
	return $res;
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

function buildAmazonLeaderboards(){
	global $data, $leaderboards;
	$res='';

// HEADER SAMPLE:
// LeaderboardId,IconId,SortOrder,ScoreThreshold,Title_en_US,ScoreUnits_en_Us,Description_en_US,Title_de_DE,ScoreUnits_de_DE,Description_de_DE,Title_fr_FR,ScoreUnits_fr_FR,Description_fr_FR,Title_it_IT,ScoreUnits_it_IT,Description_it_IT,Title_en_GB,ScoreUnits_en_GB,Description_en_GB,Title_es_ES,ScoreUnits_es_ES,Description_es_ES,Title_ja_JP,ScoreUnits_ja_JP,Description_ja_JP,Title_zh_CN,ScoreUnits_zh_CN,Description_zh_CN,Title_ko_KR,ScoreUnits_ko_KR,Description_ko_KR,Title_pt_BR,ScoreUnits_pt_BR,Description_pt_BR,Title_ru_RU,ScoreUnits_ru_RU,Description_ru_RU
	$res='LeaderboardId,IconId,SortOrder,ScoreThreshold';
	foreach($data[$leaderboards[0]['title_id']] as $lang=>$v){
		$res.=',Title_'.$lang.',ScoreUnits_'.$lang.',Description_'.$lang;
	}


// BODY SAMPLE:
// LeaderboardId,IconId,highest scores first,1,Leaderboard Title,Points,Leaderboard Description,Leaderboard Title,Points,Leaderboard Description,Leaderboard Title,Points,Leaderboard Description,Leaderboard Title,Points,Leaderboard Description,Leaderboard Title,Points,Leaderboard Description,Leaderboard Title,Points,Leaderboard Description,Leaderboard Title,Points,Leaderboard Description,Leaderboard Title,Points,Leaderboard Description,Leaderboard Title,Points,Leaderboard Description,Leaderboard Title,Points,Leaderboard Description,Leaderboard Title,Points,Leaderboard Description
	foreach($leaderboards as $ldb){
		if($ldb['highest_scores_first']===true){
			$sort = 'highest scores first';
		}else{
			$sort = 'lowest scores first';
		}
		$res .= "\n".$ldb['id'].','.$ldb['icon'].','.$sort.','.$ldb['score_limit'];
		foreach($data[$ldb['title_id']] as $lang=>$title){
			$units = $data[$ldb['units_id']][$lang];
			$description = $data[$ldb['description_id']][$lang];
			$res.=',"'.$title.'","'.trim($units).'","'.$description.'"'; // add to every achievement, his description for before and after achieved
		}
	}
	return $res;
}

function buildAmazonAchievements(){
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

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

function buildIOSLeaderboard($id,$singularID,$pluralID,$data){
	global $nonSingularLanguages;
	$res='';
	foreach($data[$id] as $k=>$v){
		if(in_array($k, $nonSingularLanguages)){
			$singular = '';
		}else{
			$singular="\n".'                                <formatter_suffix_singular> '.$data[$singularID][$k].'</formatter_suffix_singular>';
		}
		$res.='
                            <locale name="'.$k.'">
                                <title>'.$v.'</title>
                                <formatter_suffix> '.$data[$pluralID][$k].'</formatter_suffix>'.$singular.'
                                <formatter_type>INTEGER_DECIMAL_SEPARATOR</formatter_type>
                                <leaderboard_image>'.getImage('icon-512x512-round.png').'
                                </leaderboard_image>
                            </locale>';
	}
	return $res;
}

function getImage($img){
	$fname='../download/'.SKU.'/'.SKU.'.itmsp/'.$img;
	$fsize=filesize($fname);
	$md5=md5(file_get_contents($fname));
	return '
                                    <size>'.$fsize.'</size>
                                    <file_name>'.$img.'</file_name>
                                    <checksum type="md5">'.$md5.'</checksum>';

}

function buildIOSAchievement($id,$beforeID,$afterID,$data,$r1=''){
	$res='';
	list($mode,$none)=explode('_',$id,2);
	$r2=$r1;
	if($mode=='unlock') {
		$img = 'puralax_'.$r1.'_unlocked.png';
		$r1--;
	}else{
		$img = 'puralax_'.$r1.'_completed.png';		
	}
	foreach($data[$id] as $k=>$v){
		$after = $data[$afterID][$k];
		$res.='
                            <locale name="'.$k.'">
                                <title>'.doReplaces($v,$k,$r2,$r2).'</title>
                                <before_earned_description>'.doReplaces($data[$beforeID][$k],$k,$r1,$r2).'</before_earned_description>
                                <after_earned_description>'.doReplaces($after,$k,$r2,$r2).'</after_earned_description>
                                <achievement_after_earned_image>'.getImage($img).'
                                </achievement_after_earned_image>
                            </locale>';
    }
    return $res;
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

function getLangName($name,$map){
	foreach($map as $k=>$v){
		if(in_array($name, $v)) return $k;
	}
	return null;
}

$data = array();
$leaderboards = array();
$achievements = array();
$nonSingularLanguages = array('fr-FR','pt-BR','ru-RU','ja-JP','cmn-Hans','cmn-Hant','tr-TR','vi-VI','ko-KR');

$appleLangMap = array();

$appleLangMap['English']	= array('en-US','en-GB');
$appleLangMap['French']		= array('fr-FR');
$appleLangMap['German']		= array('de-DE');
$appleLangMap['Portuguese']	= array('pt-BR','pt-PT');
$appleLangMap['Russian']	= array('ru-RU');
$appleLangMap['Spanish']	= array('es-ES');
$appleLangMap['Italian']	= array('it-IT');
$appleLangMap['Japanese']	= array('ja-JP');
$appleLangMap['Dutch']		= array('nl-NL');
$appleLangMap['Chinese (Simplified)'] = array('cmn-Hans');
$appleLangMap['Chinese (Traditional)'] = array('cmn-Hant');
$appleLangMap['Turkish']	= array('tr-TR');
$appleLangMap['Vietnamese']	= array('vi-VI');
$appleLangMap['Korean']		= array('ko-KR');

$appleLangMap['Hebrew']		= array();
$appleLangMap['Polish']		= array();
$appleLangMap['Arabic']		= array();
$appleLangMap['Catalan']	= array();

$amazonLangMap = array();
$amazonLangMap['English']	= array('en_US','en_GB');
$amazonLangMap['French']	= array('fr_FR');
$amazonLangMap['German']	= array('de_DE');
$amazonLangMap['Portuguese']= array('pt_BR');
$amazonLangMap['Russian']	= array('ru_RU');
$amazonLangMap['Spanish']	= array('es_ES');
$amazonLangMap['Italian']	= array('it_IT');
$amazonLangMap['Japanese']	= array('ja_JP');
$amazonLangMap['Korean']	= array('ko_KR');
$amazonLangMap['Chinese (Simplified)'] = array('zh_CN');

$amazonLangMap['Chinese (Traditional)'] = array();
$amazonLangMap['Turkish']	= array();
$amazonLangMap['Dutch']		= array();
$amazonLangMap['Vietnamese']= array();
$amazonLangMap['Hebrew']	= array();
$amazonLangMap['Polish']	= array();
$amazonLangMap['Arabic']	= array();
$amazonLangMap['Catalan']	= array();



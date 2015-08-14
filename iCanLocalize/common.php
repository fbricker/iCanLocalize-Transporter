<?php 
require_once "simple_html_dom.php";

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

function buildMap($dom){
	global $langMap;
	$res = array();
	$eng=explode("<translation",$dom->innertext,2);
	
	foreach($langMap['English'] as $lang) $res[$lang]=$eng[0];
	foreach($dom->find('translation') as $elem){
		foreach($langMap[$elem->attr['language']] as $lang) $res[$lang]=$elem->innertext;;
	}
	return $res;
}


function buildLeaderBoard($id,$singularID,$pluralID,$data){
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

function doReplaces($string,$lang,$r1,$r2){
	global $forcedTranslations;
	if(!empty($forcedTranslations[$lang][$r1])) $r1 = $forcedTranslations[$lang][$r1];
	if(!empty($forcedTranslations[$lang][$r2])) $r2 = $forcedTranslations[$lang][$r2];

	$string = str_replace('%1', $r1, $string);
	$string = str_replace('%2', $r2, $string);
	return str_replace("\r","",trim($string));
}

function buildLine($str,$number){
	$lines = explode("\n",str_replace("\n\n","\n",$str));
	if($number=='1') return $lines[0];
	$aux = explode("!",$lines[0],2);
	if(count($aux)==1) $aux = explode("！",$lines[0],2);
	return trim(str_replace('...','',$lines[($number-1)])).$aux[1];
}

function buildAchievement($id,$beforeID,$afterID,$data,$r1=''){
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
//		if($k!='es-ES' && $k!='en-US') continue;
		$after = buildLine($data[$afterID][$k],$r1);
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

define('SKU','0777');

global $useful,$langMap,$nonSingularLanguages,$forcedTranslations;
$useful = array('leaderboard_completed_levels','level_singular','level_plural','completed_stage_X_description','complete_stage_X_description','unlock_stage_X','complete_stage_X','unlock_stage_X_description','unlocked_stage_X_description');


$nonSingularLanguages = array('fr-FR','pt-BR','ru-RU','ja-JP','cmn-Hans','cmn-Hant','tr-TR','vi-VI','ko-KR');
$langMap = array();

$langMap['English'] = array('en-US','en-GB');
$langMap['French'] = array('fr-FR');
$langMap['German'] = array('de-DE');
$langMap['Portuguese'] = array('pt-BR','pt-PT');
$langMap['Russian'] = array('ru-RU');
$langMap['Spanish'] = array('es-ES');
$langMap['Italian'] = array('it-IT');
$langMap['Japanese'] = array('ja-JP');
$langMap['Dutch'] = array('nl-NL');
$langMap['Chinese (Simplified)'] = array('cmn-Hans');
$langMap['Chinese (Traditional)'] = array('cmn-Hant');
$langMap['Turkish'] = array('tr-TR');
$langMap['Vietnamese'] = array('vi-VI');
$langMap['Korean'] = array('ko-KR');

$langMap['Hebrew'] = array();
$langMap['Polish'] = array();
$langMap['Arabic'] = array();
$langMap['Catalan'] = array();

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

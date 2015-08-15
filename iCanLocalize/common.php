<?php 
require_once "simple_html_dom.php";
global $appleLangMap,$nonSingularLanguages,$achievements,$leaderboards,$data,$amazonLangMap;

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

function buildMap($dom,$langMap){
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



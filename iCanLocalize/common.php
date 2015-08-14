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

global $useful,$langMap;
$useful = array('leaderboard_completed_levels','level_singular','level_plural');
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

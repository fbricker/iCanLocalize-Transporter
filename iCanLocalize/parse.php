<?php 
require_once "common.php";

if(!file_exists($argv[1])) {
	echo "Error... modo de uso:\n";
	echo $argv[0]." (xml file)\n\n";
	exit;
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

$xmlData = file_get_contents($argv[1]); 
$dom = str_get_html( $xmlData );
$data = array();

foreach($dom->find('string') as $elem){
	//echo $elem->attr['label']."\n";
	if(in_array( $elem->attr['label'], $useful)){
		$data[$elem->attr['label']]=buildMap($elem);
	}
}

print_r($data);
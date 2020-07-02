<table cellpadding='2' cellspacing='2' border='1'>
<tr><td>id</td><td>title</td><td>scrc?</td><td>uncap?</td></tr>
<?php

include 'config.php';

$str = file_get_contents($MARKLOGIC . "/admin/gimme.xqy?collection=collection/UNCAP");
$str = str_replace(' xmlns="urn:isbn:1-931666-22-9"', '', $str);

$uncap = new DOMDocument();
$uncap->loadXML($str);

$str = file_get_contents($MARKLOGIC . "/admin/gimme.xqy?collection=project/SCRC");
$str = str_replace(' xmlns="urn:isbn:1-931666-22-9"', '', $str);

$scrc = new DOMDocument();
$scrc->loadXML($str);

$docs = array();
foreach ($uncap->getElementsByTagName('div') as $div) {
	$id = $div->getElementsByTagName('span')->item(0)->nodeValue;
	$title = $div->getElementsByTagName('span')->item(1)->nodeValue;
	if (!array_key_exists($id, $docs)) {
		$docs[$id] = array(
			'title' => $title,
			'uncap' => '',
			'scrc' => ''
		);
	}
	$docs[$id]['uncap'] = 'x';
}

foreach ($scrc->getElementsByTagName('div') as $div) {
	$id = $div->getElementsByTagName('span')->item(0)->nodeValue;
	$title = $div->getElementsByTagName('span')->item(1)->nodeValue;
	if (!array_key_exists($id, $docs)) {
		$docs[$id] = array(
			'title' => $title,
			'uncap' => '',
			'scrc' => ''
		);
	}
	$docs[$id]['scrc'] = 'x';
}

ksort($docs);

foreach ($docs as $id => $data) {
	printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", 
		$id,
		$data['title'],
		$data['scrc'],
		$data['uncap']
	);
}

?>
</table>

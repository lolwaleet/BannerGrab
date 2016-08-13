<?php

/*
 * ~ Coded by AnonGuy & T3N38R1S <3
 *
*/

function getJoomlaInformation($url){
	if(!endsWith($url, '/')){$url .= '/';}

	$version   = '';
	$data_comp = [];
	$fulldata  = GetContent($url);

	preg_match_all("/\/components\/(.*?)[\/|\"|']/", $fulldata, $data_comp);
	if(isset($data_comp[1])){
		$data_comp = array_unique($data_comp[1]);
	}
	else{
		$data_comp = [];
	}
	
	$isJoomlaMeta = preg_match('/"generator" content="Joomla!/', $fulldata);
	$fulldata     = GetContent($url . 'README.txt');
	preg_match('/\* Joomla! (.*?) version history/', $fulldata, $version_r);
	if(isset($version_r[1])){
		$version = $version_r[1];
	}
	else{
		$xml = simplexml_load_file("$url/language/en-GB/en-GB.xml");
		$version = $xml->version;
	}
	return ['version' => $version, 'components' => $data_comp, 'isjoomla' => $isJoomlaMeta];
}

function getWordpressInformation($url){
	if(!endsWith($url,'/')){$url .= '/';}

	$version     = '';
	$data_plugin = [];
	$data_theme  = [];
	$fulldata    = GetContent($url);

	preg_match_all("/\/wp-content\/plugins\/(.*?)[\/|\"|']/", $fulldata, $data_plugin);
	if(isset($data_plugin[1])){
		$data_plugin = array_unique($data_plugin[1]);
	}
	else{
		$data_plugin = [];
	}

	preg_match_all("/\/wp-content\/themes\/(.*?)[\/|\"|']/", $fulldata, $data_theme);
	if(isset($data_theme[1])){
		$data_theme = array_unique($data_theme[1]);
	}
	else{
		$data_theme = [];
	}
	$isWordpress = preg_match('/\/wp-content\//', $fulldata);
	$fulldata    = GetContent($url . 'readme.html');
	preg_match('/\<br \/\> Version (.*?)\<\/h1\>/s', $fulldata, $version_r);
	if(isset($version_r[1])){
		$version = preg_replace('/[^0-9,.]+/i', '', $version_r[1]);
	}
	return ['version' => $version, 'plugins' => $data_plugin, 'themes' => $data_theme, 'iswordpress' => $isWordpress];
}
function GetContent($url,$getloc=false){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	$a   = curl_exec($ch);
	$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
	curl_close($ch); 
	if($getloc){
		return $url;
	}
	return $a;
}
function endsWith($haystack, $needle){return $needle === '' || substr($haystack, -strlen($needle)) === $needle;}
function getHost($url){
	$url = parse_url($url);
	if (preg_match("/(.*?)\.(.*)/", $url['host'], $m)) {
  		$url['host'] = $m[2];
	}
	return $url['host'];
}

function getVulnsP($plugin){
	return json_decode(file_get_contents('https://wpvulndb.com/api/v2/plugins/'.$plugin), true)[$plugin]['vulnerabilities'];
}
function getVulnsT($theme){
	return json_decode(file_get_contents('https://wpvulndb.com/api/v2/themes/'.$theme), true)[$theme]['vulnerabilities'];
}
function getVulnsV($version){
	$vers  = str_replace('.', null, $version);
	return json_decode(file_get_contents('https://wpvulndb.com/api/v2/wordpresses/'.$vers), true)[$version]['vulnerabilities'];
}
function getVulnsC($component){
	$json  = json_decode(file_get_contents('http://vel.myjoomla.io'), true);
	$vulns = [];
	foreach ($json['data'] as $vuln) {
		if($vuln['com_whatever'] == $component){
			array_push($vulns, $vuln['title'].' might be vulnerable to  - [ '.$vuln['type'].' ] if it\'s running v'.$vuln['version_effected']."\n");
		}
	}
	return $vulns;
}
?>
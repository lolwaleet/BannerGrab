<?php

// ~ Coded by AnonGuy ~ [ an0nguy@protonmail.ch ] -- [ blog.lolwaleet.com ]

error_reporting(0);
require('...wp.php'); 
$sublist3r = '...sublist3r.py'; // Sublist3r.py's path here!

echo "\033[33m ____                               _____           _    
|  _ \\                             / ____|         | |    
| |_) | __ _ _ __  _ __   ___ _ __| |  __ _ __ __ _| |__  
|  _ < / _` | '_ \\| '_ \\ / _ \\ '__| | |_ | '__/ _` | '_ \\
| |_) | (_| | | | | | | |  __/ |  | |__| | | | (_| | |_) |
|____/ \\__,_|_| |_|_| |_|\\___|_|   \\_____|_|  \\__,_|_.__/ ~ by \033[31mAnonGuy
\033[32mGreets to ~ \033[36mT3N38R1S \033[31m<3 <3\033[0m -- \033[36mMakMan\033[0m -- \33[36mMawnsta Maini\033[0m -- \33[36mKira\033[0m  -- \33[36m".get_current_user()."\033[0m\n";
$sep = "\033[36m-----------------------------------------------------------------------";
$array = ['Server' => "\033[31m[!]\033[0m Server header found!", 'X-Generator' => "\033[31m[!]\033[0m X-Generator header found!", 'X-Powered-By' => "\033[31m[!]\033[0m X-Powered-By header found!", 'zope3' => "\033[31m[!]\033[0m Zope framework in use!", 'CAKEPHP' => "\033[31m[!]\033[0m CakePHP framework in use!", 'kohanasession' => "\033[31m[!]\033[0m Kohana framework in use!", 'X-AspNet-Version' => "\033[31m[!]\033[0m ASP.NET framework in use!", 'laravel_session' => "\033[31m[!]\033[0m Laravel framework in use!", '__cfduid' => "\033[31m[!]\033[0m Site is behind CloudFlare!", 'ns_af' => "\033[31m[!]\033[0m Site is behind Citrix Netscaler WAF!", 'Joomla' => "\033[31m[!]\033[0m Site is using Joomla!", 'Drupal' => "\033[31m[!]\033[0m Site is using Drupal!", 'X-Pingback' => "\033[31m[!]\033[0m Site is running Wordpress!", 'Link' => "\033[31m[!]\033[0m Site is running Wordpress!"];

echo "$sep\n\033[31mURL ->\033[0m ";
$handle = fopen("php://stdin", 'r');
$url = trim(fgets($handle));
fclose($handle);
echo "$sep\n";
$headers = get_headers($url);

foreach($headers as $header) {
	foreach($array as $val => $desc) {
		if (stripos($header, $val) !== false) {
			echo "$desc \033[36m[ \033[32m" . explode(': ', $header)[1] . "\033[36m ]\n\033[0m";
		}
	}
}

$safeString = eval(base64_decode('LyoKICogSnVzdCBLaWRkaW5nIHhECiov'));

if (!array_key_exists('X-Frame-Options', get_headers($url, 1))) {
	echo "\033[31m[!]\033[0m Vulnerable to ClickJacking! \033[36m[ \033[32m$url\033[36m ]\n\033[0m"; //BegBounty hax0rZs
}

$uUrl = getHost($url);
$tmp = rand(10, 100) . '.txt';
shell_exec("python $sublist3r -d $uUrl -o $tmp");
$subs = file_get_contents($tmp) ? "\n" . file_get_contents($tmp) : "\033[0mCan't find any! :(\n";
echo "$sep\n\033[31mSubdomains -> $subs$sep\n";
unlink($tmp);

if (getWordpressInformation($url)['iswordpress']) {	
	$plugins = getWordpressInformation($url)['plugins'];
	$themes  = getWordpressInformation($url)['themes'];
	$version = getWordpressInformation($url)['version'];

	echo "\033[31m[!]\033[0m Scanning Themes and Plugins [ Site is running WP $version ] . . .\n\n";

	if(!empty(getVulnsV($version))){
		echo "\033[31m[+] WP Core $version\033[0m is vulnerable to ~\n";
		foreach(getVulnsV($version) as $cVuln){
			echo $cVuln['title']."\n";
		}
		echo "\n";
	}

	foreach($plugins as $plugin) {
		if (!empty(getVulnsP($plugin))) {
			echo "\033[31m[+] $plugin\033[0m might be vulnerable to ~\n";
			foreach(getVulnsP($plugin) as $pVuln) {
				echo $pVuln['title'] . "\n";
			}
		}
		else {
			echo "\033[31m[+]\033[32m $plugin\033[0m\n";
		}

		echo "\n";
	}

	foreach($themes as $theme) {
		if (!empty(getVulnsT($theme))) {
			echo "\033[31m[+] $theme\033[0m might be vulnerable to ~\n";
			foreach(getVulnsT($theme) as $tVuln) {
				echo $tVuln['title'] . "\n";
			}
		}
		else {
			echo "\033[31m[+]\033[32m $theme\033[0m\n";
		}
	}

	echo "$sep\n";
}

if (getJoomlaInformation($url)['isjoomla']) {
	$components = getJoomlaInformation($url)['components'];
	$version = getJoomlaInformation($url)['version'];
	echo "\033[31m[!]\033[0m Scanning Components [ Site is running Joomla $version ] . . .\n\n";
	if(!empty($components)){
	foreach($components as $component) {
		if (!empty(getVulnsC($component))) {
			echo "\033[31m[~] " . $component . "\033[0m\n";
			foreach(getVulnsC($component) as $vuln) {
				echo "\033[31m[+]\033[0m " . $vuln . "\n";
			}
		}
		else {
			echo "\033[31m[~]\033[32m $component\033[0m\n";
		}
	}}
	else{
		echo "\033[31m[!]\033[0m Can't find any! :(";
	}
	echo "$sep\n";
}

?>
<?php
$start = microtime(true);

if (isset($_GET['req'])) {
	$requests = (int) $_GET['req'];
} else {
	$requests = 0;
}

if (isset($_GET['rand']) && $_GET['rand']) {
	$rand = true;
} else {
	$rand = false;
}

include('./jackalope/src/jackalope/autoloader.php');
error_reporting(E_ALL ^E_NOTICE);
include("config.php");

try {
$server = "http://$loadbalancer:85/server";
$user = 'admin';
$pass = 'admin';
$workspace =  'default';

$cred = new \PHPCR\SimpleCredentials($user, $pass);
$repo = new \jackalope\Repository($server, null); //let jackalope factory create the transport

$sess = $repo->login($cred, $workspace);
print round((microtime(true) - $start) * 1000,2) . " ms";
print "<hr/>";

for ($a = 0; $a < $requests; $a++) {
if ($rand) {
$i = floor(mt_rand(0,1));
$j = floor(mt_rand(0,11));
$k = floor(mt_rand(0,9));
$l = floor(mt_rand(0,9));
} else {
$i = $j = $l = 1; $k = $a;
}
#print "$i/$j/$k/$l.dat/jcr:content\n";
$node = $sess->getNode("/$i/$j/$k/$l.dat/jcr:content");
print  $node->getProperty("jcr:lastModified")->getString();
print "<br/>\n";
print round((microtime(true) - $start) * 1000,2) . " ms";
print "<hr/>";
}
} catch (Exception $e) {
   var_dump($e);
}

print "<hr/>";
print round((microtime(true) - $start) * 1000,2) . " ms";

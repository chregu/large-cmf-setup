<?php
$start = microtime(true);
print "<hr/>";
print "frontend<hr/>";
print file_get_contents("http://localhost:83/bench.php?req=1");
print "<hr/>";
print (microtime(true) - $start) * 1000;

<?php
$root = "http://ec2-46-51-132-64.eu-west-1.compute.amazonaws.com:8080/repository/default/"; 
$root = "http://localhost:8080/repository/default/"; 
$inserted = 0;
                
for( $i = 0; $i < 1; $i++) {
    $path = $i;
    mkcol($root.$path);
    for( $j = 0; $j < 12; $j++) {
          $path = "$i/$j";
          mkcol($root.$path);

        for( $k = 0; $k < 10; $k++) {
            $path = "$i/$j/$k";
            mkcol($root.$path);

            for( $l = 0; $l < 10; $l++) {
                
                $path = "$i/$j/$k/$l.dat";

                $url = $root.$path;
if (url_exists($url)) {
continue;
}
for($len=1000,$r='';strlen($r)<$len;$r.=chr(!mt_rand(0,2)?mt_rand(48,57):(!mt_rand(0,1)?mt_rand(65,90):mt_rand(97,122))));

$data = $r;
                $url = $root.$path;
                $ch = getCurl();
                print "$path ";
                
                curl_setopt($ch, CURLOPT_PUT, 1); 
                curl_setopt($ch, CURLOPT_URL, $url);
                $putData = tmpfile(); 
                fwrite($putData, $data); 
                fseek($putData, 0); 
                
                
                curl_setopt($ch, CURLOPT_INFILE, $putData); 
                curl_setopt($ch, CURLOPT_INFILESIZE, strlen($data)); 
                
                $returned = curl_exec($ch); 
                $len = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD); 
                $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
                fclose($putData); 
                curl_close($ch);
                
                print $code ." ";
      $inserted++;          
print             $inserted . " \n";    
                
            }
        }
    }
}

function mkcol($url) {
    $ch = getCurl();
    print "mkcol $url\n";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"MKCOL");
    $returned = curl_exec($ch); 
    $len = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD); 
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
    //fclose($putData); 
    curl_close($ch);
    
    print $code ."\n";
    
    
    
}

function getCurl() {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0); 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); 
    curl_setopt($ch, CURLOPT_USERPWD, "admin:admin"); 
    
    return $ch;  
    
}
function url_exists($url) {
    // Version 4.x supported
    $handle   = curl_init($url);
    curl_setopt($handle, CURLOPT_USERPWD, "admin:admin"); 
    if (false === $handle)
    {
        return false;
    }
    curl_setopt($handle, CURLOPT_HEADER, false);
curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'HEAD'); 

    curl_setopt($handle, CURLOPT_FAILONERROR, true);  // this works
    curl_setopt($handle, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") ); // request as if Firefox    
    curl_setopt($handle, CURLOPT_NOBODY, true);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, false);
    $connectable = curl_exec($handle);
    curl_close($handle);   
    return $connectable;
}

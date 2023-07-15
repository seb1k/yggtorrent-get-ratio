<?php


$YGGTORRENT_URL="yggtorrent.wtf";

$USER = "the_username";
$PASSWORD = "the_password";





// request 1
$ch = curl_init("https://$YGGTORRENT_URL/user/login");


curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_HEADER, 1);

curl_setopt($ch, CURLOPT_COOKIESESSION, true);
curl_setopt($ch, CURLOPT_POST, true);



curl_setopt($ch, CURLOPT_POSTFIELDS, array("id"=>$USER,"pass"=>$PASSWORD));



$response = curl_exec($ch);



if (curl_errno($ch)) {
		echo "curl error : ".curl_error($ch);
		die();
	}
		
		
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($http_code == intval(200)){
	//		echo $response; // OK
	}
else{
		echo "Login echoué, ressource introuvable : " . $http_code;
		die();
	}

//	 GET COOKIE IN VARIABLE cookies
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header      = substr($response, 0, $header_size);

//echo "----header : -----  ".print_r($header)." -------<br/>";

preg_match_all("/^Set-cookie: (.*?);/ism", $header, $cookiesinfo);

$cookies=[];
foreach( $cookiesinfo[1] as $cookie ){
    $buffer_explode = strpos($cookie, "=");
    $cookies[ substr($cookie,0,$buffer_explode) ] = substr($cookie,$buffer_explode+1);
	}


curl_close($ch);


// request 2
$ch = curl_init("https://$YGGTORRENT_URL/user/ajax_usermenu");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Reload cookie
$cookieBuffer = array();
foreach(  $cookies as $k=>$c ) array_push($cookieBuffer, "$k=$c");//$cookieBuffer[] = "$k=$c";
curl_setopt($ch, CURLOPT_COOKIE, implode("; ",$cookieBuffer) );


$req2_response = curl_exec($ch);



if (curl_errno($ch)) {
		echo "curl error : ".curl_error($ch);
		die();
	}
		
		
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($http_code == intval(200)){
	//	echo $req2_response;
	}
else{
		echo "Error, ressource introuvable : " . $http_code;
	}

curl_close($ch);



echo "<br><br>";




$r=get_string_between($req2_response, "Ratio : ", "<");


// without magic_quote
//$u=get_string_between($req2_response, "ico_upload\'><\/span> ", "<\/strong>");
//$d=get_string_between($req2_response, "ico_download\'><\/span> ", "<");


$u=get_string_between($req2_response, 'ico_upload\"><\/span> ', "<\/strong>");
$d=get_string_between($req2_response, 'ico_download\"><\/span> ', "<");


echo "Ratio: $r<br/> Upload: $u <br/> Download: $d";




//chdir(dirname(__FILE__));
//file_put_contents("ygg_stats.txt", date("Y/m/d"). " - r: $r\tu: $u\td: $d\n", FILE_APPEND );







function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
	


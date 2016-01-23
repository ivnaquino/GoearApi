<?php 

function goearRequest($url = false) {

	if ( !$url )
		throw new Exception("No se ha indicado url para el request a goear.", 1);
	
	$opciones = array(
	  'http'=>array(
	    'method'=>"GET",
	    'header'=>"User-Agent: Apache-HttpClient/UNAVAILABLE(java 1.4).\r\n"
	  )
	);
	$contexto = stream_context_create($opciones);

	$result = file_get_contents($url, false, $contexto);

	if ($result == "[0]")
		return false;

	return json_decode($result,1);

}

function cors() {

    // Allow from any origin
	if (isset($_SERVER['HTTP_ORIGIN'])) {
		header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
		header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
    		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
    		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    	exit(0);
    }
}

function json404 ($params = []) {
	header('HTTP/1.0 404 Not Found', true, 404);
	echo json_encode($params);
}

function dd($a = false) {
	die(var_dump($a));
};

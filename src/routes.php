<?php
cors();

// Routes

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

/**
 * Buscar canciones
 */
$app->get('/api/search/songs/{q}', function ($request,$response, $args) use($endpoints) {
	// ?q=los%20redondos&p=0&order=default
	header('Content-Type: application/json');

	$page = (isset($_GET['page'])) ? $_GET['page'] : 0;
	$url = $endpoints['searchSong'];
	$url .= "?order=default&q={$args['q']}&p={$page}";

	$res = goearRequest($url);
	
	if ( !$res ) {
		json404(['error' => 'No se han encontrado datos']);
		exit();
	}

	echo json_encode($res);

	exit();
});

/**
 * Login
 */

$app->get('/api/login/{user}', function ($request, $response, $args) use ($endpoints) {
	// username=tvalacarta&password=123456
	header('Content-Type: application/json');

	$password = ( isset($_GET['password']) ) ? $_GET['password'] : "";

	$url = $endpoints['userLogin'];
	$url .= "?username={$args['user']}&password={$password}";
	//dd($url);

	$res = goearRequest($url);
	
	if ( !$res ) {
		json404(['error' => 'Verifique sus credenciales']);
		exit();
	}

	echo json_encode($res[0]);

	exit();

});

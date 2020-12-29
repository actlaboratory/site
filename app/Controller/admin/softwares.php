<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Model\Dao\Softwares;
use Util\SoftwareUtil;

$app->get('/admin/softwares/', function (Request $request, Response $response) {

    $softwares = new softwares($this->db);

    $data = [];
	$data["softwares"]=$softwares->getLatestIgnoreHiden(null, FLG_HIDEN);
	foreach($data["softwares"] as &$software){
        SoftwareUtil::makeTextVersion($software);
        if($software["flag"]==FLG_HIDEN){

        }
    }

    // Render index view
    return $this->view->render($response, 'admin/softwares.twig', $data);
});


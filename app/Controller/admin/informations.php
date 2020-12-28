<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Model\Dao\Softwares;
use Model\Dao\SoftwareVersions;
use Model\Dao\Members;
use Model\Dao\Updaterequests;
use Model\Dao\informations;
use Util\SoftwareUtil;
use Util\ValidationUtil;
use Util\MembersUtil;
use Util\GitHubUtil;
use Util\EncryptUtil;


// お知らせ配信画面

$app->get('/admin/informations',function (Request $request, Response $response, $args) {
	showInformationsEditor(array(),$this->db,$this->view,$response);
});

function showInformationsEditor(array $data,$db,$view,$response,$message=""){
	if(empty($data)){
		$data=[];
	}
	$data["message"]=$message;
	$data["step"]="edit";

    // Render view
    return $view->render($response, 'admin/informations/index.twig', $data);
}

$app->post('/admin/informations', function (Request $request, Response $response) {
	$input = $request->getParsedBody();
	$message = informationsCheck($input);

	if($message!=""){
		$data=$input;
		$data["message"]=$message;
		return showInformationsEditor($data,$this->db,$this->view,$response, $message);
	}else{
		if($input["step"]==="edit"){
			return showInformationsConfirm($input,"confirm",$this->view,$response);
		}else if($input["step"]==="confirm"){
			return setInformationsRequest($input,$this->db,$this->view,$response, $request);
		}
	}
});

function showInformationsConfirm(array $data,$step,$view,$response){
	$data["step"] = $step;
	// Render view
    return $view->render($response, 'admin/informations/confirm.twig', $data);
}

function informationsCheck(array $data){
	$message = "";
	if (empty($data["infoString"]) || ValidationUtil::checkParam($data,array("infoString"=>"/^.{10,100}$/"))==false){
		$message.="お知らせ文字列は10～100字で入力してください。";
	}
	if(!empty($data["infoURL"]) && !ValidationUtil::checkParam($data,array("infoURL"=>ValidationUtil::URL_PATTERN))){
		$message.="URLの形式が不正です。";
	}
	return $message;
}

function setInformationsRequest(array $data,$db,$view,$response, $request){
	$updaterequests=new Updaterequests($db);
	$no=$updaterequests->insert(array(
		"requester"=>$_SESSION["ID"],
		"type"=>"informations",
		"value"=>serialize($data)
	));
	$data["message"] ="リクエストを記録し、他のメンバーに承認を依頼しました。[リクエストNo:".$no."]";
	$data["topPageUrl"]=$request->getUri()->getBasePath()."/admin/?".SID;
	return $view->render($response, 'admin/request/request.twig', $data);
}

function setInformationsApprove(array $data,$db,$view,$response){	#本人以外のリクエストなので確定してDB反映
	$updaterequests=new Updaterequests($db);
	$request = $updaterequests->select(array(
		"id"=>$data["requestId"],
		"type"=>"informations"
	));
	$info=unserialize($request["value"]);
	$infoDB=new Informations($db);
	if(empty($info["infoURL"])){
		$info["infoURL"]=NULL;
	}
	$infoDB->insert(array(
		"title"=>$info["infoString"],
		"date"=>date("Y-m-d"),
		"url"=>$info["infoURL"],
		0
	));
	$updaterequests->delete(array("id"=>$data["requestId"]));
	return "更新が完了しました。";
}


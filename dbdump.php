<?php
if(empty($_GET["password"]) || $_GET["password"] != getenv("SCRIPT_PASSWORD")){
	http_response_code(400);
	exit("Invalid password\n");
}

$cmd = "mysqldump {$_ENV['DB_NAME']} -u {$_ENV['DB_USER']} -p{$_ENV['DB_PASS']} --default-character-set=utf8mb4 --no-tablespaces -B $_ENV{['DB_NAME']}";
$data = shell_exec($cmd);
//echo($data);


$header=array(
	"Authorization: Bearer ".getenv("DROPBOX_TOKEN"),
	"Content-Type: application/octet-stream",
	"Content-Length:".strlen($data),
	'Dropbox-API-Arg: {"path": "/actlab/server�EIT�T�[�r�X���p/DB_backups/backup_'.date("y-m-d-His").'.sql","mode": "overwrite","autorename": false,"mute": false,"strict_conflict": false}',
	"User-Agent: ACTLaboratory-webadmin"
);

$context = array(
	"http" => array(
		"method"  => "POST",
		"header"  => implode("\r\n", $header),
		"content" => $data,
		"ignore_errors"=>true
	)
);

$result=file_get_contents("https://content.dropboxapi.com/2/files/upload", false, stream_context_create($context));
$result = json_decode($result,true);
if (isset($result["path_display"]) && isset($result["size"])){
	print("{$result['size']}�o�C�g�̃t�@�C��\"{$result['path_display']}\"�̃A�b�v���[�h�ɐ������܂����B");
} else {
	print("�A�b�v���[�h�Ɏ��s���܂����B<br>\n");
}

print("<br>\n----------------------<br>\n");
var_dump($result);
print("<br>\n----------------------<br>\n");
var_dump(json_decode($result, true));


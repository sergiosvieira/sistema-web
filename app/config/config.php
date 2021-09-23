<?php
$pasta="";
$barra = substr($_SERVER["DOCUMENT_ROOT"], -1) == '/' ? "" : "/";

define("CAMINHO_RAIZ", "{$_SERVER['DOCUMENT_ROOT']}$barra$pasta");
define("CAMINHO_SERVIDOR", "http://{$_SERVER['HTTP_HOST']}/{$pasta}");
define("URLBASE", "http://{$_SERVER['HTTP_HOST']}");

define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "sistemaweb",
    "port" => "3306",
    "dbname" => "sistemaweb",
    "username" => "root",
    "passwd" => "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

function url(string $uri = null): string {
	if ($uri) {
		return URLBASE . "/{$uri}";
	}
	return URLBASE;
}


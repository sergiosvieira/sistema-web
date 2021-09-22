<?php
$pasta="";
$barra = substr($_SERVER["DOCUMENT_ROOT"], -1) == '/' ? "" : "/";

define("CAMINHO_RAIZ", "{$_SERVER['DOCUMENT_ROOT']}$barra$pasta");
define("CAMINHO_SERVIDOR", "http://{$_SERVER['HTTP_HOST']}/{$pasta}");
define("URLBASE", "http://{$_SERVER['HTTP_HOST']}");
define("HOST", "sistemaweb");
define("DB", "localhost");
define("USER", "root");
define("PASS", "");

function url(string $uri = null): string {
	if ($uri) {
		return URLBASE . "/{$uri}";
	}
	return URLBASE;
}


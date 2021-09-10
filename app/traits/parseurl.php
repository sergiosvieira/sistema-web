<?php
namespace Traits;

trait ParseUrl {
	public static function parse($par=null) {
		$arranjo_url = explode('/', rtrim($_GET['url'], FILTER_SANITIZE_URL));
		return ($par == null) ? $arranjo_url : $url[$par];
	}
}

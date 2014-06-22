<?php

class Dispatcher {
	private $request_uri = "";

	public function __construct($request_uri) {
		$this->request_uri = $request_uri;
	}

	public function dispatch() {
		if ($_SERVER["SERVER_NAME"] === "localhost") {
			require "./sys_configs/local_config.php";
		}
		else {
			require "./sys_configs/server_config.php";
		}

		$request_uri = $this->request_uri;
		$request_uri = preg_replace("/\?.*$/", "", $request_uri);

		$limit = 1;

		$request_uri =
			preg_replace("|$root_url_path|", "", $request_uri, $limit);

		if ($request_uri === "") {
			require_once "controllers/IndexController.php";

			$index_controller = new IndexController();

			if (method_exists($index_controller, "index")) {
				$index_controller->index();
				return true;
			}
			else {
				throw new ErrorException();
			}
		}

		$exploded_request_uri_orig = explode("/", $request_uri);
		$exploded_request_uri = $exploded_request_uri_orig;
		$method_tmp = array_pop($exploded_request_uri);

		$method_piece_list = null;

		foreach (explode("-", $method_tmp) as $exploded_method_tmp_piece) {
			if (is_null($method_piece_list)) {
				$method_piece_list[] = $exploded_method_tmp_piece;
			}
			else {
				$method_piece_list[] = ucfirst($exploded_method_tmp_piece);
			}
		}

		$method = join($method_piece_list);

		if (1 == count($exploded_request_uri_orig)) {
			require_once "controllers/IndexController.php";

			$index_controller = new IndexController();

			if (method_exists($index_controller, $method)) {
				$index_controller->$method();
				return true;
			}
			else {
				throw new ErrorException();
			}
		}

		$controller_tmp = array_pop($exploded_request_uri);

		foreach (explode("-", $controller_tmp) as $exploded_controller_tmp_piece) {
			$controller_piece_list[] = ucfirst($exploded_controller_tmp_piece);
		}

		$controller = join($controller_piece_list) . "Controller";

		require "./sys_configs/common_config.php";

		$controllers_dir_path = $search_dir_list["app"] . "/controllers/";

		if (file_exists($controllers_dir_path . $controller . ".php")) {
			require_once "controllers/" . $controller . ".php";

			$controller = new $controller();
		}
		else {
			throw new ErrorException();
		}

		if (2 <= count($exploded_request_uri_orig) && $method === "") {
			if (method_exists($controller, "index")) {
				$controller->index();
				return true;
			}
			else {
				throw new ErrorException();
			}
		}

		if (2 <= count($exploded_request_uri_orig) && $method) {
			if (method_exists($controller, $method)) {
				$controller->$method();
				return true;
			}
			else {
				throw new ErrorException();
			}
		}

		throw new ErrorException();
 	}
}

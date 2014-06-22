<?php
require "./sys_configs/common_config.php";

if ($_SERVER["SERVER_NAME"] === "localhost") {
	require_once "./sys_configs/local_config.php";
}
else {
	require_once "./sys_configs/server_config.php";
}

foreach ($search_dir_list as $key => $search_dir) {
	$include_path_list[$key] = $top_path . $search_dir;
}

foreach ($include_path_list as $include_path) {
	$include_dir_path = get_include_path();
	$include_dir_path .= PATH_SEPARATOR;
	$include_dir_path .= $_SERVER["CONTEXT_DOCUMENT_ROOT"];
	$include_dir_path .= $include_path;

	set_include_path($include_dir_path);
}

function base_autoload($class_name) {
	require "./sys_configs/common_config.php";

	$load_dir_name = "";

	foreach ($search_dir_list as $key => $search_dir) {
		if (is_dir($search_dir)) {
			if (file_exists($search_dir . "/" . $class_name . ".php")) {
				require_once $class_name . ".php";
				return;
			}
			else {
				foreach (glob($search_dir . "/*") as $load_dir) {
					$file_path = $load_dir . "/" . $class_name . ".php";

					if (file_exists($file_path)) {
						$exploded_load_dir = explode("/", $load_dir);
						$load_dir_name = array_pop($exploded_load_dir);
						require_once $load_dir_name . "/" . $class_name . ".php";
						return;
					}
				}
			}
		}
	}
}

spl_autoload_register("base_autoload");

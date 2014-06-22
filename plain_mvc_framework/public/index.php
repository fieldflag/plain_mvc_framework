<?php
require_once "./sys_configs/top_config.php";

$dispatcher = new Dispatcher($_SERVER["REQUEST_URI"]);

$dispatcher->dispatch();

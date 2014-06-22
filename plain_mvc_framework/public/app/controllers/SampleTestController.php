<?php

class SampleTestController extends BaseController {
	public function index() {
		$view = new View("./html/base.html");

		$text_node = $view->createTextNode("SampleTest index\n");
		$view->getElementsByTagName("body")->item(0)->appendChild($text_node);

		echo $view->saveHTML();
	}

	public function methodTest() {
		$view = new View("./html/base.html");

		$text_node = $view->createTextNode("SampleTest methodTest\n");
		$view->getElementsByTagName("body")->item(0)->appendChild($text_node);

		echo $view->saveHTML();
	}
}

<?php

class SampleController extends BaseController {
	public function index() {
		$view = new View("./html/base.html");

		$text_node = $view->createTextNode("World\n");
		$view->getElementsByTagName("body")->item(0)->appendChild($text_node);

		echo $view->saveHTML();
	}

	public function abc() {
		$view = new View("./html/base.html");

		$text_node = $view->createTextNode("abc\n");
		$view->getElementsByTagName("body")->item(0)->appendChild($text_node);

		echo $view->saveHTML();
	}
}

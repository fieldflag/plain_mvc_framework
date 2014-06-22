<?php

class View extends BaseView {
	private $html_file_path = null;

	public function __construct($html_file_path = null) {
		if (isset($html_file_path)) {
			$this->html_file_path = $html_file_path;
			parent::loadHTMLFile($html_file_path);
		}

		$this->formatOutput = true;
	}
}

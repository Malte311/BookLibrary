<?php

defined('BookLib') or die('Bad Request');

/**
 * Manages html outputs.
 */
class Template {
	/**
	 * Holds the template which is currently in use.
	 */
	private string $curr_template;

	/**
	 * Holds key => value pairs for substitution (i.e., every occurrence of key should be
	 * replaced by value).
	 */
	private array $replacements;

	/**
	 * Holds the server url which is defined in the docker-compose.yml file.
	 */
	private string $server_url;

	/**
	 * Receives the name of a html template and displays it.
	 * @param string $name The name of the html template to display.
	 */
	public function __construct(string $name) {
		$this->curr_template = $name;
		$this->server_url = !empty($_ENV['SERVERURL']) ? $_ENV['SERVERURL'] : 'http://localhost:8000';

		$this->replacements = array();
		$this->replacements['%%SERVERURL%%'] = $this->server_url;
	}

	/**
	 * Substitutes given strings in some html text.
	 * @param string $html The html text in which we want to substitute specific strings.
	 * @param array $replacements An array with key => value pairs such that every occurrence
	 * of key is replaced by value.
	 * @return string The html text with substituted values.
	 */
	private function substitute(string $html, array $replacements) : string {
		foreach ($replacements as $key => $val) {
			$html = str_replace($key, $val, $html);
		}

		return $html;
	}
}

?>
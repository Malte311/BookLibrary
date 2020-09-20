<?php

defined('BookLib') or die('Bad Request');

/**
 * Manages html outputs.
 */
class Template {
	/**
	 * Holds the template which is currently in use.
	 */
	private string $currTemplate;

	/**
	 * Holds key => value pairs for substitution (i.e., every occurrence of key should be
	 * replaced by value).
	 */
	private array $replacements = array();

	/**
	 * Holds the server url which is defined in the docker-compose.yml file.
	 */
	private string $serverUrl;

	/**
	 * Receives the name of a html template and displays it.
	 * @param string $name The name of the html template to display.
	 */
	public function __construct(string $name) {
		$this->currTemplate = file_get_contents(__DIR__ . "/../templates/{$name}.html");
		$this->serverUrl = !empty($_ENV['SERVERURL']) ? $_ENV['SERVERURL'] : 'http://localhost:8000';

		$this->replacements['%%SERVERURL%%'] = $this->serverUrl;
	}

	/**
	 * Displays the currently selected html template.
	 */
	public function displayHtml() : void {
		echo $this->substitute($this->currTemplate);
	}

	/**
	 * Returns the currently selected html template (no echoing).
	 * @return string The currently selected html template.
	 */
	public function getHtml() : string {
		return $this->substitute($this->currTemplate);
	}

	/**
	 * Adds a new replacement to the replacements array.
	 * @param string $key The value which should be replaced.
	 * @param string $value The substitution for the value which should be replaced.
	 * @return Template Returns this object for method chaining.
	 */
	public function addReplacement($key, $value) : Template {
		$this->replacements[$key] = $value;
		return $this;
	}

	/**
	 * Substitutes given strings in some html text.
	 * @param string $html The html text in which we want to substitute specific strings.
	 * @return string The html text with substituted values.
	 */
	private function substitute(string $html) : string {
		foreach ($this->replacements as $key => $val) {
			$html = str_replace($key, $val, $html);
		}

		return $html;
	}
}

?>
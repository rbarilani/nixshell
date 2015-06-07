<?php

namespace Nixshell\Command;

class CommandResult implements CommandResultInterface {
	use CommandResultTrait;

	public function __construct($command, $output, $exit_code) {
		$this->command = $command;
		$this->output = $output;
		$this->exit_code = $exit_code;
	}

	public function __toString() {

		return sprintf('{ "command" : "%s", "exit_code" : %s, "output" : "%s" }',
			$this->getCommand(), $this->getExitCode(), json_encode($this->getOutput()));
	}
}

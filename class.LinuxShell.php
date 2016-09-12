<?php
/**
 * Class for executing linux shell commands
 */
class LinuxShell
{
	protected $dir_path;
	protected $envopts = array();

	/**
	 * Constructor
	 *
	 * Set working dir path if any
	 * If no working dir path is set, current __DIR__ where the class is called is used
	 *
	 * @access  public
	 * @param   string  directory path
	 * @return  void
	 */
	public function __construct( $dir_path = null )
	{
		if ( is_string($dir_path) ) {
			$this->set_working_dir($dir_path);
		}
	}

	/**
	 * Set the directory's path
	 *
	 * Accepts the directory path
	 *
	 * @access  public
	 * @param   string  directory path
	 * @return  void
	 */
	public function set_working_dir( $dir_path )
	{
		if ( is_string($dir_path) ) {
			if ( $new_path = realpath($dir_path) ) {
				$dir_path = $new_path;
				if ( is_dir($dir_path) ) {
					$this->dir_path = $dir_path;
				} else {
					throw new Exception('"' . $dir_path . '" does not exist.');
				}
			}
		}
	}

	/**
	 * Run a shell command
	 *
	 * Accepts a shell command to run
	 *
	 * @access  public
	 * @param   string  command to run
	 * @return  string  output
	 */
	public function run_command($command) {
		$descriptorspec = array(
			1 => array('pipe', 'w'),
			2 => array('pipe', 'w'),
		);
		$pipes = array();

		/* Depending on the value of variables_order, $_ENV may be empty.
		 * In that case, we have to explicitly set the new variables with
		 * putenv, and call proc_open with env=null to inherit the reset
		 * of the system.
		 *
		 * This is kind of crappy because we cannot easily restore just those
		 * variables afterwards.
		 *
		 * If $_ENV is not empty, then we can just copy it and be done with it.
		 */
		if ( count($_ENV) === 0 ) {
			$env = NULL;
			foreach ( $this->envopts as $k => $v ) {
				putenv(sprintf("%s=%s",$k,$v));
			}
		} else {
			$env = array_merge($_ENV, $this->envopts);
		}
		$cwd = $this->dir_path;
		$resource = proc_open($command, $descriptorspec, $pipes, $cwd, $env);

		$stdout = stream_get_contents($pipes[1]);
		$stderr = stream_get_contents($pipes[2]);
		foreach ( $pipes as $pipe ) {
			fclose($pipe);
		}

		$status = trim(proc_close($resource));
		if ( $status ) throw new Exception($command . "\n" . $stderr);

		return $stdout;
	}

	/**
	 * Sets custom environment options that will be present in all shell commands
	 *
	 * @param string key
	 * @param string value
	 */
	public function setenv( $key, $value ) {
		$this->envopts[$key] = $value;
	}
}
// eof
<?php
// --- general settings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . 'class.LinuxShell.php';

// Set working dir path if any,
// If no working dir path is set, current __DIR__ where the class is called is used
$working_dir = 'true/path/to/working-dir';

try {
	$linux_shell = new LinuxShell($working_dir);
	$linux_shell->run_command('cp -r src_dir/. dest_dir/');

	echo PHP_EOL . 'Copy src_dir/ to dest_dir/ success.' . PHP_EOL;
} catch (Exception $e) {
	echo PHP_EOL . 'Copy src_dir/ to dest_dir/ failed:' . PHP_EOL . $e->getMessage();
	exit();
}


try {
	$linux_shell = new LinuxShell();
	$linux_shell->run_command('ln -s /home/user_name/src_dir/ /home/user_name/dest_dir');

	echo PHP_EOL . 'Make symlink from dest_dir to src_dir/ success.' . PHP_EOL;
} catch (Exception $e) {
	echo PHP_EOL . 'Make symlink from dest_dir to src_dir/ failed:' . PHP_EOL . $e->getMessage();
	exit();
}

exit();
// eof
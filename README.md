# README #

Class for executing linux shell commands

### What is this repository for? ###

* Just-do-the-job class for executing linux shell commands
* Version 0.0.1

### How do I get set up? ###


```
#!php
<?php
require 'class.LinuxShell.php';
```

### Usage ###
See examples.php for full examples.

Initialize:


```
#!php
<?php
// Set working dir path if any,
// If no working dir path is set, current __DIR__ where the class is called is used
$working_dir = 'true/path/to/working-dir';
$linux_shell = new LinuxShell($working_dir);
```

Run commands:


```
#!php
<?php
$linux_shell->run_command('cp -r src_dir/. dest_dir/');

$linux_shell->run_command('ln -s /home/user_name/src_dir/ /home/user_name/dest_dir');
```


### Who do I talk to? ###

* Repo owner or admin
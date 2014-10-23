<?php
include 'autoload.php';
$file = empty($_GET['file']) ? 'readme.md':$_GET['file'];
$instance = new Markdown();
$text = file_get_contents($file);
echo $instance->text($text);

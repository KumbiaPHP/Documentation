<?php
include 'vendor/autoload.php';
include 'Markdown.php';
$file = empty($_GET['file']) ? 'readme.md':$_GET['file'];
$instance = new Markdown();
$text = file_get_contents($file);
echo $instance->text($text);

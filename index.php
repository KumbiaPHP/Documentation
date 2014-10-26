<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="/doc/style.css" />
    <link href="/doc/prism.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php
include 'toc.php';
$file = empty($_GET['file']) ? 'readme.md':$_GET['file'];
$instance = new Markdown();

$text = file_get_contents($file);
?>
<?php if (!preg_match('/index.md$/', $file)):?>
<div class="toc">
<?php echo $instance->text(toc_file($file, FALSE));?>
</div>
<?php endif;?>

<?php echo $instance->text($text);?>
<script src="/doc/prism.js"></script>
</body>
</html>
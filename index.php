<?php
include 'toc.php';
$file = empty($_GET['file']) ? 'readme.md':$_GET['file'];
$instance = new Markdown();
$text = file_get_contents($file);
$url = substr($_SERVER['PHP_SELF'],0,-9);
?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo $url;?>style.css" />
    <link href="<?php echo $url;?>prism.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />.
    <?php preg_match('/^\s*(#{1,})(.*)/m', $text, $title);?>
    <title><?php echo $title[2];?></title>
</head>
<body>

<?php if (!preg_match('/index.md$/', $file)):?>
<div class="toc">
<?php echo $instance->text(toc_file($file, FALSE));?>
</div>
<?php endif;?>

<?php echo $instance->text($text);?>
<script src="<?php echo $url;?>prism.js"></script>
</body>
</html>
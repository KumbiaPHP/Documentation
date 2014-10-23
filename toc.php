#!/usr/bin/env php
<?php
$file =  ($argc < 1 || !isset($argv[1]))? NULL: $argv[1];

if(empty($file) || !is_file($file)){
    die("$file is not a valid");
}

$dir = dirname(realpath($file));

chdir($dir);

$tab = 0;
$file = new SplFileObject(basename($file));
$current = $dir;
echo '# '. $file->current();
$file->next();
while ($file->valid()) {
    $line = $file->current();
    $trim = trim($line);
    if(empty($trim))continue;
    $part = explode(':', $line);
    $name  = trim($part[0]);
    if(is_dir($name)){
        if(count($part)!=2)
            die('Syntaxys Error');
        $title = trim($part[1]);
        $current = $name;
        echo "## $title\n";
    }elseif(is_file("$current/$name")){
        toc_file("$current/$name");
    }else{
        die("Invalid file o dir $name\n");
    }
    $file->next();
}


function toc_file($path){
    $content = file_get_contents($path);
    preg_match_all('/(#{1,})(.*)/m',$content,$salida, PREG_SET_ORDER);
    foreach ($salida as $key => $value) {
        $tab   = substr(str_replace('#', '  ', $value[1]), 0, -2);
        $title = $value[2];
        echo "$tab*$title \n";

    }
}


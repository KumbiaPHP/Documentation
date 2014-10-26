<?php
include 'autoload.php';

function generate_toc($argc, $argv){
    $file =  ($argc < 1 || !isset($argv[1]))? NULL: $argv[1];
    if(empty($file) || !is_file($file)){
        die("$file is not a valid\n ");
    }
    $dir = dirname(realpath($file));
    chdir($dir);
    $data = spyc_load_file($file);
    $current = $dir;
    echo "# {$data[0]} \n";
    unset($data[0]);
   foreach($data as $value) {
        if(!is_array($value)){
            die("Syntaxys error\n");
        }
        list($title, $node) = each($value);
        echo "\n## $title\n";
        foreach ($node as $name) {
            echo toc_file("$name");
        }
    }
}


function toc_file($path, $use_path = TRUE){
    $content = file_get_contents($path);
    preg_match_all('/(#{1,})(.*)/m',$content,$salida, PREG_SET_ORDER);
    $text = '';
    $path = $use_path?$path:'';
    foreach ($salida as $key => $value) {
        $tab   = substr(str_replace('#', '  ', $value[1]), 0, -2);
        $title = $value[2];
        $id    = Markdown::generateId($title);
        $text .= "$tab* [$title]($path#$id) \n";
    }
    return $text;
}


if(php_sapi_name() == "cli") {
    generate_toc($argc, $argv);
}
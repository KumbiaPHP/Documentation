<?php
class Markdown extends ParsedownExtra{

    protected function identifyAtx($line){
        $array = parent::identifyAtx($line);
        $id = str_replace(' ', '-', strtolower($array['element']['text']));
        $array['element']['attributes'] = array('id' => $id);
        return $array;
    }

}
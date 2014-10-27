<?php
class Markdown extends ParsedownExtra{

    protected function identifyAtx($line){
        $array = parent::identifyAtx($line);
        $id = self::generateId($array['element']['text']);
        $array['element']['attributes'] = array('id' => $id);
        return $array;
    }



    static public function generateId($title){
        return  str_replace(' ',  '-', 
            str_replace(array('(', ')', '?', '¿'), '', strtolower($title))
        );        
    }

    protected function identifyLink($Excerpt){
        $r = parent::identifyLink($Excerpt);
        if(isset($r['element']['name']) && $r['element']['name'] == 'img'){
            $r['element']['attributes']['src'] =  '/doc/'.$r['element']['attributes']['src'];
        }
        return $r;
    }

}
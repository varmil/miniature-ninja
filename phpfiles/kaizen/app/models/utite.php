<?php

class Utite extends AppModel {
    var $name = 'Utite';                
    
    //検索用オプション記述
    public $actsAs = array('Search.Searchable');
    public $filterArgs = array(
        array('name' => 'utite', 'type' => 'value',),
    );
    
}

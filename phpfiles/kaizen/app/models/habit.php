<?php

class Habit extends AppModel {
    var $name = 'Habit';                
    
    //検索用オプション記述
    public $actsAs = array('Search.Searchable');
    public $filterArgs = array(
        array('name' => 'habit', 'type' => 'value',),
    );


    
}
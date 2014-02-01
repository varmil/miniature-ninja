<?php

class Hansei extends AppModel {
    var $name = 'Hansei';                
    
    //検索用オプション記述
    public $actsAs = array('Search.Searchable');
    public $filterArgs = array(
        array('name' => 'prob1', 'type' => 'value',),
    );
    
    var $belongsTo = array(
        'User' => array(
            'className'    => 'User',
            'foreignKey'    => 'user_id',
        ),
    );     
    
    var $hasMany = array(
        'Utite' => array(
            'className'     => 'Utite',
            'foreignKey'    => 'hansei_id',
            //'conditions'    => array('Comment.status' => '1'),
            //'order'    => 'Comment.created DESC',
            //'limit'        => '5',
            'dependent'=> true
        ),
        'Comment' => array(
            'className'     => 'Comment',
            'foreignKey'    => 'hansei_id',
            //'conditions'    => array('Comment.status' => '1'),
            //'order'    => 'Comment.created DESC',
            //'limit'        => '5',
            'dependent'=> true
        ),
        'StarHansei' => array(
            'className'     => 'StarHansei',
            'foreignKey'    => 'hansei_id',
            //'conditions'    => array('Comment.status' => '1'),
            //'order'    => 'Comment.created DESC',
            'limit'        => '1',
            'dependent'=> true
        ),        
        
    );
    
    var $hasOne = array(
        'Sleep' => array(
            'className' => 'Sleep', 
            'foreignKey' => 'hansei_id',
            //'conditions' => '', 
            //'order' => '', 
            'dependent' => true, 
        ),
        'Habit' => array(
            'className' => 'Habit', 
            'foreignKey' => 'hansei_id',
            //'conditions' => '', 
            //'order' => '', 
            'dependent' => true, 
        ),
    );    
    
}

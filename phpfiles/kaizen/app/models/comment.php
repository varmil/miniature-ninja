<?php

class Comment extends AppModel {
    var $name = 'Comment';                
    
    var $hasMany = array(
        'CommentPoint' => array(
            'className'     => 'CommentPoint',
            'foreignKey'    => 'comment_id',
            //'conditions'    => array('Comment.status' => '1'),
            //'order'    => 'Comment.created DESC',
            //'limit'        => '5',
            'dependent'=> true
        ),
    );  
    
    var $belongsTo = array(
        'User' => array(
            'className'    => 'User',
            'foreignKey'    => 'user_id',
        ),
        'Hansei' => array(
            'className'    => 'Hansei',
            'foreignKey'    => 'hansei_id',
        ),        
    ); 
    
}
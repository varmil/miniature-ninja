<?php

class Sleep extends AppModel {
    var $name = 'Sleep';                
    
    var $belongsTo = array(
        'User' => array(
            'className'    => 'User',
            'foreignKey'    => 'user_id',
        ),
    );         
    
}    
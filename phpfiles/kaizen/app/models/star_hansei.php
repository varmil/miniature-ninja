<?php

class StarHansei extends AppModel {
    var $name = 'StarHansei';                
    
    var $belongsTo = array(
        'Hansei' => array(
            'className'    => 'Hansei',
            'foreignKey'    => 'hansei_id',
        ),
        'User' => array(
            'className'    => 'User',
            'foreignKey'    => 'my_id',
        ),        
    );
    
    
    
}

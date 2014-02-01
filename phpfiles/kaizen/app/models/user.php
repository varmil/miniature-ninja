<?php

class User extends AppModel {
    var $name = 'User';                
    
    //検索用オプション記述
    public $actsAs = array('Search.Searchable');
    public $filterArgs = array(
        array('name' => 'username', 'type' => 'value',),
    );
    
    var $validate = array(
        'username' => array(
            'notempty' => array(
                'rule' => array('notempty'), // 未入力チェック
                'message' => 'アカウント名は必須項目です。',  
            ),
            'isUnique' => array(
                'rule' => 'isUnique', // 重複チェック
                'message' => 'そのアカウント名は既に登録されています。',  
            ),
            'maxLength' => array(
                'rule' => array('maxLength', '15'),
                'message' => 'アカウント名は最大15文字です。',  
            ),
        ),
        'new_password' => array(
            'custom' => array(
                'rule' => array('custom', '/^[a-zA-Z0-9]{6,}$/i'), // 半角英数6文字以上
                'message' => 'パスワードは6文字以上で半角英数のみ使用できます。',  
            ),
        ),
    );    

    var $hasMany = array(
        'Sleep' => array(
            'className'     => 'Sleep',
            'foreignKey'    => 'user_id',
            //'conditions'    => array('Comment.status' => '1'),
            //'order'    => 'Comment.created DESC',
            //'limit'        => '5',
            'dependent'=> true
        ),
    );    
    
}

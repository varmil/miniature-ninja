<?php
class CommentsController extends AppController {

    var $name = 'Comments';
    public $uses = array('User', 'Hansei','StarHansei', 'Comment', 'CommentPoint', 'Group', 'Sleep', 'Utite', 'UtiteCheck');
    var $components = array('RequestHandler','Search.Prg');    
    
    
    function ajax_comment() {
        // Ajax
        if ($this->RequestHandler->isAjax()) {
           // Configure for ajax
           Configure::write('debug', 0);
           $this->autoRender = false;
           // Output        
            if (empty($this->data['Comment']['comment'])) {
                
            } else {
                //データが送られてきた場合
                $user_id = $this->Auth->user('id');
                $this->data['Comment']['user_id'] = $user_id;
                
                if($this->Comment->save($this->data)) {
                    //さらに、StarHanseiテーブルにコメント１、既読０でsaveする。ただし既にフィールドが存在している場合は保存しない。
                    $hansei_id = $this->data['Comment']['hansei_id'];
                    //updateAllで、$hansei_id に該当する全フィールドのkidokuフラグを０に戻す。フィールド名はクォートを入れる必要がある（文字列なら二重に）
                    $condtion = array( 'StarHansei.hansei_id' => $hansei_id, 'StarHansei.my_id <>' => $user_id, 'StarHansei.comment' => 1 );
                    $updatefield = array( 
                        'StarHansei.kidoku' => "0", 
                        'modified' => "'" . date('Y-m-d H:i:s') . "'",
                    );
                    $this->StarHansei->updateAll( $updatefield, $condtion ) ;
                    
                    //自分のフィールドの処理。まずは既に存在しているかどうかチェック
                    $StarHansei = $this->StarHansei->find('first', 
                         array(
                            'conditions' => array('StarHansei.hansei_id' => $hansei_id, 'StarHansei.my_id' => $user_id, 'StarHansei.comment' => 1),
                        )
                    );
                    if (!empty($StarHansei)){
                        //自分の反省はkidoku１に。既に存在していたら、modified更新のためだけにUPDATEする。つまり2度目以降の書き込みと言うこと。
                        $this->data['StarHansei']['kidoku'] = 1;
                        $this->StarHansei->id = $StarHansei['StarHansei']['id'];
                        $this->StarHansei->save($this->data); 
                        return 1;                      
                    } else {
                        //初回書き込み時は新たにフィールドをINSERTする。自分のkidokuふらぐは１
                        $this->data['StarHansei']['my_id'] = $user_id;
                        $this->data['StarHansei']['hansei_id'] = $hansei_id;
                        $this->data['StarHansei']['comment'] = 1;
                        $this->data['StarHansei']['kidoku'] = 1;
                        $this->StarHansei->save($this->data);
                        return 1;
                    }
                 } else {
                    return 0;
                 }
            }  
        }
        
    }
    
    
    
    
    
    
    
}
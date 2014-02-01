<?php
class StarHanseisController extends AppController {

    var $name = 'StarHanseis';
    
    function auto_reload_kidoku() {
        // Ajax
        if ($this->RequestHandler->isAjax()) {
           // Configure for ajax
           Configure::write('debug', 0);
           $this->autoRender = false;
           // Output        
            $user_id = $this->Auth->user('id');
            //kidokuフラグが０のフィールド数をカウントして表示
            $count_kidoku_0 = $this->StarHansei->find('count', 
                 array(
                    'conditions' => array('StarHansei.kidoku' => 0, 'StarHansei.my_id' => $user_id, 'StarHansei.comment' => 1),
                )
            );
            if ($count_kidoku_0 != 0){
                //未読のコメントが一件以上ある場合
                return $count_kidoku_0;
            } else {
                //全て未読の場合
                return 'nothing';
            }               
        }            
            
    }
    
    
    
    
}
        
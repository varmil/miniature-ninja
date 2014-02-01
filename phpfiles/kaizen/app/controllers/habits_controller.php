<?php
class HabitsController extends AppController {

    var $name = 'Habits';
    
    //検索プラグイン用記述
    public $presetVars = array(
        array('field' => 'habit', 'type' => 'value'),
    );     
    
    function toukou_habit(){
        // Ajax
        if ($this->RequestHandler->isAjax()) {
            // Configure for ajax
            Configure::write('debug', 0);
            $this->autoRender = false;
            // Output        
            if ( empty($this->params['form']['habit']) ) {
                return 0;
            } else {
                //データが送られてきた場合
                $user_id = $this->Auth->user('id');
                //データを受け取る
                $habit = $this->params['form']['habit'];
                //まずは反省テーブルにtype==3を保存
                $this->data['Hansei']['type'] = 3;
                $this->data['Hansei']['user_id'] = $user_id;
                if( $this->Hansei->save($this->data['Hansei']) ){
                    //反省テーブルに保存できたら処理を続行
                    $hansei_id = $this->Hansei->getLastInsertID();
                    $this->data['Habit']['hansei_id'] = $hansei_id;
                    $this->data['Habit']['habit'] = $habit;
                    $this->data['Habit']['latest_status'] = '習慣づけると決意しました。';                
                    if($this->Habit->save($this->data['Habit'])) {
                        return 1;
                    } else {
                        return 0;
                    }                    
                } else {
                    return 0;
                }              
            }            
            
        }
    }
    
    //Habit投稿時や、マルバツ付与時、マスター時などリロードする時に使う読み込み処理
    function reload_habit() {
        $user_id = $this->Auth->user('id');
        //自分のHabitフィールドを読み出すための記述
        //Hanseiテーブルから情報を読み込む
        $habits = $this->Hansei->find('all', 
            array(
                'conditions' => array('Hansei.type' => 3, 'Hansei.user_id' => $user_id),
                'order' => array('Hansei.id' => 'desc'),
                'limit' => 100,
            )
        );        
        $this->set('habits', $habits);
    }
    
    //ボタン押下時の処理
    function habit_button_dealing() {
        // Ajax
        if ($this->RequestHandler->isAjax()) {
            // Configure for ajax
            Configure::write('debug', 0);
            $this->autoRender = false;
            // Output        
            $html = $this->params['form']['button_html'];
            $hansei_id = $this->params['form']['hansei_id'];
            //まず親テーブルである反省のmodifiedを更新するために上書き
            $this->Hansei->id = $hansei_id;
            $this->data['Hansei']['type'] = 3;
            $this->Hansei->save($this->data);
               
            //上記の反省IDを持つフィールドを取り出してIDを取得する
            $habit = $this->Habit->find('first', 
                array( 'conditions' => array('Habit.hansei_id' => $hansei_id)) );
            $habit_id = $habit['Habit']['id'];
            $this->Habit->id = $habit_id;
            //押したボタンによって処理を変える。上書き保存するのだが、必ず親モデルを基準にsaveAllを使う
            if ($html == '実行'){
                $count_ok = $habit['Habit']['count_ok'];
                $this->data['Habit']['count_ok'] = $count_ok + 1;
                $this->data['Habit']['latest_status'] = '実行しました。';     
                if($this->Habit->save($this->data)) {
                    return 1;
                } else {
                    return 0;
                }                      
            } elseif ($html == '未遂') {
                $count_ng = $habit['Habit']['count_ng'];
                $this->data['Habit']['count_ng'] = $count_ng + 1;
                $this->data['Habit']['latest_status'] = '実行できませんでした。';     
                if($this->Habit->save($this->data)) {
                    return 1;
                } else {
                    return 0;
                }                   
            } elseif ($html == '会得') {
                $this->data['Habit']['master'] = 1;
                $this->data['Habit']['latest_status'] = '会得しました。';     
                if($this->Habit->save($this->data)) {
                    return 1;
                } else {
                    return 0;
                }                   
            } elseif ($html == '削除') {
                //Hansei hasOne Habitなので反省を消す
                $this->Hansei->delete($hansei_id);
                return 1;
            }
            
        }        
    }

    //Good_Fightカウント用
    function good_fight() {
        // Ajax
        if ($this->RequestHandler->isAjax()) {
            // Configure for ajax
            Configure::write('debug', 0);
            $this->autoRender = false;
            // Output        
            $html = $this->params['form']['html'];
            $hansei_id = $this->params['form']['hansei_id'];
            
            //上記の反省IDを持つフィールドを取り出してIDを取得する
            $habit = $this->Habit->find('first', 
                array( 'conditions' => array('Habit.hansei_id' => $hansei_id)) );
            $habit_id = $habit['Habit']['id'];
            $this->Habit->id = $habit_id;
            //押したボタンによって処理を変える。上書き保存するのだが、必ず親モデルを基準にsaveAllを使う
            if ($html == 'Good!'){
                $good = $habit['Habit']['good'];
                $this->data['Habit']['good'] = $good + 1;
                if($this->Habit->save($this->data)) {
                    return 1;
                } else {
                    return 0;
                }                      
            } elseif ($html == '頑張れ!') {
                $fight = $habit['Habit']['fight'];
                $this->data['Habit']['fight'] = $fight + 1;
                if($this->Habit->save($this->data)) {
                    return 1;
                } else {
                    return 0;
                }                       
            }            
        
        
        }        
    }

    
}
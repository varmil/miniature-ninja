<?php
class SleepsController extends AppController {

    var $name = 'Sleeps';
    public $uses = array('User', 'Hansei', 'Comment', 'CommentPoint', 'Group', 'Sleep', 'Utite', 'UtiteCheck');
    var $components = array('RequestHandler','Search.Prg');    
    
    
    function graph() {
        $this->layout = '';
        $user_id = $this->Auth->user('id');
        
        //睡眠情報取出し
        $sleeps = $this->Sleep->find('all', 
             array(
                'conditions' => array('Sleep.user_id' => $user_id),
                'order' => array('Sleep.date' => 'asc'),
                'limit' => 2000,
            )
        );
        $this->set('sleeps', $sleeps);
        
        //睡眠時間ごとに棒グラフに集計するので、それようにcountする
        $count_lessthan_3 = $this->Sleep->find('count', 
             array( 'conditions' => array('Sleep.user_id' => $user_id, 'Sleep.hour <' => 3) )
        );
        $this->set('count_lessthan_3', $count_lessthan_3);
        
        $count[] = '';
        for ($i=3; $i<12; $i++){
            $count[$i] = $this->Sleep->find('count', 
                 array( 'conditions' => array('Sleep.user_id' => $user_id, 'Sleep.hour >=' => $i, 'Sleep.hour <' => $i+1) )
            );
        }
        $this->set('count', $count);              
        
        $count_morethan_12 = $this->Sleep->find('count', 
             array( 'conditions' => array('Sleep.user_id' => $user_id, 'Sleep.hour >=' => 12) )
        );
        $this->set('count_morethan_12', $count_morethan_12);
        
        //平均睡眠時間を算出する
        //全ユーザー
        $list_all_user = $this->Sleep->find('list', 
             array( 'conditions' => array(),
                    'order' => array('Sleep.modified' => 'desc'),
                    'limit' => 300,
                    "fields" => array("Sleep.hour"),                                     
             )
        );
        $sum = array_sum($list_all_user); //配列の数値を足し算する
        $count_average_all_user = count($list_all_user); //取り出した配列の個数をカウントする
        $average_all_user = $sum / $count_average_all_user;
        $this->set('average_all_user', $average_all_user);
        //個別ユーザー
        $list_user = $this->Sleep->find('list', 
             array( 'conditions' => array('Sleep.user_id' => $user_id),
                    'order' => array('Sleep.modified' => 'desc'),
                    'limit' => 300,
                    "fields" => array("Sleep.hour"),                                     
             )
        );
        $sum = array_sum($list_user); //配列の数値を足し算する
        $count_average_user = count($list_user); //取り出した配列の個数をカウントする
        $average_user = $sum / $count_average_user;
        $this->set('average_user', $average_user); 
                                                                                           
    }
    
    function toukou_suimin() {
        // Ajax
        if ($this->RequestHandler->isAjax()) {
           // Configure for ajax
           Configure::write('debug', 0);
           $this->autoRender = false;
           // Output        
            if ($this->params['form']['syusin'] == ':' || $this->params['form']['kisyou'] == ':') {
                return 0;
            } else {
                //データが送られてきた場合
                $user_id = $this->Auth->user('id');
                $this->data['Sleep']['user_id'] = $user_id;
                //データを受け取る
                $date = $this->params['form']['date'];
                $syusin = $this->params['form']['syusin'];
                $kisyou = $this->params['form']['kisyou'];
                
                //まずは反省テーブルにtype==2を保存
                $this->data['Hansei']['type'] = 2;
                $this->data['Hansei']['user_id'] = $user_id;
                if( $this->Hansei->save($this->data['Hansei']) ){
                    //反省テーブルに保存できたら処理を続行
                    $hansei_id = $this->Hansei->getLastInsertID();
                    //睡眠時間計算
                    //まずはタイムスタンプに直してからdate()でばらばらに
                    $syusin_stamp = strtotime($syusin);
                    $kisyou_stamp = strtotime($kisyou);
                    //date()で時間と分を取り出す
                    $h_s = date("H",$syusin_stamp);
                    $h_k = date("H",$kisyou_stamp);
                    $m_s = date("i",$syusin_stamp);
                    $m_k = date("i",$kisyou_stamp);
                    //秒数に直してから、10進数に直す
                    $s_s = $h_s*3600 + $m_s*60;
                    $s_k = $h_k*3600 + $m_k*60;
                    $h10_s = $s_s / 3600;
                    $h10_k = $s_k / 3600;
                    //就寝時間と起床時間の大きさを比べて処理を変える。strtotime()でコロンがついた時間を扱うときは9時間マイナスする。
                    if ($h10_s > $h10_k){
                        //就寝時間の方が大きい場合。
                        $length_stamp = 60*60*24 - strtotime($syusin) + strtotime($kisyou) - 60*60*9;
                        $length = date("H:i", $length_stamp);
                        $hour = 24 - $h10_s + $h10_k;
                    } else if ($h10_s < $h10_k){
                        $length_stamp = strtotime($kisyou) - strtotime($syusin) - 60*60*9;
                        $length = date("H:i", $length_stamp);
                        $hour = $h10_k - $h10_s;
                        //就寝が0時を過ぎている場合は、24以上の数値で記録する
                        //$syusin = $h_s+24 .':'. $m_s;
                    } else if ($h10_s == $h10_k){
                        //就寝起床とも同じ場合
                    }
                    //データに以上の値をぶち込む
                    $this->data['Sleep']['hansei_id'] = $hansei_id;
                    $this->data['Sleep']['date'] = $date;
                    $this->data['Sleep']['syusin'] = $syusin;
                    $this->data['Sleep']['kisyou'] = $kisyou;
                    $this->data['Sleep']['length'] = $length;
                    $this->data['Sleep']['hour'] = $hour;
                    if($this->Sleep->save($this->data['Sleep'])) {
                        return 1;
                    } else {
                        return 0;
                    }
                } else {
                    //反省テーブルに保存できなかったら0を返す
                    return 0;
                }
            }  
        }
        
    }    

    //睡眠データの削除用
    function delete_sleep() {
        // Ajax
        if ($this->RequestHandler->isAjax()) {
           // Configure for ajax
           Configure::write('debug', 0);
           $this->autoRender = false;
           // Output        
            if (empty($this->params['form']['date'])) {
                
            } else {
                //データが送られてきた場合
                $user_id = $this->Auth->user('id');
                $date = $this->params['form']['date'];
                $sleeps = $this->Sleep->find('all', 
                     array( 'conditions' => array('Sleep.date' => $date, 'Sleep.user_id' => $user_id) )
                );                
                foreach ($sleeps as $sleep ) {
                    $hansei_id[] = $sleep["Sleep"]["hansei_id"];
                }
                //Hansei HasOne Sleep なので反省側を消す。配列を用いて。
                $this->Hansei->deleteAll(array('Hansei.id' => $hansei_id));
                return 1;
            }  
        }         
    }
    
}    
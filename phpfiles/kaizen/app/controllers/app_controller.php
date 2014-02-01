<?php
class AppController extends Controller {
    
    public $uses = array('User', 'Hansei','StarHansei', 'Comment', 'CommentPoint', 'Group', 'Sleep', 'Utite', 'UtiteCheck', 'Habit');
    
    var $helpers = array('Ajax','Js','Html','Form','Session','Javascript');
    //恐らくバグだが、ヘルパーにSessionも含めないとApp controllerで入力するとエラーになる。
	public $components = array('Session','Auth','RequestHandler','Search.Prg');
    
    //認証関連
    public function beforefilter(){
    
        $this->Auth->allow('twitter','twitter_callback','facebook','facebook_callback', 'create', 'auto_reload_others');
    
        $this->Auth->loginRedirect = array('controller' => 'users','action' => 'index');
        $this->Auth->logoutRedirect = array('controller' => 'users','action' => 'login');
        
    	$this->Auth->loginError = 'ユーザーIDまたは、パスワードが正しくありません。';
        $this->Auth->authError = 'アクセス権限がありません。';
        
        parent::beforeFilter();
    }
    
    //アクションポイントによって称号を付ける
    public function ap(){
        //ユーザーのAPを取得
        $user_id = $this->Auth->user('id');
        $this->set('user_id', $user_id);
                
        //アクションポイントの計算
        $count_hansei = $this->Hansei->find('count', 
             array(
                'conditions' => array('User.id' => $user_id),
            )
        );
        $count_comment = $this->Comment->find('count', 
             array(
                'conditions' => array('Comment.user_id' => $user_id),
            )
        );
        $count_utite = $this->Utite->find('count', 
             array(
                'conditions' => array('Utite.user_id' => $user_id),
            )
        );
        $count_sleep = $this->Sleep->find('count', 
             array(
                'conditions' => array('Sleep.user_id' => $user_id),
            )
        );                           
        $all_hansei = $this->Hansei->find('all', 
             array(
                'conditions' => array('Hansei.user_id' => $user_id, 'Hansei.type' => 3),
                'recursive' => 0,
            )
        );          //まずはユーザー情報で絞るため結びついている反省テーブルからfindする。
        $sum_count_ok = 0;
        foreach ($all_hansei as $hansei) {
          $sum_count_ok += $hansei['Habit']['count_ok'];
        }
        //以上の値を全て足し合わせる。これがAPとなる。
        $ap = $count_comment + $count_hansei + $count_sleep + $count_utite + $sum_count_ok;
        $this->data['User']['action_point'] = $ap;
        
        //APの値によって称号をつける
        if($ap <= 3){
            $this->data['User']['ap_name'] = 'ルーキー';
            $this->data['User']['nameicon'] = 'newlylicenseddriver001.png';
        } elseif ($ap <= 10) {
             $this->data['User']['ap_name'] = '期待のルーキー';
             $this->data['User']['nameicon'] = 'newlylicenseddriver001.png';
        } elseif ($ap <= 20) {
             $this->data['User']['ap_name'] = '板についてきた';
             $this->data['User']['nameicon'] = 'medal_bronze001.png';
        } elseif ($ap <= 50) {
             $this->data['User']['ap_name'] = '有能な';
             $this->data['User']['nameicon'] = 'medal_bronze001.png';
        } elseif ($ap <= 100) {
             $this->data['User']['ap_name'] = 'プロフェッショナル';
             $this->data['User']['nameicon'] = 'medal_silver001.png';
        } elseif ($ap <= 200) {
             $this->data['User']['ap_name'] = '改善公爵';
             $this->data['User']['nameicon'] = 'medal_gold001.png';
        } elseif ($ap <= 300) {
             $this->data['User']['ap_name'] = '改善大公';
             $this->data['User']['nameicon'] = 'medal_gold001.png';
        } elseif ($ap <= 400) {
             $this->data['User']['ap_name'] = '改善親王';
             $this->data['User']['nameicon'] = 'medal_gold002.png';
        } elseif ($ap <= 500) {
             $this->data['User']['ap_name'] = '改善王';
             $this->data['User']['nameicon'] = 'medal_gold002.png';
        } elseif ($ap <= 777) {
             $this->data['User']['ap_name'] = '改善皇帝';
             $this->data['User']['nameicon'] = 'cup_gold001.png';
        }
        //ユーザーテーブルにsaveする
        $this->User->id = $user_id;
        $this->User->save($this->data);
        //ユーザーテーブルからユーザー情報を取り出す
        $user = $this->User->find('first', 
             array(
                'conditions' => array('User.id' => $user_id),
            )
        );
        $this->set('user', $user);
        
    }


    
    
}
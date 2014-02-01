<?php
class UsersController extends AppController {

    var $name = 'Users';
    var $components = array('RequestHandler','Search.Prg', 'CompImageUpload');    
    
    
    //検索プラグイン用記述
    public $presetVars = array(
        array('field' => 'username', 'type' => 'value'),
    );     
    
    function create() {
        if (!empty($this->data)) {
                $this->data['User']['password'] = $this->Auth->password($this->data['User']['new_password']);
                $this->User->save($this->data);
                $this->User->set($this->data);
            if ($this->User->validates()) { //バリデーションする
                    $this->Session->setFlash('登録が完了しました。上部よりログインして下さい。');
                    $this->redirect('/users/login');
            } else {    //バリデーションに通らなかった時の処理
                $this->Session->setFlash(implode("<br>", $this->User->invalidFields()));
                $this->redirect('/users/login');
            }
        }

    }
    
    function login() {
        $this->layout = 'for_login';
        if($this->Auth->user()) {
            $this->redirect('/users/index');
        }  else {

        }
        
    }
    function logout() {
        $this->redirect($this->Auth->logout());
    }    
    
    function index() {      
        //ページを開いた時にAPを更新
        $this->ap();
        //ページを開いた時にkidokuフラグ読み込み
        $user_id = $this->Auth->user('id');
        $this->set('user_id', $user_id);
        //kidokuフラグが０のフィールド数をカウントして表示
        $count_kidoku_0 = $this->StarHansei->find('count', 
             array(
                'conditions' => array('StarHansei.kidoku' => 0, 'StarHansei.my_id' => $user_id, 'StarHansei.comment' => 1),
            )
        );
        $this->set('count_kidoku_0', $count_kidoku_0);
        
        //自分の反省フィールドを読み出すための記述
        //Hanseiテーブルから情報を読み込む
        $this->set('hanseis',$this->Hansei->find('all', 
            array(
                'conditions' => array('Hansei.user_id' => $user_id, 'Hansei.type' => 1),
                'order' => array('Hansei.id' => 'desc'),
                'limit' => 150,
            )
        ));
        
        //他人の反省フィールドを読み出すための記述
        //Hanseiテーブルから情報を読み込む
        $this->set('hanseis_other',$this->Hansei->find('all', 
            array(
                'conditions' => array('Hansei.type' => 1),
                'order' => array('Hansei.id' => 'desc'),
                'limit' => 150,
            )
        ));
    }

    /**
     * 画像編集
     */
    function pic_edit()
    {
        $this->layout = 'scroll_available';
        // ページタイトルの設定
        $this->pageTitle = 'WebLocalCommunity「LocalSNS」　プロフィール画像編集画面';

        // ログインしているユーザー情報を取得
        $user_id = $this->Auth->user('id');
        $data = $this->User->find('first', array('conditions' => array('User.id' => $user_id)));
        $this->set('user', $data);
        // 画像の登録が無い場合は[no_image]の画像を代入
        if ($data['User']['usericon'] == '') {
            $data['User']['usericon'] = 'default.jpg';
        }
        $this->set('data', $data['User']);
        $this->set('flg', 'edit_flg');

        // 削除ボタンクリック時
        if (!empty($this->params['form']['del'])) {
            // [update]のため[id]を指定
            $this->data['User']['id'] = $user_id;
            $this->data['User']['usericon'] = 'default.jpg';
            if ($this->User->save($this->data['User'], false)) {
                $this->Session->setFlash('<div class="setFlash">※※※※※※　削除しました　※※※※※※</div>');
                $this->redirect('/users/pic_edit/');
                return;
            }
        }

        if (!empty($this->data)) {
            // モデル名・フィールド名を指定[name]
            $name = $this->data['User']['usericon']['name'];
            // モデル名・フィールド名を指定[tmp_name]
            $tmp_name = $this->data['User']['usericon']['tmp_name'];
            // 画像をアップするパスの指定
            $path = 'img/usericon';
            // 保存するファイル名の指定(User.id)
            $file_id = $data['User']['id'];

            $upload_name = $this->CompImageUpload->upload($name, $tmp_name, $path, $file_id);
            if(empty($upload_name)){    //エラーの場合
                    $this->Session->setFlash('<div class="setFlash">※※※※※※　エラーです。拡張子とファイルサイズを確認して下さい　※※※※※※</div>');
                    $this->redirect('/users/pic_edit/');                
            } else {
                // [update]のため[id]を指定
                $upload_data['User']['id'] = $data['User']['id'];
                $upload_data['User']['usericon'] = $upload_name;
    
                if($this->User->save($upload_data['User'], false)) {
                    $this->Session->setFlash('<div class="setFlash">※※※※※※　登録・変更しました　※※※※※※</div>');
                    $this->redirect('/users/pic_edit/');
                    return;
                }
            }

        }
    }



    
}
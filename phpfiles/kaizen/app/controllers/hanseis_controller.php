<?php
class HanseisController extends AppController {

    var $name = 'Hanseis';
    public $uses = array('User', 'Hansei','StarHansei', 'Comment', 'CommentPoint', 'Group', 'Sleep', 'Utite', 'UtiteCheck');
    var $components = array('RequestHandler','Search.Prg');  
    
    function detail($hansei_id ){
        $this->layout = '';
        $user_id = $this->Auth->user('id');
        $this->set('user_id', $user_id);
        $hansei_d = $this->Hansei->find('first', 
             array('conditions' => array('Hansei.id' => $hansei_id))
        );
        $this->set('hansei_d', $hansei_d);
        
        //クリックされた反省のIDを贈る
        $this->set('hansei_id', $hansei_id);
        //そのIDに結びついている反省の投稿ユーザーIDを取得する
        $hansei = $this->Hansei->find('first', 
             array(
                'conditions' => array('Hansei.id' => $hansei_id),
            )
        );
        $this->set('commented_user_id', $hansei['Hansei']['user_id']);        
        
        //投稿が自分のものなら表示を変える?
        if ($hansei_d['Hansei']['user_id'] == $user_id ){
            $this->set('mine', 1);
        }
        
        //コメント取出し
        $comments = $this->Comment->find('all', 
             array(
                'conditions' => array('Comment.hansei_id' => $hansei_id),
                'order' => array('Comment.id' => 'desc')
            )
        );
        $this->set('comments', $comments);
        
        //反省のfavを取り出し
        $star_hansei = $this->StarHansei->find('first', 
             array(
                'conditions' => array('StarHansei.hansei_id' => $hansei_id, 'StarHansei.my_id' => $user_id),
                //'order' => array('StarHansei.id' => 'desc')
            )
        );
        $this->set('value', $star_hansei['StarHansei']['value']);
        
        //star_hansei読み込み、kidokuフラグ変更
        //updateAllで、$my_id $hansei_idに該当するフィールドのkidokuフラグを1にする。フィールド名はクォートを入れる必要がある（文字列なら二重に）。myreflectionをクリックした時はkidokuを変えない。
        $condtion = array( 'StarHansei.my_id' => $user_id, 'StarHansei.comment' => 1, 'StarHansei.hansei_id' => $hansei_id, 'StarHansei.kidoku <>' => -1 );
        $updatefield = array( 
            'StarHansei.kidoku' => "1", 
            //'modified' => "'" . date('Y-m-d H:i:s') . "'",
        );
        $this->StarHansei->updateAll( $updatefield, $condtion );
                   
        
    }

    //削除処理
    function delete($id) {
            $this->Hansei->delete($id);
            //$this->Session->setFlash("正常に".$id."は削除されました");
            $this->redirect('/users/index');
    }    
    
    //自分の反省を一定間隔で読みだす。mainクリック時の挙動
    function auto_reload($new_hansei_id) {
        // Ajax
        if ($this->RequestHandler->isAjax()) {
           // Configure for ajax
           Configure::write('debug', 0);
           $this->autoRender = false;
           // Output
            $user_id = $this->Auth->user('id');
            //自分の反省フィールドを読み出すための記述
            //Hanseiテーブルから情報を読み込む
            $new_hanseis = $this->Hansei->find('all', 
                array(
                    'conditions' => array('Hansei.user_id' => $user_id, 'Hansei.type' => 1), //'Hansei.id >' => $new_hansei_id
                    'order' => array('Hansei.modified' => 'desc'),
                    'limit' => 150,
                )
            );
            //もし存在したらそのテーブルを挿入する。
            if($new_hanseis){
                foreach ($new_hanseis as $hansei): ?>
                <div class="wrap_each_write">
                    <!--         ブロッククリックで詳細表示            -->
                    <div id="detail" class="each_write clearfix">
                        <div class="ap_name">
                            <span class="wrap_rated_star wrap_rated_star_mine">
                                <? for ($i=0; $i < $hansei['Hansei']['rating']; $i++) : ?>
                                    <img class="rated_star" src="<?= $this->webroot ?>img/rating/star-on.png" width="10" />
                                <? endfor; ?>
                            </span>
                        </div>
                        <div class="each_write_left each_write_left_mine"><img class="avatar" src="<?= $this->webroot ?>img/usericon/<?= $hansei['User']['usericon'] ?>" width="50" /></div>
                        <div class="each_write_right">
                            <div class="authorname authorname_mine"></div>
                            <div class="honbun ajax_d">
                                <span id="<?= $hansei['Hansei']['id'] ?>" class="c_hansei_id" ></span>
                                <?if (!empty($hansei['Hansei']['fact'])): ?><span class="honbun_a">【振り返り】</span><?= h($hansei['Hansei']['fact']) ?><? endif; ?>
                                <?if (!empty($hansei['Hansei']['prob1'])): ?><span class="honbun_a">【問題】</span><?= h($hansei['Hansei']['prob1']) ?><? endif; ?>
                                <?if (!empty($hansei['Utite'][0]['utite'])): ?><span class="honbun_a">【打ち手】</span><?= h($hansei['Utite'][0]['utite']) ?><? endif; ?>
                            </div>
                            <div class="toukounitiji">
                                <a href="<?= $this->webroot?>hanseis/delete/<?= $hansei['Hansei']['id']?>" onclick="return confirm('本当に削除しますか？')">削除</a>
                                <?= date("m月j日H時i分", strtotime($hansei['Hansei']['created'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;
                //ここまで
            }
        }
    }
    
    //他人の反省を一定間隔で読みだす
    function auto_reload_others($new_hansei_id, $limit = 150) {
        // Ajax
        if ($this->RequestHandler->isAjax()) {
           // Configure for ajax
           Configure::write('debug', 0);
           $this->autoRender = false;
           // Output
            $user_id = $this->Auth->user('id');
            //自分の反省フィールドを読み出すための記述
            //Hanseiテーブルから情報を読み込む
            $new_hanseis = $this->Hansei->find('all', 
                array(
                    //'conditions' => array('Hansei.id >' => $new_hansei_id),
                    'order' => array('Hansei.modified' => 'desc'),
                    'limit' => $limit,
                )
            );
            //もし存在したらそのテーブルを挿入する。
            if($new_hanseis){
                foreach ($new_hanseis as $hansei): ?>
<!--       type別にHTML記述を変える 。type=1          -->
                <? if($hansei['Hansei']['type'] == 1): ?>
                <div class="wrap_each_write">
                    <!--         ブロッククリックで詳細表示            -->
                    <div id="detail" class="each_write clearfix">
                        <? if($hansei['Hansei']['tokumei'] == 0): ?>
                        <div class="ap_name">
                            <img class="nameicon" src="<?= $this->webroot ?>img/name/<?= $hansei['User']['nameicon'] ?>" width="20" /><?= h($hansei['User']['ap_name']) ?>
                            <span class="wrap_rated_star">
                                <? for ($i=0; $i < $hansei['Hansei']['rating']; $i++) : ?>
                                    <img class="rated_star" src="<?= $this->webroot ?>img/rating/star-on.png" width="10" />
                                <? endfor; ?>
                            </span>
                        </div>                        
                        <div class="each_write_left"><img class="avatar" src="<?= $this->webroot ?>img/usericon/<?= $hansei['User']['usericon'] ?>" width="50" /></div>
                        <? else: ?>
                        <div class="each_write_left"><img class="avatar" src="<?= $this->webroot ?>img/usericon/tokumei.gif" width="50" /></div>
                        <? endif; ?>
                        <div class="each_write_right">
                            <? if($hansei['Hansei']['tokumei'] == 0): ?>
                            <div class="authorname"><?= h($hansei['User']['username']) ?></div>
                            <? else: ?>
                            <div class="authorname">Anonymous</div>
                            <? endif; ?>
                            <div class="honbun ajax_d">
                                <span id="<?= $hansei['Hansei']['id'] ?>" class="o_hansei_id" ></span>
                                <?if (!empty($hansei['Hansei']['fact'])): ?><span class="honbun_a">【振り返り】</span><?= h($hansei['Hansei']['fact']) ?><? endif; ?>
                                <?if (!empty($hansei['Hansei']['prob1'])): ?><span class="honbun_a">【問題】</span><?= h($hansei['Hansei']['prob1']) ?><? endif; ?>
                                <?if (!empty($hansei['Utite'][0]['utite'])): ?><span class="honbun_a">【打ち手】</span><?= h($hansei['Utite'][0]['utite']) ?><? endif; ?>
                            </div>
                            <div class="toukounitiji"><?= date("m月j日H時i分", strtotime($hansei['Hansei']['created'])) ?></div>
                        </div>
                    </div>
                </div>
                <? endif; ?>
<!--       type別にHTML記述を変える。type=2           -->
                <? if($hansei['Hansei']['type'] == 2): ?>
                <div class="wrap_each_write">
                    <!--         ブロッククリックで詳細表示            -->
                    <div id="detail" class="each_write clearfix">
                        <div class="ap_name">
                            <img class="nameicon" src="<?= $this->webroot ?>img/name/<?= $hansei['User']['nameicon'] ?>" width="20" /><?= h($hansei['User']['ap_name']) ?>
                            <span class="wrap_rated_star">
                                <? for ($i=0; $i < $hansei['Hansei']['rating']; $i++) : ?>
                                    <img class="rated_star" src="<?= $this->webroot ?>img/rating/star-on.png" width="10" />
                                <? endfor; ?>
                            </span>
                        </div>                          
                        <div class="each_write_left"><img class="avatar" src="<?= $this->webroot ?>img/usericon/<?= $hansei['User']['usericon'] ?>" width="50" /></div>
                        <div class="each_write_right">
                            <div class="authorname_sleep"><span class='username_color bold'><?= h($hansei['User']['username']) ?></span>さんが睡眠を記録しました。</div>
                            <div class="honbun cursor_default">
                                <span id="<?= $hansei['Hansei']['id'] ?>" class="o_hansei_id" ></span>
                                <span class="honbun_sleep">【日時】</span><?= date("m月j日", strtotime($hansei['Sleep']['date'])) ?><br />
                                <span class="honbun_sleep">【就寝】</span><?= h( date("H:i", strtotime($hansei['Sleep']['syusin'])) ) ?>
                                <span class="honbun_sleep">【起床】</span><?= h( date("H:i", strtotime($hansei['Sleep']['kisyou'])) ) ?><br />
                                <span class="honbun_sleep">【睡眠時間】</span><?= h( date("H時間i分", strtotime($hansei['Sleep']['length'])) ) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <? endif; ?>
<!--       type別にHTML記述を変える。type=3           -->
                <? if($hansei['Hansei']['type'] == 3): ?>
                <div class="wrap_each_write">
                    <!--         ブロッククリックで詳細表示            -->
                    <div id="detail" class="each_write clearfix">
                        <div class="ap_name">
                            <img class="nameicon" src="<?= $this->webroot ?>img/name/<?= $hansei['User']['nameicon'] ?>" width="20" /><?= h($hansei['User']['ap_name']) ?>
                            <span class="wrap_rated_star">
                                <? for ($i=0; $i < $hansei['Hansei']['rating']; $i++) : ?>
                                    <img class="rated_star" src="<?= $this->webroot ?>img/rating/star-on.png" width="10" />
                                <? endfor; ?>
                            </span>
                        </div>                          
                        <div class="each_write_left"><img class="avatar" src="<?= $this->webroot ?>img/usericon/<?= $hansei['User']['usericon'] ?>" width="50" /></div>
                        <div class="each_write_right">
                            <div class="honbun cursor_default">
                                <span id="<?= $hansei['Hansei']['id'] ?>" class="o_hansei_id" ></span>
                                <span class="honbun_habit">
                                    <span class='username_color bold'><?= h($hansei['User']['username']) ?></span>さんは
                                    <span class='habit_color'><?= h( $hansei['Habit']['habit'] ) ?></span>
                                    を<?= h( $hansei['Habit']['latest_status'] ) ?>
                                </span>
                                <div class="count_ok_ng">
                                    <img class="iconwhite" alt="" src="<?= $this->webroot ?>img/iconwhite/ok.png" height="15" /><?= $hansei['Habit']['count_ok'] ?>回
                                    <img class="iconwhite" alt="" src="<?= $this->webroot ?>img/iconwhite/ng.png" height="15" /><?= $hansei['Habit']['count_ng'] ?>回
                                </div>
                                <div id="<?= $hansei['Hansei']['id'] ?>"  class="good_fight">
                                    <a id="good_habit" class="good_fight_a">Good!</a>
                                    <? if ( $hansei['Habit']['good'] !=0){ echo $hansei['Habit']['good'];} ?>　
                                    <a id="fight_habit" class="good_fight_a">頑張れ!</a>
                                    <? if ( $hansei['Habit']['fight'] !=0){ echo $hansei['Habit']['fight'];} ?>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
                <? endif; ?>                              
                <?php endforeach;
                //ここまで
            }
        }
    }    


    //自分のコメント付きの自他反省を読みだす
    function reload_comment($new_hansei_id) {
        // Ajax
        if ($this->RequestHandler->isAjax()) {
           // Configure for ajax
           Configure::write('debug', 0);
           $this->autoRender = false;
           // Output
            $user_id = $this->Auth->user('id');

            //自分・他人のcommentと反省フィールドを読み出すための記述
            //StarHanseiテーブルから情報を読み込む
            $this->StarHansei->recursive = 2;
            $conditions = array( 
                    'StarHansei.my_id' => $user_id,
                    'StarHansei.comment' => 1,
                    'StarHansei.kidoku <=' => 1,
                    'StarHansei.kidoku >=' => 0, //0以上1以下のkidokuカラムを指定。
            );
            $new_hanseis = $this->StarHansei->find('all', 
                array(
                    'conditions' => $conditions,
                    'order' => array('StarHansei.modified' => 'desc', 'StarHansei.created' => 'desc'),
                    'limit' => 150,
                )
            );
            //もし存在したらそのテーブルを挿入する。
            if($new_hanseis){
                foreach ($new_hanseis as $hansei): ?>
                <div class="wrap_each_write">
                    <!--         ブロッククリックで詳細表示            -->
                    <div id="detail" class="each_write clearfix">
                        <? if($hansei['StarHansei']['kidoku'] == 0): ?>
                        <span class="new_icon">
                            <img src="<?= $this->webroot ?>img/users.index/new_icon.png" width="20" />
                        </span>
                        <? endif; ?>
                        <? if($hansei['Hansei']['tokumei'] == 0 || $hansei['Hansei']['user_id'] == $user_id): ?>
                        <div class="ap_name">
                            <img class="nameicon" src="<?= $this->webroot ?>img/name/<?= $hansei['Hansei']['User']['nameicon'] ?>" width="20" /><?= h($hansei['Hansei']['User']['ap_name']) ?>
                            <span class="wrap_rated_star">
                                <? for ($i=0; $i < $hansei['Hansei']['rating']; $i++) : ?>
                                    <img class="rated_star" src="<?= $this->webroot ?>img/rating/star-on.png" width="10" />
                                <? endfor; ?>
                            </span>
                        </div>                        
                            <div class="each_write_left"><img class="avatar" src="<?= $this->webroot ?>img/usericon/<?= $hansei['Hansei']['User']['usericon'] ?>" width="50" /></div>
                        <? else: ?>
                            <div class="each_write_left"><img class="avatar" src="<?= $this->webroot ?>img/usericon/tokumei.gif" width="50" /></div>
                        <? endif; ?>                          
                        <div class="each_write_right">
                            <? if($hansei['Hansei']['tokumei'] == 0 || $hansei['Hansei']['user_id'] == $user_id): ?>
                                <div class="authorname"><?= h($hansei['Hansei']['User']['username']) ?></div>
                            <? else: ?>
                                <div class="authorname">Anonymous</div>
                            <? endif; ?>                                
                            <div class="honbun ajax_d">
                                <span id="<?= $hansei['Hansei']['id'] ?>"></span>
                                <?if (!empty($hansei['Hansei']['fact'])): ?><span class="honbun_a">【振り返り】</span><?= h($hansei['Hansei']['fact']) ?><? endif; ?>
                                <?if (!empty($hansei['Hansei']['prob1'])): ?><span class="honbun_a">【問題】</span><?= h($hansei['Hansei']['prob1']) ?><? endif; ?>
                                <?if (!empty($hansei['Hansei']['Utite'][0]['utite'])): ?><span class="honbun_a">【打ち手】</span><?= h($hansei['Hansei']['Utite'][0]['utite']) ?><? endif; ?>
                            </div>
                            <div class="toukounitiji"><?= $hansei['Hansei']['created'] ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach;
                //ここまで
            }
        }
    }

    //自分の反省を一定間隔で読みだす
    function reload_favorite($new_hansei_id) {
        // Ajax
        if ($this->RequestHandler->isAjax()) {
           // Configure for ajax
           Configure::write('debug', 0);
           $this->autoRender = false;
           // Output
            $user_id = $this->Auth->user('id');
            //自分の反省フィールドを読み出すための記述
            //Hanseiテーブルから情報を読み込む
            $this->StarHansei->recursive = 2;
            $new_hanseis = $this->StarHansei->find('all', 
                array(
                    'conditions' => array('StarHansei.my_id' => $user_id, 'value' => 1),
                    'order' => array('StarHansei.modified_star' => 'desc'),
                    'limit' => 150,
                )
            );
            //もし存在したらそのテーブルを挿入する。匿名且つそれが他人の反省ならばアイコンとユーザー名を変更する
            if($new_hanseis){
                foreach ($new_hanseis as $hansei): ?>
                <div class="wrap_each_write">
                    <!--         ブロッククリックで詳細表示            -->
                    <div id="detail" class="each_write clearfix">
                        <? if($hansei['Hansei']['tokumei'] == 0 || $hansei['Hansei']['user_id'] == $user_id): ?>
                        <div class="ap_name">
                            <img class="nameicon" src="<?= $this->webroot ?>img/name/<?= $hansei['Hansei']['User']['nameicon'] ?>" width="20" /><?= h($hansei['Hansei']['User']['ap_name']) ?>
                            <span class="wrap_rated_star">
                                <? for ($i=0; $i < $hansei['Hansei']['rating']; $i++) : ?>
                                    <img class="rated_star" src="<?= $this->webroot ?>img/rating/star-on.png" width="10" />
                                <? endfor; ?>
                            </span>
                        </div>                        
                            <div class="each_write_left"><img class="avatar" src="<?= $this->webroot ?>img/usericon/<?= $hansei['Hansei']['User']['usericon'] ?>" width="50" /></div>
                        <? else: ?>
                            <div class="each_write_left"><img class="avatar" src="<?= $this->webroot ?>img/usericon/tokumei.gif" width="50" /></div>
                        <? endif; ?>                          
                        <div class="each_write_right">
                            <? if($hansei['Hansei']['tokumei'] == 0 || $hansei['Hansei']['user_id'] == $user_id): ?>
                                <div class="authorname"><?= h($hansei['Hansei']['User']['username']) ?></div>
                            <? else: ?>
                                <div class="authorname">Anonymous</div>
                            <? endif; ?>                                
                            <div class="honbun ajax_d">
                                <span id="<?= $hansei['Hansei']['id'] ?>"></span>
                                <?if (!empty($hansei['Hansei']['fact'])): ?><span class="honbun_a">【振り返り】</span><?= h($hansei['Hansei']['fact']) ?><? endif; ?>
                                <?if (!empty($hansei['Hansei']['prob1'])): ?><span class="honbun_a">【問題】</span><?= h($hansei['Hansei']['prob1']) ?><? endif; ?>
                                <?if (!empty($hansei['Hansei']['Utite'][0]['utite'])): ?><span class="honbun_a">【打ち手】</span><?= h($hansei['Hansei']['Utite'][0]['utite']) ?><? endif; ?>
                            </div>
                            <div class="toukounitiji"><?= $hansei['Hansei']['created'] ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach;
                //ここまで
            }
        }
    }


    
    //反省の投稿を書き込む
    function ajax_add() {
        // Ajax
        if ($this->RequestHandler->isAjax()) {
           // Configure for ajax
           Configure::write('debug', 0);
           $this->autoRender = false;
           // Output        
            if (empty($this->data['Hansei']['fact']) and empty($this->data['Hansei']['prob1'])) {
                
            } else {
                //データが送られてきた場合
                $user_id =$this->Auth->User('id');
                //まず反省テーブルにデータを保存
                $this->data['Hansei']['user_id'] = $user_id;
                $this->data['Hansei']['type'] = 1;
                //saveAllでまとめてHasManyのデータを保存できる
                if($this->Hansei->saveAll($this->data)) {
                    //StarHanseiテーブルにも保存。kidokuフラグは-1で。
                   $hansei_id = $this->Hansei->getLastInsertID();
                   //データの整形
                   $this->data['StarHansei']['my_id'] = $user_id;
                   $this->data['StarHansei']['hansei_id'] = $hansei_id;
                   $this->data['StarHansei']['comment'] = 1;
                   $this->data['StarHansei']['kidoku'] = -1;
                   //saveできたら返り値１
                   if($this->StarHansei->save($this->data['StarHansei'])){
                       return 1;
                   }
                } else {
                    return '';
                }
            }  
        }         
    }
    
    //反省のfavを登録
    function star_hansei(){
        // Ajax
        if ($this->RequestHandler->isAjax()) {
           // Configure for ajax
           Configure::write('debug', 0);
           $this->autoRender = false;
           // Output
           //必要なデータを格納する
           $user_id =$this->Auth->User('id');
           $value = $this->params['form']['value'];
           $hansei_id = $this->params['form']['hansei_id'];
           //データの整形
           $this->data['StarHansei']['my_id'] = $user_id;
           $this->data['StarHansei']['hansei_id'] = $hansei_id;
           $this->data['StarHansei']['value'] = $value;
           //fav登録の場合はmodified_starのみに現在時刻を挿入
           $this->data['StarHansei']['modified'] = false;
           $this->data['StarHansei']['modified_star'] = date("Y-m-j H:i:s", time());
           //modifiedは更新しない
           //既に過去にfavしてあったらINSERTではなくUPDATEするように
            $update = $this->StarHansei->find('first', 
                 array(
                    'conditions' => array('StarHansei.hansei_id' => $hansei_id, 'StarHansei.my_id' => $user_id),
                )
            );
            if(!empty($update)){
                $starhansei_id = $update['StarHansei']['id'];
                $this->data['StarHansei']['id'] = $starhansei_id;
            }
           //star_hanseisテーブルにデータを保存する
           if($this->StarHansei->save($this->data)){
                return 1;
           } else {
               return '';
           }
        }        
    }
    
    
    
    
}
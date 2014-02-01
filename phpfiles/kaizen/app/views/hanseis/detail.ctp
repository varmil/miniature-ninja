        <div id="detail_wrap">
            <div class="area1 detail">
                <div class="area_title">詳細情報</div>
                <span class="hansei_id" id="<?= $hansei_d['Hansei']['id'] ?>"></span>
                <div class="area_content">
                    <span class="star" title="お気に入り">
                        <!--           1なら黄色い星を初期表示。1で無ければ白い星を初期表示               -->
                        <? if($value == 1): ?>
                        <img class="off" src="<?=$this->webroot ?>img/star_gr.png" width="30" id="0" style="display:none"/>
                        <img class="on" src="<?=$this->webroot ?>img/star_ye.png" width="30" id="1"/>                        
                        <? else: ?>
                        <img class="off" src="<?=$this->webroot ?>img/star_gr.png" width="30" id="0" />
                        <img class="on" src="<?=$this->webroot ?>img/star_ye.png" width="30" id="1" style="display:none;"/>
                        <? endif; ?>
                    </span><br />
                    <? if (!empty($hansei_d['Hansei']['fact']) ) : ?>
                        振り返り：<br />
                       <?= h($hansei_d['Hansei']['fact']) ?><br />                    
                    <? endif; ?>
                    <? if (!empty($hansei_d['Hansei']['prob1']) ) : ?>
                        問題：<br />
                        <?= h($hansei_d['Hansei']['prob1']) ?><br />
                                <? 
                                    $i = 2;
                                    if ($hansei_d['Hansei']['prob2']){
                                        echo '<div class="why_output">';
                                        echo "思考の軌跡：<br >";
                                        while ($hansei_d['Hansei']['prob'.$i]){
                                            echo h($hansei_d['Hansei']['prob'.$i]).'<br >';
                                            $i++ ;
                                        }
                                        echo '</div>';
                                    }
                                ?>
                            ↓<br />
                    <? endif; ?>
                    <? if (!empty($hansei_d['Hansei']['ideal']) ) : ?>
                            理想：<br />
                           <?= h($hansei_d['Hansei']['ideal']) ?><br />
                            ↓<br />
                    <? endif; ?>
                    <? if (!empty($hansei_d['Utite'][0]['utite']) ) : ?>
                            <!--          自分で作ったものならば打ち手の追加が可能                    -->
                            打ち手：<br />
                            <? $i=0; while(!empty($hansei_d['Utite'][$i]['utite'])){ ?>
                            <?= h($hansei_d['Utite'][$i]['utite']) ?><br />
                            <? $i++; } ?>
                    <? endif; ?>
                            <br />

                </div>
            </div>
            <div class="area1 detail">
                <div class="area_title">コメント</div>
                <div class="area_content">
                    <?=$form->create('Comment', array('controller' => 'comments', 'action' => 'add','type' => 'post', 'default'=>false, 'class' => 'toukou_comment'))?>
                    <?=$form->input('Comment.comment', array('type' => 'textarea', 'label' => '','maxlength' => 140, 'rows' => 2) )?>
                    <?= $form->hidden('Comment.hansei_id', array('value'=> $hansei_id)); ?>
                    <?= $form->hidden('Comment.commented_user_id', array('value'=> $commented_user_id)); //反省の投稿ユーザーID?>
                    <?=$form->end("コメント")?>
                </div>
                <div class="comment_area">
                    <?php foreach ($comments as $comment): ?>
                    <div class="wrap_each_write">
                        <!--         ブロッククリックで詳細表示            -->
                        <div class="each_write clearfix">
                            <span id="<?= $comment['Comment']['id'] ?>"></span>
                            <div class="ap_name">
                                <img class="nameicon" src="<?= $this->webroot ?>img/name/<?= $comment['User']['nameicon'] ?>" width="20" /><?= h($comment['User']['ap_name']) ?>
                            </div>                            
                            <div class="each_write_left"><img class="avatar" src="<?= $this->webroot ?>img/usericon/<?= $comment['User']['usericon'] ?>" width="50" /></div>
                            <div class="each_write_right">
                                <div class="authorname"><?= h($comment['User']['username']) ?></div>
                                <div class="honbun">
                                    <span class="honbun_c"><?= h($comment['Comment']['comment']) ?></span>
                                </div>
                                <div class="toukounitiji"><?= h($comment['Comment']['created']) ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>    
            
            
<div class="save">正常に保存しました</div>


<script>
$(function(){
    //IEでのajaxがキャッシュによって制限されてしまうのを解除
    //$.ajaxSetup({ cache: false });
    
    //フォームのajax処理
    $('form.toukou_comment').submit(function(){
            var postData = {};
            $('form').find(':input').each(function(){
                if ( !$(this).is(':disabled') ) {
                    // disableでない場合のみサーバに送る
                    if ( $(this).attr('type') == 'radio'  || $(this).attr('type') == "checkbox" ) {
                        // ラジオボタンの場合
                        if ( $(this).is(':checked') ) {
                            postData[$(this).attr('name')] = $(this).val();
                        }
                    }
                    else if ( $(this).get(0).tagName == "SELECT" ) {
                        // セレクトボックスの場合
                        postData[$(this).attr('name')] = $(this).val();
                    }
                    else {
                        // その他
                        postData[$(this).attr('name')] = $(this).val();
                    }
                }
            });
        //二重送信防止措置
        $('input').attr("disabled", "disabled");
    //反省投稿時のajax処理
        $.post("<?php echo Router::url(array('controller'=>'Comments','action'=>'ajax_comment')); ?>", postData, function(res){
            //...callback処理
            if(res == 1) {
                //フォームの値をリセットする
                $('input,textarea').not('input[type="radio"],input[type="checkbox"],:hidden, :button, :submit,:reset').val('');
                //デフォルトレイアウト内にあるセーブ完了divを一定時間表示する
                $('div.save')
                    .show("normal", function() {$(this).delay(1100).hide(700)});
                //今保存したデータをコメント欄に追加する
                $.ajax({
                       type: 'GET',
                       url: '<?=$this->webroot?>hanseis/detail/' + '<?=$hansei_id?>',
                       dataType: 'html',
                       success: function(data) {
                           $('#show_detail .area_content_index').html('').prepend(data);
                       },
                       error:function() {
                           alert('書き込んだコメントの読み込みに問題がありました。');
                       }
                });
                //disabeldを解除して再度ボタンを利用可能にする
                $('input').removeAttr("disabled");                
            } else {
                alert("保存に失敗しました。コメント入力して下さい。");
                $('input').removeAttr("disabled");
            }
        });
        return false;
    });
    
    
    //スターのトグル。クリックする度にまずはクラスを除去。それからクラスを付与してセレクターで利用する
    $('.star').click(function(e) {
        $('img', this).removeClass('clicked');
        $('img:hidden', this).addClass('clicked');
        var value = $('img.clicked', this).attr('id');
        $(".star .on, .star .off").toggle();
        
        //詳細情報の反省IDを取得
        var hansei_id = $('.detail span.hansei_id').attr('id');
        
        //ajaxでvalueを送信してDBに書き込み
        $.post("<?php echo Router::url(array('controller'=>'Hanseis','action'=>'star_hansei')); ?>", {"value": value, "hansei_id": hansei_id }, function(res){
            //...callback処理
            if(res == 1) {
                
            } else {
                alert("データが空のようです");
            }
        });        
        
    });
    
    //powertip記述
    $('*').powerTip({
        placement: 'ne',
        smartPlacement: "true",
        mouseOnToPopup: "true",
        fadeInTime: 160,
        fadeOutTime: 90,
        closeDelay: 0,
        intentPollInterval: 0,
    });
    
    //こっちで読み込む。スクロールバー表示
    $("#detail_wrap")
        .mCustomScrollbar({
          set_width:false, 
          set_height:false, 
          horizontalScroll:false, 
          scrollInertia:0, 
          scrollEasing:"easeOutCirc", 
          mouseWheel:5, 
          autoDraggerLength:true,
          // scrollButtons:{ 
            // enable:true, 
            // scrollType:"continuous", 
            // scrollSpeed:20, 
            // scrollAmount:40 
          //}
          advanced:{
            updateOnBrowserResize:true, 
            updateOnContentResize:true, 
            autoExpandHorizontalScroll:true, 
            autoScrollOnFocus:true
          }
    });        
    
    
});
</script>
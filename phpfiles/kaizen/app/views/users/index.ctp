<div id="wrap_all">
    <div id="clear_all"></div>
    <div id="mainblock1">
        <div class="block_title">HOME</div>
        
        <!--睡眠時間記録用  -->
        <div id="suimin_graph" class="ui-widget-content hidden">
            <div class="area1">
                <div class="area_title">睡眠グラフ</div>
                <div class="area_content">
        <!--ここにグラフをぶち込む  -->
                </div>                
            </div>
        </div>        
        
        <?=$form->create('Hansei', array('default'=>false, 'class' => 'toukou_hansei'))?>
            <!--ツールチップ用  -->
            <div id="whyarea" class="jquery-ui-draggable ui-widget-content hidden">
                <div class="area1">
                    <div class="area_title">なぜを10回問う！</div>
                    <div class="area_content">
                        <div class="why"></div>
                        <?=$form->input('Hansei.prob2', array('type' => 'textarea', 'class' => 'why_input', 'label' => '', 'maxlength' => 50, 'rows' => 2) )?>
                        <div class="why"></div>
                        <?=$form->input('Hansei.prob3', array('type' => 'textarea', 'class' => 'why_input', 'label' => '', 'maxlength' => 50, 'rows' => 2) )?>      
                        <div class="why"></div>
                        <?=$form->input('Hansei.prob4', array('type' => 'textarea', 'class' => 'why_input', 'label' => '', 'maxlength' => 50, 'rows' => 2) )?>
                        <div class="why"></div>
                        <?=$form->input('Hansei.prob5', array('type' => 'textarea', 'class' => 'why_input', 'label' => '', 'maxlength' => 50, 'rows' => 2) )?>
                        <div class="why"></div>
                        <?=$form->input('Hansei.prob6', array('type' => 'textarea', 'class' => 'why_input', 'label' => '', 'maxlength' => 50, 'rows' => 2) )?>
                        <div class="why"></div>
                        <?=$form->input('Hansei.prob7', array('type' => 'textarea', 'class' => 'why_input', 'label' => '', 'maxlength' => 50, 'rows' => 2) )?>
                        <div class="why"></div>
                        <?=$form->input('Hansei.prob8', array('type' => 'textarea', 'class' => 'why_input', 'label' => '', 'maxlength' => 50, 'rows' => 2) )?>
                        <div class="why"></div>
                        <?=$form->input('Hansei.prob9', array('type' => 'textarea', 'class' => 'why_input', 'label' => '', 'maxlength' => 50, 'rows' => 2) )?>
                        <div class="why"></div>
                        <?=$form->input('Hansei.prob10', array('type' => 'textarea', 'class' => 'why_input', 'label' => '', 'maxlength' => 50, 'rows' => 2) )?>
                        <br /><br />
                        <div class="button why_kakutei">問題確定</div>
                    </div>                
                </div>
            </div>
        <div class="scroll">
            
            <div class="area1 animate">
                <div class="area_title"><img class="iconwhite" alt="" src="<?= $this->webroot ?>img/iconwhite/Pen.png" height="20" />行動を振り返る</div>
                <div class="area_content">
                    <div class="button hide_b inline">元に戻す</div>
                    <span class="count_wrap"><span class="count"></span></span><br />
                    <span class="count_input_fact">100</span>
                        <div class="button inline button_kaizen">改善モードに切替</div><br />
                        <?=$form->input('Hansei.fact', array('type' => 'textarea', 'class' => 'input_fact', 'label' => '',  'value' => '100字で一日を振り返り、次の日の目標を立てましょう', 'maxlength' => 100, 'rows' => 3) )?>

                    <div class="hansei_hide hidden">
                        問題・良くなかったこと
                        <?=$form->input('Hansei.prob1', array('type' => 'textarea', 'class' => 'ori_why_input', 'label' => '', 'maxlength' => 50, 'rows' => 2) )?>
                            ↓<br />
                            理想
                            <?=$form->input('Hansei.ideal', array('type' => 'textarea', 'label' => '','maxlength' => 50, 'rows' => 2) )?>
                            ↓<br />                        
                            打ち手
                            <div class="button inline utite_add">打ち手の追加</div>
                            <div class="utite_wrap">
                            <?=$form->input('Utite.0.utite', array('type' => 'textarea', 'label' => '','maxlength' => 50, 'rows' => 2, 'class' => 'utite_input') )?>
                            <?= $form->hidden('Utite.0.user_id', array('value'=> $user_id)); ?>
                            </div>
                            <br />
                            <?= $form->input('Hansei.tokumei', array('type' => 'checkbox', 'checked'=>false, 'label' => '匿名で投稿', 'class' => 'add_checkbox')); ?>
                    </div>
                    自己評価<div id="rating_hansei" data-number="6"></div>
                    <div class="submit_kaizen">
                        <input id="toukou_hansei_button" type="submit" value="投稿する" >
                    </div>
                        <?//= $form->end(); ?>
<!--       form閉じタグ入れるとIEでエリア１が表示されない                   -->
                </div>
            </div>
            <div class="area1">
                <div class="area_title"><img class="iconwhite" alt="" src="<?= $this->webroot ?>img/iconwhite/Bar-Chart.png" height="20" />睡眠の記録</div>
                <div class="area_content">
                    <img id="icon_calendar" class="iconwhite" alt="" src="<?= $this->webroot ?>img/iconwhite/calendar.png" height="28" /><input id="datepicker" type="text" />
                    <div class="button inline suimin_graph_show">グラフ</div>
                    <!--位置ずれ起こすのでここにfix表示するしかない。leftの位置がずれるとNG  -->
                    <div id="slider_wrap" class="hidden">
                        <div id="time_input">
                            就寝時間<input type="text" name="hour1" id="hour1" value="" style="width:2em" />：<input type="text" name="minute1" id="minute1" value="" style="width:2em" /><br />
                            起床時間<input type="text" name="hour2" id="hour2" value="" style="width:2em" />：<input type="text" name="minute2" id="minute2" value="" style="width:2em" />
                        </div>
                        <input type="submit" id="toukou_suimin_button" value="記録する">
                        <!--         ここに保持しておく                 -->
                        <div id="" class="hidden">
                            <span class="hidden_ji"></span>
                            <span class="hidden_hun"></span>
                            <span class="hidden_am_pm"></span>
                            <span class="hidden_kisyou_syusin"></span>
                        </div>
                        <table id="clock">
                          <tr>
                            <td></td>
                            <td class="ji">11</td>
                            <td class="kara"></td>
                            <td class="ji">12</td>
                            <td class="kara"></td>
                            <td class="ji">1</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td class="ji">10</td>
                            <td class="kara"></td>
                            <td class="kara"></td>
                            <td class="hun">00</td>
                            <td class="kara"></td>
                            <td class="kara"></td>
                            <td class="ji">2</td>
                          </tr>
                          <tr>
                            <td class="kara"></td>
                            <td class="hun">50</td>
                            <td class="kara"></td>
                            <td id="am" class="am_pm">AM</td>
                            <td class="kara"></td>
                            <td class="hun">10</td>
                            <td class="kara"></td>
                          </tr>
                          <tr>
                            <td class="ji">9</td>
                            <td class="kara"></td>
                            <td id="kisyou" class="kisyou_syusin">起床</td>
                            <td class="kara">●</td>
                            <td id="pm" class="am_pm">PM</td>
                            <td class="kara"></td>
                            <td class="ji">3</td>
                          </tr> 
                          <tr>
                            <td></td>
                            <td class="hun">40</td>
                            <td class="kara"></td>
                            <td id="syusin" class="kisyou_syusin">就寝</td>
                            <td class="kara"></td>
                            <td class="hun">20</td>
                            <td class="kara"></td>
                          </tr>
                          <tr>
                            <td class="ji">8</td>
                            <td class="kara"></td>
                            <td class="kara"></td>
                            <td class="hun">30</td>
                            <td class="kara"></td>
                            <td class="kara"></td>
                            <td class="ji">4</td>
                          </tr>
                          <tr>
                            <td class="kara"></td>
                            <td class="ji">7</td>
                            <td class="kara"></td>
                            <td class="ji">6</td>
                            <td class="kara"></td>
                            <td class="ji">5</td>
                            <td class="kara"></td>
                          </tr>                                                                                                                       
                        </table>                    
                    </div>
                </div>                
            </div>
            <div class="area1">
                <div class="area_title"><img class="iconwhite" alt="" src="<?= $this->webroot ?>img/iconwhite/Repeat.png" height="20" />習慣づけたいこと</div>
                <div class="area_content">
                  <textarea name="habit" class="input_habit" maxlength="60" rows="2" cols="30" id="input_habit_original" style="">習慣づけたいことを記入</textarea>
                  <input type="submit" id="toukou_habit_button" value="追加する"><br />
                  <div id="habit_wrap_all">
                        <!--      ここに習慣づけたいことをぶち込む                -->
                  </div>
                </div>                
            </div>            
        </div>
        
    </div>
    
    <div id="mainblock2">
        <div class="block_title">My Record</div>
        <ul class="tabs_wrap">
            <li class="tab main"><img class="iconwhite" alt="" src="<?= $this->webroot ?>img/iconwhite/Picture-Profile.png" height="15" />Main</li>
            <li class="tab comment"><img class="iconwhite" alt="" src="<?= $this->webroot ?>img/iconwhite/Comment-1.png" height="15" />コメント <span class="new_comment hidden"></span> </li>
            <li class="tab favorite"><img class="iconwhite" alt="" src="<?= $this->webroot ?>img/iconwhite/star.png" height="15" />お気に入り</li>
        </ul>
        <div class="scroll">
            <div class="area_tl">
            <!--      ここに自分の反省をぶち込む            -->
            </div>
        </div>
    </div>
    
    <div id="mainblock3">
        <div class="block_title">Other's Record</div>
        <div class="tabs1"></div>
        <div class="scroll">
            <div class="area_tl">
            <!--      ここに他人の反省をぶち込む            -->
            </div>        
        </div>
    </div>

</div>


<!--睡眠時間記録用  -->
<div id="show_detail" class="jquery-ui-draggable ui-widget-content hidden">
    <div class="area1_index">
        <div class="area_title "><div class="button hide_c inline_block">閉じる</div></div>
        <div class="area_content_index">
<!--ここにグラフをぶち込む  -->
        </div>                
    </div>
</div>    

<div class="save">正常に処理しました</div>

<script>
$(function(){
    //dislay:inline-blockの要素を初期非表示にしたい場合
    $('.hide_b').hide();
    
    //フォームのajax処理。関数にする
        function form_ajax(class_name){
            var postData = {};
            $('form.'+class_name).find(':input').each(function(){
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
            return postData;
        }
        
    //関数。自分のTL読み込み
    function auto_reload(first_id) {
        var new_hansei_id = first_id;
        $.ajax({
               type: 'GET',
               url: '<?=$this->webroot?>hanseis/auto_reload/' + new_hansei_id,
               dataType: 'html',
               success: function(data) {
                   $('#mainblock2 .area_tl').html('').prepend(data).show('fast');
               },
               error:function() {
                   //alert('問題がありました。');
               }
        });
    }
    auto_reload(0);
        
    $('#toukou_hansei_button').click(function(){
        //詳細画面を読み込む際にキャッシュを無効にしているのでにキャッシュを有効に戻したい。有効にしないと登校が保存されないようだ
        //$.ajaxSetup({ cache: true });    
        
        var postData = form_ajax('toukou_hansei');
        //二重送信防止措置
        $('input').attr("disabled", "disabled");
    //反省投稿時のajax処理
        $.post("<?php echo Router::url(array('controller'=>'Hanseis','action'=>'ajax_add')); ?>", postData, function(res){
            //...callback処理
            if(res == 1) {
                //フォームの値をリセットする
                $('input,textarea').not('input[type="radio"],input[type="checkbox"],:hidden, :button, :submit,:reset').val('');
                $('.why').html('');
                //デフォルトレイアウト内にあるセーブ完了divを一定時間表示する
                $('div.save')
                    .show("normal", function() {$(this).delay(1100).hide(700)});
                //スクロールしてから要素を隠す
                $('#mainblock1 .mCSB_container').attr('style', 'position: relative; top:0'); // ページの一番上にスクロール
                $('#whyarea, .hansei_hide, .utite_copy, .hide_b, .count').hide('normal');
                $('.input_fact, .button_kaizen, .count_input_fact').show('normal');
                $('.count_input_fact').html('100');
                $('.why_input').hide();
                
                auto_reload(0);       
                //disabeldを解除して再度ボタンを利用可能にする
                $('input').removeAttr("disabled");  
            } else {
                alert("保存に失敗しました。【一日の出来事】は必須項目です");
                //disabeldを解除して再度ボタンを利用可能にする
                $('input').removeAttr("disabled");  
            }
        });
        return false;
    });
    
    //フフォームに表示される初期表示
    $(".input_fact, .input_habit").css('color', 'dimgray').focus(function() {
    //  class名 "textFocus" を追加。（文字色を濃くする）
    jQuery(this).addClass("textFocus");
    //  if条件は HTMLで設定した初期値（value）のままかどうか
    if(this.value == this.defaultValue){
        //  trueなら テキストボックスを 空 にする
        jQuery(this).val('');
    }
    //  逆に テキストボックスからフォーカスが失われたとき。
    }).blur(function(){
        //  if条件は テキストボックスの数値が 空（０文字）のとき
        if(jQuery(this).val() == ''){
            //  テキストボックスの中身を 元の初期値（value）にする
            //  classも外す（文字色を元の薄い色に戻す）
            jQuery(this).val(this.defaultValue).removeClass("textFocus");
        }
    });
 


        
    //改善モード切り替えボタン
    $('.button_kaizen').click(function(){
        $('.hansei_hide, .hide_b').show('normal');
        $('.button_kaizen, .input_fact, .count_input_fact').hide('normal');
        $('.input_fact').val("");
    })
    //なぜなぜエリア
    $('.why_input').bind('keydown keyup keypress focus',function(){
        $(this).fadeTo(0, 1.0);
    });
    $('.why_input').focusout(function(){
        if(! $(this).val()){
            $(this).fadeTo(0, 0.5);
        }
    });
    $('.hide_b').click(function(){
        $('#mainblock1 .mCSB_container').attr('style', 'position: relative; top:0'); // ページの一番上にスクロール
        $('.hansei_hide, .hide_b, .count, #whyarea, .why_input').hide('normal');
        $('.button_kaizen, .input_fact, .count_input_fact').show('fast');
        $('.count_input_fact').html('100');
        $('.ori_why_input, .why_input, #HanseiIdeal, .utite_input').not('input[type="radio"],input[type="checkbox"],:hidden, :button, :submit,:reset').val(''); //改善エリアをリセットする
        $('.why').html('');        
    });

    //オリジナルの問題フォームが空ならばなぜなぜエリアを閉じる
    $('.ori_why_input').keyup(function(){
        if(! $(this).val()){
            //フォームの値をリセットしてなぜなぜエリアリセットする
            $('#whyarea').hide('normal');
            $('.why').html('');
            $('textarea.why_input').not('input[type="radio"],input[type="checkbox"],:hidden, :button, :submit,:reset').val('');
            $('.why_input').hide();
        } else {
            $('#whyarea').show('slow');
        }
    });
    //ループ用処理
    var why = [];
    var index = '';
    $('.why_input, .ori_why_input').bind('keydown keyup keypress',function(){
        index = $('.why_input').index(this);
        why[index] = $(this).val();
        if (why[index]) {
            $('.why_input').eq(index+1).show('slow');
            $('.why').eq(index+1).show().html(why[index] + "。それはなぜ？");
            $('.why').eq(index).html(why[index-1] + "。それはなぜ？");
        } else {
            $('.why_input').eq(index+1).hide('slow');
            $('.why').eq(index+1).hide().html('');
        }
    });
    
    //問題を確定するボタンの処理
    $('.why_kakutei').click(function(){
        $('.why_input:visible:last').val('').fadeTo(0, 0.4);
        $('.why:visible:last').html('上記で確定です。');
    })    
    
    //睡眠グラフエリア
    //デートピッカークリックでオープン
    $('.suimin_graph_show').click(function(){
        //詳細画面を読み込む際にキャッシュを無効にしているのでにキャッシュを有効に戻したい。
        //$.ajaxSetup({ cache: false });           
        
        $('#suimin_graph').toggle();
        //アジャックスでグラフを読み込む
        $.ajax({
               type: 'GET',
               url: '<?=$this->webroot?>sleeps/graph',
               dataType: 'html',
               success: function(data) {
                   $('#suimin_graph .area_content').html('').prepend(data).show('fast');
               },
               error:function() {
                   //alert('問題がありました。');
               }
        });          
        

    });
    
    //反省詳細読み込み記述。詳細表示。ajaxで読み込んだ要素にもイベントを登録するにはliveを使う
    $('.ajax_d').live('click',function(e) {
        $('#show_detail').show('fast');
        $('#show_detail .area_content_index').html('');
        //e.preventDefault();
        var hansei_id = $('span', this).attr('id');
        $.ajax({
               type: 'GET',
               url: '<?=$this->webroot?>hanseis/detail/' + hansei_id,
               dataType: 'html',
               success: function(data) {
                   //アニメーションした後に要素を追加しないとスクロールがバグる。高さ設定はダミー
                   $('#show_detail').animate(
                       { height: '88%' }, 
                       { duration: 10, complete: function()
                           { $('#show_detail .area_content_index').prepend(data); }
                       }
                   );
               },
               error:function() {
                   //alert('問題がありました。');
               }
        });  
    });
    
    //閉じるボタンの処理
    $('.hide_c').click(function(){
        $('#show_detail').hide('fast');
    });   
    
    //タブの透明性
    $('#mainblock2 .tab:first').addClass("clicked").fadeTo(0,0.6);
    //マウスが乗った時、外れた時
    $('.tab').mouseenter(function(){
        $(this).not('.clicked').fadeTo(60, 0.8);
    });
    $('.tab').mouseleave(function(){
        $(this).not('.clicked').fadeTo(30, 1.0);
    });
    //mainblock2のtabのクリック制御
    $('#mainblock2 .tab').click(function(){
        var index = $('#mainblock2 .tab').index(this);
        $('#mainblock2 .tab').removeClass("clicked").fadeTo(0,1.0);
        $('#mainblock2 .tab').eq(index).addClass("clicked").fadeTo(0,0.6);
    });    
    
    
    //メインエリアクリック時の挙動
    $('.tabs_wrap .main').click(function(){
        //最新の反省フィールドのIDを取得
        var new_hansei_id = 0;
        $.ajax({
               type: 'GET',
               url: '<?=$this->webroot?>hanseis/auto_reload/' + new_hansei_id,
               dataType: 'html',
               success: function(data) {
                   //一旦TLエリアのHTMLをクリアしてから再度読み込み
                   $('#mainblock2 .area_tl').html('').prepend(data).show('fast');
               },
               error:function() {
                   //alert('読み込みに問題がありました。');
               }
        });                
    });    
    //コメントエリアクリック時の挙動
    $('.tabs_wrap .comment').click(function(){
        //最新のコメント付き反省フィールドのIDを取得
        var new_hansei_id = 0;
        $.ajax({
               type: 'GET',
               url: '<?=$this->webroot?>hanseis/reload_comment/' + new_hansei_id,
               dataType: 'html',
               success: function(data) {
                   //一旦TLエリアのHTMLをクリアしてから再度読み込み
                   $('#mainblock2 .area_tl').html('').prepend(data).show('fast');
               },
               error:function() {
                   //alert('読み込みに問題がありました。');
               }
        });                
    });        
    //お気に入りエリアクリック時の挙動
    $('.tabs_wrap .favorite').click(function(){
        //最新のコメント付き反省フィールドのIDを取得
        var new_hansei_id = 0;
        $.ajax({
               type: 'GET',
               url: '<?=$this->webroot?>hanseis/reload_favorite/' + new_hansei_id,
               dataType: 'html',
               success: function(data) {
                   //一旦TLエリアのHTMLをクリアしてから再度読み込み
                   $('#mainblock2 .area_tl').html('').prepend(data).show('fast');
               },
               error:function() {
                   //alert('読み込みに問題がありました。');
               }
        });                
    });            
    

    //関数。他人のTL読み込み
    function auto_reload_others(first_id) {
        //最新の反省フィールドのIDを取得
        var o_new_hansei_id = first_id;
        $.ajax({
               type: 'GET',
               url: '<?=$this->webroot?>hanseis/auto_reload_others/' + o_new_hansei_id,
               dataType: 'html',
               success: function(data) {
                   $('#mainblock3 .area_tl').html('').prepend(data).show('fast');
               },
               error:function() {
                   //alert('ブラウザを更新して下さい。世界の反省読み込みに問題がありました。');
               }
        });      
    }
    auto_reload_others(0);
    //一定間隔で新着を読み込む。他人のTL
    setInterval(function(){
        auto_reload_others( $('.o_hansei_id:first').attr('id') );
    },200000);
    
    //一定間隔で新着を読み込む。自分のコメントのkidokuフラグ。つまり新しいコメントの件数通知
    setInterval(function(){
        $.ajax({
               type: 'GET',
               url: '<?=$this->webroot?>star_hanseis/auto_reload_kidoku/' ,
               dataType: 'html',
               success: function(data) {
                   if (data == 'nothing'){
                        $('.new_comment').hide('normal').html('');
                   } else {
                        $('.new_comment').html(data).show('normal');
                   }
               },
               error:function() {
                   //alert('ブラウザを更新して下さい。既読フラグ読み込みに問題がありました。');
               }
        });  
    }, 300000);
    //NEWアイコンの初期表示
    if('<?= $count_kidoku_0?>' != 0){
        $('.new_comment').html(<?= $count_kidoku_0 ?>).show('normal');
    }
    
    
    //打ち手追加ボタンをクリックした時にappendする
    $('.utite_add').click(function(){
        var size = $('.utite_wrap :hidden').size();
        if (size > 6) {
            $('.utite_add').hide('normal');
        } else {
            $('.utite_wrap').append('<textarea name="data[Utite]['+size+'][utite]" maxlength="50" rows="2" cols="30" id="Utite'+size+'Utite" class="utite_input"></textarea><input type="hidden" name="data[Utite]['+size+'][user_id]" value="<?=$user_id?>" id="Utite'+size+'UserId">')
        }
     });
     
     //ドラッグ移動
    $('.jquery-ui-draggable').draggable({
        opacity: 0.5,
    });
    
    //カレンダーUI
    $('#datepicker').datepicker({
        changeMonth: false,
        changeYear: false,
        dateFormat: 'yy-mm-dd',
        yearRange: '2012:2030',
    });
    //datepickerの値が入ったところでボックス拡張
    $('#datepicker').change(function(){
        $('#slider_wrap').toggle('normal');
    });
    $('#datepicker').click(function(){
        $('#slider_wrap').hide('normal');
        $(this).val('');
    });    
    
    //自作タイムピッカー
    //時間にマウスえんたーした時の処理
    $('.ji, .hun, .am_pm, .kisyou_syusin').mouseenter(function(){
        //クラスを取得。そのクラス名の要素のclickedを解除して、背景色も透明に戻す
        var class_name = $(this).attr('class');
        $('.'+class_name).removeClass("clicked").css("background-color", "transparent");
        //class名によって場合分け
        if (class_name == 'ji') {
            //現在マウスが乗っている要素の背景色を変化してID名を付ける
            $(this).css("background-color", "pink");
            var entered_ji = $(this).html();
            $('span.hidden_ji').attr('id', entered_ji);
        } else if (class_name == 'hun'){
            //現在マウスが乗っている要素の背景色を変化してID名を付ける
            $(this).css("background-color", "green");
            var entered_hun = $(this).html();
            $('span.hidden_hun').attr('id', entered_hun);               
        } else if( class_name == 'am_pm'){
            //現在マウスが乗っている要素の背景色を変化してID名を付ける
            $(this).css("background-color", "#ffe4c4");
            var entered_am_pm = $(this).html();
            $('span.hidden_am_pm').attr('id', entered_am_pm);                
        } else if (class_name == 'kisyou_syusin'){
            //現在マウスが乗っている要素の背景色を変化してID名を付ける
            $(this).css("background-color", "#f5fffa");
            var entered_kisyou_syusin = $(this).html();
            $('span.hidden_kisyou_syusin').attr('id', entered_kisyou_syusin);              
            
        }
    });    

    //クロックエリアをクリックした時、時間・分・AMPM全てが点灯していればデータをインプットに入力。就寝が埋まっていたら起床。
    $('#clock').click(function(e) {
        //変数にhidden spanのID値を格納する
        var ji = $('span.hidden_ji').attr('id');
        var hun = $('span.hidden_hun').attr('id');
        var am_pm = $('span.hidden_am_pm').attr('id');
        var kisyou_syusin = $('span.hidden_kisyou_syusin').attr('id');
        //4つとも空で無ければインプットに値を転写
        if(ji != undefined && hun != undefined && am_pm != undefined && kisyou_syusin != undefined){
            var new_ji = Number(ji);
            //AMかPMかで数値を変換する。24時はPMならば12時とする。AMならば0時。それ以外はそのまま出力
            if (am_pm == 'PM' && new_ji <= 11){
               new_ji = new_ji + 12;
            } else if(am_pm == 'PM' && new_ji == 12) {
               new_ji = new_ji ;
            } else if(am_pm == 'AM' && new_ji == 12) {
               new_ji = new_ji - 12;
            }
            //起床就寝によってフォームを入れ替え
            if(kisyou_syusin == '就寝'){
                $('#hour1').attr('value', new_ji );
                $('#minute1').attr('value', hun);
            } else {
                $('#hour2').attr('value', new_ji );                
                $('#minute2').attr('value', hun);
            }
        }
    });
    //睡眠時間投稿をした時の処理
    $('#toukou_suimin_button').click(function(e) {
        var date = $('#datepicker').val();
        var syusin = $('#hour1').val() + ':' + $('#minute1').val();
        var kisyou = $('#hour2').val() + ':' + $('#minute2').val();
        //二重送信防止措置
        $('input').attr("disabled", "disabled");
        //ajaxでvalueを送信してDBに書き込み
        $.post("<?php echo Router::url(array('controller'=>'Sleeps','action'=>'toukou_suimin')); ?>", {"date": date, "syusin": syusin, "kisyou": kisyou }, function(res){
            //...callback処理
            if(res == 1) {
                //フォームの値をリセット
                $('input,textarea').not('input[type="radio"],input[type="checkbox"],:hidden, :button, :submit,:reset').val('');
                //デフォルトレイアウト内にあるセーブ完了divを一定時間表示する
                $('div.save')
                    .show("normal", function() {$(this).delay(1100).hide(700)}); 
                //disabeldを解除して再度ボタンを利用可能にする
                $('input').removeAttr("disabled");
                //睡眠グラフをもう一度読み込む
                $.ajax({
                       type: 'GET',
                       url: '<?=$this->webroot?>sleeps/graph',
                       dataType: 'html',
                       success: function(data) {
                           $('#suimin_graph .area_content').html('').prepend(data).show('fast');
                       },
                       error:function() {
                           //alert('問題がありました。');
                       }
                });                     
                $('#slider_wrap').hide('normal');
                auto_reload_others(0);  //他人の反省を再読み込み
            } else {
                alert("データが空のようです");
                //disabeldを解除して再度ボタンを利用可能にする
                $('input').removeAttr("disabled");  
            }
        });        
    });
    
    //最新のHabitを読み込む
    function reload_habit(){
        $.ajax({
               type: 'GET',
               url: '<?=$this->webroot?>habits/reload_habit/',
               dataType: 'html',
               success: function(data) {
                   $('#habit_wrap_all').html('').prepend(data).show('fast');
               },
               error:function() {
                   //alert('読み込みに問題がありました。');
               }
        });            
    }
    reload_habit();   
    //習慣づけたいことの投稿処理
    $('#toukou_habit_button').click(function(e) {
        var str = $('#input_habit_original').val();
        //二重送信防止措置
        $('input').attr("disabled", "disabled");
        //ajaxでvalueを送信してDBに書き込み
        $.post("<?php echo Router::url(array('controller'=>'Habits','action'=>'toukou_habit')); ?>", {"habit": str,}, function(res){
            //...callback処理
            if(res == 1) {
                //フォームの値をリセット
                $('input,textarea').not('input[type="radio"],input[type="checkbox"],:hidden, :button, :submit,:reset').val('');
                //デフォルトレイアウト内にあるセーブ完了divを一定時間表示する
                $('div.save')
                    .show("normal", function() {$(this).delay(1100).hide(700)}); 
                //最新のHabitを読み込む
                reload_habit();               
                auto_reload_others(0);  //他人の反省を再読み込み               
                //disabeldを解除して再度ボタンを利用可能にする
                $('input').removeAttr("disabled");               
            } else {
                alert("データが空のようです");
                //disabeldを解除して再度ボタンを利用可能にする
                $('input').removeAttr("disabled");  
            }
        });        
    });    
    
    
    //Good_fightカウント用。
    $('.good_fight_a').live('click',function(){
        var str = $(this).html();
        var hansei_id = $(this).parent('div').attr('id');
        //二重送信防止措置
        $(this).parent('div').hide(80);
        //ajaxでvalueを送信してDBに書き込み
        $.post("<?php echo Router::url(array('controller'=>'Habits','action'=>'good_fight')); ?>", {"html": str, "hansei_id": hansei_id,}, function(res){
            //...callback処理
            if(res == 1) {
                //デフォルトレイアウト内にあるセーブ完了divを一定時間表示する
                $('div.save')
                    .show("fast", function() {$(this).delay(400).hide(300)}); 
                auto_reload_others(0);
            } else {
                alert("保存に失敗しました。時間をおいてお試し下さい");
            }
        });        
    });     
    
    //バリデーション用文字カウント
    var countMax = 50;
    $('#HanseiProb1, #HanseiIdeal, #HanseiTheme, .utite_input, .why_input').live('keydown keyup keypress change focus',function(){
        var thisValueLength = $(this).val().length;
        var countDown = (countMax)-(thisValueLength);
        $('.count').show('normal').html(countDown);

        if(countDown < 0){
            $('.count').css({color:'#ff0000',fontWeight:'bold'});
        } else {
            $('.count').css({color:'#fff',fontWeight:'normal'});
        }
    });
    var countMax_input_fact = 100;
    $('.input_fact').live('keydown keyup keypress change',function(){
        var thisValueLength = $(this).val().length;
        var countDown = (countMax_input_fact)-(thisValueLength);
        $('.count_input_fact').show('normal').html(countDown);

        if(countDown < 0){
            $('.count_input_fact').css({color:'#ff0000',fontWeight:'bold'});
        } else {
            $('.count_input_fact').css({color:'#fff',fontWeight:'normal'});
        }
    });
    
    //レーティング用
    $('#rating_hansei').raty({ path: '<?= $this->webroot ?>img/rating', scoreName: 'data[Hansei][rating]', numberMax: 6, width: 150, score: 3,
         hints: ['最悪', '悪い', 'やや悪い', 'やや満足', '満足だ', '最高'],
         number: function() {
            return $(this).attr('data-number');
         },
    });
    

});
</script>
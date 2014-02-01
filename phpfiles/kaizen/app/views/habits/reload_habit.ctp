<?foreach ($habits as $habit): ?>
    <div id="habit_wrap_each_write" class="wrap_each_write">
        <!--         ブロッククリックで詳細表示            -->
        <div id="detail" class="each_write clearfix">
            <div class="habit_mainblock">
<!--                 <div class="authorname"><?= h($habit['User']['username']) ?></div> -->
                <div class="honbun">
                    <?= h( $habit['Habit']['habit'] ) ?>
                </div>
                <div class="count_ok_ng">
                    <img class="iconwhite" alt="" src="<?= $this->webroot ?>img/iconwhite/ok.png" height="15" /><?= $habit['Habit']['count_ok'] ?>回
                    <img class="iconwhite" alt="" src="<?= $this->webroot ?>img/iconwhite/ng.png" height="15" /><?= $habit['Habit']['count_ng'] ?>回　<?= date("m月j日", strtotime($habit['Hansei']['created'])) ?>登録
                </div>
                <div class="good_fight">
                    Good! <?= $habit['Habit']['good']; ?>　
                    頑張れ! <?= $habit['Habit']['fight']; ?>　
                </div>                  
            </div>
            <div id="<?= $habit['Hansei']['id'] ?>" class="habit_hover_show hidden">
                <div id="" class="button button_habit ok">実行</div>
                <div id="" class="button button_habit ng">未遂</div>
                <div id="" class="button button_habit master">会得</div>
                <div id="" class="button_delete button_habit delete" onclick="return confirm('本当に削除しますか？')">削除</div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<script>
$(function(){
    
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
    
    $('#habit_wrap_each_write').live('click',function(){
        $('.habit_hover_show', this).show(100);
        $(this).fadeTo(50, 1.0);
    });
    $('#habit_wrap_each_write').live('mouseenter',function(){
        $(this).fadeTo(50, 0.6);
    });    
    $('#habit_wrap_each_write').live('mouseleave',function(){
        $('.habit_hover_show', this).hide(80);
        $(this).fadeTo(50, 1.0);
    });    
    

    //習慣づけたいことの実行未遂投稿処理
    $('.habit_hover_show .button_habit').click(function(e) {
        var str = $(this).html();
        var hansei_id = $(this).parent('div').attr('id');
        //二重送信防止措置
        $('input').attr("disabled", "disabled");
        //ajaxでvalueを送信してDBに書き込み
        $.post("<?php echo Router::url(array('controller'=>'Habits','action'=>'habit_button_dealing')); ?>", {"button_html": str, "hansei_id": hansei_id,}, function(res){
            //...callback処理
            if(res == 1) {
                //デフォルトレイアウト内にあるセーブ完了divを一定時間表示する
                $('div.save')
                    .show("normal", function() {$(this).delay(1100).hide(700)}); 
                //最新のHabitを読み込む
                reload_habit();      
                auto_reload_others(0);  //他人の投稿をリロード                        
                //disabeldを解除して再度ボタンを利用可能にする
                $('input').removeAttr("disabled");               
            } else {
                alert("保存に失敗しました。時間をおいてお試し下さい");
                //disabeldを解除して再度ボタンを利用可能にする
                $('input').removeAttr("disabled");  
            }
        });        
    });        
    
    
});    
</script>
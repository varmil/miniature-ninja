<div id="for_login_leftBox">
    <div class="title">Aratameを使うと、毎日の生活を改善することができます。<br>全国の仲間とつながりを持って楽しく改善することができます。</div>
    <img class="eye_catch" src="<?= $this->webroot ?>img/Aratame_eyecatch.png" alt="">
    <h2>最新の投稿</h2>
    <div id="auto_reload_others_insert"></div>
</div>

<div id="for_login_rightBox">
    <h1 class="" style="font-size: 36px">アカウント登録</h1>
    <h2 class="">無料でご利用いただけます。</h2>
    <div id="registration_container">
        <div id="simple_registration_container" class="simple_registration_container">
            <? echo $form->create('User', array('action' => 'create')); ?>
                <?=$form->input('User.username', array('type' => 'text', 'class' => 'input_username', 'label' => '',  'value' => '新規アカウント名', 'maxlength' => 15,) )?>
                <?echo $form->error('User.username'); ?>
                <?=$form->input('User.new_password', array('type' => 'text', 'class' => 'input_password', 'label' => '',  'value' => '新規パスワード (6文字以上半角英数)', 'maxlength' => 20, 'autocomplete' => 'off',) )?>
                <?echo $form->error('User.new_password'); ?>
                <div id="reg_form_box" class="large_form">
                    スペル等の誤りが無いかもう一度ご確認下さい
                </div>
            <?echo $form->end('新規アカウント登録');?>
        </div>
    </div>
</div>

<script>
$(function(){
    //初期値を格納
    var username_ori = $('.input_username').val();
    var password_ori = $('.input_password').val();
    
    //フフォームに表示される初期表示
    $(".input_username, .input_password").css('color', '#999').focus(function() {
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
    
    $('#UserCreateForm').submit(function(){
        //フォーム入力値を取得
        var username = $('.input_username').val();
        var password = $('.input_password').val();
        if (username == username_ori || password == password_ori){
            alert('デフォルト値のままです。');
            return false;
        }
    });
    
    //関数。他人のTL読み込み
    function auto_reload_others(first_id, limit) {
        //最新の反省フィールドのIDを取得
        var o_new_hansei_id = first_id;
        var limit = limit
        $.ajax({
               type: 'GET',
               url: '<?=$this->webroot?>hanseis/auto_reload_others/' + o_new_hansei_id +'/'+ limit,
               dataType: 'html',
               success: function(data) {
                   $('#auto_reload_others_insert').html('').prepend(data).show('fast');
               },
               error:function() {
                   //alert('ブラウザを更新して下さい。世界の反省読み込みに問題がありました。');
               }
        });      
    }
    auto_reload_others(0, 8);
    
});
</script>
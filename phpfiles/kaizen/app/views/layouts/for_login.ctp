<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo $this->Html->charset(); ?>
    <link rel="SHORTCUT ICON" href="<?= $this->webroot ?>img/logo/icon.ico">
    <title>
        <?php __('Aratame'); ?>
        <?php //echo $title_for_layout; ?>
    </title>
    <?php
        //echo $this->Html->meta('icon');

        echo $this->Html->css('cake.generic');
        echo $this->Html->css('style0');
        echo $this->Html->css('dark-hive/jquery-ui-1.9.2.custom.min');
        echo $this->Html->css('jquery.powertip');
        echo $this->Html->css('jquery.mCustomScrollbar');
        echo $this->Html->css('jquery.jqplot.min');
        
        echo $this->Html->script('jQuery1.7.2');
        echo $this->Html->script('jquery-ui-1.9.2.custom.min');
        echo $this->Html->script('jquery.powertip-1.1.0.min');
        //スクロールバー装飾
        echo $this->Html->script('scroll/jquery.mCustomScrollbar');
        echo $this->Html->script('scroll/jquery.mousewheel.min');
        //グラフ作成
        echo $this->Html->script('graph/jquery.jqplot.min');
        echo $this->Html->script('graph/jqplot.cursor.min');
        echo $this->Html->script('graph/excanvas');
        echo $this->Html->script('graph/jqplot.dateAxisRenderer.min');
        echo $this->Html->script('graph/jqplot.pointLabels.min');
        echo $this->Html->script('graph/jqplot.barRenderer.min');
        echo $this->Html->script('graph/jqplot.categoryAxisRenderer.min');
        echo $this->Html->script('graph/jqplot.canvasAxisTickRenderer.min');
        echo $this->Html->script('graph/jqplot.canvasTextRenderer.min');
        //★レーティング
        echo $this->Html->script('rating/jquery.raty');

        echo $scripts_for_layout;
    ?>
    <script>
        $(document).ready(function() {
            //bodyを非表示にする
            //$("body").css("display", "none");
            //フェードイン表示
            $("body").fadeIn(1200);
            //ページ移動の処理
            $("a.fade").click(function(event) {
                linkLocation = this.href;
                $("body").fadeOut(200, redirectPage);
                event.preventDefault();
            });
            function redirectPage() {
                window.location = linkLocation;
            }
            
            //スクロールバー表示
            $(".scroll, #whyarea .area_content")
                .mCustomScrollbar({
                  set_width:false, 
                  set_height:false, 
                  horizontalScroll:false, 
                  scrollInertia:0, 
                  //scrollEasing:"easeOutQuad", 
                  mouseWheel:7, 
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
            
            //セッティングにホバーした時の表示
            $('a.setting').click(function(){
                $('.setting_item').fadeToggle('fast');
            });            
            
        });
    </script>
</head>
<body style="overflow: visible;">
    <div id="container" class="for_login_container">
        <div id="header">
            <div id="header_width_define">
                <h1>
                    <a class="hidden" href="<?= $this->webroot ?>users/login">Aratame</a>
                    <img id="title_logo" class="" alt="" src="<?= $this->webroot ?>img/logo/title_logo.png" height="40" />
                </h1>
                <span class="userinfo menu_login_container">
                    <? echo $form->create('User', array('action' => 'login')); ?>
                    <table>
                        <tr>
                            <td class="html7magic"><label for="email">アカウント名</label></td>
                            <td class="html7magic"><label for="pass">パスワード</label></td>
                        </tr>
                        <tr>
                            <td><?echo $form->input('username', array('class' => '', 'label' => false,));?></td>
                            <td><?echo $form->input('password', array('class' => '', 'label' => FALSE,));?></td>
                            <td><?echo $form->end('ログイン');?></td>
                        </tr>
                        <tr>
                            <td class="login_form_label_field">
                                <div>
                                    <div class="uiInputLabel clearfix">
                                        <input id="persist_box" type="checkbox" name="persistent" value="1" checked="1" class="uiInputLabelCheckbox"><label for="persist_box">ログインしたままにする</label>
                                    </div>
                                    <input type="hidden" name="default_persistent" value="1">
                                </div>
                            </td>
                            <td class="login_form_label_field">
                                <a rel="nofollow" href=""></a>
                            </td>
                        </tr>
                    </table>
                </span>
            </div>
        </div>
        <div id="content" class="edit">

            <?php echo $this->Session->flash(); ?>
            
            <?php
                //ログインエラーメッセージを表示
                echo $session->flash('auth');
            ?>          

            <?php echo $content_for_layout; ?>

        </div>
        <div id="footer">
            <div id="footer_wrap">

                <div id="ft_copyright">
                    
                </div>
                
                <div id="ft_link" class="clearfix">
<!--                     <a href="#" >良くあるご質問・FAQ</a>
                    <a href="#" id="btnsitemap">▲サイトマップ</a> -->
                </div>
            </div>
        </div>
    </div>
</html>
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
            
            //インプットホバーに色変化
            $('input').mouseover(function(){
                $(this).fadeTo(100,0.6);
            });
            $('input').mouseleave(function(){
                $(this).fadeTo(100,1.0);
            });            
            
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
<body>
	<div id="container">
		<div id="header">
		    <div id="header_width_define">
    			<h1><a href="<?= $this->webroot ?>users/login">Aratame</a></h1>
    			<span class="userinfo">
    			    <img class="avatar_header" src="<?= $this->webroot ?>img/usericon/<?= $user['User']['usericon'] ?>" width="20" height="20"/>
    			    <?= $user['User']['username']; ?>｜
    			    AP：<?= $user['User']['action_point']; ?>｜
    			    <img class="iconwhite" alt="" src="<?= $this->webroot ?>img/iconwhite/Award.png" height="15" /><?= $user['User']['ap_name']; ?>｜
    			    <a class="setting" href="#" onclick="return false;"><img class="iconwhite" alt="" src="<?= $this->webroot ?>img/iconwhite/setting.png" height="15" /></a>
    			    <ul class="hidden setting_item">
    			        <li><a href="<?= $this->webroot ?>users/pic_edit">ユーザーアイコンの編集</a></li>
    			        <li><a href="<?= $this->webroot ?>users/logout">ログアウト</a></li>
    			    </ul>
    			</span>
			</div>
		</div>
		<div id="content">

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
<!-- 	<?php echo $this->element('sql_dump'); ?></body> -->
</html>
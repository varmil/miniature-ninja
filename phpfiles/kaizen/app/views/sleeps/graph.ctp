<div id="graph_wrap">
<div id="oresen"  style="height:300px; width:600px;"></div><br />
<div id="oresen_controller" style="height: 100px; width: 570px;"></div>
<div id="bou"  style="height:300px; width:600px;"></div><br />
最近のあなたの平均睡眠時間：<?= round($average_user, 2) ?>時間<br />
最近のみんなの平均睡眠時間：<?= round($average_all_user, 2) ?>時間
<hr /><br />
睡眠記録の削除：日付<input id="datepicker_delete" type="text" /><div id="" class="button_delete button_suimin_delete delete" onclick="return confirm('本当に削除しますか？')">削除</div>
</div>


<script>
$(function(){
    
        //クリック時にグラフを読み込む
        var s1 = [ 
            <?php foreach ($sleeps as $sleep): ?>
                [" <?= h($sleep['Sleep']['date']) ?> ",
                " <?= h($sleep['Sleep']['syusin']) ?> " ],
            <?php endforeach; ?> 
        ];
        var s2 = [ 
            <?php foreach ($sleeps as $sleep): ?>
                [" <?= h($sleep['Sleep']['date']) ?> ",
                " <?= h($sleep['Sleep']['kisyou']) ?> " ],
            <?php endforeach; ?>         
        ];
        
        var s3 = [ [ '3時間未満', <?=$count_lessthan_3?> ], [ '3～4時間', <?=$count[3]?>  ], [ '4～5時間', <?=$count[4]?> ], [ '5～6時間', <?=$count[5]?> ], [ '6～7時間', <?=$count[6]?> ], [ '7～8時間', <?=$count[7]?> ], [ '8～9時間', <?=$count[8]?> ], [ '9～10時間', <?=$count[9]?> ], [ '10～11時間', <?=$count[10]?> ], [ '11～12時間', <?=$count[11]?> ], [ '12時間以上', <?=$count_morethan_12?> ] ];
        
        var s4 = [ 
            <?php foreach ($sleeps as $sleep): ?>
                [" <?= h($sleep['Sleep']['date']) ?> ",
                " <?= h($sleep['Sleep']['length']) ?> " ],
            <?php endforeach; ?> 
        ];        
       
        //折れ線グラフの記述
        targetPlot = $.jqplot('oresen', [ s1, s2 ], 
                //options
                {
                    axesDefaults: {
                    },
                    axes:{
                        xaxis:{
                            renderer: jQuery . jqplot . DateAxisRenderer,
                            tickInterval: '2 day',
                            autoscale: true,
                            max: '<?=date("Y-m-d", strtotime("+1 day")) ?>',
                            min: '<?=date("Y-m-d", strtotime("-14 day")) ?>',
                            tickOptions:  { 
                                formatString: '%#m/%#d%n%a',
                                showMark: true,
                            },
                        },                    
                        yaxis:{
                            renderer: jQuery . jqplot . DateAxisRenderer,
                            autoscale: true,
                            //ticks: [ "20:00", "23:59", "04:00", "08:00", "12:00", "16:00", "20:00" ],
                            tickOptions:  { 
                                formatString: '%R',
                                showMark: true,
                            },
                        }
                    },
                    animate: true,
                    seriesDefaults: {
                        pointLabels: {
                            show: true,
                            location: 's',
                        },
                        rendererOptions: {
                            smooth: true
                        },
                    },
                    series: [
                        { label: '就寝時間' },
                        { label: '起床時間' },
                    ],
                    legend: {
                        show: true,
                        placement: 'insideGrid',
                        location: 'sw',
                    },
                    cursor: {
                        show: true,
                        showTooltip: false,
                        zoom: true,
                    }
                }
        );
        //棒グラフの記述
        $.jqplot('bou', [ s3, s4 ], 
                //options
                {
                    series:[
                        {
                            renderer: jQuery . jqplot . BarRenderer,
                            label: '睡眠の長さ別分類',
                            pointLabels: false,
                        },
                        {
                            xaxis: 'x2axis',
                            yaxis: 'y2axis',
                            label: '睡眠時間の長さ',
                        }
                    ],
                    axes:{
                        xaxis:{
                            renderer: jQuery . jqplot . CategoryAxisRenderer,
                            autoscale: true,
                            tickOptions:  { 
                                showMark: true,
                                showGridline: false,
                            },
                        },
                        x2axis:{
                            renderer: jQuery . jqplot . DateAxisRenderer,
                            tickInterval: '2 day',
                            autoscale: true,
                            max: '<?=date("Y-m-d", strtotime("+1 day")) ?>',
                            min: '<?=date("Y-m-d", strtotime("-14 day")) ?>',
                            tickOptions:  { 
                                formatString: '%#m/%#d%n%a',
                                showMark: true,
                            },
                        },                   
                        yaxis:{
                            autoscale: true,
                            tickOptions:  { formatString: '%d', showLabel: true,},
                        },
                        y2axis:{
                            renderer: jQuery . jqplot . DateAxisRenderer,
                            autoscale: true,
                            min: '00:00',
                            max: '20:00',
                            tickInterval: '4 hour',
                            tickOptions:  { 
                                formatString: '%#H.%M',
                                showMark: true,
                            },
                        }
                    },
                    animate: true,
                    seriesDefaults: {
                        rendererOptions: {
                            barPadding: 8,
                            barMargin: 10,
                            barWidth: 20,
                            shadowOffset: 2,
                            shadowDepth: 5,
                            shadowAlpha: 0.08,
                        },
                        pointLabels: {
                            show: true,
                            location: 'n',
                        },
                    },
                    legend: {
                        show: true,
                        placement: 'insideGrid',
                        location: 'nw',
                    },                
                }
        );
        //コントロールパレット
        controllerPlot = jQuery . jqplot(
            'oresen_controller',
            [
                s1, s2
            ],
            {
                seriesDefaults: {
                    showMarker: false,
                    pointLabels: {
                        show: false,
                    },
                    rendererOptions: {
                        smooth: true
                    },
                },
                axes: {
                    xaxis: {
                        renderer: jQuery . jqplot . DateAxisRenderer,
                        tickOptions:  { 
                            formatString: '%#m/%#d週',
                            showMark: true,
                        },
                    },
                    yaxis: {
                        renderer: jQuery . jqplot . DateAxisRenderer,
                        autoscale: true,
                        tickOptions:  {showLabel: false}, 
                        min: "00:00",
                        max: "23:59",
                    }
                },
                cursor: {
                    show: true,
                    showTooltip: false,
                    zoom: true,
                    constrainZoomTo: 'x'
                }
            }
        );
        jQuery . jqplot . Cursor . zoomProxy( targetPlot, controllerPlot );        
        
        
    //睡眠記録の削除処理
    $('.button_suimin_delete').click(function(e) {
        var date = $('#datepicker_delete').val();
        //二重送信防止措置
        $('input').attr("disabled", "disabled");
        //ajaxでvalueを送信してDBに書き込み
        $.post("<?php echo Router::url(array('controller'=>'Sleeps','action'=>'delete_sleep')); ?>", {"date": date, }, function(res){
            //...callback処理
            if(res == 1) {
                //デフォルトレイアウト内にあるセーブ完了divを一定時間表示する
                $('div.save')
                    .show("normal", function() {$(this).delay(1100).hide(700)}); 
                //disabeldを解除して再度ボタンを利用可能にする
                $('input').removeAttr("disabled");    
                //グラフをもう一度読み込む           
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
                
                
            } else {
                alert("削除に失敗しました。時間をおいてお試し下さい");
                //disabeldを解除して再度ボタンを利用可能にする
                $('input').removeAttr("disabled");  
            }
        });        
    });          
        
        
        //スクロールバー表示
        $("#graph_wrap")
            .mCustomScrollbar({
              set_width:false, 
              set_height:false, 
              horizontalScroll:false, 
              scrollInertia:400, 
              scrollEasing:"easeOutCirc", 
              mouseWheel:20, 
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
        
    //カレンダーUI
    $('#datepicker_delete').datepicker({
        changeMonth: false,
        changeYear: false,
        dateFormat: 'yy-mm-dd',
        yearRange: '2012:2030',
    });        
        
});
</script>
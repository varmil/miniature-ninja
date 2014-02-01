<div id="edit_usericon">
    <h1><span>ユーザーアイコン画像の編集</span></h1>
    <h2 class="edit"><span>ユーザーアイコン画像の登録・変更・削除</span></h2>
    <table border="0" cellpadding="0" cellspacing="10" class="form_tbl mb5 edit">
                    <tbody>
                    <tr>
                        <th class="form_th">&nbsp;</th>
                        <td class="w50p">
                            現在の画像
                        </td>
                        <td class="form_td">
                            <img src="<?= $this->webroot ?>img/usericon/<?php echo $data['usericon']; ?>" alt="<?php echo $data['username']; ?>" width='100' />
                        </td>
                    </tr>
                    <tr>
                        <th class="form_th">&nbsp;</th>
                        <td class="w50p">
                            画像<br>
                            (200KB以下のjpg,gif,pngイメージ。正方形に近い画像をお勧めします。)
                        </td>
                        <td class="form_td">
                            <?php e($form->create(null, array('action' => 'pic_edit', 'type' => 'file', 'enctype' => "multipart/form-data"))); ?>
                            <input type="hidden" name="MAX_FILE_SIZE" value="200000" />
                            <?php e($form->file('usericon')); ?>
                            <span style="padding-left:200px;"><?php e($form->submit('　　登録・変更する　　')); ?></span>
                        </td>
                    </tr>                     
                    <tr>
                        <th class="form_th">&nbsp;</th>
                        <td class="w50p">
                            削除
                        </td>
                        <td class="form_td">
                            <span style="margin-left:160;"><?php e($form->submit('　　現在の画像を削除する　　', array('name' => 'del'))); ?></span>
                        </td>
                    </tr>      
                </tbody>
    </table>
    <?php e($form->end()); ?>
</div>
<div style="display:flex; flex-wrap:wrap;justify-content:space-around">
        <?
        foreach ($files as $file):
        $filePath=Yii::getAlias('@showImages').'/'.$file->name[0].'/'.$file->name;
        ?>
        <div>
        <a href="<?=$filePath?>" style="margin-right:10px"><img width="100px" height="100px" src="<?=$filePath?>" /></a>
        <div style="text-align:center"><a href="/file/download/<?=$file->fileId?>" >cкачать</a> <a href="/file/delete/<?=$file->fileId?>">удалить</a></div>
        </div>
        <? endforeach; ?>
</div>

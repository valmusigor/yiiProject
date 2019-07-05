<span style="color:red"><?=Yii::$app->request->get('error')?></span>
      <form action="/auth" method="POST">
        <input type="text" name="login" placeholder="enter login" value="<?=Yii::$app->request->get('login') ?>" />
        <input type="password" name="pass" placeholder="enter password" value="<?=Yii::$app->request->get('pass') ?>" />
        <input type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
        <button type="submit">Войти</button>
      </form> 
<a href="/register">Зарегистироваться</a> 

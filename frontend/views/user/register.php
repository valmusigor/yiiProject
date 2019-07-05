<span style="color:red"><?=Yii::$app->request->get('error')?></span>
      <form action="/auth/add" method="POST">
        <input type="text" name="login" placeholder="enter login" value="<?=Yii::$app->request->get('login') ?>" />
        <input type="password" name="pass" placeholder="enter password" value="<?=Yii::$app->request->get('pass') ?>" />
        <input type="email" name="email" placeholder="enter email" value="<?=Yii::$app->request->get('email') ?>" />
        <input type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
        <button type="submit">Зарегестрироваться</button>
      </form> 
<a href="/login">Войти</a>

<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;
use yii\captcha\Captcha;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>考试系统 - <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"> 考试系统 </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav pull-left">
                <li <?=Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index' ? 'class="active"' : ''?>><a href="/">首页</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 选择考试类型 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php if (isset($this->params['carTypes'])): ?>
                            <?php foreach ($this->params['carTypes'] as $value) : ?>
                                <li><a href="<?=Url::toRoute(['classification/index', 'id' => $value->id])?>"><?=$value->name?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php if (isset($this->params['menu']) && $this->params['menu']): ?>
                    <li class="active">
                        <a href="<?=$this->params['menu']['link']?>"><?=$this->params['menu']['title']?></a>
                    </li>
                <?php endif; ?>

                <li><a href="javascript:;" class="login no-login <?=Yii::$app->user->isGuest ? '' : 'hide'?>">登录</a></li>
                <li><a href="javascript:;" class="register no-login <?=Yii::$app->user->isGuest ? '' : 'hide'?>">注册</a></li>
                <li class="dropdown user-login <?=Yii::$app->user->isGuest ? 'hide' : ''?>">
                    <a href="#" class="dropdown-toggle user" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <img class="nav-user-photo" id="user-face" src="<?=Yii::$app->user->isGuest || ! Yii::$app->user->identity->face ? '/images/avatar.jpg' : Yii::$app->user->identity->face?>" alt="<?=Yii::$app->user->isGuest ? '' : (Yii::$app->user->identity->username ? Yii::$app->user->identity->username : Yii::$app->user->identity->email)?>">
                        <span class="user-info"><small>Welcome,</small> <span class="text-danger" id="username"><?=Yii::$app->user->isGuest ? '' : (Yii::$app->user->identity->username ? Yii::$app->user->identity->username : Yii::$app->user->identity->email)?></span></span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header"> 我的信息 </li>
                        <li><a href="<?=Url::toRoute(['question/warning', 'subject' => 1])?>"> 我的错题 </a></li>
                        <li><a href="<?=Url::toRoute(['user/collect', 'subject' => 1])?>"> 我的收藏 </a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">其他操作</li>
                        <li><a href="<?=Url::toRoute(['site/logout'])?>" class=""> 退出登录 </a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
<div class="container theme-showcase main" id="content" role="main">
    <div class="row">
        <div class="col-md-12">
            <?= $content ?>
        </div>
    </div>
</div> <!-- /container -->

<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="jkbd-width wid-auto">
                    <ul class="cl">
                        <li><a href="http://www.dd119.com" target="_blank" class="a-link">技术支持--湖南得大工程有限公司</a></li>
<!--                        <li class="bd-line"></li>-->
<!--                        <li class="fankui" data-item="feedback"><a href="/feedback" class="a-link">意见反馈</a></li>-->
                    </ul>
<!--                    <p>技术支持--湖南得大工程有限公司</p>-->
<!--                    <img class="a-wap a-dis icon" src="http://web.resource.mucang.cn/jiakaobaodian.web/jkbd/resources/images/public/gongan.png">-->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="login-dialog hide member-dialog" id="login-dialog">
    <div>
        <p class="tips normal"> 注册/登录后可保存做题进度 </p>
    </div>
    <div class="content-container">
        <form class="login-form form-horizontal user-form" id="login-form" action="<?=Url::toRoute(['site/login'])?>">
            <input type="hidden" value="<?= Yii::$app->getRequest()->getCsrfToken() ?>" name="_csrf" />
            <div class="form-group">
                <input name="username" class="i-username form-control" required="true" rangelength="[2, 100]" placeholder="请输入手机号 or 昵称" type="text" />
            </div>
            <div class="form-group">
                <input name="password" class="i-password form-control" required="true" rangelength="[6, 50]" placeholder="请输入您的密码" type="password" />
            </div>
            <div class="form-group">
                <button type="submit" class="submit btn btn-info">登 录</button>
            </div>
            <div class="form-group">
                <span class="show-span pull-left"><a href="javascript:;" class="register">立即注册</a></span>
            </div>
        </form>
    </div>
</div>

<div class="register-dialog member-dialog hide" id="register-dialog">
    <div>
        <p class="tips normal"> 注册/登录后可保存做题进度 </p>
    </div>
    <div class="content-container">
        <form class="register-form form-horizontal user-form" id="register-form" action="<?=Url::toRoute(['site/register'])?>">
            <input type="hidden" value="<?= Yii::$app->getRequest()->getCsrfToken() ?>" name="_csrf" />
            <div class="form-group">
                <input name="username" class="form-control" required="true" rangelength="[2, 100]" placeholder="请输入昵称" type="text">
            </div>
            <div class="form-group">
                <input name="phone" class="i-username form-control" required="true"  maxlength="11" minlength="11" placeholder="请输入手机号" type="text">
            </div>
            <div class="form-group">
                <input name="password" id="m-password" class="i-password form-control" required="true" rangelength="[6, 50]"  placeholder="请设置密码" type="password">
            </div>
            <div class="form-group">
                <input name="rePassword" class="form-control" required="true" rangelength="[6, 50]" equalTo="#m-password" placeholder="确认密码" type="password">
            </div>
            <div class="form-group">
                <div class="col-sm-6 pl-none">
                    <input name="verifyCode" class="captchaCode form-control pull-left" required="true" minlength="6" maxlength="6" placeholder="请输入图片验证码" type="text">
                </div>
                <div class="col-sm-6">
                    <?=Captcha::widget([
                        'name'          => 'captchaimg',
                        'captchaAction' => 'site/captcha',
                        'imageOptions'  => [
                            'id'    => 'captchaimg',
                            'title' => '换一个',
                            'alt'   => '换一个',
                            'style' => 'cursor:pointer;margin-left:25px;'
                        ],
                        'template' => '{image}'
                    ])?>
                </div>
            </div>
            <div class="form-group">
                <p class="other-tips">点击“注册”按钮，既表示你同意<a rel="nofollow" target="_blank" href="<?=Url::toRoute(['article/detail', 'id' => 1])?>">《用户协议》</a></p>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-info submit">立即注册</button>
            </div>
            <div class="form-group">
                <span class="show-span pull-left"><a href="javascript:;" class="login">有账号，去登录</a></span>
            </div>
        </form>
    </div>
</div>
<!--[if !IE]> -->
<script type="text/javascript">
    window.jQuery || document.write("<script src='/resource/js/jquery.min.js'>"+"<"+"/script>");
</script>
<!-- <![endif]-->
<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='/resource/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='/resource/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<?php $this->endBody() ?>
<?=$this->blocks['javascript']?>
<script>
    var message = '<?=Yii::$app->session->getFlash('error')?>';
    if (message) {
        layer.msg(message);
    }
</script>
</body>
</html>
<?php $this->endPage() ?>

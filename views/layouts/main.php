<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use mdm\admin\components\MenuHelper;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
    </head>
    <body>
		<?php $this->beginBody() ?>

		<?php
		NavBar::begin([
			'brandLabel' => 'УРАЛСИБ',
			'brandUrl' => Yii::$app->homeUrl,
			'options' => [
				'class' => 'navbar-inverse navbar-fixed-top',
			],
			'innerContainerOptions' => ['class' => 'container-fluid'],
		]);
		$items = MenuHelper::getAssignedMenu(Yii::$app->user->id, 2);
		if (Yii::$app->user->isGuest) {
			$items[] = ['label' => 'Login', 'url' => ['admin/user/login']];
		}
		echo Nav::widget([
			'options' => ['class' => 'navbar-nav navbar-left'],
			'items' => $items
			/*
			  [
			  ['label' => 'Home', 'url' => ['/site/index']],
			  ['label' => 'About', 'url' => ['/site/about']],
			  ['label' => 'Contact', 'url' => ['/site/contact']],
			  Yii::$app->user->isGuest ? (
			  ['label' => 'Login', 'url' => ['/site/login']]
			  ) : (
			  '<li>'
			  . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
			  . Html::submitButton(
			  'Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link']
			  )
			  . Html::endForm()
			  . '</li>'
			  ),
			  YII_ENV_DEV ? (['label' => 'Gii', 'url' => ['/gii']]) : '',
			  ],
			 * 
			 */
		]);
		NavBar::end();
		?>

		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-2">
					<?php
#var_dump(isset($this->params['LeftMenuItemsURL']));
					if (isset($this->params['LeftMenuItemsURL'])) {
						echo Nav::widget([
							'options' => ['class' => 'nav nav-pills nav-stacked'],
							'items' => $this->params['LeftMenuItemsURL'],
						]);
					}
					?>
				</div>
				<div class="col-xs-10">
					<!--					<div class="jumbotron">
										<!--	<h3><?= Html::encode($this->title) ?></h3>
										</div>-->
					<?= $content ?>
				</div>
			</div>    
		</div>

        <footer class="footer">
            <div class="container-fluid">
                <p class="pull-left">&copy; My Company <?= date('Y') ?> 
					<?= (Yii::$app->user->isGuest ? 'Guest' : Yii::$app->user->identity->username) ?></p>

                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

		<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>

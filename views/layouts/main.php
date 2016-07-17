<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;

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
    <body data-spy="scroll">
		<?php $this->beginBody() ?>
		<?= $this->render('@app/views/layouts/_navbar'); ?>

		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-2">
					<?= $this->render('@app/views/layouts/_leftmenu'); ?>
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

<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$controller = $this->context;
$menus = $controller->module->menus;
$route = $controller->route;
foreach ($menus as $i => $menu) {
	$menus[$i]['active'] = strpos($route, trim($menu['url'][0], '/')) === 0;
}
$this->params['LeftMenuItemsURL'] = $menus;
?>
<?php $this->beginContent('@app/views/layouts/main.php', ['LeftMenuItemsURL' => $menus]) ?>
<?= $content ?>
<?php

list(, $url) = Yii::$app->assetManager->publish('@mdm/admin/assets');
$this->registerCssFile($url . '/main.css');
$this->registerCssFile($url . '/list-item.css');
?>

<?php $this->endContent(); ?>

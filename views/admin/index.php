<?php
/** @var yii\web\View $this */

/** @var yii\data\ActiveDataProvider $dataProvider */


use app\models\Request;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
?>
<h1>Админ панель</h1>
<?= GridView::widget ([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'category.name',
        'user.name',
        'name',
        'description:ntext',
        [
            'class' => ActionColumn::className(),
            'urlCreator' => function ($action, Request $model, $key, $index, $column) {
                return Url::toRoute(['request/' . $action, 'id' => $model->id]);
            }
        ],
    ],
]); ?>

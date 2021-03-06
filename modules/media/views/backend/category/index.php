<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\datecontrol\DateControl;
use yii\helpers\StringHelper;
use common\models\User;
use modules\media\models\Category;
use common\helpers\Toolbar;

use common\access\AccessManager;

/* @var $this yii\web\View */
/* @var $searchModel modules\media\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
?>
<div class="media-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'sortable-table',
        ],
        'rowOptions' => function ($data) {
            return [ 'id' => $data->id ];
        },
        'filterModel' => $searchModel,
        'resizeStorageKey' => 'userGrid',
        'panel' => [
            'footer' => Html::tag('div', Toolbar::createButton(Yii::t('app', 'Add Category')), ['class' => 'pull-left'])
                . Toolbar::paginationSelect($dataProvider),
        ],
        'toolbar' => [
            Toolbar::toggleButton($dataProvider),
            Toolbar::refreshButton(),
            Toolbar::createButton(Yii::t('app', 'Add Category')),
            Toolbar::deleteButton(),
            Toolbar::showSelect(),
        ],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
            ],
            'id',
            'name',
            'slug',
            [
                'attribute' => 'user_id',
                'filter' => User::getList(),
                'value' => function ($data) {
                    return !empty($data->user) ? $data->user->username : null;
                },
            ],
            [
                'attribute' => 'description',
                'value' => function ($data) {
                    return StringHelper::truncate(strip_tags($data->description), 180, '...');
                },
            ],
            /*[
                'attribute' => 'visible',
                'filter' => Category::getVisibilityStatuses(),
                'format' => 'boolean',
            ],
            'created',
            'updated',*/
            [
                'attribute' => 'created',
                'options' => ['style'=>'width: 240px'],
                'filter' => Html::tag(
                    'div',
                    DateControl::widget([
                        'model' => $searchModel,
                        'attribute' => 'date_from',
                        'type' => DateControl::FORMAT_DATE,
                        'autoWidget' => [
                            'pickerButton' => false,
                        ],
                        'widgetOptions' => [
                            'layout' => '{remove}{input}',
                            'options' => ['placeholder' => Yii::t('app', 'From date')],
                        ],
                    ])
                    . DateControl::widget([
                        'model' => $searchModel,
                        'attribute' => 'date_to',
                        'type' => DateControl::FORMAT_DATE,
                        'autoWidget' => [
                            'pickerButton' => false,
                        ],
                        'widgetOptions' => [
                            'layout' => '{input}{remove}',
                            'options' => ['placeholder' => Yii::t('app', 'To date')],
                        ],
                    ]),
                    ['class' => 'date-range']
                ),
            ],
            [
                'attribute' => 'updated',
                'options' => ['style'=>'width: 240px'],
                'filter' => Html::tag(
                    'div',
                    DateControl::widget([
                        'model' => $searchModel,
                        'attribute' => 'date_upd_from',
                        'type' => DateControl::FORMAT_DATE,
                        'autoWidget' => [
                            'pickerButton' => false,
                        ],
                        'widgetOptions' => [
                            'layout' => '{remove}{input}',
                            'options' => ['placeholder' => Yii::t('app', 'From date')],
                        ],
                    ])
                    . DateControl::widget([
                        'model' => $searchModel,
                        'attribute' => 'date_upd_to',
                        'type' => DateControl::FORMAT_DATE,
                        'autoWidget' => [
                            'pickerButton' => false,
                        ],
                        'widgetOptions' => [
                            'layout' => '{input}{remove}',
                            'options' => ['placeholder' => Yii::t('app', 'To date')],
                        ],
                    ]),
                    ['class' => 'date-range']
                ),
            ],
            [
                'class' => 'common\components\Column\SetColumn',
                'attribute' => 'visible',
                'filter' => Category::getVisibilityStatuses(),
                'cssClasses' => [
                    Category::VISIBLE_YES => 'success',
                    Category::VISIBLE_NO => 'danger',
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'show' => function ($url, $model) {
                        if ($model->visible) {
                            $options = ['title' => Yii::t('app', 'Disable')];
                            $iconClass = 'glyphicon-unlock';
                        } else {
                            $options = ['title' => Yii::t('app', 'Enable')];
                            $iconClass = 'glyphicon-lock';
                        }
                        return Html::a('<span class="glyphicon ' . $iconClass . '"></span>', $url, $options);
                    },
                    'files' => function ($url, $model) {
                        $expandButton = Html::tag('span', '', ['class' => 'glyphicon glyphicon-list']);
                        return Html::a($expandButton, Url::to(['/media', 'MediaSearch' => ['parent_id' => $model->id]]), [
                            'title' => Yii::t('app', 'Files'),
                            'aria-label' => Yii::t('app', 'Files'),
                        ]);
                    }
                ],
                'template' => $this->render('@backend/views/layouts/_options', [
                    'options' => [
                        'update' => 'media.backend.default:' . AccessManager::UPDATE,
                        'files' => 'media.backend.default:' . AccessManager::UPDATE,
                        'show' => 'media.backend.default:' . AccessManager::VIEW,
                        'delete' => 'media.backend.default:' . AccessManager::DELETE
                    ],
                ]),
            ],
        ],
    ]); ?>

</div>

<?php

use jakim\ig\Url;
use app\modules\admin\components\grid\StatsColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var app\modules\admin\models\AccountSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var array $dailyDiff
 * @var array $monthlyDiff
 */

$this->title = 'Monitoring :: Accounts';
$this->params['breadcrumbs'][] = 'Monitoring';
$this->params['breadcrumbs'][] = 'Accounts';

/** @var \app\components\Formatter $formatter */
$formatter = Yii::$app->formatter;
?>
<div class="account-index nav-tabs-custom">

    <?= $this->render('_tabs') ?>

    <div class="tab-content table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                [
                    'attribute' => 'username',
                    'content' => function (\app\models\Account $model) {
                        $html = [];
                        $html[] = Html::a($model->displayName, ['account/dashboard', 'id' => $model->id]);
                        $html[] = Html::a('<span class="fa fa-external-link text-sm"></span>', Url::account($model->username), ['target' => '_blank']);

                        if ($model->is_private) {
                            $html[] = '<span class="fa fa-user-secret text-muted pull-right" title="is private"></span>';
                        }
                        if ($model->accounts_monitoring_level) {
                            $html[] = sprintf('<span class="fa fa-magic text-muted pull-right" title="monitoring level: %s"></span>', $model->accounts_monitoring_level);
                        }
                        if ($model->disabled) {
                            $html[] = '<span class="fa fa-exclamation-triangle text-danger pull-right" title="Not found."></span>';
                        }

                        return implode(" \n", $html);
                    },
                ],
                [
                    'class' => StatsColumn::class,
                    'attribute' => 'as_followed_by',
                    'statsAttribute' => 'followed_by',
                    'dailyDiff' => $dailyDiff,
                    'monthlyDiff' => $monthlyDiff,
                ],
                [
                    'class' => StatsColumn::class,
                    'attribute' => 'as_follows',
                    'statsAttribute' => 'follows',
                    'dailyDiff' => $dailyDiff,
                    'monthlyDiff' => $monthlyDiff,
                ],
                [
                    'class' => StatsColumn::class,
                    'attribute' => 'as_media',
                    'statsAttribute' => 'media',
                    'dailyDiff' => $dailyDiff,
                    'monthlyDiff' => $monthlyDiff,
                ],
                [
                    'class' => StatsColumn::class,
                    'attribute' => 'as_er',
                    'statsAttribute' => 'er',
                    'dailyDiff' => $dailyDiff,
                    'monthlyDiff' => $monthlyDiff,
                    'numberFormat' => [
                        'percent',
                        2,
                        ['sign' => false],
                    ],
                ],
                's_tags',
                [
                    'attribute' => 'as_created_at',
                    'label' => 'Updated At',
                    'format' => 'date',
                ],
                [
                    'attribute' => 'created_at',
                    'format' => 'date',
                ],
            ],
        ]); ?>

        <?= \app\modules\admin\widgets\CreateMonitoringModal::widget() ?>
        <?= \app\modules\admin\widgets\favorites\AddToModal::widget() ?>
    </div>
</div>

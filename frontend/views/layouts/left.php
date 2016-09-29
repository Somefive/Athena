<?php
use common\models\User;
/* @var User $user */
$user = Yii::$app->user->identity;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?=\yii\helpers\Html::img("@web/img/user/".$user->profile->gender.".jpg", ['class' => 'img-circle', 'alt' => 'User Image']);?>
            </div>
            <div class="pull-left info">
                <p><?=$user->username?></p>
                <a href="/site/validate">
                    <?php if(Yii::$app->user->can('Verified')): ?>
                        <i class="fa fa-circle text-success"></i> Verified
                    <?php else: ?>
                        <i class="fa fa-circle text-warning"></i> Unverified
                    <?php endif ?>
                </a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Home', 'options' => ['class' => 'header']],
                    ['label' => 'Dashboard', 'icon' => 'fa fa-tachometer', 'url' => ['/dashboard/']],
                    ['label' => 'Course', 'icon' => 'fa fa-book', 'url' => '#', 'items' => [
                        ['label' => 'Course List', 'icon' => 'fa fa-circle-o', 'url' => '/course/course-list',],
                        ['label' => 'My Courses', 'icon' => 'fa fa-circle-o', 'url' => '/course/my-courses',],
                    ]],
                    ['label' => 'Profile', 'icon' => 'fa fa-user', 'url' => ['/site/profile']],
                    ['label' => 'Students', 'icon' => 'fa fa-users', 'url' => ['/site/students'], 'visible' => Yii::$app->user->can('Teacher')],
                    ['label' => 'Course', 'options' => ['class' => 'header']],
                    ['label' => 'Materials', 'icon' => 'fa fa-file-text', 'url' => ['']],
                    ['label' => 'Compose', 'icon' => 'fa fa-pencil-square-o', 'url' => ['']],
                    ['label' => 'Communication', 'options' => ['class' => 'header']],
                    ['label' => 'Discussion', 'icon' => 'fa fa-wechat', 'url' => ['']],
                    ['label' => 'Wiki', 'icon' => 'fa fa-wikipedia-w', 'url' => ['']],
//                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
//                    [
//                        'label' => 'Same tools',
//                        'icon' => 'fa fa-share',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
//                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'fa fa-circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'fa fa-circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
//                        ],
//                    ],
                ],
            ]
        ) ?>

    </section>

</aside>

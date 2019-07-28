<?php

use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Menu;

Menu::macro('adminlteSubmenu', function ($submenuName) {
    return Menu::new ()->prepend('<a href="#">' . $submenuName . ' <i class="fa fa-angle-left pull-right"></i></a>')
        ->addParentClass('treeview')->addClass('treeview-menu');
});
Menu::macro('adminlteMenu', function () {
    return Menu::new ()
        ->addClass('sidebar-menu')->setAttribute('data-widget', 'tree');
});
Menu::macro('adminlteSeparator', function ($title) {
    return Html::raw($title)->addParentClass('header');
});

Menu::macro('adminlteDefaultMenu', function ($content) {
    return Html::raw('<i class="fa fa-link"></i><span>' . $content . '</span>')->html();
});

Menu::macro('sidebar', function () {
    return Menu::adminlteMenu()
        ->action('Admin\IndexController@index', '<i class="fa fa-home"></i><span>管理后台</span>')
        ->action('Admin\StockController@check', '<i class="fa fa-cubes"></i><span>库存盘点</span>')
        ->action('Admin\UserController@getList', '<i class="fa fa-user"></i><span>用户管理</span>')
        ->add(
            Menu::adminlteSubmenu('<i class="fa fa-gift"></i><span>商品管理</span>')
                ->action('Admin\CategoryController@getList', '<i class="fa fa-gift"></i><span>商品分类</span>')
                ->action('Admin\ProductController@getList', '<i class="fa fa-gift"></i><span>商品列表</span>')
                ->add(
                    Menu::adminlteSubmenu('<i class="fa fa-gift"></i><span>商品属性</span>')
                        ->action('Admin\AttributeController@getList', '<i class="fa fa-gift"></i><span>属性列表</span>')
                        ->action('Admin\AttributeController@getGroups', '<i class="fa fa-gift"></i><span>属性分类</span>')
                )
                ->action('Admin\ProductController@import', '<i class="fa fa-gift"></i><span>商品导入</span>')
                ->action('Admin\ReviewController@getList', '<i class="fa fa-comment"></i><span>商品评论</span>')
        )
        ->add(
            Menu::new ()->adminlteSubmenu('<i class="fa fa-shopping-cart"></i><span>订单管理</span>')
                ->action('Admin\OrderController@getList', '<i class="fa fa-shopping-cart"></i><span>订单列表</span>')
                ->action('Admin\OrderController@getTemp', '<i class="fa fa-shopping-cart"></i><span>临时订单</span>')
        )
        ->add(
            Menu::new ()->adminlteSubmenu('<i class="fa fa-file"></i><span>页面管理</span>')
                ->action('Admin\PageController@getList', '<i class="fa fa-file"></i><span>页面列表</span>')
                ->action('Admin\PageCategoryController@getList', '<i class="fa fa-file"></i><span>页面分类</span>')
                ->action('Admin\SettingController@terms', '<i class="fa fa-file"></i><span>Terms and Conditions</span>')
        )
        ->add(
            Menu::new ()->adminlteSubmenu('<i class="fa fa-cog"></i><span>网站设置</span>')
                ->action('Admin\SettingController@index', '<i class="fa fa-cog"></i><span>基本设置</span>')
                ->action('Admin\BannerController@getList', '<i class="fa fa-cog"></i><span>首页广告</span>')
                ->action('Admin\SettingController@paypal', '<i class="fa fa-cog"></i><span>Paypal设置</span>')
                ->action('Admin\SettingController@tracking', '<i class="fa fa-cog"></i><span>快递设置</span>')
        )
        ->setActiveFromRequest('/admin');
});

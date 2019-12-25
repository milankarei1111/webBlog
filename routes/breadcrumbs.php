<?php

//register: 靜態定義 寫法1:Home
Breadcrumbs::register('home', function($breadcrumbs){
    $breadcrumbs->push('主控台', route('home'), ['icon' => 'fa fa-fw fa-home']);
});

/*
//register: 靜態定義 寫法2:Home url 不使用icon
Breadcrumbs::register('home', function ($trail) {
    $trail->push('主控台', url('/home'));
});
*/

// Breadcrumbs::resource('articles', '文章', 'fa fa-fw fa-file');
Breadcrumbs::macro('resource', function ($name, $title, $icon = null, $field_name = 'title', $parent = null) {

    // 文章分類
    Breadcrumbs::for("$name.index", function ($trail) use ($name, $title, $icon, $parent) {
        if ($parent) $trail->parent($parent);
        $trail->push($title, route("$name.index"), ['icon' => $icon]);
    });

    // 文章目錄 > 新增
    Breadcrumbs::for("$name.create", function ($trail) use ($name){
        $trail->parent("$name.index");
        $trail->push('新增', route("$name.create"));
    });

    // 文章分類 > [Category Name]
    Breadcrumbs::for("$name.show", function ($trail, $model) use ($name, $field_name) {
        $trail->parent("$name.index");
        $trail->push($model->{$field_name}, route("$name.show", $model));
    });

    // 文章分類 > [Category Name] > 編輯
    Breadcrumbs::for("$name.edit", function ($trail, $model) use ($name) {
        $trail->parent("$name.index", $model);
        $trail->push('編輯', route("$name.edit", $model));
    });
});

// 用檔案減少 breadcrumbs.php 的負擔
foreach (glob(__DIR__.'/breadcrumbs/*.php') as $breadcrumbs) {
    include $breadcrumbs;
}

<?php
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
// Trang chủ
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Trang chủ', route('admin'));
});

// phòng ban (những dữ liều truyền vào có thể để rỗng tùy theo view)
Breadcrumbs::for('nameaccount', function ($trail, $message) {
    $trail->parent('home');
    $trail->push('Danh sách tài khoản', route('account.index',  ['message' => $message]));
});
?>
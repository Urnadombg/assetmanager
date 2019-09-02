<?php
// Home
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', '/');
});

Breadcrumbs::for('assets', function ($trail) {
    $trail->parent('home');
    $trail->push('Списък с активи', route('assets.index'));
});


// Home > About
Breadcrumbs::for('asset', function ($trail, $asset) {
    $trail->parent('assets');
    $trail->push($asset->title . ' ' . $asset->model . ' ' . $asset->serial, route('assets.show', $asset->id));
});

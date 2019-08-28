<?php
// Home
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('assets', function ($trail, $asset) {
    $trail->parent('home');
    $trail->push('Активи', route('assets.index'));
    $trail->push($asset->title . ' ' . $asset->model, route('assets.show', $asset->id));
});

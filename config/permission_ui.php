<?php

namespace Illuminate\Support\Facades;
use Illuminate\Support\Facades\Cache;


// Cache::put('uid', uniqid());



return [
    'middleware'        => ['web', 'auth'],
    'url_prefix'        => 'permissions1',
    'route_name_prefix' => 'permission_ui.',
];


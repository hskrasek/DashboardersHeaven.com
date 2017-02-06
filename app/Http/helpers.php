<?php

use Illuminate\Http;

function set_active_link($path, $active = '')
{
    return Request::is($path) ? $active : '';
}

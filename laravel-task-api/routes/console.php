<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment('Keep learning full stack development!');
})->purpose('Display an inspiring message');

<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('linuxpath:info', function () {
    $this->info('LinuxPath API - Laravel 11');
});

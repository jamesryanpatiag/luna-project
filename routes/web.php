<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Timeintimeout;

Route::post('/member/inOurOut', 'TimeInTimeOutController@inOrOut')->name('member.inOrOut');
Route::get('/', Timeintimeout::class)->name('timeintimeout');
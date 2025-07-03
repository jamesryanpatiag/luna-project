<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Timeintimeout;
use App\Livewire\Leavefiling;

Route::post('/member/inOurOut', 'TimeInTimeOutController@inOrOut')->name('member.inOrOut');
Route::get('/', Timeintimeout::class)->name('timeintimeout');
Route::get('/leave-filing', Leavefiling::class)->name('leavefiling');
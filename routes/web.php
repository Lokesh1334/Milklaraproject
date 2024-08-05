<?php

// routes/web.php
use App\Http\Controllers\MilkController;
use App\Http\Controllers\MemberController;

Route::get('/milk-entry', function () {
    $members = App\Models\Member::all();
    return view('milk_entry', ['members' => $members]);
});

Route::post('/milk-entry', [MilkController::class, 'store'])->name('milk.store');

Route::resource('members', MemberController::class);
// routes/web.php
Route::get('/test-sms', [MilkController::class, 'testSms']);
Route::get('/milk-entries', [MilkController::class, 'index']);
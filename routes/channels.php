<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Stream;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('stream.{id}', function ($user, $id) {
    return true;
});
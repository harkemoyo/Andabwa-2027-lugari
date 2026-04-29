<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Stream;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('stream.{id}', function ($user, $id) {
    // Basic auth: user must be logged in to view/host
    // Return an array to identify the user on the presence channel
    return ['id' => $user->id, 'name' => $user->name];
});
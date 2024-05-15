<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('conversations.{uuid}', function ($uuid) {
    // add your logic here
    return true;
});

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Admin extends Controller
{
    public $adminUser;

    public function __construct() {
        $this->adminUser = User::query()->where('role', '=', 'A');
    }

    public function notify($data) {
        $this->adminUser->notify($data);
    }
}

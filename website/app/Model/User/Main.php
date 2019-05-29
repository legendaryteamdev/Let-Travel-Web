<?php

namespace App\Model\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Main extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';

}
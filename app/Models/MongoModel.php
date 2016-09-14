<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class MongoModel extends Eloquent {

    protected $connection = 'mongodb';
}
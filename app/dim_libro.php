<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dim_libro extends Model
{
	 protected $connection = 'datawarehouse';
     protected $table='dim_libro';
}
	
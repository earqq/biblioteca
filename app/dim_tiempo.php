<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dim_tiempo extends Model
{
	 protected $connection = 'datawarehouse';
     protected $table='dim_tiempo';
}
	
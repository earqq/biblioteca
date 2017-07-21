<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dim_usuario extends Model
{
	 protected $connection ='datawarehouse';
     protected $table='dim_usuario';
}
	
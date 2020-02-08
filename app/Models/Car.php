<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
	protected $fillable = [
		'jenis', 'kapasitas', 'nopol', 'id_pegawai',
	];

	public $timestamps = true;
}
?>
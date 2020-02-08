<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
	protected $fillable = [
		'nama_peminjam', 'jenis_kelamin', 'alamat',
	];

	public $timestamps = true;
}
?>
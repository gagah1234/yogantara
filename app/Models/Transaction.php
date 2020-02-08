<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $fillable = [
		'tgl_transaksi', 'tgl_kembali', 'jml_transaksi', 'biaya', 'id_pegawai', 'id_mobil', 'id_supir', 'id_peminjaman',
	];

	public $timestamps = true;
}
?>
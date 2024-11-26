<?php

namespace App\Models;

use CodeIgniter\Model;

class Pelanggan extends Model
{
    protected $table            = 'pelanggan';
    protected $primaryKey       = 'id_pelanggan';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_pelanggan', 'alamat_pelanggan', 'no_telp'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

}
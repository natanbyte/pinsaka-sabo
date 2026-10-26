<?php

namespace App\Models;

use CodeIgniter\Model;

class LokasiSarprasModel extends Model
{
    protected $DBGroup       = 'default';
    protected $table         = 'lokasi_sarpras';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['nama_lokasi', 'kategori'];
}

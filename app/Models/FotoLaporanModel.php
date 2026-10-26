<?php

namespace App\Models;

use CodeIgniter\Model;

class FotoLaporanModel extends Model
{
    protected $DBGroup       = 'default';
    protected $table         = 'foto_laporan';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['laporan_id', 'nama_file', 'jenis'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
}

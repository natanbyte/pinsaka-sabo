<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup       = 'default';
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['nama_lengkap', 'nip', 'bagian_id', 'no_hp', 'email', 'password', 'role'];
    protected $useTimestamps = true;
}

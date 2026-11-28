<?php

namespace App\Models;

use CodeIgniter\Model;

class Tugas8MahasiswaModel extends Model
{
    protected $table            = 'mahasiswa_tugas8';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nim',
        'nama',
        'prodi',
        'ipk',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}

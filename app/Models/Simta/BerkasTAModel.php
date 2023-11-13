<?php

namespace App\Models\Simta;

use CodeIgniter\Model;

class BerkasTAModel extends Model
{
    protected $uuidFields       = ['id_berkas'];
    protected $table            = 'simta_berkas';
    protected $primaryKey       = 'id_berkas';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_berkas', 'nama_berkas', 'file_berkas', 'created_at', 'update_at'];
    protected $validationRules = [
        'id_berkas' => 'required'
    ];
    

    
}
<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Divisi;
use App\Models\Penilaian;

class Karyawan extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'karyawans';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['nik', 'nama', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'pendidikan', 'divisi_id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getDivisiIdAttribute($value)
    {
        $divisi = Divisi::find($value);
        $value = $divisi['nama'];
        return $value;
    }

    public function getJenisKelaminAttribute($value)
    {
        if ($value == 1){
            $value = 'laki-laki';
            return $value;
        } else {
            $value = 'perempuan';
            return $value;
        }
    }

    public function getPendidikanAttribute($value)
    {
        if ($value == 1){
            $value = 'SD';
            return $value;
        } elseif ($value == 2) {
            $value = 'SMP';
            return $value;
        } elseif ($value == 3) {
            $value = 'SMA';
            return $value;
        } elseif ($value == 4) {
            $value = 'S1/D.IV';
            return $value;
        } else {
            $value = 'S3';
            return $value;
        }
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function divisi()
    {
        return $this->belongsTo('App\Models\Divisi');    
    }

    public function penilaian()
    {
        return $this->belongsTo('App\Models\Penilaian');
    }

}

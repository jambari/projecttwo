<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Models\Karyawan;
use App\Models\Penilaian;

class Penilaian extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'penilaians';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
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
    public function getKaryawanAttribute($value) {
        $karyawan = Karyawan::find($value);
        $value = $karyawan->nama;
        return $value;
    }

    public function getTotalAttribute($value)
    {
        $k1 = $this->attributes['kedisiplinan'];
        $k2 = $this->attributes['loyalitas'];
        $k3 = $this->attributes['tanggungjawab'];
        $k4 = $this->attributes['kualitas'];
        $k5 = $this->attributes['kecepatan'];
        $k6 = $this->attributes['inisiatif'];
        $k7 = $this->attributes['mengatur'];
        $k8 = $this->attributes['kerjasama'];
        $value = $k1+$k2+$k3+$k4+$k5+$k6+$k7+$k8;
        $akhir = $value/8;
        $id = $this->attributes['id'];
        $total = Penilaian::find($id);
        $total->total = $value;
        $total->akhir = $akhir;
        $total->save();
        return $value;
    }

    //public function getAkhirAttribute($value) {
        // $k1 = $this->attributes['kedisiplinan'];
        // $k2 = $this->attributes['loyalitas'];
        // $k3 = $this->attributes['tanggungjawab'];
        // $k4 = $this->attributes['kualitas'];
        // $k5 = $this->attributes['kecepatan'];
        // $k6 = $this->attributes['inisiatif'];
        // $k7 = $this->attributes['mengatur'];
        // $k8 = $this->attributes['kerjasama'];
        // $value = ($k1+$k2+$k3+$k4+$k5+$k6+$k7+$k8)/8;
        // // $id = $this->attributes['id'];
        // // $akhir = Penilaian::find($id);
        // // $akhir->akhir = $value;
        // // $total->save();
        //return $value;
   // }

    public function getKriteriaAttribute($value) {
        $k1 = $this->attributes['kedisiplinan'];
        $k2 = $this->attributes['loyalitas'];
        $k3 = $this->attributes['tanggungjawab'];
        $k4 = $this->attributes['kualitas'];
        $k5 = $this->attributes['kecepatan'];
        $k6 = $this->attributes['inisiatif'];
        $k7 = $this->attributes['mengatur'];
        $k8 = $this->attributes['kerjasama'];
        $akhir = ($k1+$k2+$k3+$k4+$k5+$k6+$k7+$k8)/8;

        if ($akhir >= 4.1){
            $value = 'S.B';
            return $value;
        } elseif ($akhir >= 3.1 && $akhir <= 4){
            $value = 'B';
            return $value;
        } elseif ($akhir >= 2.1 && $akhir <= 3){
            $value = 'C';
            return $value;
        } elseif ($akhir >= 1.1 && $akhir <= 2){
            $value = 'K';
            return $value;
        } else {
            $value = 'T.B';
            return $value;
        }
        return $value;
    }

    // public function getVerifikasiAttribute($value) {
    //     if ($value) {
    //         $value = ' Terverifikasi';
    //         return $value;
    //     }
    //     if (!$value) {
    //         $value = 'Belum Terverifikasi';
    //         return $value;
    //     }
    // }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    //public function setTotalAttribute(Request $request)

    // public function setTotalAttribute(Request $request)
    // {
    //     $k1 = $request['kedisiplinan'];
    //     $k2 = $request['loyalitas'];
    //     $k3 = $request['tanggungjawab'];
    //     $k4 = $request['kualitas'];
    //     $k5 = $request['kecepatan'];
    //     $k6 = $request['inisiatif'];
    //     $k7 = $request['mengatur'];
    //     $k8 = $request['kerjasama'];
    //     $value = $k1+$k2+$k3+$k4+$k5+$k6+$k7+$k8;
    //     $this->attributes['total'] = $value;
    // }

    // public function setAkhirAttribute($value) {
    //     $k1 = $this->attributes['kedisiplinan'];
    //     $k2 = $this->attributes['loyalitas'];
    //     $k3 = $this->attributes['tanggungjawab'];
    //     $k4 = $this->attributes['kualitas'];
    //     $k5 = $this->attributes['kecepatan'];
    //     $k6 = $this->attributes['inisiatif'];
    //     $k7 = $this->attributes['mengatur'];
    //     $k8 = $this->attributes['kerjasama'];
    //     $value = ($k1+$k2+$k3+$k4+$k5+$k6+$k7+$k8)/8;
    //     return $value;
    // }
    public function karyawan()
    {
        return $this->hasMany('App\Models\Karyawan');
    }


}

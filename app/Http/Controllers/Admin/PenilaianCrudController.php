<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PenilaianRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PenilaianCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PenilaianCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Penilaian::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/penilaian');
        CRUD::setEntityNameStrings('penilaian', 'penilaian');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
        $this->crud->addColumns(['tahun', 'karyawan','kedisiplinan','loyalitas','tanggungjawab','kualitas', 'kecepatan',
        'inisiatif', 'mengatur', 'kerjasama', 'total', 'akhir', 'kriteria']);
        $this->crud->setColumnDetails('kedisiplinan', ['label' =>'K1']);
        $this->crud->setColumnDetails('loyalitas', ['label' =>'K2']);
        $this->crud->setColumnDetails('tanggungjawab', ['label' =>'K3']);
        $this->crud->setColumnDetails('kualitas', ['label' =>'K4']);
        $this->crud->setColumnDetails('kecepatan', ['label' =>'K5']);
        $this->crud->setColumnDetails('inisiatif', ['label' =>'K6']);
        $this->crud->setColumnDetails('mengatur', ['label' =>'K7']);
        $this->crud->setColumnDetails('kerjasama', ['label' =>'K8']);
        $this->crud->setColumnDetails('total', ['label' =>'Nilai Total']);
        $this->crud->setColumnDetails('akhir', ['label' =>'Nilai Akhir']);

        $this->crud->enableExportButtons();
        $this->crud->orderBy('total', 'desc');
        if (backpack_user()->hasRole('pimpinan')) {
        $this->crud->removeButton('delete');
        }
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PenilaianRequest::class);

        //CRUD::setFromDb(); // fields

        $this->crud->addField([
            'name' => 'tahun',
            'label' => 'Penilaian Tahun',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'label'     => "Karyawan",
            'type'      => 'select2',
            'name'      => 'karyawan', // the db column for the foreign key

            // optional
            'entity'    => 'karyawan', // the method that defines the relationship in your Model
            'model'     => "App\Models\Karyawan", // foreign key model
            'attribute' => 'nama', // foreign key attribute that is shown to user
            // 'default'   => 2, // set the default value of the select2

                // also optional
            'options'   => (function ($query) {
                    return $query->orderBy('nama', 'asc')->get();
                }), 
        ]);

        $this->crud->addField([   // select_from_array
            'name'        => 'kedisiplinan',
            'label'       => "K1 KEDISIPLINAN",
            'type'        => 'select_from_array',
            'options'     => ['5' => 'A/5 = Selalu mentaati Peraturan,Perintah Kedinasan dan selalu ditempat kerja, tidak pernah absen',
             '4' => 'B/4 = Pada umumnya mentaati Peraturan, Perintah Kedinasan dan absen tidak berada ditempat kerja hanya bila ada alasan yang sangat penting',
             '3'=>'C/3 = Kurang mentaati Peraturan, Perintah Kedinasan dan sesekaliabsen tidak berada ditempat kerja atau terlambat',
             '2'=>'D/2 = Mengabaikan Peraturan, Perintah Kedinasan dan sering terlambat tidak berada ditempat kerja/absen',
             '1' =>'E/1 = Tidak mentaati Peraturan, Perintah Kedinasan dan sering terlambat tidak berada ditempat kerja/absen'],
            'allows_null' => false,
            'default'     => '5',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([   // select_from_array
            'name'        => 'loyalitas',
            'label'       => "K2 LOYALITAS",
            'type'        => 'select_from_array',
            'options'     => [
             '5' => 'A/5 = Tekun dan bersemangat dalam bekerja',
             '4' => 'B/4 = Cukup tekun dalam bekerja',
             '3'=>'C/3 = Masih ada ketekunan dalam Pekerjaannya',
             '2'=>'D/2 = Kurang menekuni pekerjaannya',
             '1' =>'E/1 = Malas bekerja'],
            'allows_null' => false,
            'default'     => '5',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([   // select_from_array
            'name'        => 'tanggungjawab',
            'label'       => "K3 TANGGUNGJAWAB PEKERJAAN",
            'type'        => 'select_from_array',
            'options'     => [
             '5' => 'A/5 = Sangat dan dapat diandalkan, Pengabdian pada tugasnya',
             '4' => 'B/4 = Pengabdian pada Pekerjaan umumnya baik',
             '3'=>'C/3 = Pengabdian pada Tugas Pekerjaan cukup baik',
             '2'=>'D/2 = Kadang-kadang melalaikan Tugas Pekerjaannya',
             '1' =>'E/1 = Sering melalaikan Tugas Pekerjaannya'],
            'allows_null' => false,
            'default'     => '5',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([   // select_from_array
            'name'        => 'kualitas',
            'label'       => "K4 KUALITAS/MUTU PEKERJAAN",
            'type'        => 'select_from_array',
            'options'     => [
             '5' => 'A/5 = Selalu tepat tanpa memerlukan petunjuk dan kontrol dalam pencapaiannya',
             '4' => 'B/4 = Pada umumnya tepat petunjuk dan control dalam pencapaiannya sangat minim',
             '3'=>'C/3 = Mencapai kebutuhan normal dan Pekerjaannya memerlukan sedikit petunjuk dan koreksi',
             '2'=>'D/2 = Kurang memenuhi standart normal dari Pekerjaannya memerlukan banyak petunjuk',
             '1' =>'E/1 = Tidak memenuhi kriteria minimum hanya mampu bekerja dengan petunjuk dan control'],
            'allows_null' => false,
            'default'     => '5',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([   // select_from_array
            'name'        => 'kecepatan',
            'label'       => "K5 KECEPATAN KERJA DAN KETERAMPILAN",
            'type'        => 'select_from_array',
            'options'     => [
             '5' => 'A/5 = Cekatan sekali dalam melaksanakan Pekerjaannya',
             '4' => 'B/4 = Dapat menyelesaikan Pekerjaannya dengan cepat',
             '3'=>'C/3 = Dapat menyelesaikan Tugas pada waktunya',
             '2'=>'D/2 = Kadang-kadang agak lambat menyelesaikan Pekerjaannya',
             '1' =>'E/1 = Kerja sangat lambat'],
            'allows_null' => false,
            'default'     => '5',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([   // select_from_array
            'name'        => 'inisiatif',
            'label'       => "K6 INISIATIF DAN KREATIFITAS",
            'type'        => 'select_from_array',
            'options'     => [
             '5' => 'A/5 = Aktif berusaha dan berinisiatif dalam melakukan tugasnya',
             '4' => 'B/4 = Pada umumnya mempunyai inisiatif dalam melakukan tugasnya',
             '3'=>'C/3 = Kadang kala mau berinisiatif dalam melakukan tugasnya',
             '2'=>'D/2 = Perlu didorong untuk melakukan tugasnya',
             '1' =>'E/1 = Pasif dan selalu didorong untuk melakukan pekerjaan'],
            'allows_null' => false,
            'default'     => '5',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([   // select_from_array
            'name'        => 'mengatur',
            'label'       => "K7 KEMAMPUAN MENGATUR DAN MELAKSANAKAN PEKERJAAN",
            'type'        => 'select_from_array',
            'options'     => [
             '5' => 'A/5 = Pekerjaan berjalan lancar dan ada keseimbangan kerja sesuai dengan rencana',
             '4' => 'B/4 = Perencanaan kerja ada tetapi kadang-kadang kontrolnya kurang',
             '3'=>'C/3 = Sesekali waktu pekerjaan tidak berjalan dengan lancar',
             '2'=>'D/2 = Kadang-kadang pekerjaan terlambat dan sering tertunda sehingga mengganggu pekerjaan berikutnya',
             '1' =>'E/1 = Tidak memenuhi kriteria minimum hanya mampu bekerja dengan petunjuk dan control'],
            'allows_null' => false,
            'default'     => '5',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([   // select_from_array
            'name'        => 'kerjasama',
            'label'       => "K8 HUBUNGAN KERJASAMA",
            'type'        => 'select_from_array',
            'options'     => [
             '5' => 'A/5 = Selalu dapat bekerja sama, ringan tangan',
             '4' => 'B/4 = Pada umumnya dapat bekerja sama dan mau membantu rekan sekerja',
             '3'=>'C/3 = Cukup dapat bekerja sama dan mau membantu rekan sekerja bila diminta',
             '2'=>'D/2 = Kurang dapat bekerja sama',
             '1' =>'E/1 = Tidak dapat bekerja sama'],
            'allows_null' => false,
            'default'     => '5',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);
        if (backpack_user()->hasRole('pimpinan')) {
            $this->crud->addField([
                'name'  => 'verifikasi',
                'label' => 'verifikasi',
                'type'  => 'boolean',
                // optionally override the Yes/No texts
                'options' => [0 => 'belum diverifikasi', 1 => 'terverifikasi']
            ]);

        }


        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}

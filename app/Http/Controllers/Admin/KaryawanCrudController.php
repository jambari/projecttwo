<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\KaryawanRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class KaryawanCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class KaryawanCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Karyawan::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/karyawan');
        CRUD::setEntityNameStrings('karyawan', 'karyawan');
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
        //$this->crud->addColumns(['nik', 'nama', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'pendidikan', 'divisi']);
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
        $this->crud->setColumnDetails('nik',['label'=>'NIK']);
        if (backpack_user()->hasRole('pimpinan')) {
            $this->crud->removeButton('update');
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
        CRUD::setValidation(KaryawanRequest::class);

        //CRUD::setFromDb(); // fields
            $this->crud->addField([
            'name' => 'nik',
            'type' => 'text',
            'label' => "NIK"
        ]);

        $this->crud->addField(
            [
                'name'  => 'nama',
                'label' => 'Nama',
                'type'  => 'text'
            ]
        );

        $this->crud->addField(
            [
                'name'  => 'jenis_kelamin',
                'label' => 'Jenis Kelamin',
                'type'  => 'select_from_array',
                'options'   => ['1' => 'Laki-laki', '2' => 'Perempuan'],
                'default'   => '1'
            ]
        );

        $this->crud->addField(
            [
                'name'  => 'tempat_lahir',
                'label' => 'Tempat Lahir',
                'type'  => 'text'
            ]
        );

        $this->crud->addField(
            [
                'name'  => 'tanggal_lahir',
                'label' => 'Tanggal Lahir',
                'type'  => 'date'
            ]
        );

        $this->crud->addField(
            [
                'name'  => 'pendidikan',
                'label' => 'Pendidikan Terakhir',
                'type'  => 'select_from_array',
                'options'   => ['1' => 'SD', '2' => 'SMP', '3'=>'SMA', '4' => 'S1/D.IV', '5' => 'S2', '6'=>'S3'],
                'default'   => '4'
            ]
        );

        $this->crud->addField([
            'label'     => "Divisi",
            'type'      => 'select2',
            'name'      => 'divisi_id', // the db column for the foreign key

            // optional
            'entity'    => 'divisi', // the method that defines the relationship in your Model
            'model'     => "App\Models\Divisi", // foreign key model
            'attribute' => 'nama', // foreign key attribute that is shown to user
            // 'default'   => 2, // set the default value of the select2

                // also optional
            'options'   => (function ($query) {
                    return $query->orderBy('nama', 'asc')->get();
                }), 
        ]);

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

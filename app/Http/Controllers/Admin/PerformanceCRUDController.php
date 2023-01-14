<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PerformanceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PerformanceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PerformanceCRUDController extends CrudController
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
        CRUD::setModel(\App\Models\Performance::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/performance');
        CRUD::setEntityNameStrings('performance', 'performances');
    }

    /**
     * Define what happens when the Show operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-show
     * @return void
     */
    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        $this->crud->addColumns($this->getConfig(true));
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumns($this->getConfig(true, false));
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PerformanceRequest::class);

        $this->crud->addFields($this->getConfig());
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::setValidation(PerformanceRequest::class);

        $this->crud->addFields($this->getConfig());
    }

    /**
     * Get backpack configuration.
     *
     * @return array
     */
    private function Config( $show = FALSE)
    {
        return [
            [
                'name' => 'name',
                'label' => 'Name Of Performance',
                'type' => 'text',
            ],

            [
                'name' => 'performance_date',
                'label' => 'Performance Date',
                'type' => 'datetime',
            ],

            [
                'name' => 'venue_id',
                'label' => 'Venue',
                'type' => 'text',
            ],

            [
                'label' => "Article Image",
                'name' => "image",
                'type' => ($show ? 'view' : 'upload'),
                'view' => 'partials/image',
                'upload' => true,
            ],

            [
                'label' => 'Venue', // Label for HTML form field
                'type' => 'select',  // HTML element which displaying transactions
                'name' => 'venue_id', // Table column which is FK for Customer table
                'entity' => 'venue', // Function (method) in Customer model which return transactions
                'attribute' => 'location', // Column which user see in select box
                'model' => 'App\Models\Venue' // Model which contain FK
            ],


        ];
    }
}

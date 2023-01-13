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
    private function getConfig(bool $isReadOnly = false, $displayPoster = true)
    {
        $config = [
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
                'name' => 'tickets',
                'label' => 'Tickets',
                'type' => $isReadOnly ? 'select' : 'select_multiple',
                'attribute' => 'type',
                'pivot' => 'true',
            ],
        ];

        if ($displayPoster) {
            $config[] = [
                'label' => "Poster",
                'name' => "poster",
                'type' => $isReadOnly ? 'view' : 'upload',
                'view' => 'partials/poster_preview',
                'upload' => true,
            ];
        }

        return $config;
    }
}

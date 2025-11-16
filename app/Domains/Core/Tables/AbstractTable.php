<?php
namespace Core\Tables;

use Core\Request\AbstractRequest;
use Core\Services\AbstractService;
use PowerComponents\LivewirePowerGrid\{Exportable, Footer, Header, PowerGridComponent};

class AbstractTable extends PowerGridComponent
{
    public string $sortDirection = 'desc';
    //Custom per page
    public int $perPage = 10;
    
    //Custom per page values
    public array $perPageValues = [10, 20, 50, 100, 500];

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            // Exportable::make('export')
            //     ->striped()
            //     ->type(Exportable::TYPE_CSV),
            Header::make()
                ->showSearchInput(),
            Footer::make()
                ->showPerPage($this->perPage, $this->perPageValues)
                ->showRecordCount(),
        ];
    }
}
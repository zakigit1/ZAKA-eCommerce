<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendorListDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('status', function($query){
                
            $checked = ($query->status == 'active') ? 'checked' : '';

            $Status_button ='
                <label  class="custom-switch mt-2" >
                        <input type="checkbox" name="custom-switch-checkbox" 
                        class="custom-switch-input  change-status"
                        data-id="'.$query->id.'"
                        '.$checked.'>
                    <span class="custom-switch-indicator" ></span>
                </label>';

            return $Status_button;
        })
        ->addColumn('shop_name',function($query){
            
                return $query->vendor->shop_name ;
            
        })

        ->filterColumn('shop_name',function($query , $keyword){
            $query->whereHas('vendor',function($query) use($keyword){
                $query->where('shop_name','like',"%$keyword%");
            });
        })

        ->rawColumns(['status'])
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->where('role','vendor')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('shop_name'),
            Column::make('status'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorList_' . date('YmdHis');
    }
}

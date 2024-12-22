<?php

namespace App\DataTables;


use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CustomerListDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            /** Start Custom Columns : */
            
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
            /** End Custom Columns : */

            /** Start Filtring : */
            ->filterColumn('status',function($query , $keyword){
                if($keyword == '1' || strtolower($keyword) == 'active'){
                    $query->where('status','active');
                }elseif($keyword == '0' || strtolower($keyword) == 'inactive'){
                    $query->where('status','inactive');
                }else{
                    $query->where('status','like',"%$keyword%");
                }
            })
            /** End Filtring : */

            
            ->rawColumns(['status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->where('role','user')->newQuery();
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
            Column::make('status'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'CustomerList_' . date('YmdHis');
    }
}

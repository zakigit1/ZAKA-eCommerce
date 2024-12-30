<?php

namespace App\DataTables;


use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AdminListDataTable extends DataTable
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
            
            ->addColumn('action', function($query){

                $delete_btn='<a class="btn btn-danger delete-item-with-ajax"  href="'.route("admin.admin-list.destroy",$query->id).'"><i class="fas fa-trash-alt"></i></a>';
                if($query->id != 21 || $query->id != 1){ // change it to id = 1 
                    return $delete_btn;   
                }

            })

            ->addColumn('status', function($query){
                    
                $checked = ($query->status == 'active') ? 'checked' : '';
                // make id just 1 for admin and change this code to button be hidden for admin id 1
                $Status_button ='
                    <label  class="custom-switch mt-2" style="display: '.($query->id == 1 || $query->id == 21 ? 'none' : '').';" >
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
            
            
            ->rawColumns(['status','action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        // return $model->where('id','!=',1)->where('role','admin')->newQuery();
        return $model->where('id','!=',21)->where('role','admin')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('adminlist-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0, 'asc')
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
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AdminList_' . date('YmdHis');
    }
}

<?php

namespace App\DataTables;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SlidersDataTable extends DataTable
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
                $user_role='admin';
                $type='slider';
                return view('Backend.DataTable.yajra_datatable_columns.action_button',['query'=>$query,'type'=>$type,'role'=>$user_role]);
            })

            ->addColumn('banner', function($query){
                
                $columnName='banner';
                return view('Backend.DataTable.yajra_datatable_columns.image',['query'=>$query,'columnName'=>$columnName]);
            })

            ->addColumn('status',function($query){

                $active='<i class="badge badge-success">Active</i>';
                $inactive='<i class="badge badge-danger">Inactive</i>';

                return ($query->status) ? $active : $inactive ;
                
            })

            ->addColumn('price',function($query){
                return currencyIcon().$query->starting_price;
            })
            /** End Custom Columns : */


            /** Start Filtring : */
            ->filterColumn('price',function($query , $keyword){
                $keyword = str_replace(currencyIcon(), '', $keyword);
                $query->where('starting_price','like',"%$keyword%");
            })

            ->filterColumn('status',function($query , $keyword){
                $query->where('status','like',"%$keyword%");
            })
            /** End Filtring : */


            ->rawColumns(['status'])//if you add in this file html code you need to insert the column name inside (rawColumns)
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Slider $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('sliders-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0,'desc')//0 mean the table index in our table the zero is id (always) , exp '1' is icons
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
            Column::make('id')->width(100),
            Column::make('banner')->width(200),
            Column::make('title'),
            Column::make('serial'),
            Column::make('price')->width(100),
            Column::make('status'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(200)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Sliders_' . date('YmdHis');
    }
}

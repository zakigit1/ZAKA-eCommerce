<?php

namespace App\DataTables;

use App\Models\Childcategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ChildcategoriesDataTable extends DataTable
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
                $type='child-category';
                return view('Backend.DataTable.yajra_datatable_columns.action_button',['query'=>$query,'type'=>$type,'role'=>$user_role]);
            })

            ->addColumn('status',function($query){

                $checked = ($query->status) ? 'checked' : '';

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

            ->addColumn('category',function($query){
                $categoryName =$query->category->name;
                return $categoryName;
            })

            ->addColumn('sub_category',function($query){
                $subcategoryName =$query->subcategory->name;
                return $subcategoryName;
            })
            /** End Custom Columns : */


            /** Start Filtring : */
            ->filterColumn('category',function($query , $keyword){
                $query->whereHas('category',function($query) use($keyword){
                    $query->where('name','like',"%$keyword%");
                });
            })

            ->filterColumn('sub_category',function($query , $keyword){
                $query->whereHas('subcategory',function($query) use($keyword){
                    $query->where('name','like',"%$keyword%");
                });
            })

            ->filterColumn('status',function($query , $keyword){
                $query->where('status','like',"%$keyword%");
            })

            /** End Filtring : */


            ->rawColumns(['status',])//if you add in this file html code you need to insert the column name inside (rawColumns)
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Childcategory $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('childcategories-table')
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
            Column::make('name')->width(200),
            Column::make('slug')->width(200),
            Column::make('status')->width(200),
            Column::make('category')->width(200),//custom column
            Column::make('sub_category')->width(200),//custom column
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
        return 'Childcategories_' . date('YmdHis');
    }
}

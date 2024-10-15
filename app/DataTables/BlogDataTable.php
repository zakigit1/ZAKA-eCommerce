<?php

namespace App\DataTables;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BlogDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function($query){
            $user_role='admin';
            $type='blog';
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

        ->addColumn('image',function($query){
            
            $columnName="image";
            return view('Backend.DataTable.yajra_datatable_columns.image',['query'=>$query,'columnName'=>$columnName]);
            
            
        })

        ->addColumn('user_name',function($query){
            return $query->user->name;
        })

        ->addColumn('publish_date',function($query){
            return date('d M Y',strtotime($query->created_at));
        })


        ->addColumn('category',function($query){
            return $query->blogcategory->name;
        })

        // Filtring : 

        ->filterColumn('user_name',function($query , $keyword){
            $query->whereHas('user',function($query) use($keyword){
                $query->where('name','like',"%$keyword%");
            });
        })

        ->filterColumn('category',function($query , $keyword){
            $query->whereHas('blogcategory',function($query) use($keyword){
                $query->where('name','like',"%$keyword%");
            });
        })
        
        ->filterColumn('publish_date', function ($query, $keyword) {
            $query->where('created_at','like',"%$keyword%");
        })
 
        ->rawColumns(['status','action'])//if you add in this file html code you need to insert the column name inside (rawColumns)
        ->setRowId('id',);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Blog $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('blogs-table')
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
            Column::make('image'),
            Column::make('title'),
            Column::make('user_name'),
            Column::make('category'),

            Column::make('publish_date'),
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
        return 'Blog_' . date('YmdHis');
    }
}

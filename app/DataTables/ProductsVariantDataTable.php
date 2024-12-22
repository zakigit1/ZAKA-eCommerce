<?php

namespace App\DataTables;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductsVariantDataTable extends DataTable
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
                $type='product-variant';

                $variant_items_buttom ='<a class="btn btn-info ml-4" href="'.route("$user_role.product-variant-item.index",['productId'=>request()->id,'variantId'=>$query->id]).'"><i class="fas fa-sitemap"></i> '.$query->name.' Items </a>';

                return view('Backend.DataTable.yajra_datatable_columns.action_button',['query'=>$query,'type'=>$type,'role'=>$user_role]).$variant_items_buttom;
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
            /** End Custom Columns : */


            /** Start Filtring : */
            ->filterColumn('status',function($query , $keyword){
                $query->where('status','like',"%$keyword%");
            })
            /** End Filtring : */

            
            ->rawColumns(['status','action'])//if you add in this file html code you need to insert the column name inside (rawColumns)
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductVariant $model): QueryBuilder
    {
        return $model->where('product_id',request()->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('product_variants-table')
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
                Column::make('id')->width(80),

                Column::make('name'),

                Column::make('status'),
    
                Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(300)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ProductsVariant_' . date('YmdHis');
    }
}

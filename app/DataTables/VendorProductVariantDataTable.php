<?php

namespace App\DataTables;

use App\Models\ProductVariant;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

use Yajra\DataTables\Services\DataTable;

class VendorProductVariantDataTable extends DataTable
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
                $user_role='vendor';
                $type='product-variant';

                $variant_items_buttom ='<a class="btn btn-info  variant-item"  href="'.route("$user_role.product-variant-item.index",['productId'=>request()->id,'variantId'=>$query->id]).'"><i class="fas fa-sitemap"></i> '.$query->name.' Items </a>';

                return view('Backend.DataTable.yajra_datatable_columns.action_button',['query'=>$query,'type'=>$type,'role'=>$user_role]).$variant_items_buttom;
            })

            ->addColumn('status',function($query){

                $checked = ($query->status) ? 'checked' : '';

                $Status_button ='<div class="form-check form-switch">
                                    <input type="checkbox" 
                                        class="form-check-input change-status" 
                                        data-id="'.$query->id.'" 
                                        role="switch" 
                                        id="flexSwitchCheckDefault"
                                        '.$checked.'
                                    >
                                </div>';
                return $Status_button;  
                
            })

            /** Start Filtring : */
            /** Start Filtring : */


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
                    ->setTableId('vendorproductvariant-table')
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
        return 'VendorProductVariant_' . date('YmdHis');
    }
}

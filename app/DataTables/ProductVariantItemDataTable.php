<?php

namespace App\DataTables;

use App\Models\ProductVariantItem;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductVariantItemDataTable extends DataTable
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
                $type='product-variant-item';//name route

                return view('Backend.DataTable.yajra_datatable_columns.action_button',['query'=>$query,'type'=>$type,'role'=>$user_role]);
                // return '<a class="btn btn-primary" href="'.route("admin.$type.edit",[$query->id,'productId'=,'productId'=>]).'"><i class="fas fa-edit"></i></a>
                // <a class="btn btn-danger ml-2  delete-item-with-ajax"  href="'.route("admin.$type.destroy",$query->id).'"><i class="fas fa-trash-alt"></i></a>';
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

            ->addColumn('is_default',function($query){

                $Yes='<i class="badge badge-success">default</i>';
                $No='<i class="badge badge-danger">No</i>';
                return ($query->is_default) ? $Yes : $No ;
                
            })

            ->addColumn('price',function($query){
                return currencyIcon().$query->price;
            })

            /** Start Filtring : */

            ->filterColumn('status',function($query , $keyword){
                $query->where('status','like',"%$keyword%");
            })
            
            ->filterColumn('is_default',function($query , $keyword){
                if (strtolower($keyword) == 'default') {
                    $query->where('is_default',1);
                } elseif (strtolower($keyword) == 'no') {
                    $query->where('is_default',0);
                } else {
                    $query->where('is_default','like',"%$keyword%");
                }
            })

            ->filterColumn('price',function($query , $keyword){
                $keyword = str_replace(currencyIcon(), '', $keyword);
                $query->where('price','like',"%$keyword%");
            })

            /** End Filtring : */

            ->rawColumns(['status','is_default'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductVariantItem $model): QueryBuilder
    {
        return $model->where('product_variant_id',request()->variantId)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('product_variant_items-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
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
            Column::make('price'),
            Column::make('is_default'),
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
        return 'ProductVariantItem_' . date('YmdHis');
    }
}

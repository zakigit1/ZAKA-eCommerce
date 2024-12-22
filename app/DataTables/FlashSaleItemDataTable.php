<?php

namespace App\DataTables;

use App\Models\FlashSaleItem;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FlashSaleItemDataTable extends DataTable
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
                            
                $delete_btn='<a class="btn btn-danger delete-item-with-ajax"  href="'.route("admin.flash-sale.destroy",$query->id).'"><i class="fas fa-trash-alt"></i></a>';
                return $delete_btn;
            })

            ->addColumn('show_at_home',function($query){
                
                $checked = ($query->show_at_home) ? 'checked' : '';

                $Show_at_home_button ='
                    <label  class="custom-switch mt-2" >
                            <input type="checkbox" name="custom-switch-checkbox" 
                            class="custom-switch-input  change-at-home-status"
                            data-id="'.$query->id.'"
                            '.$checked.'>
                        <span class="custom-switch-indicator" ></span>
                    </label>';

                return $Show_at_home_button;          
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

            ->addColumn('product',function($query){
            //   $product=Product::find($query->product_id)  ;
            //     return $product->name;
            
            //   return $query->product->name;
            return '<a href="'.route('admin.product.edit',$query->product->id).'">'.$query->product->name.'</a>';
            })

            ->addColumn('End Date',function($query){
            return $query->flashSale->end_date;
            })
            /** End Custom Columns : */

            
            /** Start Filtring : */
            ->filterColumn('product',function($query , $keyword){
                $query->whereHas('product',function($query) use($keyword){
                    $query->where('name','like',"%$keyword%");
                });
            })
 
            ->filterColumn('End Date',function($query , $keyword){
                $query->whereHas('flashSale',function($query) use($keyword){
                    $query->whereDate('end_date','like',"%$keyword%");
                });
            })

            ->filterColumn('show_at_home',function($query , $keyword){
                $query->where('show_at_home','like',"%$keyword%");
            })

            ->filterColumn('status',function($query , $keyword){
                $query->where('status','like',"%$keyword%");
            })
            /** End Filtring : */


            ->rawColumns(['status','action','show_at_home','product'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(FlashSaleItem $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('flashsaleitem-table')
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
            Column::make('id')->width(100),
            Column::make('product'),
            Column::make('End Date'),
            Column::make('show_at_home'),
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
        return 'FlashSaleItem_' . date('YmdHis');
    }
}

<?php

namespace App\DataTables;

use App\Models\Product;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VendorProductDataTable extends DataTable
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
                $user_role='vendor';
                
                $type='product';
                $moreFeature=
                        '<!-- Default dropstart button -->
                            <div class="btn-group dropstart">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-cog"></i>
                                </button>

                                <ul class="dropdown-menu">
                                    <!-- Dropdown menu links -->
                                <li><a class="dropdown-item has-icon" href="'.route("$user_role.product-image-gallery.index",['id'=>$query->id]).'"><i class="fas fa-images"></i>  Image Gallery</a></li>
                                <li><a class="dropdown-item has-icon" href="'.route("$user_role.product-variant.index",['id'=>$query->id]).'"><i class="fas fa-list-ul"></i>  Product Variant</a></li>
                                </ul>
                            </div>';






                return view('Backend.DataTable.yajra_datatable_columns.action_button',['query'=>$query,'type'=>$type,'role'=>$user_role]).$moreFeature;
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
            ->addColumn('price',function($query){

                return currencyIcon().$query->price;
                
            })
            ->addColumn('image',function($query){
                
                $columnName="thumb_image";
                
                return view('Backend.DataTable.yajra_datatable_columns.image',['query'=>$query,'columnName'=>$columnName]);
                
            })
            ->addColumn('type',function($query){

                switch ($query->product_type) {
                    case 'new_arrival':
                    return '<i class="badge bg-success">New Arrival</i>';
                        break ;
                    case 'featured_product':
                    return '<i class="badge bg-warning">Featured</i>';
                        break;
                    case 'top_product':
                    return '<i class="badge bg-info">Top</i>';
                        break;
                    case 'best_product':
                        return'<i class="badge bg-danger">Best</i>';
                        break;
                    
                    default:
                        return'<i class="badge bg-dark">None</i>';
                        break;
                }

            })
            ->addColumn('approved',function($query){
                if($query->is_approved === 1){
                    return '<i class="badge bg-success">Approved</i>';
                }else{
                    return '<i class="badge bg-warning">Pending</i>';
                }
            })
            /** End Custom Columns : */

            
            /** Start Filtring : */
            ->filterColumn('status',function($query , $keyword){
                $query->where('status','like',"%$keyword%");
            })

            ->filterColumn('price',function($query , $keyword){
                $keyword = str_replace(currencyIcon(), '', $keyword);
                $query->where('price','like',"%$keyword%");
            })

            ->filterColumn('type',function($query , $keyword){
                switch (strtolower($keyword)) {
                    case 'new_arrival':
                        $query->where('product_type','new_arrival');
                        break;
                    case 'featured_product':
                        $query->where('product_type','featured_product');
                        break;
                    case 'top_product':
                        $query->where('product_type','top_product');
                        break;
                    case 'best_product':
                        $query->where('product_type','best_product');
                        break;
                    default:
                        $query->where('product_type','like',"%$keyword%");
                        break;
                }

            })

            ->filterColumn('approved',function($query , $keyword){
                if (strtolower($keyword) == 'approved') {
                    $query->where('is_approved',1);
                } elseif (strtolower($keyword) == 'pending') {
                    $query->where('is_approved',0);
                } else {
                    $query->where('is_approved','like',"%$keyword%");
                }
            })
            /** End Filtring : */

            
            ->rawColumns(['status','action','type','approved'])//if you add in this file html code you need to insert the column name inside (rawColumns)
            ->setRowId('id',);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        
        
        return $model->where('vendor_id',auth()->user()->vendor->id)->newQuery();

        // return $model->whereHas('vendor', function ($query) {
        //     $query->where('user_id', auth()->user()->id);   
        // })
        // ->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendorproduct-table')
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
            Column::make('name'),
            Column::make('price'),
            Column::make('approved'),
            Column::make('type')->width(150),
            Column::make('status'),

            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(320)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorProduct_' . date('YmdHis');
    }
}

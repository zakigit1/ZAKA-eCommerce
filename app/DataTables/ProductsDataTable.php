<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductsDataTable extends DataTable
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
                $type='product';
                $moreFeature='
                        <div class="dropdown dropleft d-inline ">
                        <button class="btn btn-primary dropdown-toggle ml-2" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cog"></i>
                        </button>

                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <a class="dropdown-item has-icon" href="'.route('admin.product-image-gallery.index',['id'=>$query->id]).'"><i class="fas fa-images"></i>  Image Gallery</a>
                            <a class="dropdown-item has-icon" href="'.route('admin.product-variant.index',['id'=>$query->id]).'"><i class="fas fa-list-ul"></i> Product Variant</a>
                        </div>
                        </div>';

                return view('Backend.DataTable.yajra_datatable_columns.action_button',['query'=>$query,'type'=>$type,'role'=>$user_role]).$moreFeature;
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

            ->addColumn('price',function($query){
                //currencyIcon() function in helper file : 
                return currencyIcon().$query->price;
                
            })

            ->addColumn('image',function($query){
                
                $columnName="thumb_image";
                return view('Backend.DataTable.yajra_datatable_columns.image',['query'=>$query,'columnName'=>$columnName]);
                
                
            })
            
            ->addColumn('type',function($query){

                switch ($query->product_type) {
                    case 'new_arrival':
                    return '<i class="badge badge-success">New Arrival</i>';
                        break ;
                    case 'featured_product':
                    return '<i class="badge badge-warning">Featured</i>';
                        break;
                    case 'top_product':
                    return '<i class="badge badge-info">Top</i>';
                        break;
                    case 'best_product':
                        return'<i class="badge badge-danger">Best</i>';
                        break;
                    
                    default:
                        return'<i class="badge badge-dark">None</i>';
                        break;
                }

            })
    

            /** Start Filtring : */
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

            ->filterColumn('status',function($query , $keyword){
                $query->where('status','like',"%$keyword%");
            })

            /** End Filtring : */


            
            ->rawColumns(['status','action','type'])//if you add in this file html code you need to insert the column name inside (rawColumns)
            ->setRowId('id',);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        
        return $model->where('vendor_id',auth()->user()->vendor->id)->newQuery();

        //? same method : 

        //* return $model->whereHas('vendor', function ($query) {
        //*     $query->where('user_id', auth()->user()->id);   
        //* })
        //* ->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('products-table')
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
            Column::make('id'),
            Column::make('image'),
            Column::make('name'),
            Column::make('price'),
            Column::make('type')->width(150),
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
        return 'Products_' . date('YmdHis');
    }
}

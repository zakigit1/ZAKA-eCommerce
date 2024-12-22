<?php

namespace App\DataTables;

use App\Models\ProductReview;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VendorProductReviewDataTable extends DataTable
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
            ->addColumn('status',function($query){

                $active='<i class="badge bg-success">Approved</i>';
                
                $inactive='<i class="badge bg-warning">Pending</i>';
                return ($query->status) ? $active : $inactive ;
            })
            ->addColumn('product',function($query){
                
                return '<a href ="'.route('product-details', $query->product->slug).'">'.$query->product->name.'</a>';
            })
            ->addColumn('rating',function($query){
                switch ($query->rating) {
                    case 1:
                        return '<i class="fas fa-star"></i>';
                        break;

                    case 2:
                        for($i = 0 ; $i<=1 ;$i++){
                            $stars [] = '<i class="fas fa-star"></i>' ;
                        };
                        return str_replace(',','',implode(',',$stars));
                        break;
                    case 3:
                        
                        for($i = 0 ;$i <= 2 ;$i++){
                            $stars [] = '<i class="fas fa-star"></i>' ;
                        };
                        return str_replace(',','',implode(',',$stars));
                        break;

                        // return '<i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>';
                        // break;
                        
                    case 4:
                        for($i = 0 ;$i <= 3 ;$i++){
                            $stars [] = '<i class="fas fa-star"></i>' ;
                        };
                        return str_replace(',','',implode(',',$stars));
                        break;

                    case 5:
                        for($i = 0 ;$i <=4 ;$i++){
                            $stars [] = '<i class="fas fa-star"></i>' ;
                        };
                        return str_replace(',','',implode(',',$stars));
                        break;

                    default:
                        return'<i class="far fa-star"></i>';
                        break;
                }
            })
            ->addColumn('client',function($query){
                return $query->user->name;
            })
            /** End Custom Columns : */


            /** Start Filtring : */
            ->filterColumn('product',function($query , $keyword){
                $query->whereHas('product',function($query) use($keyword){
                    $query->where('name','like',"%$keyword%");
                });
            })
 
            ->filterColumn('client',function($query , $keyword){
                $query->whereHas('user',function($query) use($keyword){
                    $query->where('name','like',"%$keyword%");
                });
            })

            ->filterColumn('rating',function($query , $keyword){
                $query->where('rating','like',"%$keyword%");
            })
            /** End Filtring : */


            ->rawColumns(['status','rating','product'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductReview $model): QueryBuilder
    {
        return $model->where('vendor_id',auth()->user()->vendor->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('product_reviews-table')
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
            Column::make('id')->width(10),
            Column::make('client'),
            Column::make('product'),
            Column::make('rating'),
            Column::make('review'),
            Column::make('status')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorProductReview_' . date('YmdHis');
    }
}

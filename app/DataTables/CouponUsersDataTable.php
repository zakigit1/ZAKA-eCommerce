<?php

namespace App\DataTables;

use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CouponUsersDataTable extends DataTable
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

            ->addColumn('user_name', function($query){  
                return $query->user->name;
            })
            
            ->addColumn('coupon_name', function($query){  
                return $query->coupon->name;
            })

            ->addColumn('max_use', function($query){  
                return $query->coupon->max_use;
            })

            ->addColumn('used', function($query){ 
                return ($query->coupon->max_use - $query->available_use);
            })

            
            
            ->addColumn('coupon_code', function($query){  
                return $query->coupon->code;
            })
            
            
            /** End Custom Columns : */
            
            /** Start Filtring : */

            ->filterColumn('coupon_code',function($query , $keyword){
                $query->whereHas('coupon',function($query) use($keyword){
                    $query->where('code','like',"%$keyword%");
                });
            })

            ->filterColumn('coupon_name',function($query , $keyword){
                $query->whereHas('coupon',function($query) use($keyword){
                    $query->where('name','like',"%$keyword%");
                });
            })

            ->filterColumn('user_name',function($query , $keyword){
                $query->whereHas('user',function($query) use($keyword){
                    $query->where('name','like',"%$keyword%");
                });
            })


            /** End Filtring : */

            
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(CouponUser $model): QueryBuilder
    {
        return $model->where('coupon_id', $this->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('couponusers-table')
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
            Column::make('id')->width(50),

            Column::make('user_name'),
            Column::make('coupon_name'),
            Column::make('coupon_code'),
            Column::make('used'),
            Column::make('available_use'),
            Column::make('max_use'),


        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'CouponUsers_' . date('YmdHis');
    }
}

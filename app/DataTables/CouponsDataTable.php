<?php

namespace App\DataTables;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CouponsDataTable extends DataTable
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
                $type='coupons';
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

            ->addColumn('discount_type',function($query){

                $percent='<i class="badge badge-success">Percentage (%)</i>';
                $amount='<i class="badge badge-warning">Amount('.currencyIcon().')</i>';
                return ($query->discount_type == 'percent') ? $percent : $amount ;  
            })

            ->addColumn('discount',function($query){

                return ($query->discount_type == 'percent') ? ($query->discount.'%') : (currencyIcon().$query->discount)  ;  
            })

            ->addColumn('coupon_code',function($query){
                return $query->code;
            })


            /** Start Filtring : */
                        
            ->filterColumn('status',function($query , $keyword){
                $query->where('status','like',"%$keyword%");
            })

            ->filterColumn('coupon_code',function($query , $keyword){
                $query->where('code','like',"%$keyword%");
            })

            ->filterColumn('discount_type',function($query , $keyword){
                if (strtolower($keyword) == 'percentage')
                    $query->where('discount_type','percent');
                elseif (strtolower($keyword) == 'amount')
                    $query->where('discount_type','amount');
            })

            ->filterColumn('discount',function($query , $keyword){
                $keyword = str_replace(currencyIcon(), '', $keyword);
                $query->where('discount','like',"%$keyword%");
            })

            ->filterColumn('coupon_code',function($query , $keyword){
                $query->where('code','like',"%$keyword%");
            })

        
                        
            /** End Filtring : */


            ->rawColumns(['status','discount_type'])//if you add in this file html code you need to insert the column name inside (rawColumns)
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Coupon $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('coupons-table')
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
            Column::make('name'),
            Column::make('coupon_code'),
            Column::make('discount_type'),
            Column::make('discount'),
            Column::make('start_date'),
            Column::make('end_date'),
            Column::make('status'),
            
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(150)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Coupons_' . date('YmdHis');
    }
}

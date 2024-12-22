<?php

namespace App\DataTables;

use App\Models\WithdrawRequest;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VendorWithdrawDataTable extends DataTable
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

                $action="
                    <a class='btn btn-primary' href='".route('vendor.withdraw.show',$query->id)."'><i class='fas fa-eye'></i></a>
                ";

                return $action;
            })

            ->addColumn('withdraw_mehtod',function($query){

                return $query->method['name'];
                    
            })

            ->addColumn('total_amount',function($query){

                return currencyIcon().$query->total_amount;
                    
            })

            ->addColumn('withdraw_amount',function($query){

                return currencyIcon().$query->withdraw_amount;
                    
            })

            ->addColumn('withdraw_charge',function($query){

                return $query->withdraw_charge .'%';
                    
            })
            
            ->addColumn('status',function($query){
                if($query->status == 'paid'){
                    return '<i class="badge bg-success">Paid</i>';
                }elseif($query->status == 'pending'){
                    return '<i class="badge bg-warning">Pending</i>';
                }elseif($query->status == 'decline'){
                    return '<i class="badge bg-danger">decline</i>';
                    // return '<i class="badge bg-danger">canceled</i>';
                    
                }
            })
            /** End Custom Columns : */

            /** Start Filtring : */
            ->filterColumn('withdraw_charge',function($query , $keyword){
                $query->where('withdraw_charge','like',"%$keyword%");
            })


            ->filterColumn('withdraw_mehtod',function($query , $keyword){
                $query->whereHas('method',function($query) use($keyword){
                    $query->where('name','like',"%$keyword%");
                });
            })

            ->filterColumn('status',function($query , $keyword){
                if (strtolower($keyword) == 'paid') {
                    $query->where('status','paid');
                } elseif (strtolower($keyword) == 'pending') {
                    $query->where('status','pending');
                } elseif (strtolower($keyword) == 'decline') {
                    $query->where('status','decline');
                } else {
                    $query->where('status','like',"%$keyword%");
                }
            })

            ->filterColumn('total_amount',function($query , $keyword){
                $keyword = str_replace(currencyIcon(), '', $keyword);
                $query->where('total_amount','like',"%$keyword%");
            })

            ->filterColumn('withdraw_amount',function($query , $keyword){
                $keyword = str_replace(currencyIcon(), '', $keyword);
                $query->where('withdraw_amount','like',"%$keyword%");
            })
            /** End Filtring : */


            ->rawColumns(['status','action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(WithdrawRequest $model): QueryBuilder
    {
        return $model->where('vendor_id',auth()->user()->vendor->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendorwithdraw-table')
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

            Column::make('withdraw_mehtod'),
            Column::make('total_amount'),
            Column::make('withdraw_amount'),
            Column::make('withdraw_charge'),
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
        return 'VendorWithdraw_' . date('YmdHis');
    }
}

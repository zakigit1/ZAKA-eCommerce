<?php

namespace App\DataTables;

use App\Models\WithdrawRequest;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WithdrawRequestListDataTable extends DataTable
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

                $action="
                    <a class='btn btn-primary' href='".route('admin.withdraw-request-list.show',$query->id)."'><i class='fas fa-eye'></i></a>
                ";

                return $action;
            })

            ->addColumn('vendor_name',function($query){

                return $query->vendor->shop_name;
                    
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

            // ->addColumn('status',function($query){

            //     return "<select class='form-control change_withrow_status' data-id= $query->id>
            //         <option ".($query->status == 'pending' ? 'selected' : '')." value='pending'> Pending </option>
            //         <option ".($query->status == 'paid' ? 'selected' : '')." value='paid'> Paid </option>
            //         <option ".($query->status == 'decline' ? 'selected' : '')." value='decline'> Decline </option>
            //     </select>";
                
            // })

            ->addColumn('status',function($query){
                if($query->status == 'paid'){
                    return '<i class="badge badge-success">Paid</i>';
                }elseif($query->status == 'pending'){
                    return '<i class="badge badge-warning">Pending</i>';
                }elseif($query->status == 'decline'){
                    return '<i class="badge badge-danger">decline</i>';
                    // return '<i class="badge bg-danger">canceled</i>';
                    
                }
            })
            ->addColumn('withdrawal_request_date', function($query){
                return  date('M d ,Y',strtotime($query->created_at));
            })


            ########Filtring
            ->filterColumn('withdraw_mehtod',function($query , $keyword){
                $query->whereHas('method',function($query) use($keyword){
                    $query->where('name','like',"%$keyword%");
                });
            })
            ->filterColumn('vendor_name',function($query , $keyword){
                $query->whereHas('vendor',function($query) use($keyword){
                    $query->where('shop_name','like',"%$keyword%");
                });
            })


            ->filterColumn('withdrawal_request_date', function ($query, $keyword) {
                $query->where('created_at','like',"%$keyword%");
            })

            /** Start Filtring : */
            /** End Filtring : */


            ->rawColumns(['status','action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(WithdrawRequest $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('withdrawrequestlist-table')
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

            Column::make('vendor_name'),
            Column::make('withdraw_mehtod'),
            Column::make('total_amount'),
            Column::make('withdraw_amount'),
            Column::make('withdraw_charge'),
            Column::make('withdrawal_request_date'),
            Column::make('status')->with(150),

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
        return 'WithdrawRequestList_' . date('YmdHis');
    }
}

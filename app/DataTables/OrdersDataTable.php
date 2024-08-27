<?php

namespace App\DataTables;

use App\Models\GeneralSetting;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
{

    protected $currencyIcon;
    public function __construct(){
        $this->currencyIcon = GeneralSetting::first()->currency_icon;
    }
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
                $type='order';

                $actions='
                <a class="btn btn-primary href="'.route('admin.order.show',$query->id).'"><i class="fas fa-eye"></i></a>
                <a class="btn btn-danger ml-2  delete-item-with-ajax  href="'.route('admin.order.destroy',$query->id).'"><i class="fas fa-trash-alt"></i></a>
                <a class="btn btn-warning ml-2  href="'.route('admin.order.change-status',$query->id).'"><i class="fas fa-truck"></i></a>
                ';

                return $actions;

                // return view('Backend.DataTable.yajra_datatable_columns.action_button',['query'=>$query,'type'=>$type,'role'=>$user_role]) . $order_status;
            })
            ->addColumn('amount', function($query){
                return  $this->currencyIcon . $query->amount;
            })
            ->addColumn('date', function($query){
                return  date('Y-m-d',strtotime($query->created_at));
            })
            ->addColumn('order_status', function($query){
                /** we need to modify this we can use switch better  */

                $pending='<i class="badge badge-warning">pending</i>';
                // $No='<i class="badge badge-danger">No</i>';

                return ($query->order_status == 'pending') ? $pending : '' ;
            })
            // ->addColumn('status',function($query){
                    
            //         $checked = ($query->order_status) ? 'checked' : '';
        
            //         $Status_button ='
            //             <label  class="custom-switch mt-2" >
            //                     <input type="checkbox" name="custom-switch-checkbox" 
            //                     class="custom-switch-input  change-status"
            //                     data-id="'.$query->id.'"
            //                     '.$checked.'>
            //                 <span class="custom-switch-indicator" ></span>
            //             </label>';
        
            //         return $Status_button;
    
    
                
            // })

            ->rawColumns(['status','order_status','action'])//if you add in this file html code you need to insert the column name inside (rawColumns)
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('orders-table')
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
            Column::make('invoice_id')->width(100),
            Column::make('date'),
            Column::make('product_qty'),
            Column::make('amount'),
            Column::make('order_status'),
            Column::make('payment_method'),
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
        return 'Orders_' . date('YmdHis');
    }
}

<?php

namespace App\DataTables;

use App\Models\CanceledOrder;
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

class CanceledOrderDataTable extends DataTable
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

                $actions="
                <a class='btn btn-success' href='".route('admin.order.show',$query->id)."'><i class='fas fa-eye'></i></a>
                <a class='btn btn-danger ml-2  delete-item-with-ajax'  href='".route('admin.order.destroy',$query->id)."'><i class='fas fa-trash-alt'></i></a>
                ";

                return $actions;
            })
            ->addColumn('amount', function($query){
                $currencyIcon = GeneralSetting::first()->currency_icon;
                return  $currencyIcon . $query->amount;
            })
            ->addColumn('date', function($query){
                return  date('Y-m-d',strtotime($query->created_at));
            })
            ->addColumn('payment_status', function($query){
               
                if($query->payment_status == 1){
                   return '<i class="badge badge-success">Complete</i>';
                }else{ 
                    return '<i class="badge badge-warning">Pending</i>';
                }    
            })
            ->addColumn('order_status',function($query){

                switch ($query->order_status) {
                    case 'pending':
                        return '<i class="badge badge-warning">Pending</i>';
                         break;

                    case 'processed_and_ready_to_ship':
                       return '<i class="badge badge-info">Processing</i>';
                        break;
                    case 'dropped_off':
                        return'<i class="badge badge-info">Dropped Off</i>';
                        break;   
                        
                    case 'shipped':
                        return'<i class="badge badge-info">Shipped</i>';
                        break;

                    case 'out_for_delivery':
                        return'<i class="badge badge-light">Out For Delivery</i>';
                        break;

                    case 'delivered':
                       return '<i class="badge badge-success">Delivered</i>';
                        break ;
                    case 'canceled':
                       return '<i class="badge badge-danger">Canceled</i>';
                        break ;

                    default:
                        return'<i class="badge badge-dark">None</i>';
                        break;
                }
            })
            ->rawColumns(['order_status','action','payment_status'])//if you add in this file html code you need to insert the column name inside (rawColumns)
            ->setRowId('id');
    }
    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        return $model->where('order_status','canceled')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('canceledorder-table')
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
            Column::make('invoice_id')->width(150),
            Column::make('date'),
            Column::make('product_qty'),
            Column::make('amount'),
            Column::make('order_status'),
            Column::make('payment_status'),
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
        return 'CanceledOrder_' . date('YmdHis');
    }
}

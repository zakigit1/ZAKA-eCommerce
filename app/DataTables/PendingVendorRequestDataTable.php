<?php

namespace App\DataTables;


use App\Models\Vendor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PendingVendorRequestDataTable extends DataTable
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
                <a class='btn btn-primary' href='".route('admin.vendor-request.show',$query->id)."'><i class='fas fa-eye'></i></a>
                ";

                return $action;
            })

            ->addColumn('user_name', function($query){
                return $query->user->name;
            })

            ->addColumn('shop_email', function($query){
                return $query->email;
            })

            ->addColumn('status', function($query){
                if($query->status == 1){
                    return '<i class="badge badge-success">Approved</i>';
                }else{
                    return '<i class="badge badge-warning">Pending</i>';
                }
            })

            
            /** Start Filtring : */
            ->filterColumn('user_name',function($query , $keyword){
                $query->whereHas('user',function($query) use($keyword){
                    $query->where('name','like',"%$keyword%");
                });
            })

            ->filterColumn('shop_email',function($query , $keyword){
                $query->where('email','like',"%$keyword%");
            })

            ->filterColumn('status',function($query , $keyword){
                $query->where('status','like',"%$keyword%");
            })
            /** End Filtring : */

            
            ->rawColumns(['status','action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Vendor $model): QueryBuilder
    {
        return $model->where('status',0)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pendingvendorrequest-table')
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
            Column::make('user_name'),
            Column::make('shop_name'),
            Column::make('shop_email'),
            Column::make('status'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PendingVendorRequest_' . date('YmdHis');
    }
}

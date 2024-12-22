<?php

namespace App\DataTables;


use App\Models\WithdrawMethod;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WithdrawMethodDataTable extends DataTable
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
                $user_role='admin';
                $type='withdraw-method';
                return view('Backend.DataTable.yajra_datatable_columns.action_button',['query'=>$query,'type'=>$type,'role'=>$user_role]);
            })

            ->addColumn('minimum_amount', function($query){
                return currencyIcon() . $query->minimum_amount;
            })

            ->addColumn('maximum_amount', function($query){
                return currencyIcon() . $query->maximum_amount;
            })

            ->addColumn('withdraw_charge', function($query){
                return   $query->withdraw_charge . '%';
            })
            /** End Custom Columns : */


            /** Start Filtring : */
            ->filterColumn('minimum_amount',function($query , $keyword){
                $keyword = str_replace(currencyIcon(), '', $keyword);
                $query->where('minimum_amount','like',"%$keyword%");
            })

            ->filterColumn('maximum_amount',function($query , $keyword){
                $keyword = str_replace(currencyIcon(), '', $keyword);
                $query->where('maximum_amount','like',"%$keyword%");
            })

            ->filterColumn('withdraw_charge',function($query , $keyword){
                $keyword = str_replace('%', '', $keyword);
                $query->where('withdraw_charge','like',"%$keyword%");
            })
            /** End Filtring : */


            // ->rawColumns([])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(WithdrawMethod $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('withdrawmethod-table')
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
            Column::make('name'),
            Column::make('minimum_amount'),
            Column::make('maximum_amount'),
            Column::make('withdraw_charge'),
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
        return 'WithdrawMethod_' . date('YmdHis');
    }
}

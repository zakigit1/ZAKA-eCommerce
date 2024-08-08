<?php

namespace App\DataTables;

use App\Models\GeneralSetting;
use App\Models\ShippingRule;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ShippingRulesDataTable extends DataTable
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
            $type='shipping-rules';
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
        ->addColumn('min_cost',function ($query){

            if($query->min_cost == null){
                return $this->currencyIcon . '0'  ;
            }else{
                return $this->currencyIcon  . $query->min_cost;
            }
        })
        ->addColumn('cost',function ($query){
          
            return $this->currencyIcon  . $query->cost ;

        })
        ->addColumn('type',function($query){

            
            $flat_cost='<i class="badge badge-success">Flat Cost</i>';
            $min_cost='<i class="badge badge-warning">Minimum Order Amount </i>';
            return ($query->type == 'flat_cost') ? $flat_cost : $min_cost ;  
        })
        ->rawColumns(['status','min_cost','type'])//if you add in this file html code you need to insert the column name inside (rawColumns)
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ShippingRule $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('shipping_rules-table')
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
            Column::make('type'),
            Column::make('min_cost'),
            Column::make('cost'),
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
        return 'ShippingRules_' . date('YmdHis');
    }
}

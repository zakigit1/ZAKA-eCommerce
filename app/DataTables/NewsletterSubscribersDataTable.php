<?php

namespace App\DataTables;

use App\Models\NewsletterSubscriber;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NewsletterSubscribersDataTable extends DataTable
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

                $delete_btn='<a class="btn btn-danger delete-item-with-ajax"  href="'.route("admin.subscriber.destroy",$query->id).'"><i class="fas fa-trash-alt"></i></a>';
                return $delete_btn;
            })
            ->addColumn('is_verified',function($query){

                $Yes='<i class="badge badge-success">Yes</i>';
                $No='<i class="badge badge-danger">No</i>';
                return ($query->is_verified) ? $Yes : $No ;
                
            })

            /** Start Filtring : */
            ->filterColumn('is_verified',function($query , $keyword){
                if (strtolower($keyword) == 'yes') {
                    $query->where('is_verified',1);
                } elseif (strtolower($keyword) == 'no') {
                    $query->where('is_verified',0);
                } else {
                    $query->where('is_verified','like',"%$keyword%");
                }
            })

            /** End Filtring : */
            ->rawColumns(['action','is_verified'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(NewsletterSubscriber $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('newsletter_subscribers-table')
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
            Column::make('email'),
            Column::make('is_verified'),
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
        return 'NewsletterSubscribers_' . date('YmdHis');
    }
}

<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn(
                'action',
                function ($query) { 
                    return '
                    <a onclick="getUserData(' . $query->id . ')" class="edit btn btn-success btn-sm"><i class="bi bi-eye"></i></a>
                    <a onclick="getUserData(' . $query->id . ', '. 1 .')" class="edit btn btn-primary btn-sm"><i class="bi bi-pen"></i></a>
                     <a onclick="confirmDelete(' . $query->id . ')" class="delete btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>';
                }
            )
            ->addColumn(
                'Idade',
                function ($query) {
                    return $query->birthday ? date('Y') - date('Y', strtotime($query->birthday)) : '-';
                }
            )
            ->addColumn(
                'Status',
                function ($query) {
                    return $query->active == 1 ? 'Ativo' : 'Inativo';
                }
            )
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('usersTable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
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
            Column::make('email'),
            Column::make('phone'),
            Column::make('cpf'),
            Column::make('Idade')
                ->exportable(true)
                ->printable(true),
            Column::make('Status')
                ->exportable(true)
                ->printable(true),
            Column::computed('action')
                ->exportable(true)
                ->printable(true)
                ->width(120)
                ->addClass('text-center'),
            //Column::make('created_at'),
            //Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}

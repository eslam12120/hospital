<?php

namespace App\Livewire;

use App\Models\Receptionist;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Livewire\Attributes\Lazy;

#[Lazy]
class ReceptionistTable extends LivewireTableComponent
{
    public $showButtonOnHeader = true;

    public $showFilterOnHeader = true;

    public $paginationIsEnabled = true;

    public $buttonComponent = 'receptionists.templates.button.add-button';

    public $FilterComponent = ['receptionists.templates.button.flitter-button', Receptionist::STATUS_ARR];

    public $status;

    protected $model = Receptionist::class;

    protected $listeners = ['refresh' => '$refresh', 'changeFilter', 'resetPage'];

    public function resetPage($pageName = 'page')
    {
        $rowsPropertyData = $this->getRows()->toArray();
        $prevPageNum = $rowsPropertyData['current_page'] - 1;
        $prevPageNum = $prevPageNum > 0 ? $prevPageNum : 1;
        $pageNum = count($rowsPropertyData['data']) > 0 ? $rowsPropertyData['current_page'] : $prevPageNum;

        $this->setPage($pageNum, $pageName);
    }

    public function changeFilter($status)
    {
        $this->resetPage($this->getComputedPageName());
        $this->statusFilter = $status;
        $this->setBuilder($this->builder());
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('receptionists.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function placeholder()
    {
        return view('livewire.skeleton_files.common_skeleton_af');
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.receptionists'),
                'user.first_name')->view('receptionists.templates.columns.receptionists')
                ->sortable()
                ->searchable(function (Builder $query, $direction) {
                    $query->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                }),
            Column::make('email','user.email')->searchable()->hideIf(1),
            Column::make(__('messages.user.designation'), 'user.designation')
                ->sortable()->searchable()
                ->view('receptionists.templates.columns.designation'),
            Column::make(__('messages.user.phone'), 'user.phone')->view('receptionists.templates.columns.phone')
                ->sortable()->searchable(),
            Column::make(__('messages.common.status'), 'id')->view('receptionists.templates.columns.status')
                ->searchable(),
            Column::make(__('messages.common.action'), 'id')->view('receptionists.action'),
            Column::make(__('last_name'), 'user.email')
                ->searchable()
                ->view('receptionists.action')->hideIf('id'),
        ];
    }

    public function builder(): Builder
    {
        $query = Receptionist::whereHas('user')->with('user')->select('receptionists.*');

        $query->when(isset($this->statusFilter), function (Builder $q) {
            $q->whereHas('user', function (Builder $query) {
                if ($this->statusFilter == 1) {
                    $query->where('status', Receptionist::ACTIVE);
                }
                if ($this->statusFilter == 2) {
                    $query->where('status', Receptionist::STATUS_INACTIVE);
                }
            });
        });

        return $query;
    }
}

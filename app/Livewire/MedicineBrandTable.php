<?php

namespace App\Livewire;

use App\Models\Brand;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Livewire\Attributes\Lazy;

#[Lazy]
class MedicineBrandTable extends LivewireTableComponent
{
    protected $model = Brand::class;

    public $showButtonOnHeader = true;

    public $buttonComponent = 'brands.add-button';

    protected $listeners = ['refresh' => '$refresh', 'changeFilter', 'resetPage'];

    // public function resetPage($pageName = 'page')
    // {
    //     $rowsPropertyData = $this->getRows()->toArray();
    //     $prevPageNum = $rowsPropertyData['current_page'] - 1;
    //     $prevPageNum = $prevPageNum > 0 ? $prevPageNum : 1;
    //     $pageNum = count($rowsPropertyData['data']) > 0 ? $rowsPropertyData['current_page'] : $prevPageNum;

    //     $this->setPage($pageNum, $pageName);
    // }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('brands.created_at', 'desc')
            ->setQueryStringStatus(false);
        $this->setThAttributes(function (Column $column) {
            if ($column->isField('id')) {
                return [
                    'class' => 'd-flex justify-content-end',
                    'style' => 'width: 90% !important',
                ];
            }

            return [

            ];
        });
    }

    public function placeholder()
    {
        return view('livewire.skeleton_files.common_skeleton');
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.medicine.brand'), 'name')
                ->view('brands.templates.columns.name')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.user.email'), 'email')
                ->view('brands.templates.columns.email')
                ->sortable(),
            Column::make(__('messages.user.phone'), 'phone')
                ->view('brands.templates.columns.phone')
                ->sortable(),
            Column::make(__('messages.common.action'), 'id')->view('brands.action'),
        ];
    }
}

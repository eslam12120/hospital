<?php

namespace App\Livewire;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Livewire\Attributes\Lazy;

#[Lazy]
class BillTable extends LivewireTableComponent
{
    use WithPagination;

    public $showButtonOnHeader = true;

    public $buttonComponent = 'bills.add-button';

    public $showFilterOnHeader = false;

    protected $model = Bill::class;

    public $paymentButton = '';

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
            ->setDefaultSort('bills.created_at', 'desc')
            ->setQueryStringStatus(false);
        $this->setThAttributes(function (Column $column) {
            if ($column->isField('amount')) {
                return [
                    'class' => 'd-flex justify-content-end',
                    'style' => 'padding-right: 7.5rem !important',
                ];
            }

            return [];
        });
    }

    public function placeholder()
    {
        return view('livewire.skeleton_files.common_skeleton');
    }

    public function columns(): array
    {
        if (! getLoggedinPatient()) {
            $this->showButtonOnHeader = true;
            $actionButton = Column::make(__('messages.patient_diagnosis_test.action'),
                'id')->view('bills.action');

            $paymentButton = Column::make(__('messages.ipd_payments.payment_mode'), 'id')
                ->view('bills.columns.bill_payment')->hideIf(1);
        } else {
            $this->showButtonOnHeader = false;
            $actionButton = Column::make(__('messages.patient_diagnosis_test.action'),
                'id')->view('bills.action')->hideIf(1);

            $paymentButton = Column::make(__('messages.ipd_payments.payment_mode'), 'id')
                ->view('bills.columns.bill_payment');
        }
        return [
            Column::make(__('messages.bill.bill_id'), 'patient.patientUser.email')
                ->hideIf('patient.patientUser.email')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.bill.bill_id'), 'bill_id')
                ->view('bills.columns.bill_id')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.bill.patient'), 'patient.patientUser.first_name')
                ->view('bills.columns.patient')
                ->searchable()
                ->sortable(),
            $paymentButton,
            Column::make(__('messages.ipd_patient.bill_status'), 'id')
                ->view('bills.columns.bill_status'),
            Column::make(__('messages.bill.bill_date'), 'bill_date')
                ->view('bills.columns.bill_date')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.bill.amount'), 'amount')
                ->view('bills.columns.amount')
                ->sortable()
                ->searchable(),
            $actionButton,
            Column::make('last_name','patient.patientUser.last_name')->searchable()->hideIf(1),
            Column::make('email','patient.patientUser.email')->searchable()->hideIf(1),
        ];
    }

    public function builder(): Builder
    {
        $query = Bill::whereHas('patient.patientUser')->with(['patient.patientUser.media'])->select('bills.*');

        /** @var User $user */
        $user = Auth::user();
        if ($user->hasRole('Patient')) {
            $query->where('patient_id', $user->owner_id);
        }

        return $query;
    }
}

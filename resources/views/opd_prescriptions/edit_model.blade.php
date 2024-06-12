<div id="editOpdPrescriptionModal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl overflow-hidden custom-modal">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2>{{ __('messages.ipd_patient_prescription.edit_prescription') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'editOpdPrescriptionForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none hide" id="editOpdPrescriptionErrorsBox"></div>
                {{ Form::hidden('id',null,['id'=>'opdEditPrescriptionId']) }}
                {{ Form::hidden('opd_patient_department_id',$opdPatientDepartment->id, ['id'=>'editOpdPatientDepartmentId']) }}

                <div class="row">
                    <div class="form-group col-sm-12 mb-5">
                        {{ Form::label('header_note', __('messages.ipd_patient_prescription.header_note').':',['class' => 'form-label']) }}
                        {{ Form::textarea('header_note', null, ['placeholder' => __('messages.ipd_patient_prescription.header_note'),'class' => 'form-control', 'id' => 'editOpdHeaderNote', 'rows' => 4]) }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12 overflow-auto">
                        <div class="table-responsive mb-10 scroll-y" style="max-height: 225px">
                            <table class="table table-striped" id="editOpdPrescriptionTbl">
                                <thead class="thead-dark sticky-top">
                                <tr class="border-bottom fs-7 fw-bolder text-gray-700 text-uppercase">
                                    <th class="text-center">#</th>
                                    <th class="opdMedicineCategory">{{ __('messages.ipd_patient_prescription.category_id') }}
                                    <span class="required"></span></th>
                                <th class="opdMedicineId">{{ __('messages.ipd_patient_prescription.medicine_id') }}<span
                                    class="required"> </th>
                                <th class="opdDosage">{{ __('messages.ipd_patient_prescription.dosage') }}<span
                                            class="required"></span></th>
                                            <th>{{ __('messages.purchase_medicine.dose_duration') }}<span
                                                class="required"></span></th>
                                            <th>{{ __('messages.medicine_bills.dose_interval') }}<span
                                                class="required"></span></th>
                                        <th class="">{{ __('messages.prescription.time') }}<span
                                            class="required"> </th>
                                <th class="OpdPrescriptionInstruction">{{ __('messages.ipd_patient_prescription.instruction') }}
                                    <span class="required"></span></th>
                                <th class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary w-100"
                                            id="addOpdPrescriptionItemOnEdit"
                                            data-edit="1">{{ __('messages.common.add') }}</button>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="edit-opd-prescription-item-container"></tbody>
                        </table>
                    </div>
                </div>
                </div>
                <hr class="py-0 my-0 mb-3">
                <div class="row">
                    <div class="form-group col-sm-12 mb-5">
                        {{ Form::label('footer_note', __('messages.ipd_patient_prescription.footer_note').':', ['class' => 'form-label']) }}
                        {{ Form::textarea('footer_note', null, ['placeholder' => __('messages.ipd_patient_prescription.footer_note'),'class' => 'form-control', 'id' => 'editOpdFooterNote', 'rows' => 4]) }}
                    </div>
                </div>

                <div class="modal-footer p-0">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary m-3','id'=>'btnEditOpdPrescriptionSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="d-flex align-items-center mt-2">
    <label class="form-check form-switch form-switch-sm">
        <input name="status" data-id="{{$row->id}}" class="form-check-input bed-assign-status" type="checkbox" value="1" {{ $row->status == 0 ? 'disabled' : 'checked'}} >
        <span class="switch-slider" data-checked="&#x2713;" data-unchecked="&#x2715;"></span>
    </label>
</div>

<div class="btn-group float-end" role="group" aria-label="Basic example">
    <div>
        <a id="shift_edit" onclick ="getShiftById({{$id}})" href="#" data-bs-placement="bottom" title="Edit"><i class="fas fa-edit" data-bs-toggle="tooltip" title="Edit"></i></a>
    </div>
    <div>
        <a type="submit" class="custom" id="shift_delete" onclick ="deleteShift({{$id}})" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="far fa-trash-alt fa-1x"></i></a>
    </div>
</div>
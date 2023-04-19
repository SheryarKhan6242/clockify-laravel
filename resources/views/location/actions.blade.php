<div class="btn-group float-end" role="group" aria-label="Basic example">
    <div>
        <a id="loc_edit" onclick ="getLocById({{$id}})" href="#" data-bs-placement="bottom" title="Edit"><i class="fas fa-edit" data-bs-toggle="tooltip" title="Edit"></i></a>
    </div>
    <div>
        <a type="submit" class="custom" id="loc_delete" onclick ="deleteLoc({{$id}})" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="far fa-trash-alt fa-1x"></i></a>
    </div>
</div>
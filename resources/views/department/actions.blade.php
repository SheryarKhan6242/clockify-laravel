<div class="btn-group float-end" role="group" aria-label="Basic example">
    <div>
        <a id="dep_edit" onclick ="getDepartmentById({{$id}})" href="#" data-bs-placement="bottom" title="Edit"><i class="fas fa-edit" data-bs-toggle="tooltip" title="Edit"></i></a>
    </div>
    <div>
        <a type="submit" class="custom" id="dep_delete" onclick ="deleteDepartment({{$id}})" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="far fa-trash-alt fa-1x"></i></a>
    </div>
</div>
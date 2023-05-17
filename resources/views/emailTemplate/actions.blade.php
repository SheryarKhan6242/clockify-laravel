<div class="btn-group float-end" role="group" aria-label="Basic example">
    <div>
        <a class="px-1" href="{{ route('template.edit',['id' => $id]) }}" data-bs-placement="bottom" title="Edit"><i class="fas fa-edit" data-bs-toggle="tooltip" title="Edit"></i></a>
    </div>
    <div>
        <a class="px-1" href="{{ route('template.delete',['id' => $id]) }}" class="custom" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="far fa-trash-alt fa-1x"></i></a>
    </div>
</div>

<script>

//AJAX TO GET DEPARTMENT DATA BY ID
function getDepById(id){
    $.ajax({
        url:  "{{url('/department/edit')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // success handling
            if(response.success == true && response.department != undefined){
                //Fill Up edit modal values
                $('#edit_name').val(response.department.name);
                $('#edit_color').val(response.department.color);
                $('#edit_department_status').prop('checked', response.department.status == 1);
                //Add Update Department onclick event and append ID 
                $('#update_dep').attr('onclick', $('#update_dep').attr('onclick').replace('()', '(' + response.department.id + ')'));
                $('#edit_dep_modal').modal("show");
            }
        }
    });
}

//Delete Department data via ajax
function deleteDep(id){
//   make the ajax request
    $.ajax({
        url:  "{{url('/department/delete')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
        //Show Success message on deleting department and hide form modal 
        $('.show_message').append('Department Deleted Successfully')
            $('#success_message').modal('show');
            setTimeout(function(){
            window.location.reload();
            }, 2000);                
        }
    });
}

</script>
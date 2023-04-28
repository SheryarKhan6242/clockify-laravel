@php
 use App\Models\EmployeeType;
@endphp
<div class="btn-group float-end" role="group" aria-label="Basic example">
    <div>
        <a class="px-1" id="mng_emp_type_leave" onclick ="mngEmpTypeLeave({{$id}})" href="#" data-bs-placement="bottom" title="Manage"><i class="fas fa-tasks" data-bs-toggle="tooltip" title="Manage"></i></a>
        {{-- <a class="px-1 mng_emp_type_leave" data-id="{{$id}}" href="#" data-bs-toggle="modal" data-bs-target="#add_emp_type_leave_modal" data-bs-placement="bottom" title="Manage"><i class="fas fa-tasks" data-bs-toggle="tooltip" title="Manage"></i></a> --}}

    </div>
    <div>
        <a class="px-1" id="emp_type_edit" onclick ="getTypeById({{$id}})" href="#" data-bs-placement="bottom" title="Edit"><i class="fas fa-edit" data-bs-toggle="tooltip" title="Edit"></i></a>
    </div>
    <div>
        <a class="px-1" type="submit" class="custom" id="loc_delete" onclick ="deleteEmpType({{$id}})" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="far fa-trash-alt fa-1x"></i></a>
    </div>
</div>

<script>
//AJAX TO GET EMPLOYEE TYPE DATA BY ID
function getTypeById(id){
    $.ajax({
        url:  "{{url('/emp-type/edit')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
        // success handling
        if(response.success == true && response.empType != undefined){
                //Fill Up edit modal values
                $('#edit_name').val(response.empType.name);
                //Add Update empType onclick event and append ID 
                $('#update_emp_type').attr('onclick', $('#update_emp_type').attr('onclick').replace('()', '(' + response.empType.id + ')'));
                $('#edit_emp_type_modal').modal("show");
            }
        }
    });
}

//Delete Employee Type data via ajax
function deleteEmpType(id){
//   make the ajax request
    $.ajax({
        url:  "{{url('/emp-type/delete')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
        //Show Success message on employee type and hide form modal 
        $('.show_message').append('Type Deleted Successfully')
            $('#success_message').modal('show');
            setTimeout(function(){
            window.location.reload();
            }, 2000);                
        }
    });
}

function mngEmpTypeLeave(id){
    $("#add_emp_type_leave_modal .add-emp-type-leave").append(`
        <input type="hidden" class="hidden_emp_type_id" data-id=${id}>
    `);
    $('#add_emp_type_leave_modal').modal("show");
}

</script>
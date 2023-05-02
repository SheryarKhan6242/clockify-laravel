@php
 use App\Models\EmployeeType;
 use App\Models\LeaveType;
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
    $.ajax({
        url:  "{{url('/ajax/get-emp-type-leave')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(response){
            // console.log(response.empLeavetype.payload);
            var jsonPayload = response.empLeavetype.payload;
            var decodePayload = JSON.parse(jsonPayload)
            console.log(decodePayload);
            if (decodePayload !=undefined && decodePayload.length > 0) {
                // Clear existing rows
                $('.leave-row').empty();
                // Loop through each item and create a new row
                for(var i = 0; i < decodePayload.length; i++){
                    var leave_type = decodePayload[i].leave_type;
                    var nol = decodePayload[i].nol;
                    var row = $('<div>', { class: 'leave-row row' });
                    // Create leave type select box and preselect the option
                    console.log(leave_type == 1)
                    var leaveTypeSelect = `
                    <div class="col-sm-5">
                        <select class="form-control form-control-solid selectjs2 leave-type text-gray-900" data-aire-component="select" name="leave_type[]" id="leave_type[]" data-aire-for="leave_type">
                            <option value="">
                                Select Leave type
                            </option>
                            <option value="1" ${leave_type == 1 ? ' selected' : ''}>
                                Annual
                            </option>
                            <option value="2" ${leave_type == 2 ? ' selected' : ''}>
                                Sick
                            </option>
                            <option value="3" ${leave_type == 3 ? ' selected' : ''}>
                                Casual
                            </option>
                            <option value="4" ${leave_type == 4 ? ' selected' : ''}>
                                Half Day
                            </option>
                         </select>
                    </div>`;
                    // Create leave count input field and set the value
                    var leaveCountInput = `
                    <div class="col-sm-5">
                        <input type="text" class="form-control form-control-solid leave-count p-2 text-base rounded-sm text-gray-900" data-aire-component="input" name="leave_count[]" placeholder="No Of Leaves" id="leave_count[]" value="${nol}" required="" data-aire-for="leave_count">
                    </div>`;
                    // Create remove button
                    var removeButton = `
                        <div class= 'col-md-2 pb-2'>
                            <button type="button" class="remove-leave btn btn-rounded btn-danger">Remove</button>
                        </div>
                    `
                    // Append columns to row
                    $('.leave-row').append(leaveTypeSelect, leaveCountInput, removeButton);
                    // Append row to container
                    // $('.scroll-y').append(row);
                }
            }
        },
    });
    $("#add_emp_type_leave_modal .modal-body").append(`
        <input type="hidden" class="hidden_emp_type_id" data-id=${id}>
    `);

    $('#add_emp_type_leave_modal').modal("show");
}

</script>
<div class="btn-group float-end" role="group" aria-label="Basic example">
    <div>
        <a class="px-1" id="leave_type_edit" onclick ="getleaveTypeById({{$id}})" href="#" data-bs-placement="bottom" title="Edit"><i class="fas fa-edit" data-bs-toggle="tooltip" title="Edit"></i></a>
    </div>
    <div>
        <a class="px-1" type="submit" class="custom" id="leave_type_delete" onclick ="deleteLeaveType({{$id}})" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="far fa-trash-alt fa-1x"></i></a>
    </div>
</div>

<script>

//AJAX TO GET LEAVE TYPE DATA BY ID
function getleaveTypeById(id){
    $.ajax({
        url:  "{{url('/leave-type/edit')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // success handling
            if(response.success == true && response.leaveType != undefined){
                //Fill Up edit modal values
                $('#edit_type').val(response.leaveType.type);
                //Add Update Department onclick event and append ID 
                $('#update_leave_type').attr('onclick', $('#update_leave_type').attr('onclick').replace('()', '(' + response.leaveType.id + ')'));
                $('#edit_leave_type_modal').modal("show");
            }
        }
    });
}

//Delete Leave Type data via ajax
function deleteLeaveType(id){
//   make the ajax request
    $.ajax({
        url:  "{{url('/leave-type/delete')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
        //Show Success message on deleting department and hide form modal 
        $('.show_message').append('Leave Type Deleted Successfully')
            $('#success_message').modal('show');
            setTimeout(function(){
            window.location.reload();
            }, 2000);                
        }
    });
}

</script>
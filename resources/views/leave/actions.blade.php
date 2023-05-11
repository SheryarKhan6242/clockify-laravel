<div class="btn-group float-end" role="group" aria-label="Basic example">
    <div>
        <a class="px-1" id="leave_edit" onclick ="getLeaveById({{$id}})" href="#" data-bs-placement="bottom" title="View"><i class="fas fa-eye fa-lg" data-bs-toggle="tooltip" title="View"></i></a>
    </div>
    <div>
        <a class="px-1" id="leave_edit" onclick ="updateLeaveStatus({{$id}},1)" href="#" data-bs-placement="bottom" title="Approve"><i class="fas fa-check-square fa-lg" data-bs-toggle="tooltip" title="Approve"></i></a>
    </div>
    <div>
        <a class="px-1" id="leave_edit" onclick ="updateLeaveStatus({{$id}},0)" href="#" data-bs-placement="bottom" title="Reject"><i class="fas fa-window-close fa-lg" data-bs-toggle="tooltip" title="Reject"></i></a>
    </div>
    <div>
        <a class="px-1" id="leave_edit" onclick ="deleteLeave({{$id}})" href="#" data-bs-placement="bottom" title="Reject"><i class="fas fa-trash-alt fa-lg" data-bs-toggle="tooltip" title="Delete"></i></a>
    </div>
</div>

<script>

//AJAX TO GET LEAVE DATA BY ID
function getLeaveById(id){
    $.ajax({
        url:  "{{url('/leave/edit')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            // success handling
            if(response.success == true && response.leave != undefined){
                //Fill Up edit modal values
                // console.log(response.leave)
                $('#edit_employee').val(response.leave.user_name);
                $('#edit_subject').val(response.leave.subject);
                $('#edit_desc').val(response.leave.description);
                $('#edit_start_date').val(response.leave.start_date);
                $('#edit_leave_type').val(response.leave.leave_type);
                $('#edit_end_date').val(response.leave.end_date);
                $('#edit_status').val(response.leave.status);
                //Add Update Leave onclick event and append ID 
                // $('#update_leave').attr('onclick', $('#update_leave').attr('onclick').replace('()', '(' + response.leave.id + ')'));
                $('#edit_leave_modal').modal("show");
            }
        }
    });
}

//Reject Leave data via ajax
function updateLeaveStatus(id,status){
//   make the ajax request
    $.ajax({
        url:  "{{url('/leave/update-leave-status')}}",
        method: 'POST',
        data : {
            id: id,
            status: status
        },
        success: function(response) {
            $('.show_message').append('Leave Status Udated Successfully')
            $('#success_message').modal('show');
            setTimeout(function(){
                window.location.reload();
            }, 2000);     
        },
    });
}

function deleteLeave(id){
//   make the ajax request
    $.ajax({
        url:  "{{url('/leave/delete')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
        //Show Success message on deleting leave and hide form modal 
        $('.show_message').append('Leave Deleted Successfully')
            $('#success_message').modal('show');
            setTimeout(function(){
            window.location.reload();
            }, 2000);                
        }
    });
}

</script>
<div class="btn-group float-end" role="group" aria-label="Basic example">
    <div>
        <a class="px-1" id="shift_edit" onclick ="getShiftById({{$id}})" href="#" data-bs-placement="bottom" title="Edit"><i class="fas fa-edit" data-bs-toggle="tooltip" title="Edit"></i></a>
    </div>
    <div>
        <a class="px-1" type="submit" class="custom" id="shift_delete" onclick ="deleteShift({{$id}})" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="far fa-trash-alt fa-1x"></i></a>
    </div>
</div>

<script>
//AJAX TO GET SHIFT DATA BY ID
function getShiftById(id){
    $.ajax({
        url:  "{{url('/shift/edit')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
        // success handling
        if(response.success == true && response.shift != undefined){
                //Fill Up edit modal values
                $('#edit_name').val(response.shift.name);
                $('#edit_start_time').val(response.shift.start);
                $('#edit_end_time').val(response.shift.end);
                $('#edit_late').val(response.shift.late);
                $('#edit_shift_status').prop('checked', response.shift.status == 1);
                //Add Update Shift onclick event and append ID 
                $('#update_shift').attr('onclick', $('#update_shift').attr('onclick').replace('()', '(' + response.shift.id + ')'));
                $('#edit_shift_modal').modal("show");
            }
        }
    });
}

//Delete shift data via ajax
function deleteShift(id){
//   make the ajax request
    $.ajax({
        url:  "{{url('/shift/delete')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
        //Show Success message on deleting shift and hide form modal 
        $('.show_message').append('Shift Deleted Successfully')
            $('#success_message').modal('show');
            setTimeout(function(){
            window.location.reload();
            }, 2000);                
        }
    });
}

</script>
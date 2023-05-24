<div class="btn-group float-end" role="group" aria-label="Basic example">
    <div>
        <a class="px-1" onclick ="getEventById({{$id}})" href="#" data-bs-placement="bottom" title="Edit"><i class="fas fa-edit" data-bs-toggle="tooltip" title="Edit"></i></a>
    </div>
    <div>
        <a class="px-1" type="submit" class="custom" onclick ="deleteEvent({{$id}})" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="far fa-trash-alt fa-1x"></i></a>
    </div>
</div>

<script>
//AJAX TO GET EVENT DATA BY ID
function getEventById(id){
    $.ajax({
        url:  "{{url('/event/edit')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
        // success handling
        if(response.success == true && response.event != undefined){
                //Fill Up edit modal values
                $('#edit_name').val(response.event.name);
                $('#edit_description').val(response.event.description);
                $('#edit_event_date').val(response.event.event_date);
                $('#edit_event_status').prop('checked', response.event.status == 1);
                //Add Update Event onclick event and append ID 
                $('#update_event').attr('onclick', $('#update_event').attr('onclick').replace('()', '(' + response.event.id + ')'));
                $('#edit_event_modal').modal("show");
            }
        }
    });
}

//Delete Event data via ajax
function deleteEvent(id){
//   make the ajax request
    $.ajax({
        url:  "{{url('/event/delete')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
        //Show Success message on deleting event and hide form modal 
        $('.show_message').append('Event Deleted Successfully')
            $('#success_message').modal('show');
            setTimeout(function(){
            window.location.reload();
            }, 2000);                
        }
    });
}

</script>
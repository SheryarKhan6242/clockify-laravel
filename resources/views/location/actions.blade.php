<div class="btn-group float-end" role="group" aria-label="Basic example">
    <div>
        <a class="px-1" id="loc_edit" onclick ="getLocById({{$id}})" href="#" data-bs-placement="bottom" title="Edit"><i class="fas fa-edit" data-bs-toggle="tooltip" title="Edit"></i></a>
    </div>
    <div>
        <a class="px-1" type="submit" class="custom" id="loc_delete" onclick ="deleteLoc({{$id}})" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="far fa-trash-alt fa-1x"></i></a>
    </div>
</div>

<script>
//AJAX TO GET LOCATION DATA BY ID
function getLocById(id){
    $.ajax({
        url:  "{{url('/location/edit')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
        // success handling
        console.log(response.location)
        if(response.success == true && response.location != undefined){
                //Fill Up edit modal values
                $('#edit_title').val(response.location.title);
                $('#edit_timezone').val(response.location.timezone);
                $('#edit_description').val(response.location.description);
                $('#edit_loc_status').prop('checked', response.location.status == 1);
                //Add Update Location onclick event and append ID 
                $('#update_loc').attr('onclick', $('#update_loc').attr('onclick').replace('()', '(' + response.location.id + ')'));
                $('#edit_loc_modal').modal("show");
            }
        }
    });
}

//Delete Location data via ajax
function deleteLoc(id){
//   make the ajax request
    $.ajax({
        url:  "{{url('/location/delete')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
        //Show Success message on deleting Location and hide form modal 
        $('.show_message').append('Location Deleted Successfully')
            $('#success_message').modal('show');
            setTimeout(function(){
            window.location.reload();
            }, 2000);                
        }
    });
}

</script>
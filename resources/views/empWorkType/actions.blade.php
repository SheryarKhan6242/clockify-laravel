<div class="btn-group float-end" role="group" aria-label="Basic example">
    <div>
        <a class="px-1" id="work_type_edit" onclick ="getWorkTypeById({{$id}})" href="#" data-bs-placement="bottom" title="Edit"><i class="fas fa-edit" data-bs-toggle="tooltip" title="Edit"></i></a>
    </div>
    <div>
        <a class="px-1" type="submit" class="custom" id="work_type_delete" onclick ="deleteWorkType({{$id}})" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="far fa-trash-alt fa-1x"></i></a>
    </div>
</div>

<script>

//AJAX TO GET WORK TYPE DATA BY ID
function getWorkTypeById(id){
    $.ajax({
        url:  "{{url('/work-type/edit')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // success handling
            if(response.success == true && response.workType != undefined){
                //Fill Up edit modal values
                $('#edit_type').val(response.workType.type);
                //Add Update Department onclick event and append ID 
                $('#update_work_type').attr('onclick', $('#update_work_type').attr('onclick').replace('()', '(' + response.workType.id + ')'));
                $('#edit_work_type_modal').modal("show");
            }
        }
    });
}

//Delete Work Type data via ajax
function deleteWorkType(id){
//   make the ajax request
    $.ajax({
        url:  "{{url('/work-type/delete')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
        //Show Success message on deleting department and hide form modal 
        $('.show_message').append('Work Type Deleted Successfully')
            $('#success_message').modal('show');
            setTimeout(function(){
            window.location.reload();
            }, 2000);                
        }
    });
}

</script>
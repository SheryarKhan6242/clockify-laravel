<div class="btn-group float-end" role="group" aria-label="Basic example">
    <div>
        <a class="px-1" onclick ="getNoticeById({{$id}})" href="#" data-bs-placement="bottom" title="Edit"><i class="fas fa-edit" data-bs-toggle="tooltip" title="Edit"></i></a>
    </div>
    <div>
        <a class="px-1" type="submit" class="custom" onclick ="deleteNotice({{$id}})" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="far fa-trash-alt fa-1x"></i></a>
    </div>
</div>

<script>
//AJAX TO GET NOTICE DATA BY ID
function getNoticeById(id){
    $.ajax({
        url:  "{{url('/notice/edit')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
        // success handling
        if(response.success == true && response.notice != undefined){
                //Fill Up edit modal values
                $('#edit_name').val(response.notice.name);
                $('#edit_description').val(response.notice.description);
                $('#edit_notice_status').prop('checked', response.notice.status == 1);
                //Add Update Event onclick event and append ID 
                $('#update_notice').attr('onclick', $('#update_notice').attr('onclick').replace('()', '(' + response.notice.id + ')'));
                $('#edit_notice_modal').modal("show");
            }
        }
    });
}

//Delete Notice data via ajax
function deleteNotice(id){
//   make the ajax request
    $.ajax({
        url:  "{{url('/notice/delete')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
        //Show Success message on deleting notice and hide form modal 
        $('.show_message').append('Notice Deleted Successfully')
            $('#success_message').modal('show');
            setTimeout(function(){
            window.location.reload();
            }, 2000);                
        }
    });
}

</script>
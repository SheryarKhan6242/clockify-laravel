<div class="btn-group float-end" role="group" aria-label="Basic example">
    <div>
        <a class="px-1" onclick ="getHolidayById({{$id}})" href="#" data-bs-placement="bottom" title="Edit"><i class="fas fa-edit" data-bs-toggle="tooltip" title="Edit"></i></a>
    </div>
    <div>
        <a class="px-1" type="submit" class="custom" onclick ="deleteHoliday({{$id}})" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="far fa-trash-alt fa-1x"></i></a>
    </div>
</div>

<script>
//AJAX TO GET HOLIDAY DATA BY ID
function getHolidayById(id){
    $.ajax({
        url:  "{{url('/holiday/edit')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
        // success handling
        if(response.success == true && response.holiday != undefined){
                //Fill Up edit modal values
                $('#edit_name').val(response.holiday.name);
                $('#edit_description').val(response.holiday.description);
                $('#edit_start_date').val(response.holiday.start_date);
                $('#edit_end_date').val(response.holiday.end_date);
                $('#edit_holiday_status').prop('checked', response.holiday.status == 1);
                //Add Update Event onclick event and append ID 
                $('#update_holiday').attr('onclick', $('#update_holiday').attr('onclick').replace('()', '(' + response.holiday.id + ')'));
                $('#edit_holiday_modal').modal("show");
            }
        }
    });
}

//Delete Holiday data via ajax
function deleteHoliday(id){
//   make the ajax request
    $.ajax({
        url:  "{{url('/holiday/delete')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
        //Show Success message on deleting holiday and hide form modal 
        $('.show_message').append('Holiday Deleted Successfully')
            $('#success_message').modal('show');
            setTimeout(function(){
            window.location.reload();
            }, 2000);                
        }
    });
}

</script>
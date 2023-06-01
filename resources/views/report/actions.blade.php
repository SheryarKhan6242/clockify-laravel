<div class="btn-group float-end" role="group" aria-label="Basic example">
    <div>
        <a class="px-1" onclick ="getReportById({{$id}})" href="#" data-bs-placement="bottom" title="View"><i class="fas fa-eye fa-lg" data-bs-toggle="tooltip" title="View"></i></a>
    </div>
    <div>
        <a class="px-1" onclick ="deleteReport({{$id}})" href="#" data-bs-placement="bottom" title="Reject"><i class="fas fa-trash-alt fa-lg" data-bs-toggle="tooltip" title="Delete"></i></a>
    </div>
</div>

<script>

//AJAX TO GET REPORT DATA BY ID
function getReportById(id){
    $.ajax({
        url:  "{{url('/report/edit')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            // success handling
            if(response.success == true && response.report != undefined){
                //Fill Up edit modal values
                console.log(response.report.checkin_type)
                $('#name').val(response.report.name);
                $('#login_date').val(response.report.login_date);
                $('#office_in').val(response.report.office_in);
                $('#office_out').val(response.report.office_out);
                $('#checkin_type').val(response.report.checkin_type);
                $('#total_work_hours').val(response.report.total_work_hours);
                $('#view_report_modal').modal("show");
            }
        }
    });
}

function deleteReport(id){
//   make the ajax request
    $.ajax({
        url:  "{{url('/report/delete')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
        //Show Success message on deleting Report and hide form modal 
        $('.show_message').append('Report Deleted Successfully')
            $('#success_message').modal('show');
            setTimeout(function(){
            window.location.reload();
            }, 2000);                
        }
    });
}

</script>
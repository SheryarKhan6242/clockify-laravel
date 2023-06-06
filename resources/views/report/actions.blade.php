<div class="btn-group float-end" role="group" aria-label="Basic example">
    @if (isset($add_report))
        <a class="px-1" onclick="showReport('{{ $login_date }}')" href="#" data-bs-placement="bottom" title="Add"><i class="fas fa-plus-circle fa-lg" data-bs-toggle="tooltip" title="Add"></i></a>
    @else    
        <div>
            <a class="px-1" onclick="editReport({{$id}})" href="#" data-bs-placement="bottom" title="Edit"><i class="fas fa-edit fa-lg" data-bs-toggle="tooltip" title="Edit"></i></a>
        </div>
        <div>
            <a class="px-1" onclick ="getReportById({{$id}})" href="#" data-bs-placement="bottom" title="View"><i class="fas fa-eye fa-lg" data-bs-toggle="tooltip" title="View"></i></a>
        </div>
    @endif
</div>

<script>

//AJAX TO VIEW REPORT
function getReportById(id,edit){
    $.ajax({
        url:  "{{url('/report/edit')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            // success handling
            if(response.success == true && response.report != undefined){
                //Fill Up edit modal values
                console.log(response.report.office_in)
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

//AJAX TO EDIT REPORT
function editReport(id){
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
                $('#edit_name').val(response.report.name);
                $('#edit_login_date').val(response.report.login_date);
                $('#edit_office_in').val(response.report.office_in);
                $('#edit_office_out').val(response.report.office_out);
                $('#edit_checkin_type').val(response.report.checkin_type);
                $('#edit_total_work_hours').val(response.report.total_work_hours);
                $('#update_report').attr('onclick', $('#update_report').attr('onclick').replace('()', '(' + response.report.id + ')'));
                $('#edit_report_modal').modal("show");
            }
        }
    });
}

//AJAX TO ADD REPORT
function showReport(login_date){
    var emp_name = $('#emp_name option:selected').text().trim()
    $('#add_name').val(emp_name);
    $('#add_login_date').val(login_date);   
    $('#add_report_modal').modal("show"); 
}

</script>
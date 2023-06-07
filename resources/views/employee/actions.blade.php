<div class="btn-group float-end" role="group" aria-label="Basic example">
    <div>
        <a class="px-1" id="emp_edit" onclick ="getEmpById({{$id}})" href="#" data-bs-placement="bottom" title="Edit"><i class="fas fa-edit" data-bs-toggle="tooltip" title="Edit"></i></a>
    </div>
    <div>
        <a class="px-1" type="submit" class="custom" id="loc_delete" onclick ="deleteEmp({{$id}})" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="far fa-trash-alt fa-1x"></i></a>
    </div>
</div>

<script>

//AJAX TO GET EMPLOYEE DATA BY ID
function getEmpById(id){
    $.ajax({
        url:  "{{url('/employee/edit')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // success handling
            // console.log(response.employees)
            if(response.success == true && response.employees != undefined){
                //Fill Up edit modal values
                $('#edit_first_name').val(response.employees.first_name);
                $('#edit_last_name').val(response.employees.last_name);
                $('#edit_father_name').val(response.employees.father_name);
                $('#edit_username').val(response.username);
                $('#edit_dob').val(response.employees.date_of_birth);
                $('#edit_work_type').val(response.employees.work_type);
                $('#edit_email').val(response.employees.user_email);
                $('#edit_personal_email').val(response.employees.personal_email);
                $('#edit_gen_id').val(response.employees.gen_id);
                $('#edit_permanent_address').val(response.employees.permanent_address);
                $('#edit_temporary_address').val(response.employees.temporary_address);
                $('#edit_country_id').val(response.employees.country_id);
                $('#edit_country_id').attr('data-city-id',response.employees.city_id);
                $('#edit_city_id').val(response.employees.city_id);
                $('#edit_mobile_no').val(response.employees.mobile_no);
                $('#edit_alt_no').val(response.employees.alternative_no);
                $('#edit_cnic').val(response.employees.cnic_no);
                $('#edit_emergency_no').val(response.employees.emergency_no);
                $('#edit_marital_status').val(response.employees.marital_status);
                $('#edit_emp_type').val(response.employees.emp_type);
                $('#edit_dep_id').val(response.employees.dep_id);
                $('#edit_shift_id').val(response.employees.shift_id);
                $('#edit_designation').val(response.employees.designation);
                $('#edit_joining_date').val(response.employees.joining_date);
                $('#edit_salary').val(response.employees.salary);
                $('#edit_is_lead').val(response.employees.is_lead);
                $('#edit_reporting_to').val(response.employees.lead_reporting_to);
                $('#edit_is_lead').prop('checked', response.employees.is_lead == 1);

                // Parse Bank Payload array from JSON string
                if(response.employees.bank_payload != undefined && response.employees.bank_payload != ''){
                    var payload = JSON.parse(response.employees.bank_payload);
                    console.log(payload.acc_type);
                    $('#edit_acc_type').val(payload.acc_type)
                    $('#edit_acc_holder').val(payload.acc_holder)
                    $('#edit_acc_no').val(payload.acc_no)
                    $('#edit_branch_name').val(payload.branch_name)
                    $('#edit_branch_location').val(payload.branch_location)
                }

                // Parse weekdays array from JSON string
                if(response.employees.work_time_schedule != undefined && response.employees.work_time_schedule != ''){
                    var payload = JSON.parse(response.employees.work_time_schedule);
                    var selectedValue = $('#edit_work_type').val(response.employees.work_type).find(':selected').text().trim();
                    $('.edit-work-type-add').html('')
                    if(selectedValue == 'Hybrid')
                    {
                        var days = payload.week_days.split(", ");
                        // Create a new div with the checkboxes for the weekdays
                        var newDiv = $('<div class="col-md-6 fv-row"><label class="fs-6 fw-bold"><span class="required">Weekdays*</span></label><div style="display: inline-flex;"><label style="padding: 0 10px;"><input type="checkbox" name="weekday[]" value="Monday" ' + (days.includes("Monday") ? 'checked' : '') + ' /> Monday</label><label style="padding: 0 10px;"><input type="checkbox" name="weekday[]" value="Tuesday" ' + (days.includes("Tuesday") ? 'checked' : '') + ' /> Tuesday</label><label style="padding: 0 10px;"><input type="checkbox" name="weekday[]" value="Wednesday" ' + (days.includes("Wednesday") ? 'checked' : '') + ' /> Wednesday</label><label style="padding: 0 10px;"><input type="checkbox" name="weekday[]" value="Thursday" ' + (days.includes("Thursday") ? 'checked' : '') + ' /> Thursday</label><label style="padding: 0 10px;"><input type="checkbox" name="weekday[]" value="Friday" ' + (days.includes("Friday") ? 'checked' : '') + ' /> Friday</label></div></div>');
                        // Insert the new div after the work type div
                        $('.edit-work-type-add').append(newDiv)
                    } else if (selectedValue == 'Part Time'){
                        var hours = payload.per_day_hours;
                        var newDiv = $('<div class="row g-9 pb-2"><div class="col-md-6 fv-row"><label class="fs-6 fw-bold"><span class="required">Per Day Hours*</span></label><input type="number" id="per_day_hours" name="per_day_hours" value="'+ hours + '" class="form-control form-control-solid" /></div></div>');
                        $('.edit-work-type-add').append(newDiv)
                    }
                }

                //Add Update employee onclick event and append ID 
                $('#update_emp').attr('onclick', $('#update_emp').attr('onclick').replace('()', '(' + response.employees.id + ')'));

                //USED LATER WHEN WE FILL UP CITIES ON EDIT
                if ($('[id^="edit_country_id"]').length) {
                    var country_id = $('#edit_country_id').val();
                    let city_id = $('#edit_country_id').attr('data-city-id');
                    // var country_ids = document.querySelectorAll("#edit_country_id");
                    // console.log(country_id);
                    url = '/cities-selected'
                    if (location.hostname == 'localhost')
                        url = '/clockify-laravel/public/ajax/cities-selected'
                    // for(var i = 0; i < country_ids.length; i++){
                    //     let country_id = country_ids[i].value
                        // let city_id = city_ids[i].value
                        // let id = ids[i].value
                        $.ajax({
                            url: url,
                            method: 'post',
                            cache: false,
                            //contentType: false,
                            //processData: false,
                            data: { country_id: country_id,city_id: city_id }

                        }).done(function(responseData) {
                            $('#edit_city_id').replaceWith(responseData)
                            // $('.city-wrapper_'+id).html(responseData);
                        }).fail(function(responseData) {

                        }).always(function() {
                            $(".preloader").hide();
                        });
                    // }
                }
                    
                $('#edit_emp_modal').modal("show");
            }
        }
    });
}

//Delete Employee data via ajax
function deleteEmp(id){
//   make the ajax request
    $.ajax({
        url:  "{{url('/employee/delete')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
        //Show Success message on employee type and hide form modal 
        $('.show_message').append('Employee Deleted Successfully')
            $('#success_message').modal('show');
            setTimeout(function(){
                window.location.reload();
            }, 2000);                
        }
    });
}

</script>
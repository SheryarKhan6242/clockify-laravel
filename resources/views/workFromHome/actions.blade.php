<div class="btn-group float-end" role="group" aria-label="Basic example">
    <div>
        <a class="px-1" onclick ="getWfhId({{$workFromHome->id}})" href="#" data-bs-placement="bottom" title="View"><i class="fas fa-eye fa-lg" data-bs-toggle="tooltip" title="View"></i></a>
    </div>
    @if ($workFromHome->status == 'Pending')
        <div>
            <a class="px-1" onclick ="updateWfhStatus({{$workFromHome->id}},1)" href="#" data-bs-placement="bottom" title="Approve"><i class="fas fa-check-square fa-lg" data-bs-toggle="tooltip" title="Approve"></i></a>
        </div>    
    @endif
    @if ($workFromHome->status == 'Pending')
        <div>
            <a class="px-1" onclick ="updateWfhStatus({{$workFromHome->id}},0)" href="#" data-bs-placement="bottom" title="Reject"><i class="fas fa-window-close fa-lg" data-bs-toggle="tooltip" title="Reject"></i></a>
        </div>
    @endif
    <div>
        <a class="px-1" onclick ="deleteWfh({{$workFromHome->id}})" href="#" data-bs-placement="bottom" title="Reject"><i class="fas fa-trash-alt fa-lg" data-bs-toggle="tooltip" title="Delete"></i></a>
    </div>
</div>

<script>

//AJAX TO GET WFH DATA BY ID
function getWfhId(id){
    $.ajax({
        url:  "{{url('/work-from-home/edit')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            // success handling
            if(response.success == true && response.workFromHome != undefined){
                //Fill Up edit modal values
                // console.log(response.workFromHome)
                $('#name').val(response.workFromHome.name);
                $('#start_date').val(response.workFromHome.start_date);
                $('#end_date').val(response.workFromHome.end_date);
                $('#reason').val(response.workFromHome.reason);
                $('#status').val(response.workFromHome.status);
                $('#view_wfh_modal').modal("show");
            }
        }
    });
}

//Update WFH data via ajax
function updateWfhStatus(id,status){
//   make the ajax request
    $.ajax({
        url:  "{{url('/work-from-home/update-status')}}",
        method: 'POST',
        data : {
            id: id,
            status: status
        },
        success: function(response) {
            $('.show_message').append('WFH Status Udated Successfully')
            $('#success_message').modal('show');
            setTimeout(function(){
                window.location.reload();
            }, 2000);     
        },
    });
}

function deleteWfh(id){
//   make the ajax request
    $.ajax({
        url:  "{{url('/work-from-home/delete')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
        //Show Success message on deleting WFH and hide form modal 
        $('.show_message').append('Work From Home Request Deleted Successfully')
            $('#success_message').modal('show');
            setTimeout(function(){
            window.location.reload();
            }, 2000);                
        }
    });
}

</script>
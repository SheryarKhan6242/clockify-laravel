<div class="table-responsive" >
    <table class="table align-middle table-row-dashed fs-6 gy-5 table-row" id="table" >
        <thead>
        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
            <th class="min-w-125px">Name</th>
            <th class="min-w-125px">Address</th>
            <th class="min-w-125px">Mobile No</th>
            <th class="min-w-125px">Country</th>
            <th class="min-w-125px">City</th>
            <th class="min-w-125px">Gender</th>
            <th class="min-w-125px">Marital Status</th>
            <th class="min-w-125px">Employee Type</th>
            <th class="min-w-125px">Department</th>
            <th class="min-w-125px">Designation</th>
            <th class="min-w-125px">Shift</th>
            <th class="min-w-125px">Status</th>
            <th class="text-end min-w-100px">Actions</th>
        </tr>
        </thead>
        <tbody class="text-gray-600 fw-bold" id="tbody_render">
            @foreach ($employees as $emp)
                <tr>
                    <td>{{$emp->first_name}} {{$emp->last_name}}</td>
                    <td>{{$emp->permanent_address}}</td>
                    <td>{{$emp->mobile_no}}</td>
                    <td>{{$emp->country->name}}</td>
                    <td>{{$emp->city->name}}</td>
                    <td>{{$emp->gender->name}}</td>
                    <td>{{$emp->maritalStatus->status}}</td>
                    <td>{{$emp->employeeType->name}}</td>
                    <td>{{$emp->department->name}}</td>
                    <td>{{$emp->designation}}</td>
                    <td>{{$emp->shift->name}}</td>
                    
                    @if ($emp->status)
                        <td><div class="text-success">Active</div></td>
                    @else
                        <td><div class="text-danger">Inactive</div></td>
                    @endif
                    <td>@include('employee.actions', ['id' => $emp->id]) </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    @if(isset($employees))
                        {!! $employees->links('layouts.pagination') !!}
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
</div>


@php
    use Carbon\Carbon;
@endphp
<div class="table-responsive" >
    <table class="table align-middle table-row-dashed fs-6 gy-5 table-row" id="table" >
        <thead>
        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
            <th class="min-w-125px">S.No</th>
            <th class="min-w-125px">EMPLOYEE</th>
            <th class="min-w-125px">TYPE</th>
            <th class="min-w-125px">DATES</th>
            <th class="min-w-125px">STATUS</th>
            <th class="text-end min-w-100px">Actions</th>
        </tr>
        </thead>
        <tbody class="text-gray-600 fw-bold" id="tbody_render">
            @php
                $count = 1;
            @endphp
            @foreach ($leave as $value)
                <tr>
                    <td>{{$count}}</td>
                    <td>{{$value->userName->name}}</td>
                    <td>{{$value->leaveType->type}}</td>
                    {{-- <td>{{$value->approval_id}}</td> --}}
                    <td>{{ Carbon::parse($value->start_date)->format('d-M-Y') }} to {{Carbon::parse($value->end_date)->format('d-M-Y')}}</td>
                    <td>{{$value->status}}</td>
                    <td>@include('leave.actions', ['leave' => $value]) </td>
                    <td>
                    </td>
                    {{-- <td class="text-end">@include('departments.include.action')</td> --}}
                </tr>
                @php
                    $count += 1;
            @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    @if(isset($leave))
                        {!! $leave->links('layouts.pagination') !!}
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
</div>
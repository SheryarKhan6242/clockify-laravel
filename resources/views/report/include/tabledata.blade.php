@php
    use Carbon\Carbon;
@endphp
<div class="table-responsive" >
    <table class="table align-middle table-row-dashed fs-6 gy-5 table-row" id="table" >
        <thead>
        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
            <th class="min-w-125px">S.No</th>
            <th class="min-w-125px">EMPLOYEE</th>
            <th class="min-w-125px">LOGIN DATE</th>
            <th class="min-w-125px">CLOCK IN</th>
            <th class="min-w-125px">CLOCK OUT</th>
            <th class="min-w-125px">CHECKIN TYPE</th>
            <th class="min-w-125px">WORKING HOURS</th>
            <th class="text-end min-w-100px">ACTIONS</th>
        </tr>
        </thead>
        <tbody class="text-gray-600 fw-bold" id="tbody_render">
            @php
                $count = 1;
            @endphp
            @foreach ($reports as $report)
                <tr>
                    <td>{{$count}}</td>
                    <td>{{$report->userName->name}}</td>
                    <td>{{ Carbon::parse($report->login_date)->format('d-M-Y') }}</td>
                    <td>{{$report->office_in}}</td>
                    <td>{{$report->office_out}}</td>
                    <td>{{$report->checkinType->type}}</td>
                    <td>{{$report->total_work_hours}}</td>

                    <td>@include('report.actions', ['id' => $report->id]) </td>
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
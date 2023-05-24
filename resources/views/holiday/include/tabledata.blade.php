<div class="table-responsive" >
    <table class="table align-middle table-row-dashed fs-6 gy-5 table-row" id="table" >
        <thead>
        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
            <th class="min-w-125px">S.NO</th>
            <th class="min-w-125px">NAME</th>
            <th class="min-w-125px">DESCRIPTION</th>
            <th class="min-w-125px">START DATE</th>
            <th class="min-w-125px">END DATE</th>
            <th class="min-w-125px">STATUS</th>
            <th class="text-end min-w-100px">ACTIONS</th>
        </tr>
        </thead>
        <tbody class="text-gray-600 fw-bold" id="tbody_render">
            @php
                $count = 1;
            @endphp
            @foreach ($holidays as $holiday)
                <tr>
                    <td>{{$count}}</td>
                    <td>{{$holiday->name}}</td>
                    <td>{{$holiday->description}}</td>
                    <td>{{$holiday->start_date}}</td>
                    <td>{{$holiday->end_date}}</td>
                    @if ($holiday->status)
                    <td><div class="text-success">Active</div></td>
                @else
                    <td><div class="text-danger">Inactive</div></td>
                @endif
                    <td>@include('holiday.actions', ['id' => $holiday->id]) </td>
                </tr>
                @php
                    $count+=1;
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    @if(isset($holidays))
                        {!! $holidays->links('layouts.pagination') !!}
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
</div>
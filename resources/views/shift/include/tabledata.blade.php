<div class="table-responsive" >
    <table class="table align-middle table-row-dashed fs-6 gy-5 table-row" id="table" >
        <thead>
        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
            <th class="min-w-125px">NAME</th>
            <th class="min-w-125px">START TIME</th>
            <th class="min-w-125px">END TIME</th>
            <th class="min-w-125px">LATE</th>
            <th class="min-w-125px">STATUS</th>
            <th class="text-end min-w-100px">Actions</th>
        </tr>
        </thead>
        <tbody class="text-gray-600 fw-bold" id="tbody_render">
            @foreach ($shifts as $shift)
                <tr>
                    <td>{{$shift->name}}</td>
                    <td>{{$shift->start}}</td>
                    <td>{{$shift->end}}</td>
                    <td>{{$shift->late}}</td>
                    @if ($shift->status)
                    <td><div class="text-success">Active</div></td>
                @else
                    <td><div class="text-danger">Inactive</div></td>
                @endif
                    {{-- <td class="text-end">@include('shifts.include.action')</td> --}}
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    @if(isset($shifts))
                        {!! $shifts->links('layouts.pagination') !!}
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
</div>
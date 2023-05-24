<div class="table-responsive" >
    <table class="table align-middle table-row-dashed fs-6 gy-5 table-row" id="table" >
        <thead>
        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
            <th class="min-w-125px">S.NO</th>
            <th class="min-w-125px">NAME</th>
            <th class="min-w-125px">DESCRIPTION</th>
            <th class="min-w-125px">EVENT DATE</th>
            <th class="min-w-125px">STATUS</th>
            <th class="text-end min-w-100px">ACTIONS</th>
        </tr>
        </thead>
        <tbody class="text-gray-600 fw-bold" id="tbody_render">
            @php
                $count = 1;
            @endphp
            @foreach ($events as $event)
                <tr>
                    <td>{{$count}}</td>
                    <td>{{$event->name}}</td>
                    <td>{{$event->description}}</td>
                    <td>{{$event->event_date}}</td>
                    @if ($event->status)
                    <td><div class="text-success">Active</div></td>
                @else
                    <td><div class="text-danger">Inactive</div></td>
                @endif
                    <td>@include('event.actions', ['id' => $event->id]) </td>
                </tr>
                @php
                    $count+=1;
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    @if(isset($events))
                        {!! $events->links('layouts.pagination') !!}
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
</div>
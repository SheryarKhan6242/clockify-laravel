<div class="table-responsive" >
    <table class="table align-middle table-row-dashed fs-6 gy-5 table-row" id="table" >
        <thead>
        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
            <th class="min-w-125px">TITLE</th>
            <th class="min-w-125px">TIMEZONE</th>
            <th class="min-w-125px">DESCRIPTION</th>
            <th class="min-w-125px">STATUS</th>
            <th class="text-end min-w-100px">Actions</th>
        </tr>
        </thead>
        <tbody class="text-gray-600 fw-bold" id="tbody_render">
            @foreach ($locations as $location)
                <tr>
                    <td>{{$location->title}}</td>
                    <td>{{$location->timezone}}</td>
                    <td>{{$location->description}}</td>
                    @if ($location->status)
                        <td><div class="text-success">Active</div></td>
                    @else
                        <td><div class="text-danger">Inactive</div></td>
                    @endif
                    <td>@include('location.actions', ['id' => $location->id]) </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    @if(isset($locations))
                        {!! $locations->links('layouts.pagination') !!}
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
</div>
@php
    use Carbon\Carbon;
@endphp
@if (isset($requests))
@foreach ($requests as $request)
<tr>
    <td class="border-top-0 text-muted px-2 py-4 font-14">{{ $request->userName->username }}</td>
    <td class="border-top-0 px-2 py-4">
        <div class="d-flex no-block align-items-center">
            <div class="me-3"><img src="{{ asset('assets/images/users/widget-table-pic1.jpg')}}" alt="user" class="rounded-circle" width="45" height="45" /></div>
            <div class="">
                <h5 class="text-light mb-0 font-16 font-weight-medium">{{ "First name" }}</h5>
                <span class="text-muted font-14">{{ "Engineer" }}</span>
            </div>
        </div>
    </td>
    <td class="text-muted">{{ Carbon::parse($request->start_date)->format('m/d/y') }}</td>
    <td class="text-muted">{{ Carbon::parse($request->end_date)->format('m/d/y') }}</td>
    @if ( $request->leave_type_id == 1 )
        <td> <img src="{{ asset('assets/images/icons/annual-leave.svg') }}" alt="annual-badge"> </td>
    @elseif( $request->leave_type_id == 2 )
        <td> <img src="{{ asset('assets/images/icons/sick-leave.svg') }}" alt="sick-badge"> </td>
    @elseif($request->leave_type_id == 3) 
        <td> <img src="{{ asset('assets/images/icons/casual-leave.svg') }}" alt="casual-badge"> </td>
    @elseif($request->leave_type_id == 4) 
        <td> <img src="{{ asset('assets/images/icons/half-day.svg') }}" alt="half-day-badge"> </td>
    @endif
</tr>
@endforeach
@endif
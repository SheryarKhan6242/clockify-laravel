<select class="form-control form-control-solid" id="city_id" name="city_id">
	<option value="" >Select your city</option>
	@foreach($cities as $city)
		@if($city->id == $city_id)
		<option value="{{ $city->id }}" selected="selected" >{{  $city->name }}</option>
		@else
		<option value="{{ $city->id }}" >{{  $city->name }}</option>
		@endif
		
	@endforeach
</select>
@if(isset($edit_city_id) && $edit_city_id)
	<?php $id = "edit_city_id"; ?>
@else
	<?php $id = "city_id"; ?>
@endif
<select class="form-control form-control-solid" id={{$id}} name={{$id}}>
	<option value="" >Select your city</option>
	@foreach($cities as $city)
		@if($city->id == $city_id)
		<option value="{{ $city->id }}" selected="selected" >{{  $city->name }}</option>
		@else
		<option value="{{ $city->id }}" >{{  $city->name }}</option>
		@endif
		
	@endforeach
</select>
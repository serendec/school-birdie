@if($icon)
<span class="avator size-{{ $size }}" style="background-image:url('/storage/icons/' . Auth::user()->school_id . '/' . $icon);" {{ (isset($id)) ? 'id='.$id : '' }}></span>
@else
<span class="avator size-{{ $size }}" {{ (isset($id)) ? 'id='.$id : '' }}></span>
@endif

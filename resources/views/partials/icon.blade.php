@php
    $icon_path = ($icon) ? '/storage/icons/' . Auth::user()->school_id . '/' . $icon : '/storage/img/default-icon.png';
@endphp
<span class="avator size-{{ $size }}" style="background-image:url({{ $icon_path }});" {{ (isset($id)) ? 'id='.$id : '' }}></span>

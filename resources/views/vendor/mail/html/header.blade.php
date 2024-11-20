@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Day Expeditions')
<img src="{{asset('img/logo.png')}}"  class="logo" alt="Day Expeditions Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>

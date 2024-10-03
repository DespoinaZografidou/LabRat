@props(['url'])
<tr>
<td class="header">
<a href='http://127.0.0.1:8080' style="display: inline-block;">
@if (trim($slot) === 'Laravel')
{{--<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">--}}
        <img src="{{ URL('app_images/labrat.png') }}" alt="" style="width: 45px; height: 45px;">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>

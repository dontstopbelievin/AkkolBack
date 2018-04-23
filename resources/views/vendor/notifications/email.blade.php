@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# Whoops!
@else
# Привет!
@endif
@endif



{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset( $actionText)
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'blue';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
С уважением, Управление Архитектуры и Градостроительства города Алматы!
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
Если у вас проблемы с кнопкой "Сбросить пароль", то скопируйте эту ссылку и введите его в поисковик вашего браузера : [{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endisset
@endcomponent

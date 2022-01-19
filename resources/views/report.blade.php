Ошибка в {{env('APP_NAME')}}
<b>Описание: </b> <code>{{$description}}</code>
<b>Файл: </b> <code>{{$file}}</code>
<b>Строка: </b> <code>{{$line}}</code>
@if(\Illuminate\Support\Facades\Auth::user())
<b>Пользователь: </b> <a href="t.me/{{\Illuminate\Support\Facades\Auth::user()->telegram_username}}">{{\Illuminate\Support\Facades\Auth::user()->firstname}} {{\Illuminate\Support\Facades\Auth::user()->lastname}}</a>
@endif

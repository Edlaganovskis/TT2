<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Publiskie kalendāri</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }
        nav {
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 15px;
            box-sizing: border-box;
            top: 0;
            position: absolute;
            display: flex;
            background: #f5f0e4;
            gap: 10px;
            border-bottom: 1px solid #594a20;
        }
        nav a {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: bold;
            color: #fff;
            background-color: #594a20;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #0b0904;
        }
        .main {
            margin: 100px auto 0 auto;
            max-width: 900px;
            padding: 30px;
            background: #f7f3ea;
            border-radius: 20px;
            box-shadow: 0px 5px 25px #f0ead8;
        }
        h1 {
            color: #594a20;
            margin-bottom: 30px;
            text-align: center;
        }
        /* Jauna kolonna ar visiem kalendāriem */
        .kalendari-kolonna {
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin: 0 auto;
            max-width: 500px;
        }
        .kalendars-kartite {
            background: #fff;
            border-radius: 10px;
            padding: 18px 28px;
            box-shadow: 0px 2px 8px #e6dec3;
            display: flex;
            flex-direction: column;
        }
        .kalendars-title {
            font-size: 1.15em;
            font-weight: bold;
            color: #594a20;
        }
        .kalendars-meta {
            font-size: 0.97em;
            color: #7d7042;
            margin-bottom: 5px;
        }
        .kalendars-link {
            color: #fff;
            background: #594a20;
            padding: 7px 15px;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 8px;
            align-self: flex-start;
            transition: background 0.3s;
        }
        .kalendars-link:hover {
            background: #0b0904;
        }
        .fc {
            background: #fff;
            border-radius: 10px;
            padding: 10px;
        }
        .kalendars-outer {
            margin-bottom: 40px;
        }
        #calendar {
            padding: 20px;
            box-shadow: 0px 5px 25px #f0ead8;
        }
        .fc .fc-toolbar-title { /* Kalendāra mēneša teksts */
            margin-right: 130px;
        }
        .fc .fc-button { /* Kalendāra pogas */
            background-color: #594a20;
            transition: background-color 0.3s ease;
            border: 0;
        }
        .fc .fc-button:hover {
            background-color: #0b0904;
        }
        .fc .fc-daygrid-day.fc-day-today { /* Šodiendienas izcelšanas krāsa */
             background: #f5f0e4;
        }
    </style>
</head>
<body>
    <nav>
        <div style="display: flex; gap: 10px;">
            <a href="{{ url('/') }}">Sākumlapa</a>
            @auth
                <a href="{{ url('/MansKalendars') }}">Mans kalendārs</a>
            @else
                <a href="{{ route('register') }}">Mans kalendārs</a>
            @endauth
            <a href="{{ url('/publiskiekalendari') }}">Publiskie kalendāri</a>
        </div>
        <div style="display: flex; gap: 10px;">
            @auth
                <a href="{{route('profile.edit')}}">{{Auth::user()->name}}</a>
            @else
                <a href="{{ route('login') }}">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    </nav>
    <div class="main"> <!-- -->
        <h1>Publiskie kalendāri</h1>
        <div class="kalendari-kolonna">
            @forelse($kalendari as $kalendars) <!--Katram kalendāram div priekš unikāla publiskā kalendāra attēlošanas-->
                <div class="kalendars-outer">
                    <div id="calendar-{{ $kalendars->id }}"></div>
                    @if(auth()->check() && auth()->user()->role_id == 2)
                        <button class="KalendarsDelete" data-id="{{ $kalendars->id }}">Dzēst kalendāru</button>@endif
                </div>
            @empty
                <div>Nav neviena publiska kalendāra</div>
            @endforelse
        </div>
    </div>
    <!--Kalendāra bibliotēka-->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
    var kalendari = @json($kalendari);
    var kalendaruEntries = @json($kalendaruEntries);
    @if(Auth::check())
        var Role = {{ auth()->user()->role_id }};
    @else
        var Role = 1;
    @endif
    document.addEventListener('DOMContentLoaded', function() {
        // Kalendāra dzēšanas poga
        document.querySelectorAll('.KalendarsDelete').forEach(function(del) {
            del.addEventListener('click', function() {
                const calendarId = this.dataset.id;
                if (confirm('Vai tiešām dzēst kalendāru?')) {
                    fetch(`/kalendars/${calendarId}/dzest`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(resp => {
                        if (resp.ok) {
                            location.reload();
                        }
                    });
                }
            });
        });
        // Publisko kalendāru attēlošana
        Object.keys(kalendaruEntries).forEach(function(kalendarsId) {
            var Ieraksts = kalendaruEntries[kalendarsId];
            var kalendars = document.getElementById('calendar-' + kalendarsId);
            if (kalendars) {
                var calendar = new FullCalendar.Calendar(kalendars, {
                    initialView: 'dayGridMonth',
                    events: Ieraksts,
                    height: 420,
                    eventClick: function(info) {
                        const entryId = info.event.extendedProps.id;
                        if (Role == 2 && entryId) {
                            window.location.href = `/Garastavoklis/${entryId}/Rediget`;
                        }
                    }
                });
                calendar.render();
            }
        });
    });
</script>
</body>
</html>
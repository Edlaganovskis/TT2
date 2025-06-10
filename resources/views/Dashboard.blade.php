<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="utf-8">
    <title>Mans kalendārs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0px 5px 25px #f0ead8;
            padding: 32px 20px;
        }
        .font-bold {
            font-weight: bold;
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
            font-weight: bold;
            text-decoration: none;
            color: #fff;
            background-color: #594a20;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #0b0904;
        }
        .kalendars {
            padding: 20px;
            width: 70vw;
            margin: 5% auto 0 auto;
        }
        #Kalendars {
            padding: 20px;
            box-shadow: 0px 5px 25px #f0ead8;
        }
        .fc .fc-button { /* Kalendāra pogas */
            background-color: #594a20;
            transition: background-color 0.3s ease;
            border: 0;
        }
        .fc .fc-toolbar-title { /* Kalendāra mēneša teksts */
            margin-left: 50vh;
        }
        .fc .fc-button:hover {
            background-color: #0b0904;
        }
        .fc .fc-daygrid-day.fc-day-today { /* Šodiendienas izcelšanas krāsa */
             background: #f5f0e4;
        }
        .GarPievienot {
            background-color: #594a20;
            padding: 10px;
            color: #fff;
            transition: background-color 0.3s ease;
            border: 0;
            border-radius: 10px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .GarPievienot:hover {
            background-color: #0b0904;
        }
        #KalendaraNav {
            text-align: center;
            margin-top: 40px;
        }
        .Navkalendars {
            font-size: 30px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .Privats button {
            background-color: #594a20;
            padding: 10px;
            color: #fff;
            transition: background-color 0.3s ease;
            border: 0;
            border-radius: 10px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .Privats button:hover {
            background-color: #0b0904;
        }
    </style>
</head>
<body>
    <nav>
        <div style="display: flex; gap: 10px;">
            <a href="{{ url('/') }}">Sākumlapa</a>
            @auth
                <a href="{{url('/dashboard')}}">Mans kalendārs</a>
            @else
                <a href="{{route('register')}}">Mans kalendārs</a>
            @endauth
            <a href="{{url('/publiskiekalendari')}}">Publiskie kalendāri</a>
        </div>
        <div style="margin-left: auto;">
            @auth
                <a href="{{route('profile.edit')}}">{{Auth::user()->name}}</a>
            @endauth
        </div>
    </nav>
    <div class="kalendars">
        <div class="Privats">
            @if($kalendars) <!--Pārbauda, vai lietotājam ir kalendārs -->
                <form method="POST" action="{{route('kalendars.Publisks', $kalendars->id)}}">
                    @csrf
                    @method('PATCH')
                <button type="submit">{{$kalendars->publisks?'Privāts':'Publisks'}}</button>
                </form>
            @endif
        </div>
        <div id="calendar-buttons" style="display:none; margin-bottom: 16px;"></div>
        <div id="Kalendars"></div>
        <div id="KalendaraNav" style="display:none;"></div> <!-- Kalendāra pogai -->

    <script>
        kalendars = @json($kalendars);
        Ieraksti = @json($entries);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() { // Ja nav kalendāra, piedāvā izveidot/pievienot pirmo ierakstu
        if (typeof kalendars === "undefined" || kalendars === null) {
            document.getElementById('KalendaraNav').innerHTML = `
                <p class="Navkalendars">Tev vēl nav izveidots kalendārs.</p>
                <div>
                    <button type="button" onclick="window.location.href='{{ url('/Garastavoklis/pievienot') }}'" class="GarPievienot">Izveidot kalendāru un pievienot pirmo ierakstu</button>
                </div>`;
            document.getElementById('KalendaraNav').style.display = ''; // Parāda pogu, jo noklusējumā style="display:none;
        return;
        }
        var JaunsIeraksts = document.getElementById('calendar-buttons');
        // Poga jauna ieraksta pievienošanai
        JaunsIeraksts.innerHTML = `<button class="GarPievienot" onclick="window.location.href='{{ url('/Garastavoklis/pievienot') }}'">Pievienot jaunu ierakstu</button>`;
        JaunsIeraksts.style.display = 'block';
        var entries = Ieraksti.map(I => ({ //Masīvs ar vērtībām, kalendāra aizpildei
            title: `${I.Gstavoklis}`,
            start: I.datums,
            extendedProps: {
                id: I.id,
            }
        }));
        var Kalen = document.getElementById('Kalendars'); // kalendāra objekts
        var Kalendars = new FullCalendar.Calendar(Kalen, { initialView: 'dayGridMonth', events: entries,
            eventClick: function(info) {
                var entryId = info.event.extendedProps.id;
                if (entryId) {
                    window.location.href = `/Garastavoklis/${entryId}/Rediget`; // Ieraksta rediģēšana
                }
            }
        });
        Kalendars.render(); // Kalendāra attēlošana
    });
    </script>
</body>
</html>


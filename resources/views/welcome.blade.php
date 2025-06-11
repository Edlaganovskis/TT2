<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Garastavokļa Kalendārs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            position: relative;
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
        .main-content {
            display: flex;
            width: 100vw;
            min-height: 100vh;
            margin-top: 180px;
        }
        .main-content div.left {
            text-align: center;
            margin-top: 30px;
        }
        .left, .right {
            width: 50%;
            padding: 20px;
            box-sizing: border-box;
        }
        .left {
            background-color: #ffffff;
            font-weight: bold;
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
        .GarPievienot {
            background-color: #594a20;
            padding: 10px;
            color: #fff;
            transition: background-color 0.3s ease;
            border: 0;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .GarPievienot:hover {
            background-color: #0b0904;
        }
        .right {
            margin-top: 20vh;
            background-color: #f7f3ea;
            display: flex;
            flex-direction: column;
            gap: 20px;
            border-radius: 20px;
        }
        .right-top, .right-bottom {
            flex: 1;
            background: #fff;
            border-radius: 8px;
            padding: 10px;
            overflow: auto;
            min-height: 0;
        }
        #ieteikums, #DienasIeteikums {
            text-align: center;
            padding-top: 150px;
            font-size: 40px;
            font-weight: bold:
        }
    </style>
    <!-- https://fullcalendar.io/ -->
</head>
<body>
    @if (Route::has('login'))   <!-- Pārbauda, vai ir login -->
        <nav>                   <!-- Navigācijas josla -->
            <div style="display: flex; gap: 10px;">
                <a href="{{ url('/') }}">Sākumlapa</a>
                @auth
                    <a href="{{ url('/dashboard') }}">Mans kalendārs</a>
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
    @endif

    <div class="main-content">
        <div class="left">
            <h2>Garastāvokļa kalendārs!</h2>
            <p>Pieraksti savu garastāvokli un atklāj vairāk par sevi!</p>
            <button type="button" onclick="window.location.href='{{ url('/Garastavoklis/pievienot') }}'" class="GarPievienot">Reģistrēt garastāvokli!</button>
            <div id="calendar"></div>
        </div>
        <div class="right">
            <div class="right-top">
                <div id=DienasIeteikums></div>
            </div>
            <div class="right-bottom">
                <div id="ieteikums"></div>
            </div>
        </div>
    </div> 
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script> <!-- JS kalendārs -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var today = new Date();                                 // datuma ieguve
        var todayText = today.getDate().toString();             // datuma dienas ieguve, kalendāra pogai
        var calendar = new FullCalendar.Calendar(calendarEl, {  // Kalendāra izveide sākumlapai
            headerToolbar: {                                    // Pogas <, >, "datuma skaitlis"
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            buttonText: {                                       // Lai "datuma skaitlis" pogai, teksts būtu todayText
            today: todayText
            },
            events: [                                           // Statisko reģistru pievienošana sākumlapai
                {
                    title: 'Briesmīgi',
                    start: '2025-06-02',
                    color: '#594a20'
                },
                {
                    title: 'Lieliski!',
                    start: '2025-06-08',
                    color: '#594a20'
                },
                {
                    title: 'Labi',
                    start: '2025-06-10',
                    color: '#594a20'
                },
                {
                    title: 'Lieliski!',
                    start: '2025-06-11',
                    color: '#594a20'
                },
                {
                    title: 'Labi',
                    start: '2025-06-25',
                    color: '#594a20'
                },
                {
                    title: 'Labi',
                    start: '2025-06-20',
                    color: '#594a20'
                }
            ]
        });
        calendar.render();                                          // Kalendāra attēlošana
    });
    const Ieteikumi = [                                             // Dienas ieteikumu masīvs
        "Izej svaigā gaisā kaut uz 5 minūtēm — brīnumaini palīdz atsvaidzināt prātu!",
        "Uzdāvini sev tasi mīļākās tējas vai kafijas. Mazie prieki dara lielas lietas.",
        "Pieraksti trīs lietas, par kurām šodien jūties pateicīgs. Tas palīdz paskatīties uz dzīvi gaišāk.",
        "Ieslēdz savu iecienītāko dziesmu un ļauj sev to izbaudīt no sirds.",
        "Atceries: arī šī diena kādreiz būs jauka atmiņa. Esi maigs pret sevi.",
        "Skaties uz kaut ko skaistu — ziediem, mākoņiem, mākslas darbu. Estētika ceļ garastāvokli.",
        "Uzraksti vai piezvani kādam, kuru sen neesi dzirdējis. Sirsnīga saruna dara brīnumus.",
        "Kustība palīdz prātam — neliela pastaiga var brīnumaini atdzīvināt noskaņojumu.",
        "Pasmaidi pats sev spogulī. Tas izklausās muļķīgi, bet darbojas!",
        "Atceries: sliktas dienas ir īslaicīgas. Tu esi stiprāks, nekā domā."
    ];
    var pedejaisGarastavoklis = @json($PedejaisGstavoklis);
    var GIeteikumi = {
        "Lieliski!": "Padalies ar savu labo garastāvokli!",
        "Labi": "Turpini tādā pašā garā!",
        "Normāli": "Pamēģini sevi iepriecināt ar ko jauku.",
        "Slikti": "Atrodi brīdi atpūtai vai sarunai ar draugu.",
        "Briesmīgi!": "Atceries: arī grūtas dienas pāriet. Parūpējies par sevi!"
    };
    var ieteikums = GIeteikumi[pedejaisGarastavoklis];
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('ieteikums').textContent = ieteikums;
    });
    function RandomIeteikums() {                                     // Funkcija nejaušai masīva Ieteikumi elementa izvēlei
        return Ieteikumi[Math.floor(Math.random()*Ieteikumi.length)];
    }
    document.addEventListener('DOMContentLoaded', function() {       // funkcijas izpilde, pec visas lapas ielādes
        document.getElementById('DienasIeteikums').textContent = RandomIeteikums();
    });
</script>
</body>
</html>


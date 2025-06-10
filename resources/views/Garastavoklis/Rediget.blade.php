<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="utf-8">
    <title>Pievienot garastāvokli</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        nav {
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 15px;
            box-sizing: border-box;
            display: flex;
            background: #f5f0e4;
            gap: 10px;
            border-bottom: 1px solid #594a20;
        }
        .nav {
            gap: 10px;
            display: flex;
        }
        nav a {
            display: inline-block;
            padding: 10px 20px;
            font-weight: bold;
            text-decoration: none;
            color: #fff;
            background-color: #594a20;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        nav a:hover {
            background-color: #0b0904;
        }
        .container {
            max-width: 30%;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0px 5px 25px #f0ead8;
            padding: 30px 20px;
        }
        h2 {
            color: #0b0904;
            margin-bottom: 25px;
            text-align: center;
        }
        label {
            display: block;
            color: #0b0904;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="date"], select, textarea {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 15px;
            box-sizing: border-box;
        }
        textarea {
            min-height: 80px;
            resize: vertical;
        }
        .pogas {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        button, .Saglabat {
            background: #594a20;
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            padding: 10px 24px;
            cursor: pointer;
            font-size: 15px;
            transition: background-color 0.2s;
        }
        button:hover, .Saglabat:hover {
            background: #0b0904;
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav">
            <a href="{{ url('/') }}">Sākumlapa</a>
            @auth<a href="{{url('/dashboard')}}">Mans kalendārs</a>
            @else<a href="{{route('register')}}">Mans kalendārs</a>@endauth
            <a href="{{url('/publiskiekalendari')}}">Publiskie kalendāri</a>
        </div>
        <div style="margin-left: auto;">
            @auth
                <a href="{{route('profile.edit')}}">{{Auth::user()->name}}</a>
            @endauth
        </div>
    </nav>
    <form method="POST" action="{{ route('Garastavoklis.atjaunot', $garastavoklis->id) }}">
        @csrf
        @method('PUT')
        <div>
            <label for="datums">Datums:</label>
            <input type="date" id="datums" name="datums" value="{{ old('datums', $garastavoklis->datums) }}" required>
        </div>
        
        <div>
            <label>Garastāvoklis</label>
                <select name="Gstavoklis" required>
                    <option value="">{{$garastavoklis->Gstavoklis}}</option>
                    <option value="Lieliski!">Lieliski!</option>
                    <option value="Labi">Labi</option>
                    <option value="Normāli">Normāli</option>
                    <option value="Slikti">Slikti</option>
                    <option value="Briesmīgi!">Briesmīgi!</option>
                </select>
        <div>
            <label>Sajūtas</label>
                <select name="sajutas" id="sajutas-select" required>
                    <option value="">{{$garastavoklis->sajutas}}</option>
                    <option value="Priecīgs">Priecīgs</option>
                    <option value="Mierīgs">Mierīgs</option>
                    <option value="Satraukts">Satraukts</option>
                    <option value="Dusmīgs">Dusmīgs</option>
                    <option value="Saspringts">Saspringts</option>
                    <option value="Noguris">Noguris</option>
                    <option value="Nomākts">Nomākts</option>
                    <option value="Atvieglots">Atvieglots</option>
                </select>
        </div>
        <div>
            <label for="iemesls">Iemesls:</label>
            <input type="text" id="iemesls" name="iemesls" value="{{old('iemesls', $garastavoklis->iemesls)}}">
        </div>
        <div>
            <label for="piezimes">Piezīmes:</label>
            <textarea id="piezimes" name="piezimes">{{ old('piezimes', $garastavoklis->piezimes) }}</textarea>
        </div>
            <button type="submit">Saglabāt</button>
    </form>
    <form action="{{route('Garastavoklis.dzest', $garastavoklis->id) }}" method="POST" onsubmit="return confirm('Vai tiešām vēlies dzēst šo ierakstu?')">
            @csrf
            <button type="submit" style="background-color:#dc2626; color:white; padding:8px 16px; border-radius:4px; margin-top:16px;">Dzēst ierakstu</button>
    </form>
</body>
</html>



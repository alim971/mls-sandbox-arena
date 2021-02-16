<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="dist/switchery.css" />
    <script src="dist/switchery.js"></script>

    <style>

        /*html, body .white {*/
        /*    !*background-color: rgba(255, 255, 255, 0.88)!important;*!*/
        /*    color: #636b6f;*/
        /*}*/
        .white {
            background-color: rgba(255, 255, 255, 0.88);
            font-weight: 200;
        }

        select.white {
            background-color: white;
        }

        html, body:not(.white) {
            /*background-color: #191a1b; */
            /*background-color: #242626;*/
            background-color: rgba(0, 0, 0, 0.69);
            /*color: #636b6f;*/
            color: #d2dbe0;
        }

        html, body:not(.white) {
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            /*height: 100vh;*/
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .collapse {
            visibility: collapse;
            display: none!important;
        }

        .btn {
            width: 112px;
        }

        .title {
            font-size: 84px;
        }

        .title.while {
            color: #636b6f;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }


        select {
            height: 40px;
            width: 32%;
            border-width: 2px;
        }

        input, select:not(.white) {
            color: black;
            background: #d2dbe0;
            font-weight: 700;
        }

        input, select {
            border-color: black;
            font-weight: 700;
        }

        input[type=text] {
            text-align: center;
        }

        input[number] {
            margin-left: 10px;
            height: 40px;
            width: 40px;
        }

        #scaled input {
            width: 22%;
        }

        label.white {
            color: #d2dbe0;
        }

        label {
            margin-left: 15px;
            margin-right: 15px;
        }

        .def select {
            width: 50%;
        }
        .bigger {
            font-size: 1.1em;
            font-weight: bold;
        }

        .bigger2 {
            font-size: 1.2em;
            font-weight: bold;
        }

        .bigger3 {
            font-size: 1.3em;
            font-weight: bold;
        }

        input[type=range] {
            display: block;
            width: 94%;
            /*margin-right: 10px;*/
            margin-left: 20px;
        }

        .mode {
            float: right;
            margin-right: 25px;
        }

        .inline {
            display: inline;
        }

        .inline-block {
            display: inline-block;
        }

        .inline-container {
            display: flex;
            justify-content: center;
        }

        .scroll-container {
            margin: auto;
            max-height: 100%;
            overflow: auto;
        }

        .getBorder {

        }

        .result input {
            width: 95%;

            /*text-align: center;*/
        }

        .danger {
            /*color: #fff;*/
            color: #bd2130;
            border-color: #b21f2d;
        }

        .danger-input {
            background-color: #b21f2d;
        }

        label {
            display: block;
        }
    </style>
    <script>

        $(document).on('click', '#dark', function() {
            var dark = $(".white").length <= 0;
            if(dark) {
                $('#dark').html('Dark Mode');
                $('#dark').removeClass('btn-white');
                $('#dark').addClass('btn-dark');
            } else {
                $('#dark').html('White Mode');
                $('#dark').removeClass('btn-dark');
                $('#dark').addClass('btn-white');
            }
            // for(var i = 0; i < allInputs.length; i++) {
            if(dark) {
                $('input').addClass('white');
                $('body').addClass('white');
                $('select').addClass('white');
            }
            else {
                $('input').removeClass('white');
                $('body').removeClass('white');
                $('select').removeClass('white');
            }
            // }
        });

        function capitalFirst(string)
        {
            if(string != null) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }
        }

        $(document).on('click', '#close', function(evt) {
            evt.preventDefault();

            $('#resultDiv').addClass('collapse');
        });

        $(document).on('click', '#submit', function(evt) {
            evt.preventDefault();
            if(!$('#resultDiv').hasClass('collapse')) {
                $('#resultDiv').addClass('collapse');
            }
            var formData = new FormData(document.querySelector('form'));
            $('#title').html("Calculating");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            });

            $.ajax({
                method: 'POST',
                url   : "{{ route('select') }}",
                data  : formData,
                processData: false,
                contentType: false
            }).success(function (data) {
                $('#title').html("MLS - Sandbox Arena");
                $('#resultDiv').removeClass('alert-danger');
                // if(!$('#resultDiv').hasClass('alert-success')) {
                //     $('#resultDiv').addClass('alert-success');
                // }
                // $('#result').html(data['result']);
                // $('#resultDiv').removeClass('collapse');
                $('#games').val(data['games']);
                $('#placement').val(data['placement']);
                $('#score').val(data['score']);
                $('#kda').val(data['kda']);
                $('#dmg').val(data['dmg']);
                $('#dmgPer').val(data['dmgPer']);
                $('#aces').val(data['aces']);
                $('#worst').val(data['worst']);
                $('#team_score').val(data['team_score']);
                $('#team_kda').val(data['team_kda']);
                $('#team_dmg').val(data['team_dmg']);
                $('#worst_score').val(data['worst_score']);
                $('#worst_kda').val(data['worst_kda']);
                $('#worst_dmg').val(data['worst_dmg']);
                $('#worst_dmgPer').val(data['worst_dmgPer']);

            }).error(function (data) {
                $('#resultDiv').removeClass('alert-success');
                if(!$('#resultDiv').hasClass('alert-danger')) {
                    $('#resultDiv').addClass('alert-danger');
                }

                $('#title').html("MLS - Sandbox Arena");
                $('#result').html(data['responseText']);
                $('#resultDiv').removeClass('collapse');

            });
        });
    </script>
</head>
<body>
<div class="flex-center position-ref full-height" >
    <div class="content bigger scroll-container" style="width: 75%">
        @include('flash::message')

        <div id="title" class="title m-b-md">
            MLS - Sandbox Arena
        </div>

        <div class="alert
                    alert-success
                    alert-important collapse" id="resultDiv" role="alert">
            <div class="inline" id="result"></div>
            <button type="button" class="close" id="close">×</button>

        </div>

        <div>
            <label for="myForm">Select your server and enterr your username</label>
        </div>
        <form method="post">
            <div style="float: right">
                <button style="float: right" type="button" class="btn btn-white mode" id="dark">White mode</button>

            </div>
            <div id="keyDiv">
                <label for="key">Server</label>
                <select id="server" name="server"  style="margin-bottom: 15px">
                    @foreach($servers as $key => $server)
                        <option value="{{ $key }}" {{ $key == $defaultServer ? "selected" : ""}}>{{ $server }}</option>
                    @endforeach
                </select>
                <div>
                <label for="username">Username</label>
                <input type="text" required style="width: 60%; margin-bottom: 25px" name="username" placeholder="username" id="username">
                </div>
                <div style="margin: 15px 0 25px 0">
                    <button class="btn btn-success" id="submit">Load</button>
                </div>
            </div>
            <div class="flex-center" style="margin-bottom: 30px">
                <div>
                    <label for="games">Number of lost games</label>
                    <input type="number" disabled readonly name="games" id="games">
                </div>
                <div>
                    <label for="aces">Number of times you were the ACE</label>
                    <input type="number" disabled maxlength="10" readonly name="aces" id="aces">
                </div>
                <div>
                    <label for="worst">Number of times you were worst</label>
                    <input type="number" disabled maxlength="10" readonly name="worst" id="worst">
                </div>
                <div>
                    <label for="placement">Average Placement</label>
                    <input type="number" disabled maxlength="10" readonly name="placement" id="placement">
                </div>
            </div>
            <div class="def" style="justify-content: space-between; display: flex;">
                <div>
                    <label>Your average stats</label>
                    <div>
                        <label for="score">Score</label>
                        <input type="number" disabled maxlength="10" readonly name="score" id="score">
                    </div>
                    <div>
                        <label for="kda">KDA</label>
                        <input type="number" disabled maxlength="10" readonly name="kda" id="kda">
                    </div>
                    <div>
                        <label for="dmg">Damage</label>
                        <input type="number" disabled maxlength="10" readonly name="dmg" id="dmg">
                    </div>
                    <div>
                        <label for="dmgPer">Damage Percentage</label>
                        <input type="number" disabled maxlength="10" readonly name="dmgPer" id="dmgPer">
                    </div>
                </div>
                <div>
                    <label>Team average stats</label>
                    <div>
                        <label for="team_score">Score</label>
                        <input type="number" disabled maxlength="10" readonly name="team_score" id="team_score">
                    </div>
                    <div>
                        <label for="team_kda">KDA</label>
                        <input type="number" disabled maxlength="10" readonly name="team_kda" id="team_kda">
                    </div>
                    <div>
                        <label for="team_dmg">Damage</label>
                        <input type="number" disabled maxlength="10" readonly name="team_dmg" id="team_dmg">
                    </div>
                </div>
                <div>
                    <label>Worst player average stats</label>
                    <div>
                        <label for="worst_score">Score</label>
                        <input type="number" disabled maxlength="10" readonly name="worst_score" id="worst_score">
                    </div>
                    <div>
                        <label for="worst_kda">KDA</label>
                        <input type="number" disabled maxlength="10" readonly name="worst_kda" id="worst_kda">
                    </div>
                    <div>
                        <label for="worst_dmg">Damage</label>
                        <input type="number" disabled maxlength="10" readonly name="worst_dmg" id="worst_dmg">
                    </div>
                    <div>
                        <label for="worst_dmgPer">Damage Percentage</label>
                        <input type="number" disabled maxlength="10" readonly name="worst_dmgPer" id="worst_dmgPer">
                    </div>
                </div>
            </div>
        </form>

        <div>
        </div>
    </div>
</div>
<script>
    // $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    var elem = document.querySelector('.js-switch');
    var init = new Switchery(elem);
</script>
</body>
</html>

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

        $(document).on('change', '#own', function() {
            if($(this).is(':checked')) {
                $('#keyDiv').removeClass('collapse')
            } else {
                $('#keyDiv').addClass('collapse')
            }
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

        $(document).on('click', '#left', function(evt) {
            evt.preventDefault();

            copy(1,2);
        });

        $(document).on('click', '#right', function(evt) {
            copy(2,1);
        });

        $(document).on('click', '#submit', function(evt) {
            evt.preventDefault();
            if(!$('#resultDiv').hasClass('collapse')) {
                $('#resultDiv').addClass('collapse');
            }
            var formData = new FormData(document.querySelector('form'));
            $('#title').html("Simulating");

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
                if(!$('#resultDiv').hasClass('alert-success')) {
                    $('#resultDiv').addClass('alert-success');
                }
                $('#result').html(data['result']);
                $('#resultDiv').removeClass('collapse');

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

        function copy(from, to) {
            for (var j = 1; j <= 5; j++) {
                var nameFrom = '#' + from + '_' + j;
                var nameTo = '#' + to + '_' + j;
                var fromSelectChamp = $(nameFrom);
                var fromSelectRune = $(nameFrom + '_rune');
                var fromSelectItem = $(nameFrom + '_item');
                var toSelectChamp =  $(nameTo);
                var toSelectRune =   $(nameTo + '_rune');
                var toSelectItem =   $(nameTo + '_item');

                toSelectChamp.val(fromSelectChamp.val());
                toSelectRune.val(fromSelectRune.val());
                toSelectItem.val(fromSelectItem.val());
            }
        }
    </script>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content bigger scroll-container">
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
            <label for="myForm">Select champion(s) and runes you want to test. Empty roles will be autofilled with same champions:</label>
        </div>
        <form method="post">
            <div style="float: right">
                <button style="float: right" type="button" class="btn btn-white mode" id="dark">White mode</button>

            </div>
            <div class="bigger" style="margin-left: 120px; margin-bottom: 25px; margin-top: 25px">
                <label for="own">Use own players?</label>
                <input type="checkbox" class="js-switch" id="own" name="own">
            </div>
            <div class="collapse" id="keyDiv">
                <label for="key">Player key from MLS</label>
                <input type="text" style="width: 80%; margin-bottom: 25px" name="key" placeholder="Copy here your key from LiveDraft page" id="key">
            </div>
{{--            <div>--}}

{{--                <label for="defChamp" class="inline-block">Default champion</label>--}}
{{--                <select id="defChamp" name="defChamp">--}}
{{--                    @foreach($champions as $champion)--}}
{{--                        <option value="{{ $champion->name }}" {{ $champion->name == $defaultChampion ? "selected" : ""}}>{{ $champion->name }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--                <label for="defRune" class="inline-block">Default rune</label>--}}
{{--                <select id="defRune" name="defRune">--}}
{{--                    @foreach($runes as $key => $rune)--}}
{{--                        <option value="{{ $key }}" {{ $key == $defaultRune ? "selected" : ""}}>{{ $rune }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}
            <div class="def" style="justify-content: space-between; display: flex;">
                <div>
                    <label for="defChamp" class="">Default champion when none is selected</label>
                    <select id="defChamp" name="defChamp" style="margin-bottom: 15px">
                        @foreach($champions as $champion)
                            <option value="{{ $champion->name }}" {{ $champion->name == $defaultChampion ? "selected" : ""}}>{{ $champion->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="defRune" class="">Default rune when none is selected</label>
                    <select id="defRune" name="defRune"  style="margin-bottom: 15px">
                        @foreach($runes as $key => $rune)
                            <option value="{{ $key }}" {{ $key == $defaultRune ? "selected" : ""}}>{{ $rune }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="defItem" class="">Default item when none is selected</label>
                    <select id="defItem" name="defItem"  style="margin-bottom: 15px">
                        @foreach($items as $key => $item)
                            <option value="{{ $key }}" {{ $key == $defaultItem ? "selected" : ""}}>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div style="justify-content: center; display: flex;">
                <div>
                    <div>

                        <label for="1_1">Top</label>

                        <select id="1_1" name="1_1">
                            <option  selected value="-1"> - select a champion - </option>
                            @foreach($champions as $champion)
                                <option value="{{ $champion->name }}">{{ $champion->name }}</option>
                            @endforeach
                        </select>
                        <select id="1_1_rune" name="1_1_rune">
                            <option  selected value="-1"> -- select a rune -- </option>
                            @foreach($runes as $key => $rune)
                                <option value="{{ $key }}">{{ $rune }}</option>
                            @endforeach
                        </select>
                        <select id="1_1_item" name="1_1_item">
                            <option  selected value="-1"> -- select an item -- </option>
                            @foreach($items as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="1_2">Jg</label>
                        <select id="1_2" name="1_2">
                            <option  selected value="-1"> - select a champion - </option>
                            @foreach($champions as $champion)
                                <option value="{{ $champion->name }}">{{ $champion->name }}</option>
                            @endforeach
                        </select>
                        <select id="1_2_rune" name="1_2_rune">
                            <option  selected value="-1"> -- select a rune -- </option>
                            @foreach($runes as $key => $rune)
                                <option value="{{ $key }}">{{ $rune }}</option>
                            @endforeach
                        </select>
                        <select id="1_2_item" name="1_2_item">
                            <option  selected value="-1"> -- select an item -- </option>
                            @foreach($items as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="1_3">Mid</label>
                        <select id="1_3" name="1_3">
                            <option  selected value="-1"> - select a champion - </option>
                            @foreach($champions as $champion)
                                <option value="{{ $champion->name }}">{{ $champion->name }}</option>
                            @endforeach
                        </select>
                        <select id="1_3_rune" name="1_3_rune">
                            <option  selected value="-1"> -- select a rune -- </option>
                            @foreach($runes as $key => $rune)
                                <option value="{{ $key }}">{{ $rune }}</option>
                            @endforeach
                        </select>
                        <select id="1_3_item" name="1_3_item">
                            <option  selected value="-1"> -- select an item -- </option>
                            @foreach($items as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="1_4">Bot</label>
                        <select id="1_4" name="1_4" name="1_4_rune">
                            <option  selected value="-1"> - select a champion - </option>
                            @foreach($champions as $champion)
                                <option value="{{ $champion->name }}">{{ $champion->name }}</option>
                            @endforeach
                        </select>
                        <select id="1_4_rune" name="1_4_rune">
                            <option  selected value="-1"> -- select a rune -- </option>
                            @foreach($runes as $key => $rune)
                                <option value="{{ $key }}">{{ $rune }}</option>
                            @endforeach
                        </select>
                        <select id="1_4_item" name="1_4_item">
                            <option  selected value="-1"> -- select an item -- </option>
                            @foreach($items as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="1_5">Supp</label>
                        <select id="1_5" name="1_5">
                            <option  selected value="-1"> - select a champion - </option>
                            @foreach($champions as $champion)
                                <option value="{{ $champion->name }}">{{ $champion->name }}</option>
                            @endforeach
                        </select>
                        <select id="1_5_rune" name="1_5_rune">
                            <option  selected value="-1"> -- select a rune -- </option>
                            @foreach($runes as $key => $rune)
                                <option value="{{ $key }}">{{ $rune }}</option>
                            @endforeach
                        </select>
                        <select id="1_5_item" name="1_5_item">
                            <option  selected value="-1"> -- select an item -- </option>
                            @foreach($items as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary" style="margin-top: 15px" id="left"><i class="fa fa-arrow-right"></i> Copy blue</button>
                </div>

                <div>
                    <div>
                        <label for="2_1">Top</label>
                        <select id="2_1" name="2_1">
                            <option  selected value="-1"> - select a champion - </option>
                            @foreach($champions as $champion)
                                <option value="{{ $champion->name }}">{{ $champion->name }}</option>
                            @endforeach
                        </select>
                        <select id="2_1_rune" name="2_1_rune">
                            <option  selected value="-1"> -- select a rune -- </option>
                            @foreach($runes as $key => $rune)
                                <option value="{{ $key }}">{{ $rune }}</option>
                            @endforeach
                        </select>
                        <select id="2_1_item" name="2_1_item">
                            <option  selected value="-1"> -- select an item -- </option>
                            @foreach($items as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="2_2">Jg</label>
                        <select id="2_2" name="2_2">
                            <option  selected value="-1"> - select a champion - </option>
                            @foreach($champions as $champion)
                                <option value="{{ $champion->name }}">{{ $champion->name }}</option>
                            @endforeach
                        </select>
                        <select id="2_2_rune" name="2_2_rune">
                            <option  selected value="-1"> -- select a rune -- </option>
                            @foreach($runes as $key => $rune)
                                <option value="{{ $key }}">{{ $rune }}</option>
                            @endforeach
                        </select>
                        <select id="2_2_item" name="2_2_item">
                            <option  selected value="-1"> -- select an item -- </option>
                            @foreach($items as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="2_3">Mid</label>
                        <select id="2_3" name="2_3">
                            <option  selected value="-1"> - select a champion - </option>
                            @foreach($champions as $champion)
                                <option value="{{ $champion->name }}">{{ $champion->name }}</option>
                            @endforeach
                        </select>
                        <select id="2_3_rune" name="2_3_rune">
                            <option  selected value="-1"> -- select a rune -- </option>
                            @foreach($runes as $key => $rune)
                                <option value="{{ $key }}">{{ $rune }}</option>
                            @endforeach
                        </select>
                        <select id="2_3_item" name="2_3_item">
                            <option  selected value="-1"> -- select an item -- </option>
                            @foreach($items as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="2_4">Bot</label>
                        <select id="2_4" name="2_4" >
                            <option  selected value="-1"> - select a champion - </option>
                            @foreach($champions as $champion)
                                <option value="{{ $champion->name }}">{{ $champion->name }}</option>
                            @endforeach
                        </select>
                        <select id="2_4_rune" name="2_4_rune">
                            <option  selected value="-1"> -- select a rune -- </option>
                            @foreach($runes as $key => $rune)
                                <option value="{{ $key }}">{{ $rune }}</option>
                            @endforeach
                        </select>
                        <select id="2_4_item" name="2_4_item">
                            <option  selected value="-1"> -- select an item -- </option>
                            @foreach($items as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="2_5">Supp</label>
                        <select id="2_5" name="2_5">
                            <option  selected value="-1"> - select a champion - </option>
                            @foreach($champions as $champion)
                                <option value="{{ $champion->name }}">{{ $champion->name }}</option>
                            @endforeach
                        </select>
                        <select id="2_5_rune" name="2_5_rune">
                            <option  selected value="-1"> -- select a rune -- </option>
                            @foreach($runes as $key => $rune)
                                <option value="{{ $key }}">{{ $rune }}</option>
                            @endforeach
                        </select>
                        <select id="2_5_item" name="2_5_item">
                            <option  selected value="-1"> -- select an item -- </option>
                            @foreach($items as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-danger" style="margin-top: 15px" id="right"><i class="fa fa-arrow-left"></i> Copy red</button>
                </div>
            </div>
            <div style="margin-top: 15px">
                <button class="btn btn-success" id="submit">Play</button>
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

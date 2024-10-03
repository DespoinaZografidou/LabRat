
@extends('layouts.app')

@section('sidebar')
    @include('navbars.lessonArea_sidebar')
@endsection

@section('content')
    @include('layouts.success_msg_warning')

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-4">
                <h5> {{$l_id}} - {{$title}}</h5>
                <p>Διδάσκων: {{$name}}</p>
            </div>
                <div class="col-lg-4"></div>

            <?php $act_title = ''; $act_id='';  ?>
            @foreach($activity as $a)
                <div class="time-row col-lg-8" data-end='{{$a->updated_at}}' data-start='{{$a->created_at}}' data-role="{{Auth::user()->role}}">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{$a->title}}</h5>
                        </div>
                        <div class="card-body results row" id="results">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                            @endif
                            <div style="">
                                <p>{!! str_replace(["☺","☻",'♦','♣',"♥","♠"],['<i>','</i>','<u>','</u>','<b>','</b>'],$a->text); !!}</p>
                                    <?php $act_title = $a->title; $act_id= $a->id;?>

                            </div>
                            <div style="text-align: right; display: flex; justify-content: space-between" class="pt-3"><p class='time-difference'></p>
                                <p>Λήξη: {{date('d-m-Y H:i', strtotime($a->updated_at))}} </p></div>

                              @include('forms.quiz_participants')
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <br><br>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header" style="display: flex;justify-content: space-between" >
                        <h5>Συμμετοχές / Αποτελέσματα του Quiz</h5>
                        <form method="post" action="{{ url('/searchquizparticipation/'.$act_id.'/'.$l_id.'/'.$title.'/'.$name) }}" style="display: flex;justify-content: space-between;">
                            @csrf @method('GET')
                            <div>
                                <input type="text" name="key" id="key" class="form-control"
                                       value="<?php if(session()->has('key')) echo session()->get('key'); ?>"
                                       placeholder="Αναζήτηση">
                            </div>
                            <button type="submit" class="search"><span class="search__icon">
                                    <ion-icon name="search"></ion-icon></span></button>
                        </form>
                    </div>
                    <div class="card-body">
                    <br>
                        @if(count($data)!=0)
                            @foreach($data as $s)
                                @if ($loop->first)
                                    <div class="card">
                                        <div class="card-header">{{$s->am}}<?php $counter=1; ?></div>
                                            <div style="display: flex;justify-content: space-between; @if($s->finalscore!==null)background-color: rgba(67, 252, 100, 0.1); @endif" class="table_tr_ch" data-try="{{$s->id}}" >
                                                <label style="font-size: small;text-decoration: underline;" class="ml-3 mt-2 title">{{$counter}}η Προσπάθεια</label>
                                                @if($s->finalscore!==null) <p style="font-size: x-small;" class="mr-3 mt-2">Βαθμός:<b>{{$s->finalscore}}</b> / {{$maxgrade}}</p>
                                                @else <p style="font-size: x-small;" class="mr-3 mt-2">Βαθμός: <b>Αναμένεται</b> / {{$maxgrade}}</p>
                                                @endif
                                                @if($s->delivered===1) <p style="font-size: x-small;" class="mr-3 mt-2">Υποβλήθηκε</p>
                                                @else <p style="font-size: x-small;" class="mr-3 mt-2">Αποθηκευμένη</p>
                                                @endif
                                                    <?php $counter++; ?>
                                            </div>
                                @elseif($s->am === $data[$loop->index - 1]->am)
                                            <div style="display: flex;justify-content: space-between; @if($s->finalscore!==null)background-color: rgba(67, 252, 100, 0.1); @endif"  class="table_tr_ch" data-try="{{$s->id}}" >
                                                <label style="font-size: small;text-decoration: underline;" class="ml-3 mt-2">{{$counter}}η Προσπάθεια</label>
                                                @if($s->finalscore!==null) <p style="font-size: x-small;" class="mr-3 mt-2">Βαθμός:<b>{{$s->finalscore}}</b> / {{$maxgrade}}</p>
                                                @else <p style="font-size: x-small;" class="mr-3 mt-2">Βαθμός: <b>Αναμένεται</b> / {{$maxgrade}}</p>
                                                @endif
                                                @if($s->delivered===1) <p style="font-size: x-small;" class="mr-3 mt-2">Υποβλήθηκε</p>
                                                @else <p style="font-size: x-small;" class="mr-3 mt-2">Αποθηκευμένη</p>
                                                @endif
                                                    <?php $counter++; ?>
                                            </div>
                                @else
                                    </div><br>
                                    <div class="card">
                                        <div class="card-header">{{$s->am}}<?php $counter=1; ?></div>
                                        <div style="display: flex;justify-content: space-between; @if($s->finalscore!==null)background-color: rgba(67, 252, 100, 0.1); @endif"  class="table_tr_ch" data-try="{{$s->id}}"  @if($s->finalscore!==null) style="background: #94d3a2" @endif>
                                            <label style="font-size: small;text-decoration: underline;" class="ml-3 mt-2">{{$counter}}η Προσπάθεια</label>
                                            @if($s->finalscore!==null) <p style="font-size: x-small;" class="mr-3 mt-2">Βαθμός:<b>{{$s->finalscore}}</b> / {{$maxgrade}}</p>
                                            @else <p style="font-size: x-small;" class="mr-3 mt-2">Βαθμός: <b>Αναμένεται</b> / {{$maxgrade}}</p>
                                            @endif
                                            @if($s->delivered===1) <p style="font-size: x-small;" class="mr-3 mt-2">Υποβλήθηκε</p>
                                            @else <p style="font-size: x-small;" class="mr-3 mt-2">Αποθηκευμένη</p>
                                            @endif
                                                <?php $counter++; ?>
                                        </div>

                                @endif
                            @endforeach
                                    </div><br>
                        @endif
                        @if(count($data)==0)
                                    <p>Δεν υπάρχουν καταχωρημένα δεδομένα της αναζητησή σας</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('popup-windows.quizResult')

<script>
    $(document).ready(function () { $('#quizactivities').addClass('active');});

    var activity = document.getElementsByClassName("time-row col-lg-8");
    var endTimestamp = new Date(activity[0].getAttribute("data-end")).getTime();
    var startTimestamp = new Date(activity[0].getAttribute("data-start")).getTime();

    function calculateTimeDifference() {
        var currentTimestamp = new Date().getTime();

        if (startTimestamp <= currentTimestamp && endTimestamp >= currentTimestamp) {
            var timeDifference = endTimestamp - currentTimestamp;
            // Calculate the days, hours, minutes, and seconds
            var seconds = Math.floor(timeDifference / 1000) % 60;
            var minutes = Math.floor(timeDifference / (1000 * 60)) % 60;
            var hours = Math.floor(timeDifference / (1000 * 60 * 60)) % 24;
            var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
            // Display the time difference in the table cell
            var timeDifferenceText = 'Απομένουν: ';
            if (days > 0) {timeDifferenceText = timeDifferenceText + days + " days, ";}
            if (hours > 0) {timeDifferenceText = timeDifferenceText + hours + " hours, ";}
            if (minutes > 0) {timeDifferenceText = timeDifferenceText + minutes + " minutes, ";}
            if (seconds > 0) { timeDifferenceText = timeDifferenceText + seconds + " seconds";}
        }
        if (startTimestamp < currentTimestamp && endTimestamp < currentTimestamp) {
            timeDifferenceText = 'Έχει Λήξει';
        }
        if (startTimestamp > currentTimestamp || startTimestamp===endTimestamp) {
            timeDifferenceText = 'Απενεργό';
        }

        activity[0].getElementsByClassName("time-difference")[0].textContent = timeDifferenceText;
    }
    // Call the calculateTimeDifference function initially and then update every second
    calculateTimeDifference();
    setInterval(calculateTimeDifference, 1000);




</script>


@endsection


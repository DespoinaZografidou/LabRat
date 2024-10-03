@extends('layouts.appLessonArea')

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
            @if(Auth::user()->role!=='Μαθητής')
                @include('layouts.Activity_Link')
            @else
                <div class="col-lg-4"></div>
            @endif

            <?php $as_title = ''; $as_id=''; $at_id=''; ?>
            @foreach($activity as $a)
                <div class="time-row col-lg-8" data-end='{{$a->updated_at}}' data-start='{{$a->created_at}}'
                     data-role="{{Auth::user()->role}}">
                    <div class="card">
                        <div class="card-header" style="display: flex;justify-content: space-between;">
                            <h5>{{$a->title}}</h5>
                        </div>
                        <div class="card-body results row" id="results">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                            @endif
                            <div style="">
                                <p>{!! str_replace(["☺","☻",'♦','♣',"♥","♠"],['<i>','</i>','<u>','</u>','<b>','</b>'],$a->text); !!}</p>
                                    <?php $as_title = $a->title; $as_id= $a->id; $at_id=$a->at_id?>
                            </div>
                            <div style="text-align: right; display: flex; justify-content: space-between" class="pt-3"><p class='time-difference'></p>
                                <p>Λήξη: {{date('d-m-Y H:i', strtotime($a->updated_at))}} </p></div>

                            @if(Auth::user()->role!=='Μαθητής')
                                @include('forms.import_export_Slots')
                            @endif

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
                    <div class="card-header">
                        <h5>Slots</h5>
                        @if(Auth::user()->role!=='Μαθητής')
                            <button type="button" class="button-3 create-3"  style="position: absolute;top: 5px; right: 15px" onclick="">+ Νέα Slot</button>
                        @endif
                    </div>
                    <div class="card-body results" id="results">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                        @endif
                        @if(count($slots)!=0)
                            <div class="row container justify-content-center" style="border-bottom: 1px solid lightgrey;border-top: 1px solid lightgrey;">

                            <form method="post" id="dateForm" class="col-md-6"> @csrf @method('GET')
                                <br>
                                <label class="form-label">Επιλογή Ημερομηνίας</label>
                               <select class="form-select text-center selectdate" onchange="dateAction()" name="adate" id="adate">
                                    @foreach($dates as $d)
                                     <option value="{{$d->created_date}}" @if($thedate==$d->created_date) selected @endif>{{ date('d-m-Y', strtotime($d->created_date)) }}</option>
                                    @endforeach
                                </select><br>
                            </form>
                            </div><br>


                            <div class="table">
                                <div class="table_tbody">
                                   @foreach($slots as $s)
                                    <div @if(strpos($s->part, Auth::user()->am) !== false) class="table_tr_ch active" @else class="table_tr_ch" @endif class="table_tr_ch" data-toggle="modal" data-target="#demoModal" style="display: flex;">
                                        <div class="theslottime" style="background: #94d3a2; ">
                                            @if(Auth::user()->role!=='Μαθητής' && $s->am==' ')
                                            <button class="addteam" data-id="{{$s->id}}" data-date="{{$s->slot_time}}"><span class="addteam__icon" ><ion-icon name="add-circle-outline"></ion-icon></span></button>
                                            @endif
                                                @if(Auth::user()->role!=='Μαθητής' && $s->am!=' ')
                                                    <button class="removeteam" data-id="{{$s->id}}" data-names="{{$s->part}}" data-date="{{$s->slot_time}}">
                                                        <span class="removeteam__icon"><ion-icon name="remove-circle-outline"></ion-icon></span>
                                                    </button>
                                                @endif
                                                <?php $date=date('H:i A', strtotime($s->slot_time));
                                                      $date=str_replace(['AM', 'PM'], ['πμ', 'μμ'], $date);
                                                    ?>
                                            <label style="color: white; font-weight: bold; margin: 8px">{{ $date }}</label>
                                        </div>
                                        <div class="ttd" style="position: relative;">
                                            <div><p>{!! str_replace(',','<br>',$s->part)!!}</p></div>
                                            @if(Auth::user()->role!=='Μαθητής' && $s->am==' ')
                                                <button type="button" class="delete" data-id="{{$s->id}}" data-date="{{$s->slot_time}}" style="position: absolute;right: 20px; top:10px;">
                                                    <span class="delete__icon"><ion-icon name="trash"></ion-icon></span>
                                                </button>
                                            @endif

                                            @if(Auth::user()->role==='Μαθητής' &&  $s->am==' ')
                                                <button type="button" class="confirm" style="position: absolute;right: 15px;" data-id="{{$s->id}}" data-date="{{$s->slot_time}}">
                                                    <span class="confirm__icon"><ion-icon name="add-circle-outline"></ion-icon></span>
                                                </button>
                                            @endif
                                        </div>


                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if(count($slots)==0)
                            <p>Δεν υπάρχουν καταχωρημένα δεδομένα της αναζητησή σας</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    Pop up window to delete, edit or add a lesson--}}
        @include('popup-windows.slots_Create_Delete')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () { $('#slotactivities').addClass('active');});

        function calculateTimeDifference() {
            var activity = document.getElementsByClassName("time-row col-lg-8");
            var endTimestamp = new Date(activity[0].getAttribute("data-end")).getTime();
            var startTimestamp = new Date(activity[0].getAttribute("data-start")).getTime();
            var currentTimestamp = new Date().getTime();
            var role = activity[0].getAttribute("data-role");
            // var members =document.getElementsByName("member");

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

                if (role === 'Μαθητής') {
                    var b1=document.getElementsByClassName('confirm');
                    for (var i = 0; i < b1.length; i++) { b1[i].style.display = 'none'; }
                }
            }
            if (startTimestamp > currentTimestamp || startTimestamp===endTimestamp) {
                timeDifferenceText = 'Απενεργό';}

            activity[0].getElementsByClassName("time-difference")[0].textContent = timeDifferenceText;
        }
        // Call the calculateTimeDifference function initially and then update every second
        calculateTimeDifference();
        setInterval(calculateTimeDifference, 1000);


        function dateAction() {
            var selectedDate = document.getElementById('adate').value;
            // Base URL parts provided by Laravel Blade
            var baseUrl = "{{ url('showTheSlots') }}/" + "{{ $l_id }}/" + encodeURIComponent("{{ $title }}") + "/" + encodeURIComponent("{{ $name }}") + "/" + "{{ $a->id }}";
            // Append the dynamically selected date to the base URL
            var fullUrl = baseUrl + "/" + encodeURIComponent(selectedDate);
            // Update the form's action to include the selected date
            document.getElementById('dateForm').action = fullUrl;
            document.getElementById('dateForm').submit();
        }

    </script>
@endsection


@extends('layouts.appLessonArea')

@section('sidebar')
    @include('navbars.lessonArea_sidebar')
@endsection

@section('content')
    @include('layouts.success_msg_warning')

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-8">
                <h5> {{$l_id}} - {{$title}}</h5>
                <p>Διδάσκων: {{$name}}</p>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header" style="display: flex;justify-content: space-between;">
                        <h5>Δραστηριότητα Ψηφοφορία</h5>
                        @if(Auth::user()->role!='Μαθητής')
                            <div class="text-end">
                                <button type="button" class="button-3" >+Νέα δραστηριότητα</button>
                            </div>
                        @endif
                    </div>
                    <div class="card-body results" id="results">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                        @endif

                        @if(count($act_voting)!=0)

                            <div class="table">
                                <div class="table_tbody">
                                    @foreach($act_voting as $a)
                                        <div class="table_tr_ch time-row" data-end='{{$a->updated_at}}'
                                             data-start='{{$a->created_at}}' data-role="{{Auth::user()->role}}"
                                             data-info="<?php echo htmlspecialchars(json_encode((array)$a), ENT_QUOTES, 'UTF-8'); ?>">
                                            <div class="td" style="display: flex;">
                                                <div class="nt">
                                                    <div class="at_open">
                                                        <h6>
                                                            <button type="button" class="status"></button>
                                                            <a href="{{ route('showTheVoting',['l_id'=>$l_id,'title'=>$title,'name'=>$name,'act_id'=>$a->id]) }}">{{$a->title}}</a>
                                                        </h6>
                                                    </div>

                                                    <div style="overflow: hidden;height: 40px;">
                                                        <p>{!! str_replace(["☺","☻",'♦','♣',"♥","♠"],['<i>','</i>','<u>','</u>','<b>','</b>'],$a->text); !!}</p>
                                                    </div>
                                                    <div class="pt-3" style="text-align: right; display: flex; justify-content: space-between">
                                                        <p class='time-difference'></p>
                                                        <p>Λήξη: {{date('d-m-Y H:i', strtotime($a->updated_at))}} </p>
                                                    </div>
                                                </div>
                                                @if(Auth::user()->role!='Μαθητής')
                                                    <div class="nd" style="position: absolute;right: 20px;">
                                                        <button type="button" class="delete">
                                                            <span class="delete__icon"><ion-icon
                                                                    name="trash"></ion-icon></span>
                                                        </button>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{--                            the links for the next page of results--}}
                            {{ $act_voting->links('pagination::bootstrap-4') }}
                        @endif
                        @if(count($act_voting)==0)
                            <p>Δεν υπάρχουν καταχωρημένα δεδομένα της αναζητησή σας</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{--    Pop up window to delete, edit or add a lesson--}}
        @include('popup-windows.activityVoting-Delete_Add_Edit')
    <script>
        $(document).ready(function () {
            // Hide the textarea initially
            $('#votingactivities').addClass('active');
        });

        function calculateTimeDifference() {
            var rows = document.getElementsByClassName("time-row");
            var role = rows[0].getAttribute("data-role");

            for (var i = 0; i < rows.length; i++) {
                var endTimestamp = new Date(rows[i].getAttribute("data-end")).getTime();
                var startTimestamp = new Date(rows[i].getAttribute("data-start")).getTime();
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
                    if (days > 0) {
                        timeDifferenceText = timeDifferenceText + days + " days, ";
                    }
                    if (hours > 0) {
                        timeDifferenceText = timeDifferenceText + hours + " hours, ";
                    }
                    if (minutes > 0) {
                        timeDifferenceText = timeDifferenceText + minutes + " minutes, ";
                    }
                    if (seconds > 0) {
                        timeDifferenceText = timeDifferenceText + seconds + " seconds";
                    }

                    rows[i].getElementsByClassName("status")[0].classList = "status status_active";
                }

                if (startTimestamp < currentTimestamp && endTimestamp < currentTimestamp) {
                    timeDifferenceText = 'Έχει Λήξει';
                    rows[i].getElementsByClassName("status")[0].classList = "status status_deactive";

                }
                if (startTimestamp > currentTimestamp || startTimestamp === endTimestamp) {
                    timeDifferenceText = 'Απενεργό';
                    rows[i].getElementsByClassName("status")[0].classList = "status status_deactive";
                    if (role === 'Μαθητής') {
                        rows[i].style.display = 'none';
                    }

                }
                rows[i].getElementsByClassName("time-difference")[0].textContent = timeDifferenceText;

            }
        }

        // Call the calculateTimeDifference function initially and then update every second
        calculateTimeDifference();
        setInterval(calculateTimeDifference, 1000);
    </script>
@endsection



@extends('layouts.app')

@section('sidebar')
    @include('navbars.announcements_sidebar')
@endsection

@section('content')
    @include('layouts.success_msg_warning')
    <script>var am = '{{ Auth::user()->am }}';</script>
    @vite(['resources/js/announcements.js'])
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-8" >
                <div class="card">
                    <div class="card-header"><h5>Ειδοποιήσεις</h5></div>
                    <div class="card-body results" id="results">

                        <section>
                            @if($activity==='1')
                                @include('layouts.team_notifications')
                            @endif
                                @if($activity==='2')
                                    @include('layouts.choose_themes_notifications')
                                @endif
                                @if($activity==='3')
                                    @include('layouts.determinate_themes_notifications')
                                @endif
                            @if($activity==='4')
                                @include('layouts.slot_notifications')
                            @endif
                        </section>


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>



    function calculateTimeDifference() {
        var rows = document.getElementsByClassName("time-row");

        for (var i = 0; i < rows.length; i++){
            var endTimestamp = new Date(rows[i].getAttribute("data-end")).getTime();
            var startTimestamp = new Date(rows[i].getAttribute("data-start")).getTime();
            var currentTimestamp = new Date().getTime();

            if(startTimestamp<=currentTimestamp && endTimestamp>=currentTimestamp ){
                var timeDifference = endTimestamp - currentTimestamp;
                // Calculate the days, hours, minutes, and seconds
                var seconds = Math.floor(timeDifference / 1000) % 60;
                var minutes = Math.floor(timeDifference / (1000 * 60)) % 60;
                var hours = Math.floor(timeDifference / (1000 * 60 * 60)) % 24;
                var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                // Display the time difference in the table cell
                var timeDifferenceText ='Απομένουν: ';
                if(days>0){ timeDifferenceText = timeDifferenceText + days + " days, ";}
                if(hours>0){timeDifferenceText =timeDifferenceText +  hours + " hours, ";}
                if(minutes>0){timeDifferenceText =timeDifferenceText + minutes + " minutes, ";}
                if(seconds>0){timeDifferenceText =timeDifferenceText + seconds + " seconds";}

            }
            if(startTimestamp<currentTimestamp && endTimestamp<currentTimestamp){
                timeDifferenceText='Έχει λήξη';
                // rows[i].style.background='rgba(10, 91, 111, 0.05)';
            }
            if(startTimestamp>currentTimestamp || startTimestamp===endTimestamp){
                rows[i].style.display='none';
            }
            rows[i].getElementsByClassName("time-difference")[0].textContent = timeDifferenceText;

        }

    }

    // Call the calculateTimeDifference function initially and then update every second
    calculateTimeDifference();
    setInterval(calculateTimeDifference, 1000);



</script>

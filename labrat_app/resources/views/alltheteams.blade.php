
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

            <?php $maxnum = 0; $at_title = ''; $at_id=''; ?>
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
                                    <?php $maxnum = $a->mnp; $at_title = $a->title; $at_id= $a->id; ?>
                            </div>
                            <div style="text-align: right; display: flex; justify-content: space-between" class="pt-3"><p class='time-difference'></p>
                                <p>Λήξη: {{date('d-m-Y H:i', strtotime($a->updated_at))}} </p></div>

                                @if(Auth::user()->role!=='Μαθητής')
                                    @include('forms.export_members_TeamActivity')
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
                        <h5>Ομάδες</h5>
                        <?php $found=false; ?>
                        @foreach($teams as $t )
                            @if($t->am ==Auth::user()->am)
                                <?php $found=true?>
                                @break
                            @endif
                        @endforeach
                        @if($found===false)
                            <button type="button" class="button-3 create-3"  style="position: absolute;top: 5px; right: 15px" onclick="">+ Νέα Ομάδα</button>
                        @endif

                    </div>
                    <div class="card-body results" id="results">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                        @endif
                        @if(count($teams)!=0)
                            <div class="table">
                                <div class="table_tbody"> <?php $count=2 ?>
                                    <div class="table_tr_ch" data-toggle="modal" data-target="#demoModal" style="display: flex;position: relative">
                                        <div class="ttd tteam" style="background: #94d3a2"><label style="color: white;font-weight: bold">Ομάδα 1</label></div>
                                        <div class="ttd">
                                            @foreach($teams as $t)
                                                @if ($loop->first || $t->t_id === $teams[$loop->index - 1]->t_id)
                                                    <div @if($t->am == Auth::user()->am) class='active' @endif   @if($t->confirm != 1)name="member" @endif @if($t->t_id==$t->am) style="border-bottom: 1px solid darkgray;" @endif>
                                                        <h7 style="color: gray">{{$t->am}} - {{$t->name}}</h7>
                                                        @if($t->confirm==1)
                                                            <span type="button" class="status status_active"><ion-icon style="color: white" name="checkmark-circle-outline"></ion-icon></span>
                                                        @endif
                                                        @if($t->am == Auth::user()->am)
                                                            @if($t->confirm==1)
                                                                @if($t->t_id!=$t->am)
                                                                    <button type="button" class="walk" style="position: absolute;right: 15px" data-info="<?php echo htmlspecialchars(json_encode((array)$t), ENT_QUOTES, 'UTF-8'); ?>">
                                                                        <span class="walk__icon"><ion-icon name="walk"></ion-icon></span></button>
                                                                @endif
                                                                @if($t->t_id==$t->am && $t->num<$maxnum)
                                                                    <button type="button" class="addteam" style="position: absolute;left: 3px;" data-info="<?php echo htmlspecialchars(json_encode((array)$t), ENT_QUOTES, 'UTF-8'); ?>" >
                                                                        <span class="addteam__icon"><ion-icon name="add-circle-outline"></ion-icon></span>
                                                                    </button>
                                                                @endif
                                                            @else
                                                                <button type="button" class="confirm" style="position: absolute;right:15px" data-info="<?php echo htmlspecialchars(json_encode((array)$t), ENT_QUOTES, 'UTF-8'); ?>">
                                                                    <span class="confirm__icon"><ion-icon name="paper"></ion-icon></span></button>
                                                            @endif
                                                        @endif
                                                        @if((Auth::user()->role!=='Μαθητής' && $t->num==1) ||( Auth::user()->am==$t->t_id && $t->num==1 ))
                                                            <button type="button" class="delete" style="position: absolute;right:15px;top:0px" data-id="{{$t->t_id}}" data-name="{{$t->name}}">
                                                                <span class="delete__icon"><ion-icon name="trash"></ion-icon></span>
                                                            </button>
                                                        @endif
                                                        @if(Auth::user()->role!=='Μαθητής' && $t->am==$t->t_id && $t->num<$maxnum)
                                                            <button type="button" style="position: absolute;left: 3px;" class="addteam" data-info="<?php echo htmlspecialchars(json_encode((array)$t), ENT_QUOTES, 'UTF-8'); ?>">
                                                                <span class="addteam__icon"><ion-icon name="add-circle-outline"></ion-icon></span>
                                                            </button>
                                                        @endif

                                                    </div><br>
                                                @else
                                        </div>
                                    </div>
                                    <div class="table_tr_ch" data-toggle="modal" data-target="#demoModal" style="display: flex;position: relative;">
                                        <div class="ttd tteam" style="background: #94d3a2"><label style="color: white; font-weight: bold">Ομάδα {{$count}}</label><?php $count++; ?></div>
                                        <div class="ttd">
                                            <div @if($t->am == Auth::user()->am) class='active' @endif @if($t->confirm != 1) name="member" @endif @if($t->t_id==$t->am) style="border-bottom: 1px solid darkgray;" @endif >
                                                <h7 style="color: gray">{{$t->am}} - {{$t->name}}</h7>
                                                @if($t->confirm==1)
                                                    <span type="button" class="status status_active"><ion-icon style="color: white" name="checkmark-circle-outline"></ion-icon></span>
                                                @endif
                                                @if($t->am == Auth::user()->am)
                                                    @if($t->confirm==1)
                                                        @if($t->t_id!=$t->am)
                                                            <button type="button" class="walk" style="position: absolute;right: 15px" data-info="<?php echo htmlspecialchars(json_encode((array)$t), ENT_QUOTES, 'UTF-8'); ?>">
                                                                    <span class="walk__icon"><ion-icon name="walk"></ion-icon></span></button>
                                                        @endif
                                                        @if($t->t_id==$t->am && $t->num<$maxnum)
                                                            <button type="button" class="addteam" style="position: absolute;left: 3px;" data-info="<?php echo htmlspecialchars(json_encode((array)$t), ENT_QUOTES, 'UTF-8'); ?>">
                                                                <span class="addteam__icon"><ion-icon name="add-circle-outline"></ion-icon></span>
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button type="button" class="confirm" style="position: absolute;right:15px" data-info="<?php echo htmlspecialchars(json_encode((array)$t), ENT_QUOTES, 'UTF-8'); ?>">
                                                            <span class="confirm__icon"><ion-icon name="paper"></ion-icon></span></button>
                                                    @endif
                                                @endif
                                                @if((Auth::user()->role!=='Μαθητής'&& $t->num==1) ||( Auth::user()->am==$t->t_id && $t->num==1 ))
                                                    <button type="button" class="delete" style="position: absolute;right:15px;top:0px" data-id="{{$t->t_id}}" data-name="{{$t->name}}">
                                                        <span class="delete__icon"><ion-icon name="trash"></ion-icon></span>
                                                    </button>
                                                @endif
                                                @if(Auth::user()->role!=='Μαθητής' && $t->am==$t->t_id && $t->num<$maxnum)

                                                    <button type="button" class="addteam" style="position: absolute;left: 3px;" data-info="<?php echo htmlspecialchars(json_encode((array)$t), ENT_QUOTES, 'UTF-8'); ?>">
                                                        <span class="addteam__icon"><ion-icon name="add-circle-outline"></ion-icon></span>
                                                    </button>
                                                @endif
                                            </div>
                                            <br>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(count($teams)==0)
                            <p>Δεν υπάρχουν καταχωρημένα δεδομένα της αναζητησή σας</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    Pop up window to delete, edit or add a lesson--}}
    @include('popup-windows.teams_Confirm_Reject_Create')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

        $(document).ready(function () { $('#activitiesteam').addClass('active');});

        var activity = document.getElementsByClassName("time-row col-lg-8");
        var endTimestamp = new Date(activity[0].getAttribute("data-end")).getTime();
        var startTimestamp = new Date(activity[0].getAttribute("data-start")).getTime();
        var currentTimestamp = new Date().getTime();
        var role = activity[0].getAttribute("data-role");

        function calculateTimeDifference() {
            var activity = document.getElementsByClassName("time-row col-lg-8");
            var endTimestamp = new Date(activity[0].getAttribute("data-end")).getTime();
            var startTimestamp = new Date(activity[0].getAttribute("data-start")).getTime();
            var currentTimestamp = new Date().getTime();

            var members =document.getElementsByName("member");

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
                    var b1=document.getElementsByClassName('button-3');
                    var b2=document.getElementsByClassName('addteam');
                    var b4=document.getElementsByClassName('walk');
                    var b5=document.getElementsByClassName('delete');

                    for(var l=0; l<members.length; l++){members[l].style.display='none';}
                    for (var i = 0; i < b1.length; i++) {b1[i].style.display = 'none';}
                    for ( i = 0; i < b2.length; i++) {b2[i].style.display = 'none';}
                    for ( i = 0; i < b4.length; i++) {b4[i].style.display = 'none';}
                    for ( i = 0; i < b5.length; i++) {b5[i].style.display = 'none';}

                }
            }

            if (startTimestamp > currentTimestamp || startTimestamp===endTimestamp) {
                timeDifferenceText = 'Απενεργό';}


            activity[0].getElementsByClassName("time-difference")[0].textContent = timeDifferenceText;
        }
        // Call the calculateTimeDifference function initially and then update every second
        calculateTimeDifference();
        setInterval(calculateTimeDifference, 1000);



    </script>
@endsection

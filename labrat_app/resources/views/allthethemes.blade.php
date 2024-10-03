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

            <?php $act_title = ''; $act_id=''; $at_id=''; ?>
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
                                    <?php $act_title = $a->title; $act_id= $a->id; $at_id=$a->at_id?>
                            </div>
                            <div style="text-align: right; display: flex; justify-content: space-between" class="pt-3"><p class='time-difference'></p>
                                <p>Λήξη: {{date('d-m-Y H:i', strtotime($a->updated_at))}} </p></div>

                            @if(Auth::user()->role!=='Μαθητής')
                                @include('forms.import_export_Choose_Themes')
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
                        <h5>Θέματα</h5>
                        @if(Auth::user()->role!=='Μαθητής')
                            <button type="button" class="button-3 create-3"  style="position: absolute;top: 5px; right: 15px" onclick="">+ Νέο Θέμα</button>
                        @endif
                    </div>
                    <div class="card-body results" id="results">
            @if(count($themes)!=0)
                @foreach($themes as $s)
                    @if ($loop->first)
                        <div class="card">
                            <div class="card-header">
                                <a class="ml-5 title" style="cursor: pointer;text-decoration: underline" >{{$s->title}}<ion-icon name="arrow-dropdown"></ion-icon></a>
                                 @if($s->excusive==0)
                                    <label class="form-control-sm">/ Μη αποκλειστικό</label>
                                 @else
                                    <label class="form-control-sm">/ Αποκλειστικό</label>
                                 @endif
                                 <div class="col-lg-11 ml-4 description" style="display: none;" >
                                    @if($s->file!==' ')
                                       <div style="text-align: right">
                                           <label><ion-icon name="attach"></ion-icon>Αρχείο Περιγραφής Θέματος: </label>
                                           <a href="{{ url('downloaddescription/'.$s->file) }}">Εδώ</a>
                                       </div>
                                    @endif
                                    {!! str_replace(["☺","☻",'♦','♣',"♥","♠"],['<i>','</i>','<u>','</u>','<b>','</b>'],$s->text); !!}
                                 </div>
                                    @if(Auth::user()->role!=='Μαθητής')
                                        <button type="button" class="edit" style="position: absolute;left: 15px;top:2px;" data-info="<?php echo htmlspecialchars(json_encode((array)$s), ENT_QUOTES, 'UTF-8'); ?>">
                                            <span class="edit__icon"><ion-icon name="create"></ion-icon></span>
                                        </button>
                                        <button type="button" class="delete" data-id="{{$s->id}}" data-title="{{$s->title}}" style="position: absolute;right: 20px; top:3px;">
                                            <span class="delete__icon"><ion-icon name="trash"></ion-icon></span>
                                        </button>
                                    @endif
                                </div>
                                <div class="card-body results" id="participants">
                                @if(($s->excusive==0)||($s->excusive==1 && $s->part==null))
                                   <button @if( strpos($s->part, Auth::user()->am)!== false) style="display: none" @endif type="button" class="confirm"  data-id="{{$s->id}}" data-title="{{$s->title}}" data-exclusive="{{$s->excusive}}">
                                      <span class="confirm__icon"><ion-icon name="add-circle-outline"></ion-icon></span>
                                   </button>
                                @endif
                                <div class="table_tr_ch" @if(strpos($s->part, Auth::user()->am)!== false) class="table_tr_ch active"  @elseif($s->part==null) style="display: none;" @endif>
                                    <div class="ttd" data-toggle="modal" data-target="#demoModal" style="display: flex;justify-content: right;">
                                        <p>{!! str_replace(',','<br>',$s->part)!!}</p>
                                    </div>
                                </div>
                                @elseif($s->id === $themes[$loop->index - 1]->id)
                                <div class="table_tr_ch" @if(strpos($s->part, Auth::user()->am)!== false) class="table_tr_ch active"  @elseif($s->part==null) style="display: none;" @endif>
                                    <div  class="ttd"  data-toggle="modal" data-target="#demoModal" style="display: flex;justify-content: right;">
                                        <p>{!! str_replace(',','<br>',$s->part)!!}</p>
                                    </div>
                                </div>
                                @else
                                </div>
                       </div><br>

                           <div class="card">
                              <div class="card-header">
                                  @if(Auth::user()->role!=='Μαθητής')
                                      <button type="button" class="edit" style="position: absolute;left: 15px;top:2px;" data-info="<?php echo htmlspecialchars(json_encode((array)$s), ENT_QUOTES, 'UTF-8'); ?>">
                                          <span class="edit__icon"><ion-icon name="create"></ion-icon></span>
                                      </button>
                                      <button type="button" class="delete" data-id="{{$s->id}}" data-title="{{$s->title}}" style="position: absolute;right: 20px; top:3px;">
                                          <span class="delete__icon"><ion-icon name="trash"></ion-icon></span>
                                      </button>
                                  @endif
                                  <a class="ml-5 title" style="cursor: pointer;text-decoration: underline;" >{{$s->title}}<ion-icon name="arrow-dropdown"></ion-icon></a>
                                      @if($s->excusive==0)
                                          <label class="form-control-sm">/ Μη αποκλειστικό</label>
                                      @else
                                          <label class="form-control-sm">/ Αποκλειστικό</label>
                                      @endif
                                  <div class="col-lg-11 ml-4 description" style="display: none;" >
                                      @if($s->file!==' ')
                                          <div style="text-align: right">
                                              <label><ion-icon name="attach"></ion-icon>Αρχείο Περιγραφής Θέματος: </label>
                                              <a href="{{ url('downloaddescription/'.$s->file) }}">Εδώ</a>
                                          </div>
                                      @endif
                                      {!! str_replace(["☺","☻",'♦','♣',"♥","♠"],['<i>','</i>','<u>','</u>','<b>','</b>'],$s->text); !!}
                                  </div>
                              </div>
                                  <div class="card-body results" id="participants">
                                      @if(($s->excusive==0)||($s->excusive==1 && $s->part==null))
                                          <button @if( strpos($s->part, Auth::user()->am)!== false) style="display: none" @endif type="button" class="confirm"  data-id="{{$s->id}}" data-title="{{$s->title}}" data-exclusive="{{$s->excusive}}">
                                              <span class="confirm__icon"><ion-icon name="add-circle-outline"></ion-icon></span>
                                          </button>
                                      @endif
                                      <div class="table_tr_ch" @if(strpos($s->part, Auth::user()->am)!== false) class="table_tr_ch active"  @elseif($s->part==null) style="display: none;" @endif>
                                          <div class="ttd" data-toggle="modal" data-target="#demoModal" style="display: flex;justify-content: right">
                                            <p>{!! str_replace(',','<br>',$s->part)!!}</p>
                                          </div>
                                      </div>
                    @endif
                @endforeach

                           </div>
                       </div><br>
                    @endif
                    @if(count($themes)==0)
                            <p>Δεν υπάρχουν καταχωρημένα δεδομένα της αναζητησή σας</p>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    Pop up window to delete, edit or add a lesson--}}
        @include('popup-windows.themes_Create_Delete')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () { $('#chooseactivities').addClass('active');});

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
                var be=document.getElementsByClassName('edit');
                for (var i = 0; i < be.length; i++) { be[i].style.display = 'none'; }
                var bd=document.getElementsByClassName('delete');
                for (var i = 0; i < bd.length; i++) { bd[i].style.display = 'none'; }
            }
            if (startTimestamp < currentTimestamp && endTimestamp < currentTimestamp) {
                timeDifferenceText = 'Έχει Λήξει';
                var be=document.getElementsByClassName('edit');
                for (var i = 0; i < be.length; i++) { be[i].style.display = 'none'; }
                var bd=document.getElementsByClassName('delete');
                for (var i = 0; i < bd.length; i++) { bd[i].style.display = 'none'; }
                if (role === 'Μαθητής') {
                    var b1=document.getElementsByClassName('confirm');
                    for (var i = 0; i < b1.length; i++) { b1[i].style.display = 'none'; }
                }
            }
            if (startTimestamp > currentTimestamp || startTimestamp===endTimestamp) {
                var be=document.getElementsByClassName('edit');
                for (var i = 0; i < be.length; i++) { be[i].style.display = 'block'; }
                var bd=document.getElementsByClassName('delete');
                for (var i = 0; i < bd.length; i++) { bd[i].style.display = 'block'; }
                timeDifferenceText = 'Απενεργό';}

            activity[0].getElementsByClassName("time-difference")[0].textContent = timeDifferenceText;
        }
        // Call the calculateTimeDifference function initially and then update every second
        calculateTimeDifference();
        setInterval(calculateTimeDifference, 1000);


            $(".title").click( function() {
                var $container = $(this).closest(".card-header");
                var $description = $container.find(".description");

                $description.toggle();
                $container.toggleClass('active');
            });

    </script>
@endsection


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
                                    <?php $act_title = $a->title; $act_id= $a->id;?>
                            </div>
                            <div style="text-align: right; display: flex; justify-content: space-between" class="pt-3"><p class='time-difference'></p>
                                <p>Λήξη: {{date('d-m-Y H:i', strtotime($a->updated_at))}} </p></div>

                            @if(Auth::user()->role!=='Μαθητής')
                                @include('forms.export_Votes')
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
                        <h5>Ερωτήσεις</h5>
                        @if(Auth::user()->role!=='Μαθητής')
                            <button type="button" class="button-3 create-3"  style="position: absolute;top: 5px; right: 15px" onclick="">+ Νέα Ερώτηση</button>
                        @endif
                    </div>
                    <form method="post" action="{{ url('/vote') }}" class="card-body results" id="results"> @csrf @method('GET')
                        <input type="text" name="am" value="{{Auth::user()->am}}" hidden>
            @if(count($questions)!=0)
               <?php $counter=1; ?>
                @foreach($questions as $s)
                    @if ($loop->first)
                        <div class="card">
                            <div class="card-header">
                                @if(Auth::user()->role!=='Μαθητής')
                                    <button type="button" class="edit" style="position: absolute;left: 15px;top:2px;" data-info="<?php echo htmlspecialchars(json_encode((array)$s), ENT_QUOTES, 'UTF-8'); ?>">
                                        <span class="edit__icon"><ion-icon name="create"></ion-icon></span>
                                    </button>
                                    <button type="button" class="delete" data-id="{{$s->q_id}}" data-text="{{$s->question}}" style="position: absolute;right: 20px; top:3px;">
                                        <span class="delete__icon"><ion-icon name="trash"></ion-icon></span>
                                    </button>
                                @endif
                                <label class="title ml-5">Ερώτηση {{$counter}}</label><label class="form-control-sm">/ {{$s->type}}</label>
                                <div class="title">{!!$s->question!!}</div>
                                <?php $counter++; ?>
                                    @if($allowtosee==1)
                                        <br><p style="font-size:smaller;text-align: right;">Αριθμός Συμμετοχών στην ψηφοφορία: {{$s->voters}} </p>
                                    @endif
                            </div>
                            <div class="card-body">
                                @if(Auth::user()->role!=='Μαθητής')
                                    <button type="button" class="confirm"  data-id="{{$s->q_id}}" data-title="{{$counter}}">
                                        <span class="confirm__icon"><ion-icon name="add-circle-outline"></ion-icon></span>
                                    </button>
                                @endif
                                @if($s->answer!==null)
                                    <div class="mt-1" style="display: flex;justify-content: space-between">
                                        <input type="checkbox" class="form-check-input ml-3" name="v[]" data-question="{{$s->q_id}}" data-answer="{{$s->a_id}}" data-type="{{$s->type}}" value="{{$s->q_id}},{{$s->a_id}}" id="{{$s->q_id}},{{$s->a_id}}" >
                                        <div class="ml-5" style="font-size: small;width: 75%;">{!! $s->answer !!}</div>
                                        @if($allowtosee==1)
                                                <?php $persent = ''; if ($s->allthevotes > 0) {$persent = number_format(($s->votes / $s->allthevotes) * 100,0) . '%';} ?>
                                            <label>{{$persent}}</label>
                                        @endif
                                        @if(Auth::user()->role!=='Μαθητής')
                                            <button type="button" class="delete_paper" data-id="{{$s->a_id}}" data-title="{{$counter}}" data-text="{{$s->answer}}" ><ion-icon  name="close"></ion-icon></button>
                                        @endif
                                    </div>
                                @endif


                    @elseif($s->q_id === $questions[$loop->index - 1]->q_id)
                                        @if($s->answer!==null)
                                            <div class="mt-1" style="display: flex;justify-content: space-between">
                                                <input type="checkbox" class="form-check-input ml-3" name="v[]" data-question="{{$s->q_id}}" data-answer="{{$s->a_id}}" data-type="{{$s->type}}" value="{{$s->q_id}},{{$s->a_id}}" id="{{$s->q_id}},{{$s->a_id}}" >
                                                <div class="ml-5" style="font-size: small;width: 75%;">{!! $s->answer !!}</div>
                                                @if($allowtosee==1)
                                                        <?php $persent = '';if ($s->allthevotes > 0) {$persent = number_format(($s->votes / $s->allthevotes) * 100,0) . '%';} ?>
                                                    <label>{{$persent}}</label>
                                                @endif
                                                @if(Auth::user()->role!=='Μαθητής')
                                                    <button type="button" class="delete_paper" data-id="{{$s->a_id}}" data-title="{{$counter}}" data-text="{{$s->answer}}" ><ion-icon  name="close"></ion-icon></button>
                                                @endif
                                            </div>
                                        @endif
                    @else
                                </div>
                       </div><br>
                           <div class="card">
                               <div class="card-header">
                                   @if(Auth::user()->role!=='Μαθητής')
                                       <button type="button" class="edit" style="position: absolute;left: 15px;top:2px;" data-info="<?php echo htmlspecialchars(json_encode((array)$s), ENT_QUOTES, 'UTF-8'); ?>">
                                           <span class="edit__icon"><ion-icon name="create"></ion-icon></span>
                                       </button>
                                       <button type="button" class="delete" data-id="{{$s->q_id}}" data-text="{{$s->question}}" style="position: absolute;right: 20px; top:3px;">
                                           <span class="delete__icon"><ion-icon name="trash"></ion-icon></span>
                                       </button>
                                   @endif
                                   <label class="title ml-5">Ερώτηση {{$counter}}</label><label class="form-control-sm">/ {{$s->type}}</label>
                                       <div class="title">{!!$s->question!!}</div>
                                       <?php $counter++; ?>
                                       @if($allowtosee==1)
                                           <br><p style="font-size:smaller;text-align: right;">Αριθμός Συμμετοχών στην ψηφοφορία: {{$s->voters}} </p>
                                       @endif

                               </div>
                                  <div class="card-body">
                                      @if(Auth::user()->role!=='Μαθητής')
                                          <button type="button" class="confirm"  data-id="{{$s->q_id}}" data-title="{{$counter}}">
                                              <span class="confirm__icon"><ion-icon name="add-circle-outline"></ion-icon></span>
                                          </button>
                                      @endif
                                          @if($s->answer!==null)
                                              <div class="mt-1" style="display: flex;justify-content: space-between">
                                                  <input type="checkbox" class="form-check-input ml-3" name="v[]" data-question="{{$s->q_id}}" data-answer="{{$s->a_id}}" data-type="{{$s->type}}" value="{{$s->q_id}},{{$s->a_id}}" id="{{$s->q_id}},{{$s->a_id}}" >
                                                  <div class="ml-5" style="font-size: small;width: 75%;">{!! $s->answer !!}</div>
                                                  @if($allowtosee==1)
                                                          <?php $persent = '';if ($s->allthevotes > 0) {$persent = number_format(($s->votes / $s->allthevotes) * 100,0) . '%';} ?>
                                                      <label>{{$persent}}</label>
                                                  @endif
                                                  @if(Auth::user()->role!=='Μαθητής')
                                                      <button type="button" class="delete_paper" data-id="{{$s->a_id}}" data-title="{{$counter}}" data-text="{{$s->answer}}" ><ion-icon  name="close"></ion-icon></button>
                                                  @endif
                                              </div>
                                          @endif
                    @endif
                @endforeach

                           </div>
                       </div><br>
                    @endif
                    @if(count($questions)==0)
                            <p>Δεν υπάρχουν καταχωρημένα δεδομένα της αναζητησή σας</p>
                    @endif

                    @if($allowtovote===1)
                        <div style="height: 25px;">
                            <input type="submit" value="Υποβολή" style="position: absolute; right: 20px;" class="button-3">
                        </div>
                    @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--    Pop up window to delete, edit or add a lesson--}}
        @include('popup-windows.votes-Create_Delete')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () { $('#votingactivities').addClass('active');});

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
                var bdp=document.getElementsByClassName('delete_paper');
                for (var i = 0; i < bdp.length; i++) { bdp[i].style.display = 'none'; }
                var b3=document.getElementsByClassName('created-3');
                for (var i = 0; i < b3.length; i++) { b3[i].style.display = 'none'; }
                var b1=document.getElementsByClassName('confirm');
                for (var i = 0; i < b1.length; i++) { b1[i].style.display = 'none'; }
            }
            if (startTimestamp < currentTimestamp && endTimestamp < currentTimestamp) {
                timeDifferenceText = 'Έχει Λήξει';
                var be=document.getElementsByClassName('edit');
                for (var i = 0; i < be.length; i++) { be[i].style.display = 'none'; }
                var bd=document.getElementsByClassName('delete');
                for (var i = 0; i < bd.length; i++) { bd[i].style.display = 'none'; }
                var bdp=document.getElementsByClassName('delete_paper');
                for (var i = 0; i < bdp.length; i++) { bdp[i].style.display = 'none'; }
                var b3=document.getElementsByClassName('button-3');
                for (var i = 0; i < b3.length; i++) { b3[i].style.display = 'none'; }
                var b1=document.getElementsByClassName('confirm');
                for (var i = 0; i < b1.length; i++) { b1[i].style.display = 'none'; }

            }
            if (startTimestamp > currentTimestamp || startTimestamp===endTimestamp) {
                var be=document.getElementsByClassName('edit');
                for (var i = 0; i < be.length; i++) { be[i].style.display = 'block'; }
                var bd=document.getElementsByClassName('delete');
                for (var i = 0; i < bd.length; i++) { bd[i].style.display = 'block'; }
                timeDifferenceText = 'Απενεργό';
                var bdp=document.getElementsByClassName('delete_paper');
                for (var i = 0; i < bdp.length; i++) { bdp[i].style.display = 'block'; }
                var b3=document.getElementsByClassName('button-3');
                for (var i = 0; i < b3.length; i++) { b3[i].style.display = 'block'; }
                var b1=document.getElementsByClassName('confirm');
                for (var i = 0; i < b1.length; i++) { b1[i].style.display = 'block'; }
            }


            activity[0].getElementsByClassName("time-difference")[0].textContent = timeDifferenceText;
        }
        // Call the calculateTimeDifference function initially and then update every second
        calculateTimeDifference();
        setInterval(calculateTimeDifference, 1000);

        var data = [];

        $(document).ready(function () {

            @foreach($choises as $c)
            @if($c->type === 'Μίας Επιλογής')
            var ch = { q_id: {{$c->q_id}}, answer: '{{ $c->choise }}' };
            document.getElementById('{{ $c->choise }}').checked = true;
            data.push(ch);
            @endif
            document.getElementById('{{ $c->choise }}').checked = true;
            @endforeach
        });

        $(document).ready(function () {

            $('.form-check-input').click(function () {
                var type = $(this).data('type');
                var answer = $(this).val();
                var q_id = $(this).data('question');
                var newval = { q_id: q_id, answer: answer };

                if (type === 'Μίας Επιλογής') {
                    const index = data.findIndex(row => row.q_id === q_id);

                    if ($(this).prop('checked') === true) {
                        if (index !== -1) {
                            // Uncheck the previously selected answer
                            document.getElementById(data[index].answer).checked=false;
                            // Update the selected answer in the data array
                            data[index].answer = answer;
                        } else {
                            data.push(newval);
                        }
                    } else {
                        // If the checkbox is unchecked, remove the entry from the data array
                        if (index !== -1) {
                            data.splice(index, 1);
                        }
                    }
                }
            });
        });



    </script>
@endsection


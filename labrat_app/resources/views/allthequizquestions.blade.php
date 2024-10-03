
@extends('layouts.appLessonArea')

@section('sidebar')
    @include('navbars.lessonArea_sidebar')
@endsection

@section('content')
    @include('layouts.success_msg_warning')

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-4">
                <h5> {{$l_id}} - {!!$title!!}</h5>
                <p>Διδάσκων: {{$name}}</p>
            </div>
            @if(Auth::user()->role!=='Μαθητής')
                @include('layouts.Activity_Link')
            @else
                <div class="col-lg-4"></div>
            @endif

            <?php $act_title = ''; $act_id=''; $at_id=''; $maxgrade='' ?>
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
                                    <?php $act_title = $a->title; $act_id= $a->id; $maxgrade=$a->maxgrade?>
                            </div>
                            <div style="text-align: right; display: flex; justify-content: space-between" class="pt-3"><p class='time-difference'></p>
                                <p>Λήξη: {{date('d-m-Y H:i', strtotime($a->updated_at))}} </p></div>

                            @if(Auth::user()->role!=='Μαθητής')
                                    <div  class="col-lg-6" ></div>
                                    <form action="{{ route('quizparticipation',['act_id'=>$act_id,'l_id'=>$l_id,'title'=>$title,'name'=>$name]) }}" method="post" class="col-lg-6" > @csrf @method('GET')
                                        <hr><div class="form-control" style="border: none;background-color: transparent;"></div>
                                        <label>Συμμετοχές και Αποτελέσματα Quiz:</label>
                                        <button type="submit" class="button-5 col-md-12 mt-3">Αποτελέσματα Quiz</button>
                                    </form>
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
                @isset($allthetries)
                    <?php $i=count($allthetries) ?>
                    @foreach($allthetries as $a)
                        <input class="t" type="radio" name="tabs" id="tab{{$a->id}}" onclick="document.getElementById('myform{{$a->id}}').submit();" @if($a->id===$t_id) checked @endif /><label class="l" for="tab{{$a->id}}">{{$i}}η Προσπάθεια</label>
                            <?php $i=$i-1; ?>
                        <form id="myform{{$a->id}}" style="position: absolute" method="post" action="{{ route('showTheQuiz',['l_id'=>$l_id,'title'=>$title,'name'=>$name,'act_id'=>$act_id])}}"> @csrf @method('GET')
                            <input type="text" value="{{$a->id}}" name="tryid" hidden>
                        </form>


                    @endforeach
                @endisset
                <div class="card">
                    <div class="card-header">

                        @if(Auth::user()->role!=='Μαθητής')
                            <button type="button" class="button-3 create-3"  style="position: absolute;top: 5px; right: 15px" onclick="">+ Νέα Ερώτηση</button>

                        @endif
                            <p>Τελική Βαθμολογία: <b id="totalscore"></b>/{{$maxgrade}} </p>
                            <p style="font-size: small">Τρέχουσα Βαθμολογία: <b id="tempscore"></b>/{{$maxgrade}} </p>
                    </div>

                    <form method="post" action="{{ url('/deliveranswers') }}" class="card-body results" id="formdata"> @csrf @method('GET')
                        <input type="text" name="t_id" value="{{$t_id}}" hidden>
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
                                <label class="title ml-5">Ερώτηση {{$counter}}</label><label class="form-control-sm">/ {{$s->type}}&nbsp;&nbsp;({{$s->maxgrade}} μονάδες)</label>

                                <div class="title">{!!$s->question!!}</div>
                                    @if($allowtosee==1 && Auth::user()->role==='Μαθητής')
                                    <div class="justify-content-end mt-3" style="display: flex">
                                        <p style="font-size: small;">Τελικό score: <b id="score{{$s->q_id}}">0.00</b>/{{$s->maxgrade}}</p>
                                    </div>
                                    @endif
                                <?php $counter++; ?>

                            </div>
                            <div class="card-body">
                                @if(Auth::user()->role!=='Μαθητής' && ($s->type!=='Ελεύθερου Κειμένου') && ( $s->type!=='Ναι/Όχι' || $s->answer==null))
                                    <button type="button" class="confirm"  data-id="{{$s->q_id}}" data-title="{{$s->question}}" data-type="{{$s->type}}">
                                        <span class="confirm__icon"><ion-icon name="add-circle-outline"></ion-icon></span>
                                    </button>
                                @endif
                                    @if($s->type==='Ελεύθερου Κειμένου')
                                        <textarea class="question" name="ft[{{$s->q_id}}]" id="{{$s->q_id}}"></textarea>
                                    @endif
                                    @if($s->type==='Αντιστοίχιση')
                                        <div style="display: flex">
                                            <div class="col-md-6" style="margin-left: auto;margin-right: auto;">
                                                <table>
                                                    <thead>
                                                    <tr><td style="text-align: center;">ΛΙΣΤΑ 1</td><td style="text-align: center;">ΛΙΣΤΑ 2</td></tr>
                                                    </thead>
                                                    <tbody id="answers{{$s->q_id}}"></tbody>
                                                </table>
                                                @if($allowtosee===0)
                                                <button type="button" data-id="{{$s->q_id}}" class="newanswer form-control" style="margin-left: auto;margin-right: auto;" >Προσθήκη Απάντησης</button>
                                                @endif
                                            </div>
                                            <div id="grade{{$s->q_id}}"></div>

                                        </div>

                                    @endif
                                    @if($s->type==='Αντιστοίχιση' && Auth::user()->role!='Μαθητής' && $s->answer!=null)
                                            <?php $a = explode("=",$s->answer);?>
                                        <script>
                                            @if($s->answer==='=')
                                            $('#answers{{$s->q_id}}').html( '<tr>'+
                                                '<td colspan="2" style="text-align: center;">Κάθε Λάθος Απάντηση </td>'+
                                                '</tr>');
                                            @else
                                            $('#answers{{$s->q_id}}').html( '<tr>'+
                                                '<td>'+
                                                ' <select class="form-select text-center" disabled>'+
                                                '<option selected hidden>{{$a[0]}}</option>'+
                                                '</select>'+
                                                '</td>'+
                                                '<td>'+
                                                '<select class="form-select text-center" disabled>'+
                                                '<option selected hidden>{{$a[1]}}</option>'+
                                                '</select>'+
                                                '</td>'+
                                                '</tr>');
                                            @endif

                                            $('#grade{{$s->q_id}}').css('width', '15%');
                                            $('#grade{{$s->q_id}}').html('<div style="height:30px;"></div><div style="display:flex;justify-content:space-between;height:40px;"><label style="font-size: x-small">({{$s->grade}} μονάδες)</label>'+
                                                '<button type="button" class="delete_paper" data-id="{{$s->a_id}}" data-title="{{$counter}}" data-text="{{$s->answer}}" ><ion-icon  name="close"></ion-icon></button></div>');
                                        </script>
                                    @endif
                                @if($s->answer!==null && $s->type!=='Αντιστοίχιση')
                                    <div class="mt-1" style="display: flex;justify-content: space-between">
                                        <input type="checkbox" class="form-check-input ml-3" name="v[]" data-question="{{$s->q_id}}" data-answer="{{$s->a_id}}" data-type="{{$s->type}}" value="{{$s->q_id}},{{$s->a_id}}" id="{{$s->q_id}},{{$s->a_id}}" @if(Auth::user()->role!='Μαθητής' && $s->grade>0) checked @endif>
                                        <div class="ml-5" style="font-size: small;width: 75%;">{!! $s->answer !!}</div>@if($s->grade!=0 && $allowtosee==1) <label style="font-size: x-small">({{$s->grade}} μονάδες)</label> @endif
                                        @if(Auth::user()->role!=='Μαθητής' )
                                            <button type="button" class="delete_paper" data-id="{{$s->a_id}}" data-title="{{$counter}}" data-text="{{$s->answer}}" ><ion-icon  name="close"></ion-icon></button>
                                        @endif
                                    </div>
                                @endif


                    @elseif($s->q_id === $questions[$loop->index - 1]->q_id)
                                        @if($s->type==='Ελεύθερου Κειμένου')
                                            <div >
                                                <textarea class="question"  name="ft[{{$s->q_id}}]" id="{{$s->q_id}}" ></textarea>
                                            </div>
                                        @endif
                                            @if($s->type==='Αντιστοίχιση' && Auth::user()->role!='Μαθητής' && $s->answer!=null)
                                                    <?php $a = explode("=",$s->answer);?>
                                                <script>
                                                    @if($s->answer==='=')
                                                    $('#answers{{$s->q_id}}').append( '<tr>'+
                                                        '<td colspan="2" style="text-align: center;">Κάθε Λάθος Απάντηση </td>'+
                                                        '</tr>');
                                                    @else
                                                    $('#answers{{$s->q_id}}').append( '<tr>'+
                                                        '<td>'+
                                                        ' <select class="form-select text-center" disabled>'+
                                                        '<option selected hidden>{{$a[0]}}</option>'+
                                                        '</select>'+
                                                        '</td>'+
                                                        '<td>'+
                                                        '<select class="form-select text-center" disabled>'+
                                                        '<option selected hidden>{{$a[1]}}</option>'+
                                                        '</select>'+
                                                        '</td>'+
                                                        '</tr>');
                                                    @endif
                                                    $('#grade{{$s->q_id}}').append('<div style="display:flex;justify-content:space-between;height:40px;"><label style="font-size: x-small">({{$s->grade}} μονάδες)</label>'+
                                                        '<button type="button" class="delete_paper" data-id="{{$s->a_id}}" data-title="{{$counter}}" data-text="{{$s->answer}}" ><ion-icon  name="close"></ion-icon></button></div>');
                                                </script>
                                            @endif

                                        @if($s->answer!==null && $s->type!=='Αντιστοίχιση')
                                            <div class="mt-1" style="display: flex;justify-content: space-between">
                                                <input type="checkbox" class="form-check-input ml-3" name="v[]" data-question="{{$s->q_id}}" data-answer="{{$s->a_id}}" data-type="{{$s->type}}" value="{{$s->q_id}},{{$s->a_id}}" id="{{$s->q_id}},{{$s->a_id}}" @if(Auth::user()->role!=='Μαθητής' && $s->grade>0) checked @endif>
                                                <div class="ml-5" style="font-size: small;width: 75%;">{!! $s->answer !!}</div>@if($s->grade!=0 && $allowtosee==1) <label style="font-size: x-small">({{$s->grade}} μονάδες)</label> @endif
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
                                   <label class="title ml-5">Ερώτηση {{$counter}}</label><label class="form-control-sm">/ {{$s->type}}&nbsp;&nbsp;({{$s->maxgrade}} μονάδες)</label>
                                       <div class="title">{!!$s->question!!}</div>
                                       @if($allowtosee==1 && Auth::user()->role==='Μαθητής')
                                           <div class="justify-content-end mt-3" style="display: flex;">
                                               <label style="font-size: small;">Τελικό score: <b id="score{{$s->q_id}}">0.00</b>/{{$s->maxgrade}}</label>
                                           </div>
                                       @endif
                                       <?php $counter++; ?>
                               </div>
                                  <div class="card-body">
                                      @if(Auth::user()->role!=='Μαθητής' && ($s->type!=='Ελεύθερου Κειμένου') && ( $s->type!=='Ναι/Όχι' || $s->answer==null))
                                          <button type="button" class="confirm"  data-id="{{$s->q_id}}" data-title="{{$s->question}}" data-type="{{$s->type}}">
                                              <span class="confirm__icon"><ion-icon name="add-circle-outline"></ion-icon></span>
                                          </button>
                                      @endif
                                          @if($s->type==='Ελεύθερου Κειμένου')
                                              <div>
                                                  <textarea class="question"  name="ft[{{$s->q_id}}]" id="{{$s->q_id}}"></textarea>
                                              </div>
                                          @endif
                                          @if($s->type==='Αντιστοίχιση')
                                              <div style="display: flex">
                                                  <div class="col-md-6" style="margin-left: auto;margin-right: auto;">
                                                      <table>
                                                          <thead>
                                                          <tr><td style="text-align: center;">ΛΙΣΤΑ 1</td><td style="text-align: center;">ΛΙΣΤΑ 2</td></tr>
                                                          </thead>
                                                          <tbody id="answers{{$s->q_id}}">

                                                          </tbody>
                                                      </table>
                                                      @if($allowtosee===0)
                                                      <button type="button" data-id="{{$s->q_id}}" class=" newanswer form-control" style="margin-left: auto;margin-right: auto;" >Προσθήκη Απάντησης</button>
                                                      @endif
                                                  </div>
                                                  <div id="grade{{$s->q_id}}"></div>

                                              </div>

                                          @endif
                                          @if($s->type==='Αντιστοίχιση' && Auth::user()->role!='Μαθητής' && $s->answer!=null)
                                              <?php $a = explode("=",$s->answer);?>
                                              <script>
                                                  @if($s->answer==='=')
                                                  $('#answers{{$s->q_id}}').html( '<tr>'+
                                                      '<td colspan="2" style="text-align: center;">Κάθε Λάθος Απάντηση </td>'+
                                                      '</tr>');
                                                  @else
                                                  $('#answers{{$s->q_id}}').html( '<tr>'+
                                                      '<td>'+
                                                      ' <select class="form-select text-center" disabled>'+
                                                      '<option selected hidden>{{$a[0]}}</option>'+
                                                      '</select>'+
                                                      '</td>'+
                                                      '<td>'+
                                                      '<select class="form-select text-center" disabled>'+
                                                      '<option selected hidden>{{$a[1]}}</option>'+
                                                      '</select>'+
                                                      '</td>'+
                                                      '</tr>');
                                                  @endif
                                                  $('#grade{{$s->q_id}}').css('width', '15%');
                                                  $('#grade{{$s->q_id}}').html('<div style="height:30px;"></div><div style="display:flex;justify-content:space-between;height:40px;"><label style="font-size: x-small">({{$s->grade}} μονάδες)</label>'+
                                                      '<button type="button" class="delete_paper" data-id="{{$s->a_id}}" data-title="{{$counter}}" data-text="{{$s->answer}}" ><ion-icon  name="close"></ion-icon></button></div>');
                                              </script>
                                          @endif
                                          @if($s->answer!==null && $s->type!=='Αντιστοίχιση')
                                              <div class="mt-1" style="display: flex;justify-content: space-between">
                                                  <input type="checkbox" class="form-check-input ml-3" name="v[]" data-question="{{$s->q_id}}" data-answer="{{$s->a_id}}" data-type="{{$s->type}}" value="{{$s->q_id}},{{$s->a_id}}" id="{{$s->q_id}},{{$s->a_id}}" @if(Auth::user()->role!='Μαθητής' && $s->grade>0) checked @endif>
                                                  <div class="ml-5" style="font-size: small;width: 75%;">{!! $s->answer !!}</div>@if($s->grade!=0 && $allowtosee==1) <label style="font-size: x-small">({{$s->grade}} μονάδες)</label> @endif
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

                    @if($allowtosee===0)
                        <div style="height: 25px;">
                            <input type="text" id="previousPageUrl" name="previousPageUrl" value="" hidden>
                            <script>
                                document.getElementById('previousPageUrl').value = document.referrer;
                            </script>
                            <input type="submit" value="Υποβολή" style="position: absolute; right: 20px;" class="button-3">
                        </div>
                    @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container col-md-8" id="show">

    </div>
{{--    @if(Auth::user()->role!='Μαθητής')--}}
    {{--    Pop up window to delete, edit or add a lesson--}}
        @include('popup-windows.quizQuestions-Create_Delete')
{{--    @endif--}}

{{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        $(document).ready(function () { $('#quizactivities').addClass('active');});
        tinyMCE.init({
            selector: 'textarea.question',
            plugins: 'autolink lists link charmap preview wordcount quickbars table',
            toolbar: 'undo redo | bold italic underline | bullist | wordcount |  table| alignleft aligncenter alignright',
            menubar: false,
            force_br_newlines: true, // Recognize newlines as line breaks
            height: 250,
            elementpath: false,
            branding: false,
            entity_encoding: "raw",
            table_default_styles: {
                borderCollapse: 'collapse',
                border: '1px solid black' // Change the color and thickness as needed for table borders
            },
        });

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
             var totalgrade=0;
             var tempgrade=0;
             var allowtoshow=1;
            @foreach($choises as $c)
            {{--console.log({{$c->choise}});--}}
            @if(($c->type === 'Μίας Επιλογής' || $c->type === 'Ναι/Όχι') && $c->choise!=null)
                var ch = { q_id: {{$c->q_id}}, answer: '{{ $c->choise }}' };
                var element=document.getElementById('{{ $c->choise }}');
                element.checked = true;
                $('#score{{$c->q_id}}').html("{{$c->grade}}");
                data.push(ch);
                @if($allowtosee===1 && $c->grade>0)
                    element.style.backgroundColor = '#33cc33';
                    @elseif($allowtosee===1 && $c->grade<=0)
                    element.style.backgroundColor= '#A60505';
                @endif
            @endif
            @if($c->type === 'Πολλαπλής Επιλογής' && $c->choise!=null)
            var element=document.getElementById('{{ $c->choise }}');
            element.checked = true;
            var score=parseFloat($('#score{{$c->q_id}}').text())+parseFloat({{$c->grade}});
            $('#score{{$c->q_id}}').text(score)

            @if($allowtosee===1 && $c->grade>0)
                element.style.backgroundColor = '#33cc33';
            @elseif($allowtosee===1 && $c->grade<=0)
                element.style.backgroundColor= '#A60505';
            @endif
            @endif
            @if($c->type==='Ελεύθερου Κειμένου' && $c->choise!=null)
                @if($c->grade===null)
                $('#score{{$c->q_id}}').text('Αναμένεται');
                allowtoshow=0;
                @else
                $('#score{{$c->q_id}}').text("{{$c->grade}}");
                @endif
                $("#{{$c->q_id}}").html("{{$c->choise}}");
            @endif
            @if($c->type==='Αντιστοίχιση' && $c->choise!=null)

            var score=parseFloat($('#score{{$c->q_id}}').text())+parseFloat({{$c->grade}});
            $('#score{{$c->q_id}}').text(score)

            var ch = "{{$c->choise}}".split("=");
            $('#answers{{$c->q_id}}').append( '<tr>'+
                '<td><select name="l1[]" class="form-select text-center" @if($allowtosee===1 && $c->grade>0) style="background:rgba(1, 99, 0, 0.1)" @elseif($allowtosee==1 && $c->grade<=0) style="background:rgba(255, 99, 71, 0.2)" @endif>'+
                '<option value="'+ {{$c->q_id}}+','+ch[0]+'" selected hidden>'+ch[0]+'</option>'+
                '@for($i = 'A'; $i <= 'Z'; $i++)'+
                '<option value="'+ {{$c->q_id}}+',{{$i}}">{{$i}}</option>'+
                '@endfor'+
                '</select>'+
                '</td>'+
                '<td><select name="l2[]" class="form-select text-center" @if($allowtosee==1 && $c->grade>0) style="background:rgba(1, 99, 0, 0.1)" @elseif($allowtosee==1 && $c->grade<=0) style="background:rgba(255, 99, 71, 0.2)" @endif>'+
                '<option value="'+ {{$c->q_id}}+','+ch[1]+'" selected hidden>'+ch[1]+'</option>'+
                '@for($i = '1'; $i <= '15'; $i++)'+
                '<option value="'+{{$c->q_id}}+',{{$i}}">{{$i}}</option>'+
                '@endfor'+
                '</select>'+
                '</td>'+
                '</tr>');

                @if($allowtosee===1)
                $('#grade{{$c->q_id}}').css('width', '15%');
                $('#grade{{$c->q_id}}').append('<div style="height:30px;"></div><div style="display:flex;justify-content:space-between;height:10px;"><label style="font-size: x-small">({{$c->grade}} μονάδες)</label>');
                @endif

            @endif
            @if($c->grade!==NULL)
                    totalgrade+=parseFloat({{$c->grade}});
            @endif
             @if($c->grade!==NULL && $c->type!=='Αντιστοίχιση')
                tempgrade+=parseFloat({{$c->grade}});
            @endif
            @endforeach
                if({{$allowtosee}}==1 && allowtoshow===1) {
                    document.getElementById('totalscore').innerHTML = totalgrade;
                }
                if({{$allowtosee}}===1) {
                    document.getElementById('tempscore').innerHTML = tempgrade;
                }
        });

        $(document).ready(function () {

            $('.form-check-input').click(function () {
                var type = $(this).data('type');
                var answer = $(this).val();
                var q_id = $(this).data('question');
                var newval = { q_id: q_id, answer: answer };

                if (type === 'Μίας Επιλογής' || type === 'Ναι/Όχι') {
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

        $('.newanswer').click(function (){
            var q_id = $(this).data('id');
            $('#answers'+q_id).append( '<tr>'+
                '<td><select name="l1[]" class="form-select text-center">'+
                '<option value="" selected hidden>Επιλέξτε</option>'+
                '@for($i = 'A'; $i <= 'Z'; $i++)'+
                '<option value="'+q_id+',{{$i}}">{{$i}}</option>'+
                '@endfor'+
                '</select>'+
                '</td>'+
                '<td><select name="l2[]" class="form-select text-center">'+
                '<option value="" selected hidden>Επιλέξτε</option>'+
                '@for($i = '1'; $i <= '15'; $i++)'+
                '<option value="'+q_id+',{{$i}}">{{$i}}</option>'+
                '@endfor'+
                '</select>'+
                '</td>'+
                '</tr>');

        });


            // Function to read and store form values
            function readAndStoreFormValues() {

                var t_id = {{ json_encode($t_id) }};

                //Select all form elements with the name "name"
                var checkInputs = document.querySelectorAll('[name="v[]"]');
                var checkedValues = [];

                var textInputs = document.querySelectorAll('textarea.question');
                var textValues = [];

                var l1=document.querySelectorAll('[name="l1[]"]');
                var l2=document.querySelectorAll('[name="l2[]"]');

                var l1Values=[];
                var l2Values=[];
                // Iterate through the selected elements and store their values
                checkInputs.forEach(function(input) {
                    if (input.checked) {
                        checkedValues.push(input.value);

                    }
                });
                textInputs.forEach(function(input) {
                    var editor = tinymce.get(input.id);
                    if (editor) {

                        textValues.push(input.id+','+editor.getContent());
                        console.log(textValues);
                    }
                });
                l1.forEach(function(input) {
                        l1Values.push(input.value);
                });
                l2.forEach(function(input) {
                    l2Values.push(input.value);
                });

                var formData = {
                    t_id: t_id,
                    checkedValues: checkedValues,
                    textValues: textValues,
                    l1Values: l1Values,
                    l2Values: l2Values
                };

                axios.get('/autosave', {
                    params: formData, // Pass the data as query parameters
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => {
                        console.log(response.data.message); // Server response message
                    })
                    .catch(error => {
                        console.error(error);
                    });


        }

        @if(Auth::user()->role==='Μαθητής')
         if(startTimestamp <= new Date().getTime() && endTimestamp >= new Date().getTime()){
            // Set an interval to repeatedly call the function every 5 seconds (5000 milliseconds)
            setInterval(readAndStoreFormValues, 5000);
        }
        @endif


    </script>
@endsection


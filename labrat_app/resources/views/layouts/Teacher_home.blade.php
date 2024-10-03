<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div>
                <div class="card">
                    <div class="card-header " style="display: flex;">
                        <h5>Μαθήματα</h5>
                    </div>
                    <div class="card-body results" id="results">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                        @endif
                        <input class="t" @if($type === 'Προπτυχιακό') checked
                               @endif onclick="window.location='{{ route("thehome",['type'=>'Προπτυχιακό','am'=>Auth::user()->id]) }}'"
                               type="radio" name="tabs" id="tab1"/>
                        <label class="l" for="tab1">Προπτυχιακό</label>
                        <input class="t" @if($type === 'Μεταπτυχιακό') checked
                               @endif onclick="window.location='{{ route("thehome",['type'=>'Μεταπτυχιακό','am'=>Auth::user()->id]) }}'"
                               type="radio" name="tabs" id="tab2"/>
                        <label class="l" for="tab2">Μεταπτυχιακό</label>
                        <input class="t" @if($type === 'Διδακτορικό') checked
                               @endif onclick="window.location='{{ route("thehome",['type'=>'Διδακτορικό','am'=>Auth::user()->id]) }}'"
                               type="radio" name="tabs" id="tab3"/>
                        <label class="l" for="tab3">Διδακτορικό</label>
                        @if(count($lessons)!=0)
                            <div class="table" style="right: 0;">
                                <section class="tab content1 table_tbody">
                                    @foreach ($lessons as $l)
                                        <div class="table_tr_ch lesson" style="position:relative;" data-id="{{$l->l_id}}">
                                            <div class="td slt">
                                                <a target="_blank">{{$l->l_id}}- {{$l->title}}</a><br>
                                                <p>Διδάσκων: {{$l->name}} <br> {{$l->semester}}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </section>
                            </div>
                            {{--                                                    the links for the next page of results--}}
                            {{ $lessons->links('pagination::bootstrap-4') }}
                        @endif
                        @if(count($lessons)==0)
                            <div class=" table_tr_ch">
                                <div class="td " style="width: 60%">
                                    <p>Δεν υπάρχουν καταχωρημένα δεδομένα της αναζητησή σας</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <br><br>

            </div>

            @if(count($determinateNotifications)!==0)
            <div>
                <div class="card">
                    <div class="card-header">
                        <h5>Ειδοποιήσεις</h5>
                    </div>
                    <div class="card-body results" id="results">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                        @endif


                            <div class="table">
                                <div class="table_thead"></div>
                                <div class="table_tbody">
                                    @foreach($determinateNotifications as $n)
                                        <div class="table_tr_ch time-row" data-start='{{$n->created_at}}' data-end='{{$n->updated_at}}' data-act_id="{{$n->act_id}}" data-l_id="{{$n->l_id}}" data-title="{{$n->l_title}}" data-name="{{$n->name}}" style="background-color: rgba(0, 174, 71, 0.1)">
                                            <div class="td snt">
                                                <a style="text-decoration: underline">{{$n->act_title}}</a>
                                                <p>{{$n->l_id}} - {{$n->l_title}}, &nbsp;&nbsp;Διδάσκων: {{$n->name}}</p><hr>
                                                <p>Αναμένονται θέματα για επιβεβαίωση στη δραστηριότητα '{{$n->act_title}}'.<br> Αρ.Θεμάτων για επιβεβαίωση: {{$n->dt_count}}</p>
                                                <div class="pt-3" style="display: flex; justify-content: space-between;"><p>Ημερ.Λήξης: {{ date('d-m-Y H:i', strtotime($n->updated_at) )}}</p> <p class="time-difference"></p></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
{{--                                the links for the next page of results--}}
                            {{ $determinateNotifications->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
            @endif
        </div>



        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5>Ανακοινώσεις</h5>
                </div>
                <div class="card-body results" id="results">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                    @endif

                    @if(count($notifications)!==0)
                        <div class="table">
                            <div class="table_thead"></div>
                            <div class="table_tbody">
                                @foreach($notifications as $n)
                                    <div class="table_tr_ch not_tr " data-role="{{Auth::user()->role}}"
                                         data-info="<?php echo htmlspecialchars(json_encode((array)$n), ENT_QUOTES, 'UTF-8'); ?>">
                                        <div class="td snt">
                                            <a style="text-decoration: underline">{{$n->title}}</a>
                                            <p>{{$n->l_id}} - {{$n->l_title}}, &nbsp;&nbsp;Διδάσκων: {{$n->name}}</p><hr>
                                                <?php $mytext=str_replace(["☺","☻",'♦','♣',"♥","♠"],['','','','','',''],$n->text); ?>
                                            <p style="overflow: hidden;height: 20px;">{!! substr($mytext, 0, 100) .'...' !!}</p>
                                            <p style="text-align: right">{{ date('d-m-Y H:i', strtotime($n->created_at) )}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
{{--                                                                            the links for the next page of results--}}
                        {{ $notifications->links('pagination::bootstrap-4') }}
                    @endif
                    @if(count($notifications)===0)
                            <div class="table_tr_ch">
                                <div class="td" >
                                    <p>Δεν υπάρχουν καταχωρημένα δεδομένα της αναζητησή σας</p>
                                </div>
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>






<script>
    function calculateTimeDifference() {
        var rows = document.getElementsByClassName("time-row");

        for (var i = 0; i < rows.length; i++) {
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
                rows[i].style.display='none';
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


    $(".lesson").click(function (){
        const l_id = $(this).attr('data-id');
        var url = '/lessonArea/'+l_id;
        window.location.href = url;
    });
    // $(".time-row").click(function(){
    //     const act_id = $(this).attr('data-act_id');
    //     const l_id = $(this).attr('data-l_id');
    //     const title = $(this).attr('data-title');
    //     const name = $(this).attr('data-l_id');
    //     var url = '/showTheJournals/'+l_id+'/'+title+'/'+name+'/'+act_id;
    //     window.location.href = url;
    // });

</script>
{{--@include('popup-windows.participation_Delete')--}}
@include('popup-windows.students_notification_show')
{{--@include('popup-windows.teams_Confirm')--}}

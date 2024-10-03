<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header " style="display: flex;justify-content: space-between;">
                    <h5>Συμμετοχές στα Μαθήματα</h5>
                </div>
                <div class="card-body results" id="results">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                    @endif
                    <input class="t" @if($type === 'Προπτυχιακό') checked
                           @endif onclick="window.location='{{ route("homepage",['type'=>'Προπτυχιακό','am'=>Auth::user()->am]) }}'"
                           type="radio" name="tabs" id="tab1"/>
                    <label class="l" for="tab1">Προπτυχιακό</label>
                    <input class="t" @if($type === 'Μεταπτυχιακό') checked
                           @endif onclick="window.location='{{ route("homepage",['type'=>'Μεταπτυχιακό','am'=>Auth::user()->am]) }}'"
                           type="radio" name="tabs" id="tab2"/>
                    <label class="l" for="tab2">Μεταπτυχιακό</label>
                    <input class="t" @if($type === 'Διδακτορικό') checked
                           @endif onclick="window.location='{{ route("homepage",['type'=>'Διδακτορικό','am'=>Auth::user()->am]) }}'"
                           type="radio" name="tabs" id="tab3"/>
                    <label class="l" for="tab3">Διδακτορικό</label>
                    @if(count($lessons)!=0)
                        <div class="table" style="right: 0;">
                            <section class="tab content1 table_tbody">
                                @foreach ($lessons as $l)
                                    <div class=" table_tr_ch lesson" style="position:relative;" data-id="{{$l->l_id}}">
                                        <div class="td slt">
                                            <a target="_blank">{{$l->l_id}}
                                                - {{$l->title}}</a><br>
                                            <p>Διδάσκων: {{$l->name}} <br> {{$l->semester}}</p>
                                        </div>
                                        <button type="button" class="close" style="position: absolute;top:0;right:4px;"
                                                onclick='partDeleteS("{{$l->title}}","{{$l->id}}")'><span
                                                aria-hidden="true">&times</span></button>
                                    </div>
                                @endforeach
                            </section>
                        </div>
                        {{--                            the links for the next page of results--}}
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


        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5>Ανακοινώσεις</h5>
                </div>
                <div class="card-body results" id="results">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                    @endif

                    @if(count($notifications)!=0)
                        <div class="table">
                            <div class="table_thead"></div>
                            <div class="table_tbody">
                                @foreach($notifications as $n)
                                    <div class="table_tr_ch not_tr " data-role="{{Auth::user()->role}}"
                                         data-info="<?php echo htmlspecialchars(json_encode((array)$n), ENT_QUOTES, 'UTF-8'); ?>">
                                        <div class="td snt">
                                            <a>{{$n->title}}</a>
                                            <p>{{$n->l_id}} - {{$n->l_title}}, &nbsp;&nbsp;Διδάσκων: {{$n->name}}</p><hr>
                                                <?php $mytext=str_replace(["☺","☻",'♦','♣',"♥","♠"],['','','','','',''],$n->text); ?>
                                            <p style="overflow: hidden;height: 20px;">{!! substr($mytext, 0, 100) .'...' !!}</p>
                                            <p style="text-align: right">{{ date('d-m-Y H:i', strtotime($n->created_at) )}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{--                                                    the links for the next page of results--}}
                        {{ $notifications->links('pagination::bootstrap-4') }}
                    @endif
                    @if(count($notifications)==0)
                            <div class=" table_tr_ch">
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

</script>
@include('popup-windows.participation_Delete')
@include('popup-windows.students_notification_show')
{{--@include('popup-windows.teams_Confirm')--}}

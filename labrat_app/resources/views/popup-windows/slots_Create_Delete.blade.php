<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="modal popup" id="popupcreate">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title"  style="position: relative;">
                    <h5>{{$as_title}}</h5>
                    <p style="font-size: small">{{$l_id}} - {{$title}}<br>
                        Διδάσκων: {{$name}}</p>
                </div>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                        Δημιουργία νέων slot στην δραστηριότητα Slot <b>"{{$as_title}}"</b> του μαθήματος.
                    <div class="text-end">
                        <label class="col-form-label-sm">{{$info}}<br>Αριθμός Slot: {{count($slots)}}</label>
                    </div>
                </div>
                        <form method="post" action="{{ url('/createslots') }}"> @csrf @method('GET')
                            <div class="row justify-content-between col-md-12" >
                                <input type="text" value="{{$as_id}}" name="as_id" hidden>
                                <div class="col-md-12" >
                                    <label>Ημερομηνία Slots:</label><br>
                                    <input class="form-control start" type="date" min="{{ date('Y-m-d') }}" name="slot_date" id="slot_date" value="" required/>
                                </div><br>

                            <div class="col-md-6">
                                <br><label>Ώρα Εναρξης:</label><br>
                                <input class="form-control start" type="time" name="slot_time_start" id="slot_time_start" value="" required/>
                            </div><br>

                            <div class="col-md-6" >
                                <br><label>Ώρα Λήξης:</label><br>
                                <input class="form-control start" type="time" name="slot_time_end" id="slot_time_end" value="" required/>
                            </div><br>

                            <div class="col-md-6">
                                <br><label>Διάρκεια (σε λεπτά)</label><br>
                                <input class="form-control start" type="text" name="slot_duration" id="slot_duration" value="" required/>
                                <div style="position: absolute;right: 12.7px;top:54px;border-radius: 5px;overflow: hidden;border: 0.5px solid lightgrey;">
                                    <span class="arrows up" ><ion-icon class="arrow__icon" name="arrow-dropup"></ion-icon></span>
                                    <span class="arrows down"><ion-icon class="arrow__icon" name="arrow-dropdown"></ion-icon></span>
                                </div>
                            </div><br>

                        </div><br>
                            <button type="submit" class="cbtn btn-primary">Δημιουργία</button>
                        </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<div class="modal popup" id="popupadd">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title"  style="position: relative;">
                    <h5>{{$as_title}}</h5>
                    <p style="font-size: small">{{$l_id}} - {{$title}}<br>
                        Διδάσκων: {{$name}}</p>
                </div>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    @if(Auth::user()->role!='Μαθητής')
                        @if($at_id==null) Προσθήκη Μαθητή στο Slot "<b id="date"></b>" της δραστηριότητα Slot <b>"{{$as_title}}"</b> του μαθήματος.
                        @else Προσθήκη ομάδας στο Slot "<b id="date"></b>" της δραστηριότητα Slot <b>"{{$as_title}}"</b> του μαθήματος.
                        @endif
                         <div class="text-end">
                           <label class="col-form-label-sm">{{$info}}<br>Αριθμός Slot: {{count($slots)}}</label>
                         </div>
                    @else
                        @if($at_id==null) Είστε σίγουροι ότι θέλετε να δεσμέυσετε το Slot "<b id="date"></b>" της δραστηριότητα Slot <b>"{{$as_title}}"</b> του μαθήματος;
                        @else Είστε σίγουροι ότι θέλετε η ομάδα σας να δεσμεύσει το Slot "<b id="date"></b>" της δραστηριότητα Slot <b>"{{$as_title}}"</b> του μαθήματος;
                        @endif
                    @endif

                </div>
                <form method="post" action="{{ url('/jointoslot') }}"> @csrf @method('GET')
                    <input type="text" name="slot_id" id="slot_id" value="" hidden>
                    <input type="text" name="as_id" value="{{$as_id}}" hidden>
                    <input type="text" name="at_id" value="{{$at_id}}" hidden>
                    <input type="text" name="names" id="names" class="form-control" value="" autocomplete="off" readonly required/>
                    <input type="text" name="am" id="am" value="" hidden required/>
                    <br><br>
                    <button type="submit" class="cbtn btn-primary">Δέσμευση Slot</button>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<div class="modal popupselect" id="select" style="z-index: 9999;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #94d3a2;">
                <div class="modal-title" style="position: relative;"><h5>Επιλογή@if($at_id!=null) Ομάδα@else Μαθητή@endif </h5></div>
                <button type="button" id="close_activity_slot" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow: auto;">
                <div id="the_key"></div>
                <div id="potential_teams"></div>
                <div id="pot_teams"></div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

{{--    //pop up window that gives the ability to delete a activity from the database--}}
<div class="modal popup" id="popupdelete">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title"  style="position: relative;">
                    <h5>{{$as_title}}</h5>
                    <p style="font-size: small">{{$l_id}} - {{$title}}<br>
                        Διδάσκων: {{$name}}</p>
                </div>

                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close" style="position: absolute;right: 15px;top: 10px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{url('/deletetheslot')}}">
                @csrf @method('GET')
                <div class="modal-body ">
                    <label class="col-md-12 col-form-label" id="text"></label>
                    <input type="text" id="s_id" name="slot_id" value="" hidden>
                    <button type="submit" class="btn btn-primary col-md-12">Διαγραφή</button>
                </div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>

{{--    //pop up window that gives the ability to delete a activity from the database--}}
<div class="modal popup" id="popupremove">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title"  style="position: relative;">
                    <h5>{{$as_title}}</h5>
                    <p style="font-size: small">{{$l_id}} - {{$title}}<br>
                        Διδάσκων: {{$name}}</p>
                </div>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close" style="position: absolute;right: 15px;top: 10px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ url('/leavetheslot') }}">
                @csrf @method('GET')
                <div class="modal-body ">
                    <label class="col-md-12 col-form-label" id="sr_text"></label>
                    <input type="text" id="sr_id" name="slot_id" value="" hidden>
                    <button type="submit" class="btn btn-primary col-md-12" >Αποδέσμευση Slot</button>
                </div>
            </form>
                <div class="modal-footer"></div>
        </div>
    </div>
</div>

<script>
    $('.delete').click(function (){
        var slot_id=$(this).attr('data-id');
        var date=$(this).attr('data-date');
        $('#s_id').val(slot_id);
        $('#text').html('Είστε σίγουροι ότι θέλετε να διαγράψετε το Slot <br><b>"'+ date +'"</b> από τη δραστηριότητα Slot <b>"{{$as_title}}"</b>');
        $('#popupdelete').fadeIn()
    });

    $('.create-3').click(function (){
        $('#popupcreate').fadeIn();
        $('#slot_duration').val(1);
    });
    //function that close the popups forms
    $(".popup-close").click(function () {
        $(".popup").fadeOut();
    });

    $('.up').click(function (){
        var val=$('#slot_duration').val();
        $('#slot_duration').val(parseInt(val)+1);
    });
    $('.down').click(function (){
        var val=$('#slot_duration').val();
        if(parseInt(val)>0){
            $('#slot_duration').val(parseInt(val)-1);
        }

    });

    $('.addteam').click( function(){
        var slot_id=$(this).attr('data-id');
        var date = $(this).attr('data-date');
        $('#slot_id').val(slot_id);

        // $('#s_date').val(date);

        $('#date').html(date);
        $('#names').attr('placeholder', 'Επιλέξτε τη συμμετοχή');
        $('#popupadd').fadeIn();
    });

    $('.removeteam').click(function(){
        var slot_id=$(this).attr('data-id');
        var date=$(this).attr('data-date');
        var part=$(this).attr('data-names').replace(',','<br>');
        $('#sr_id').val(slot_id);
        // $('#sr_date').val(date);
        $('#sr_text').html('Είστε σίγουροι οτι θέλετε να αποδεσμέυσετε το slot <b>"'+date+'"</b> , της Δραστηριότητας Slot <b>"{{$as_title}}"</b> από @if($at_id!=null)την ομάδα:@else από τη συμμετοχή: @endif<br><br>'+ part);

        $('#popupremove').fadeIn();
    });
    $('.confirm').click(function(){
        var slot_id=$(this).attr('data-id');
        var date=$(this).attr('data-date');
        $('#slot_id').val(slot_id);


        $('#date').html(date);
        var am ='';
        var names='';

        var table='{{$teamorpart}}'.replace(/&quot;/g, '"');
        table = JSON.parse(table);
        table.forEach(function(t){
            am=t.am ;
            names=t.info;
        });
        $("#am").val(am);
        $('#names').val(names);
        $('#popupadd').fadeIn();


    });

    $('#names').click(function(){
        var table='{{$teamorpart}}'.replace(/&quot;/g, '"');
        table = JSON.parse(table);
        var html='';
            document.getElementById('the_key').innerHTML=' <input type="text" class="key form-control" value="" id="key" name="key" autocomplete="off">';
            $('#key').on('keypress', function(event) {
                var html='';
                if(event.keyCode === 13){
                    if($(this).val().trim()!==''){
                        var inputValue = $(this).val().trim();
                        document.getElementById("potential_teams").style.display = 'none';
                        table.forEach(function(t){
                            if(t.info.includes(inputValue)) {
                                html += '<div class="table_tr_ch" data-am="' + t.am + '" data-info="' + t.info + '"> <div class="td">' + t.info + '</div></div>'
                            }
                        });
                        document.getElementById("pot_teams").innerHTML=html;
                        document.getElementById("potential_teams").style.display = 'none';
                        document.getElementById("pot_teams").style.display='';
                    }
                    else{
                        document.getElementById("potential_teams").style.display = '';
                        document.getElementById("pot_teams").style.display='none';
                    }}
            });

            if(table.length === 0) {html='<div class="td"><p>Δεν υπάρχουν εγγραφές στη Δραστητιότητα ομάδα.</p></div>';}
            else{ table.forEach(function(t) {
                html+= '<div class="table_tr_ch"  data-am="' + t.am + '" data-info="' + t.info + '"> <div class="td">'+t.info+'</div></div>'});
            }

            document.getElementById("potential_teams").innerHTML=html;

            $('.table_tr_ch').click(function (){
                const am = $(this).attr('data-am');
                const info = $(this).attr('data-info');
                $("#am").val(am);
                $("#names").val(info);
                $('.popupselect').fadeOut();
            });
        $('.popupselect').fadeIn();
    });

    $("#close_activity_slot").click(function () {
        $('.popupselect').fadeOut();
    });


    // Get the reference to the draggable div element
    const draggableDiv = document.getElementById('select');

    let isDragging = false;
    let dragOffsetX = 0;
    let dragOffsetY = 0;

    // Event listener for when the user starts dragging
    draggableDiv.addEventListener('mousedown', (event) => {
        isDragging = true;

        // Calculate the initial offset between the mouse pointer and the div's top-left corner
        dragOffsetX = event.clientX - draggableDiv.offsetLeft;
        dragOffsetY = event.clientY - draggableDiv.offsetTop;
    });

    // Event listener for when the user stops dragging
    document.addEventListener('mouseup', () => {
        isDragging = false;
    });

    // Event listener for when the user moves the mouse
    document.addEventListener('mousemove', (event) => {
        if (isDragging) {
            // Calculate the new position of the div based on the mouse movement
            const newLeft = event.clientX - dragOffsetX;
            const newTop = event.clientY - dragOffsetY;

            // Update the div's position
            draggableDiv.style.left = newLeft + 'px';
            draggableDiv.style.top = newTop + 'px';
        }
    });





</script>

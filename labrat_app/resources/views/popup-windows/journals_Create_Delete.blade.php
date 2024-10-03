<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="modal popup" id="popupcreate">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title"  style="position: relative;">
                    <h5>{{$act_title}}</h5>
                    <p style="font-size: small">{{$l_id}} - {{$title}}<br>Διδάσκων: {{$name}}</p>
                </div>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label class="form-label" id="mytext"></label>
                <form method="post" action="{{ url('/createupdatejournal') }}" enctype="multipart/form-data"> @csrf @method('GET')
                    <div class="row justify-content-between col-md-12" >
                        <input type="text" value="" name="action" id="action" hidden>
                        <input type="text" value="" name="id" id="id" hidden>
                        <input type="text" value="{{$act_id}}" name="act_id" hidden>
                        <input class="form-control" type="text" placeholder='Περιγραφικός Τίτλος του Περιοδικού/Θέματος....' name="title" id="title" value="" required/><br><br>
                        <input class="form-control" type="text" placeholder='Συσχετιζόμενο Link ....' name="link" id="mylink" value=""/><br>
                        <br><br>
                        <textarea  name="text" id="text" placeholder='Περιγραφή Θέματος....' ></textarea>
                        <br>

                    </div><br>
                    <button type="submit" id="uc" class="cbtn btn-primary">Δημιουργία</button>
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
                    <h5>{{$act_title}}</h5>
                    <p style="font-size: small">{{$l_id}} - {{$title}}<br>
                        Διδάσκων: {{$name}}</p>
                </div>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    @if($at_id==null)
                        Προσθήκη Μαθητή στο Θέμα "<b id="d_theme_title"></b>" της δραστηριότητα <b>"{{$act_title}}"</b> του μαθήματος.
                    @else
                        Προσθήκη ομάδας στο Θέμα "<b id="d_theme_title"></b>" της δραστηριότητα <b>"{{$act_title}}"</b> του μαθήματος.
                    @endif
                        @if(Auth::user()->role!=='Μαθητής')
                    <div class="text-end">
                        <label class="col-form-label-sm">{{$info}}<br>Αριθμός Θεμάτων: {{$c_themes}}</label>
                    </div>
                        @endif
                </div>
                <form method="post" action="{{ url('/joinpaper') }}"> @csrf @method('GET')
                    <input type="text" name="dt_id" id="d_theme_id" value="" hidden>
                    <input type="text" name="act_id" value="{{$act_id}}" hidden>
                    <input type="text" name="at_id" value="{{$at_id}}" hidden>
                    <input type="text" name="names" class="names form-control" value="" autocomplete="off" readonly required/>
                    <input type="text" name="am" class="am" value="" hidden required/>
                    <br><br>
                    <button type="submit" class="cbtn btn-primary">Δέσμευση Θέματος</button>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<div class="modal popup" id="popupaddjoin">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title"  style="position: relative;">
                    <h5>{{$act_title}}</h5>
                    <p style="font-size: small">{{$l_id}} - {{$title}}<br>
                        Διδάσκων: {{$name}}</p>
                </div>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">

                    Προσθήκη συμμετοχής στο Περιοδικό/θέμα "<b id="journal_title1"></b>" της δραστηριότητα <b>"{{$act_title}}"</b> του μαθήματος.
                   @if(Auth::user()->role!=='Μαθητής')
                    <div class="text-end">
                        <label class="col-form-label-sm">{{$info}}<br>Αριθμός Θεμάτων: {{$c_themes}}</label>
                    </div>
                    @endif
                </div>
                <form method="post" action="{{ url('/jointhejournal') }}"> @csrf @method('GET')
                    <input type="text" name="j_id" id="journal_id1" value="" hidden>
                    <input type="text" name="act_id" value="{{$act_id}}" hidden>
                    <input type="text" name="at_id" value="{{$at_id}}" hidden>
                    <input type="text" name="con" id="con" value="" hidden>
                    <input type="text" name="title" class="form-control" placeholder="Τίτλος Θέματος/Άρθρου" value="" required/><br>
                    <input type="text" name="names"  class="names form-control" value="" autocomplete="off" readonly required/>
                    <input type="text" name="am" class="am" value="" hidden required/>
                    <br><br>
                    <button type="submit" class="cbtn btn-primary">Δημιουργία</button>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<div class="modal popup" id="popupaddpaper">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title"  style="position: relative;">
                    <h5>{{$act_title}}</h5>
                    <p style="font-size: small">{{$l_id}} - {{$title}}<br>
                        Διδάσκων: {{$name}}</p>
                </div>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">

                    Προσθήκη Άρθρου/θέματος στο Περιοδικό/Θέμα "<b id="journal_title"></b>" της δραστηριότητα <b>"{{$act_title}}"</b> του μαθήματος.
                    @if(Auth::user()->role!=='Μαθητής')
                    <div class="text-end">
                        <label class="col-form-label-sm">{{$info}}<br>Αριθμός Θεμάτων: {{$c_themes}}</label>
                    </div>
                    @endif
                </div>
                <form method="post" action="{{ url('/addpaper') }}"> @csrf @method('GET')
                    <input type="text" name="j_id" id="journal_id" value="" hidden>
                    <input type="text" name="dt_id" value="{{$act_id}}" hidden>
                    <div id="myfrom">
                        <input type="text" name="title[]" class="form-control" placeholder="Τίτλος Θέματος/Άρθρου" value="" required/>
                    </div>
                    <br><br>
                    <input type="button"  class="button-3" id="addinput" style="position: absolute;right:10px; bottom:90px;" value="Προσθήκη Τίτλος Θέματος/Άρθρου"><br>
                    <button type="submit" class="cbtn btn-primary">Δημιουργία</button>
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

{{--    //pop up window that gives the ability to delete a journalfrom the database--}}
<div class="modal popup" id="popupdelete">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title"  style="position: relative;">
                    <h5>{{$act_title}}</h5>
                    <p style="font-size: small">{{$l_id}} - {{$title}}<br>
                        Διδάσκων: {{$name}}</p>
                </div>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ url('/deletejournal') }}">
                @csrf @method('GET')
                <div class="modal-body ">
                    <label class="col-md-12 col-form-label" id="thetext"></label>
                    <input type="text" id="j_id" name="id" value="" hidden>
                    <button type="submit" class="btn btn-primary col-md-12">Διαγραφή</button>
                </div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>

{{--    //pop up window that gives the ability to delete a paper from the journal--}}
<div class="modal popup" id="popupdeletepaper">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title"  style="position: relative;">
                    <h5>{{$act_title}}</h5>
                    <p style="font-size: small">{{$l_id}} - {{$title}}<br>
                        Διδάσκων: {{$name}}</p>
                </div>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ url('/deletepaper') }}">
                @csrf @method('GET')
                <div class="modal-body ">
                    <label class="col-md-12 col-form-label" id="del_text"></label>

                    <input type="text" id="d_id" name="d_id" value="" hidden>

                    <button type="submit" class="btn btn-primary col-md-12">Διαγραφή</button>
                </div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>


<script>

    tinyMCE.init({
        selector: 'textarea#text',
        plugins: 'autolink lists link  charmap  preview wordcount ',
        toolbar: 'undo redo | bold italic underline | bullist | wordcount ',
        menubar: false,
        force_br_newlines: true, // Recognize newlines as line breaks
        height: 330,
        elementpath: false,
        branding: false,
        entity_encoding : "raw",
    });

    $('.delete').click(function (){
        var j_id=$(this).attr('data-id');
        var title=$(this).attr('data-title');
        $('#j_id').val(j_id);
        $('#thetext').html('Είστε σίγουροι ότι θέλετε να διαγράψετε το θέμα/Περιοδικό <br><b>"'+title+'"</b> από τη δραστηριότητα  <b>"{{$act_title}}"</b> ;');
        $('#popupdelete').fadeIn()
    });

    $('.delete_paper').click(function (){
        var dt_id=$(this).attr('data-id');
        var title=$(this).attr('data-title');
        var dtitle=$(this).attr('data-dtitle');
        $('#d_id').val(dt_id);
        $('#del_text').html('Είστε σίγουροι ότι θέλετε να διαγράψετε το θέμα/Άρθρο <br><b>"'+dtitle+'"</b> από το θέμα/Περιοδικό <b>"'+title+'"</b> της δραστηριότητας <b>"{{$act_title}}"</b> ;');
        $('#popupdeletepaper').fadeIn()
    });


    $('.create-3').click(function (){
        $('#mytext').html('Δημιουργία νέου θέματος/Περιοδικού στην δραστηριότητα <b>"{{$act_title}}"</b> του μαθήματος.');
        $('#action').val('create');
        $('#id').val('');
        $('#title').val('');
        tinymce.activeEditor.setContent('');

        $('#mylink').val('');
        $('#uc').html('Δημιουργία');

        $('#popupcreate').fadeIn();
    });

    $('.edit').click(function (){
        const info = $(this).attr('data-info');
        const myOb = JSON.parse(info);

        $('#mytext').html('Ενημέρωση του θέματος/Περιοδικού "<b>'+myOb.title+'</b>" στην δραστηριότητα <b>"{{$act_title}}"</b> του μαθήματος.');
        $('#action').val('update');
        $('#id').val(myOb.id);
        $('#title').val(myOb.title);

        if(myOb.link!==null) {
            $('#mylink').val(myOb.link);
        }
        else {
            $('#mylink').val('');
        }


        tinymce.activeEditor.setContent(myOb.text);
        $('#uc').html('Ανανέωση');
        $('#popupcreate').fadeIn();
    });
    //function that close the popups forms
    $(".popup-close").click(function () {
        $(".popup").fadeOut();
    });


    $('.confirm').click(function () {
        @if($confirmation==0)
            var j_id=$(this).attr('data-id');
            var title=$(this).attr('data-title');
            $('#journal_id').val(j_id);
            $('#journal_title').html(title)

            $('#popupaddpaper').fadeIn();
        @endif

        @if($confirmation==1)
            var j_id=$(this).attr('data-id');
            var title=$(this).attr('data-title');
            $('.names').attr('placeholder', 'Επιλέξτε τη συμμετοχή');
            $('#journal_id1').val(j_id);
            $('#journal_title1').html(title)
            @if(Auth::user()->role!=='Μαθητής')
                $('#con').val(1);
            @endif
            @if(Auth::user()->role=='Μαθητής')
                var table='{{$teamorpart}}'.replace(/&quot;/g, '"');
                table = JSON.parse(table);
                var am='';
                var names='';
                table.forEach(function(t){
                    am=t.am ;
                    names=t.info;
                });
                $(".am").val(am);
                $('.names').val(names);
            @endif

        $('#popupaddjoin').fadeIn();
        @endif
    });

    $('.add').click(function(){
        var dt_id=$(this).attr('data-id');
        var title=$(this).attr('data-title');
        $('#d_theme_id').val(dt_id);
        $('#d_theme_title').html(title);

        @if(Auth::user()->role!='Μαθητής')
        $('.names').attr('placeholder', 'Επιλέξτε τη συμμετοχή');
        @else
        var table='{{$teamorpart}}'.replace(/&quot;/g, '"');
        table = JSON.parse(table);
        var am='';
        var names='';
        table.forEach(function(t){
            am=t.am ;
            names=t.info;
        });
        $(".am").val(am);
        $('.names').val(names);
            @endif

        $('#popupadd').fadeIn();
    });



    $('.names').click(function(){
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

            if(table.length === 0) {html='<div class="td"><p>Δεν υπάρχουν εγγραφές στη Δραστηριότητα ομάδα.</p></div>';}
            else{ table.forEach(function(t) {
                html+= '<div class="table_tr_ch"  data-am="' + t.am + '" data-info="' + t.info + '"> <div class="td">'+t.info+'</div></div>'});
            }

            document.getElementById("potential_teams").innerHTML=html;

            $('.table_tr_ch').click(function (){
                const am = $(this).attr('data-am');
                const info = $(this).attr('data-info');
                $(".am").val(am);
                $(".names").val(info);
                $('.popupselect').fadeOut();
            });
        $('.popupselect').fadeIn();
    });

    $("#close_activity_slot").click(function () {
        $('.popupselect').fadeOut();
    });

    $('#addinput').click(function () {
        // Generate a unique ID for the new textarea
        var uniqueId = 'formtext_' + Date.now();

        // Append a new textarea with the generated unique ID
        $('#myfrom').append('<br><div id="myfrom"> <input type="text" name="title[]" class="form-control" placeholder="Τίτλος Θέματος/Άρθρου" value="" required/> </div>');

    });




    // Get the reference to the draggable div element
    // const draggableDiv = document.getElementById('select');

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

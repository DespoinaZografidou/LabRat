<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{--    //pop up window that gives the ability to delete a activity from the database--}}
<div class="modal popup" id="popupdelete">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Διαγραφή Δραστηριότητας</h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{url('/deletedeterminatetheme')}}">
                @csrf @method('GET')
                <div class="modal-body ">
                    <label class="col-md-12 col-form-label" id="text"></label>
                    <input type="text" id="dt_id" name="dt_id" value="" hidden>
                    <button type="submit" class="btn btn-primary col-md-12">Διαγραφή</button>
                </div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>



{{--    //pop up window that gives the ability to edit a notification from the database--}}
<div class="popup modal" id="popupedit">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel"></h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('/createupdatedeterminatetheme') }}" >
                    @csrf @method('GET')

                    <input class="form-control" type="text" id="l_id" name="l_id" value="{{$l_id}}" hidden>
                    <input class="form-control" type="text" id="act_id" name="act_id" hidden>
                    <input class="form-control" type="text" id="action" name="action" hidden>

                    <label class="col-md-4 col-form-label text-md-start" for="title" >Τίτλος</label>
                    <input class="form-control" type="text" id="title" name="title" required>

                    <label class="col-md-4 col-form-label text-md-start" for="text">Κείμενο</label>
                    <textarea  class="form-control" id="text" name="text" contenteditable="true" ></textarea>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-form-label text-md-start" for="text">Ημερομηνία Ενεργοποίησης</label>
                            <input class="form-control start" type="datetime-local" min="{{ date('Y-m-d\TH:i') }}" name="startdate" id="startdate" value="" required/>
                        </div>
                        <div class="col-md-6">
                            <label class=" col-form-label text-md-start" for="text">Ημερομηνία Απενεργοποίησης</label>
                            <input  class="form-control end" type="datetime-local" min="{{ date('Y-m-d\TH:i') }}" name="enddate" id="enddate" value="" required/>
                        </div>
                        <div class="text-end pt-1" id="stat"></div>
                        <div class="text-end pt-2" id="">
                            <p style="font-size: small"><input type="checkbox" id="de-activity"> Απενεργοποίηση Δραστηριότητας</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="col-form-label text-md-start" for="text">Συσχετιζόμενη Δραστηριότητα Ομάδα</label>
                            <input class="form-control" type="text" id="at_id" name="at_id" value="" hidden>
                            <input class="form-control at_title" type="text" id="at_title" name="at_title" value="" placeholder="Επιλέξτε Δραστηριότητα Ομάδα">
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label text-md-start" for="text">Χρήση Επιβεβαίωσης Θεμάτων</label>
                            <select name="confirmation" id="confirmation" class="form-control">
                                <option id="selected"></option>
                                <option value="1">Με επιβεβαίωση</option>
                                <option value="0">Χωρίς επιβεβαίωση</option>
                            </select>

                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary col-md-12">Αποθήκευση</button>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<div class="modal popupacticityteam" id="activity_team" style="z-index: 9999;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #94d3a2;">
                <div class="modal-title" style="position: relative;"><h5>Επιλογή Συσχετιζόμενης Δραστηριότητα Ομάδα </h5></div>
                <button type="button" id="close_activity_slot" class="close " data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
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



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    // function tha opens the popup form to add a new lesson
    $('.button-3').click(function(){
        $("#popupedit").fadeIn();
        document.getElementById("demoModalLabel").textContent = 'Εισαγωγή Νέας Δραστηριότητας Προσδιορισμός Θεμάτων';
        document.getElementById("act_id").value= '';
        document.getElementById("title").value = '';
        document.getElementById("action").value = 'add';
        document.getElementById("startdate").value='';
        document.getElementById("enddate").value='';
        document.getElementById("at_id").value='';
        document.getElementById("at_title").value='';
        document.getElementById('selected').textContent='Χωρίς επιβεβαίωση';
        document.getElementById('selected').value=1;
        document.getElementById('selected').selected=true;
        document.getElementById('selected').hidden=true;


        tinymce.activeEditor.setContent('');

    });

    //function that close the popups forms
    $(".popup-close").click(function () {
        $(".popup").fadeOut();
    });

    //function that shows the popup form to delete a notification
    const $link=$('.table_tr_ch');

    $link.click(function (event) {
        // Show the selected row from the table
        $link.removeClass('active');
        $(this).addClass('active');

        const info = $(this).attr('data-info');
        const myObject = JSON.parse(info);
        const userRole = $(this).data('role');

        if (userRole === 'Μαθητής') {
            var l_id = "{{ $l_id }}";
            var title = "{{ $title }}";
            var name = "{{ $name }}";
            var dt_id = myObject.id;

            var url = "/showTheJournals/" + encodeURIComponent(l_id) + "/" + encodeURIComponent(title) + "/" + encodeURIComponent(name) + "/" + dt_id;
            window.location.href = url;
            // return;
        }
        if (userRole === 'Καθηγητής' ||userRole === 'Διαχειριστής' ) {
            const $thelink = $(event.target).closest('.at_open').find('a');

            if ($thelink.length) {
                return;
            }

            const $button = $(event.target).closest('.nd').find('button');
            if ($button.length) {
                document.getElementById("text").textContent = 'Εισάστε σιγουροί ότι θέλετε να διαγράψετε τη δραστηριότητα με το τίτλο "' + myObject.title + '" ;';
                document.getElementById('dt_id').value = myObject.id;

                return $('#popupdelete').fadeIn();
            }


            // the title for the popup when it is open to edit the lesson
            document.getElementById("action").value = 'update';
            document.getElementById("demoModalLabel").textContent = 'Ενημέρωση Δραστηριότητας Προσδιορισμός Θεμάτων';
            document.getElementById("title").value = myObject.title;
            document.getElementById("act_id").value = myObject.id;
            document.getElementById("startdate").value=String(myObject.created_at);
            document.getElementById("enddate").value=String(myObject.updated_at);
            document.getElementById("at_title").value=myObject.at_title;
            document.getElementById("at_id").value=myObject.at_id;

            if(myObject.confirmation==1) {
                document.getElementById('selected').value=1;
                document.getElementById('selected').textContent='Με επιβεβαίωση';
            }else{
                document.getElementById('selected').value=0;
                document.getElementById('selected').textContent='Χωρίς επιβεβαίωση';
            }

            document.getElementById('selected').selected=true;
            document.getElementById('selected').hidden=true;
            var text = myObject.text
                .replace(/\n/g, '<br>')
                .replace(/♥/g, '<strong>')
                .replace(/♠/g, '</strong>')
                .replace(/☺/g, '<em>')
                .replace(/☻/g, '</em>')
                .replace(/♦/g, '<u>')
                .replace(/♣/g, '</u>')
                .replace(/•/g, '<li>');
            tinymce.get("text").setContent(text);

            $("#popupedit").fadeIn();

        }
    });

    function returnStatus() {
        const start=document.getElementById("startdate").value;
        const end=document.getElementById("enddate").value;
        var endTimestamp = new Date(end).getTime();
        var startTimestamp = new Date( start).getTime();
        var currentTimestamp = new Date().getTime();
        if(startTimestamp<=currentTimestamp && endTimestamp>=currentTimestamp ){
            document.getElementById("stat").innerHTML='<label class="col-form-label-sm">Κατάσταση Δραστηριότητας: <span class="status-s status_active"></span> Ενεργό</label>';
        }

        if(startTimestamp<currentTimestamp && endTimestamp<currentTimestamp){
            document.getElementById("stat").innerHTML='<label class="col-form-label-sm">Κατάσταση Δραστηριότητας: <span class="status-s status_deactive"></span>Έχει Λήξει</label>';
        }
        if(startTimestamp > currentTimestamp || startTimestamp === endTimestamp){
            document.getElementById("stat").innerHTML='<label class="col-form-label-sm">Κατάσταση Δραστηριότητας: <span class="status-s status_deactive"></span>Απενεργό</label>';
        }

    }

    returnStatus();
    setInterval(returnStatus, 1000);

    $('#at_title').click(function (){
        var table='{{$actteams}}'.replace(/&quot;/g, '"');
        var teams = JSON.parse(table);
        var html='';

        document.getElementById('the_key').innerHTML=' <input type="text" class="key form-control" value="" id="key" name="key" autocomplete="off">';
        $('#key').on('keypress', function(event) {
            var html='';
            if(event.keyCode === 13){
                if($(this).val().trim()!==''){
                    var inputValue = $(this).val().trim();
                    document.getElementById("potential_teams").style.display = 'none';
                    teams.forEach(function(t){
                        if(t.title.includes(inputValue)) {
                            html += '<div class="table_tr_ch" data-id="' + t.id + '" data-title="' + t.title + '"> <div class="td">' + t.title + '</div></div>'
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

        if(teams.length === 0) {html='<div class="td"><p>Δεν υπάρχουν εγγραφές στη Δραστητιότητα ομάδα.</p></div>';}
        else{ teams.forEach(function(t) {
            html+= '<div class="table_tr_ch"  data-id="'+t.id+'" data-title="'+t.title+'"> ' +
                '<div class="td">'+t.title+'</div></div>'});
        }

        document.getElementById("potential_teams").innerHTML=html;

        $('.table_tr_ch').click(function (){
            const id = $(this).attr('data-id');
            const title = $(this).attr('data-title');

            $('#at_id').val(id);
            $('#at_title').val(title);
            $('.popupacticityteam').fadeOut();
        });
        $('.popupacticityteam').fadeIn();
    })

    $("#close_activity_slot").click(function () {
        $(".popupacticityteam").fadeOut();
    });


    // Get the reference to the draggable div element
    const draggableDiv = document.getElementById('activity_team');

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

    $('#de-activity').click(function (){
        var currentTimestamp = new Date().getTime();
        var formattedTimestamp = new Date(currentTimestamp).toISOString().slice(0, 16);


        document.getElementById("startdate").value=formattedTimestamp;
        document.getElementById("enddate").value=formattedTimestamp;
    });
</script>


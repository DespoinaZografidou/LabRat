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
            <form method="post" action="{{url('/deletevoting')}}">
                @csrf @method('GET')
                <div class="modal-body ">
                    <label class="col-md-12 col-form-label" id="text"></label>
                    <input type="text" id="vt_id" name="vt_id" value="" hidden>
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
                <form method="post" action="{{ url('/createupdatevoting') }}" >
                    @csrf @method('GET')

                    <input class="form-control" type="text" id="l_id" name="l_id" value="{{$l_id}}" hidden >
                    <input class="form-control" type="text" id="act_id" name="act_id" hidden>
                    <input class="form-control" type="text" id="action" name="action" hidden>

                    <label class="col-md-4 col-form-label text-md-start" for="title" >Τίτλος</label>
                    <input class="form-control" type="text" id="title" name="title" required>

                    <label class="col-md-4 col-form-label text-md-start" for="text">Κείμενο</label>
                    <textarea  class="form-control" id="text" name="text" contenteditable="true" ></textarea>
                    <div class="row mb-3">
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

                    <button type="submit" class="btn btn-primary col-md-12">Αποθήκευση</button>
                </form>
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
        document.getElementById("demoModalLabel").textContent = 'Εισαγωγή Νέας Δραστηριότητας Ψηφοφορία';
        document.getElementById("act_id").value= '';
        document.getElementById("title").value = '';
        document.getElementById("action").value = 'add';
        document.getElementById("startdate").value='';
        document.getElementById("enddate").value='';
        document.getElementById("at_id").value='';
        document.getElementById("at_title").value='';

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
            var act_id = myObject.id;

            var url = "/showTheVoting/" + encodeURIComponent(l_id) + "/" + encodeURIComponent(title) + "/" + encodeURIComponent(name) + "/" + act_id;
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
                document.getElementById('vt_id').value = myObject.id;

                return $('#popupdelete').fadeIn();
            }


            // the title for the popup when it is open to edit the lesson
            document.getElementById("action").value = 'update';
            document.getElementById("demoModalLabel").textContent = 'Ενημέρωση Δραστηριότητας Ψηφοφορία';
            document.getElementById("title").value = myObject.title;
            document.getElementById("act_id").value = myObject.id;
            document.getElementById("startdate").value=String(myObject.created_at);
            document.getElementById("enddate").value=String(myObject.updated_at);

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


    $('#de-activity').click(function (){
        var currentTimestamp = new Date().getTime();
        var formattedTimestamp = new Date(currentTimestamp).toISOString().slice(0, 16);


        document.getElementById("startdate").value=formattedTimestamp;
        document.getElementById("enddate").value=formattedTimestamp;
    });



</script>


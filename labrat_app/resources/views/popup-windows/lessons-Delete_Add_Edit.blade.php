
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{--    //pop up window that gives the ability to edit a lesson from the database--}}
<div class="modal popup" id="popupdelete">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Διαγραφή Μαθήματος & Καταστροφή χώρου</h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ url('deleteLesson')}}">
                @csrf @method('GET')
                <div class="modal-body ">
                    <label class="col-md-12 col-form-label" id="text"></label>
                    <label class="col-md-12 col-form-label">Εισάστε σιγουροί ότι θέλετε να το διαγράψετε;</label><br>
                    <input type="text" id="les_id" name="les_id" hidden>
                    <button type="submit" class="btn btn-primary col-md-12">Διαγραφή</button>
                </div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>

{{--Popup form to update or to add a lesson--}}
<div class="popup modal" id="popupedit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel"></h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <form method="post" action="{{ url('updateAddLessons')}}">
                    @csrf @method('GET')
                    <div class="row mb-3">
                        <input class="form-control" type="text" id="action" name="action" hidden>
                        <div class="col-md-6">
                            <label class="col-md-4 col-form-label text-md-end" for="l_id">Κωδικός</label>
                            <input class="form-control" type="text" id="l_id" name="l_id" required>
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-4 col-form-label text-md-end" for="title">Τίτλος</label>
                            <input class="form-control" type="text" id="title" name="title" required>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="col-md-4 col-form-label text-md-end" for="semester">Εξάμηνο</label>
                            <select class="form-select" name="semester" id="semester" required>
                                <option value="" id="selectedsemester" hidden></option>
                                <?php for ($i = 1; $i <= 20; $i++){ ?>
                                <option value="{{$i}}ο Εξάμηνο">{{$i}}ο Εξάμηνο</option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-4 col-form-label text-md-end" for="type">Τύπος</label>
                            <select class="form-select" name="type" id="type" required>
                                <option value="" id="selectedtype" hidden></option>
                                <option value="Προπτυχιακό">Προπτυχιακό</option>
                                <option value="Μεταπτυχιακό">Μεταπτυχιακό</option>
                                <option value="Διδακτορικό">Διδακτορικό</option>
                                <option value="Επιλογής">Επιλογής</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="col-md-4 col-form-label text-md-end" for="professor">Καθηγητής</label>
                            @if(Auth::user()->role=='Διαχειριστής')
                                <select class="form-select" id="professor" name="professor" required>
                                    <option value="" id="selectedprofessor" hidden></option>
                                    @foreach($professors as $p)
                                        <option value="{{$p->id}}"> {{$p->name}}</option>
                                    @endforeach
                                </select>
                            @endif
                            @if(Auth::user()->role=='Καθηγητής')
                                <select class="form-select" id="professor" name="professor" readonly>
                                    <option value="" id="selectedprofessor" ></option>
                                </select>
                            @endif


                        </div>
                        <div class="col-md-6">
                            <label class="col-md-4 col-form-label text-md-end" for="professor">Χώρος</label>
                            <select class="form-select" name="area" id="area">
                                <option value="1" id="on">Ενεργοποιημένο</option>
                                <option value="0" id="off">Απενεργοποιημένο</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="col-md-4 col-form-label text-md-end" for="description">Περιγραφή</label>

                        </div>
                        <div class="col-md-12">
                            <textarea  class="form-control" id="description" name="description" contenteditable="true" ></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary col-md-12">Αποθήκευση</button>
                </form>

            </div>

            <div class="modal-footer"></div>
        </div>
    </div>

</div>


<script>

   import tinyMCE from "@vitejs/plugin-vue";

   tinyMCE.init({
       selector: 'textarea#description',
       plugins: 'autolink lists link  charmap  preview wordcount ',
       toolbar: 'undo redo | bold italic underline | bullist | wordcount ',
       menubar: false,
       force_br_newlines: true, // Recognize newlines as line breaks
       height: 200,
       elementpath: false,
       branding: false,
       entity_encoding : "raw",


   });



    const $links = $('.td');
    //function that shows the popups form with the information that are nessesery to update, add or delete a lesson
    $links.click(function (event) {
        // Show the selected row from the table
        $links.removeClass('active');
        $(this).addClass('active');

        //take the information from the lesson and show them to the popup form
        const info = $(this).attr('data-info');
        const myObject = JSON.parse(info);

        //the action that we want to do (add or update)
        document.getElementById("action").value = 'update';
        // the title for the popup when it is open to edit the lesson
        document.getElementById("demoModalLabel").textContent = myObject.l_id + ' ' + myObject.title;

        document.getElementById("l_id").value = myObject.l_id;
        document.querySelector('#l_id').readOnly = true;

        document.getElementById("title").value = myObject.title;

        document.querySelector("#selectedsemester").selected = true;
        document.querySelector("#selectedsemester").value = myObject.semester;
        document.querySelector("#selectedsemester").textContent = myObject.semester;

        document.querySelector("#selectedtype").selected = true;
        document.querySelector("#selectedtype").value = myObject.type;
        document.querySelector("#selectedtype").textContent = myObject.type;

        document.querySelector("#selectedprofessor").selected = true;
        document.querySelector("#selectedprofessor").value = myObject.t_id;
        document.querySelector("#selectedprofessor").textContent = myObject.name;

        var description = myObject.description
            .replace(/\n/g, '<br>')
            .replace(/♥/g, '<strong>')
            .replace(/♠/g, '</strong>')
            .replace(/☺/g, '<em>')
            .replace(/☻/g, '</em>')
            .replace(/♦/g, '<u>')
            .replace(/♣/g, '</u>')
            .replace(/•/g,'<li>');
        tinyMCE.activeEditor.setContent(description);

        if (myObject.l_area === 1) {document.querySelector("#on").selected = true;}
        if (myObject.l_area === 0) {document.querySelector("#off").selected = true;}

        //if you click the red button from the row then show the popup window to delete the lesson
        const $button = $(event.target).closest('.l_delete').find('button');
        if ($button.length) {
            document.getElementById("text").textContent = 'Διαγράφοντας το μάθημα "' + myObject.title + '", θα καταστραφεί ο χώρος του μαθήματος καθώς και όλες οι δραστηριότητες/εγγραφές που σχετίζονται με αυτό.  ';
            document.getElementById("les_id").value = myObject.l_id;
            return $('#popupdelete').fadeIn();
        }


        const $button2 = $(event.target).closest('.thetitle').find('a');
        if ($button2.length) {
            return;
        }

        // Show the popup form to edit the selected lesson
        $('#popupedit').fadeIn();

    });


    // function tha opens the popup form to add a new lesson
    function addLesson() {
        $(".popup").fadeIn();
        document.getElementById("action").value = 'add';
        document.getElementById("demoModalLabel").textContent = 'Εισαγωγή Νέου Μαθήματος';
        document.getElementById("l_id").value = '';
        document.querySelector('#l_id').readOnly = false;

        document.getElementById("title").value = '';
        document.querySelector("#selectedsemester").selected = true;
        document.querySelector("#selectedsemester").textContent = 'Επιλέξε Εξάμηνο';
        document.querySelector("#selectedtype").selected = true;
        document.querySelector("#selectedtype").textContent = 'Επιλέξε Τύπο Μαθήματος';
        document.querySelector("#selectedprofessor").selected = true;
        document.querySelector("#selectedprofessor").textContent = '<?php echo Auth::user()->name?>';
        document.querySelector("#selectedprofessor").value = '<?php echo Auth::user()->id?>';
        tinymce.activeEditor.setContent('');

        document.querySelector("#off").selected = true;
    }

    //function that close the popups forms
    $(".popup-close").click(function () {
        $(".popup").fadeOut();
    });

</script>

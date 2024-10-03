<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{--    //pop up window that gives the ability to delete a notification from the database--}}
<div class="modal popup" id="popupdelete">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Διαγραφή Ανακοίνωσης</h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="/deleteNotification">
                @csrf @method('GET')
                <div class="modal-body ">
                    <label class="col-md-12 col-form-label" id="text"></label>
                    <input type="text" id="n_id" name="n_id" value="" hidden>
                    <button type="submit" class="btn btn-primary col-md-12">Διαγραφή</button>
                </div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>

{{--    //pop up window that gives the ability to edit a notification from the database--}}

<div class="popup modal" id="popupedit">
    <div class=" modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel"></h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="/createNotification" >
                    @csrf @method('GET')

                            <input class="form-control" type="text" id="l_id" name="l_id" value="{{$l_id}}" hidden >
                            <input class="form-control" type="text" id="not_id" name="not_id" hidden>
                            <input class="form-control" type="text" id="action" name="action" hidden>

                            <label class="col-md-4 col-form-label text-md-start" for="title" >Τίτλος</label>
                            <input class="form-control" type="text" id="title" name="title" required>


                            <label class="col-md-4 col-form-label text-md-start" for="text">Κείμενο</label>
                            <textarea  class="form-control" id="text" name="text" contenteditable="true" ></textarea>


                    <button type="submit" class="btn btn-primary col-md-12">Αποθήκευση</button>
                </form>

            </div>

            <div class="modal-footer"></div>
        </div>
    </div>

</div>



<div class="popup modal" id="popupshow">
    <div  role="document" class="modal-dialog modal-lg"  >
        <div class="modal-content ">
            <div class="modal-header">
                <div>
                    <h5>{{$l_id}} - {{$title}}</h5>
                    Διδάσκων: {{$name}}
                </div>

                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input class="form-control" type="text" id="s_title" name="s_title" ><br>
                <div  class="form-control" style="height: 350px; overflow: auto;" id="s_text" contenteditable="true" ></div>
            </div>
            <div class="modal-footer " style="text-align: right">
                <p id="s_date"></p>
            </div>
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
    function addNotification(){
        $("#popupedit").fadeIn();
        // document.getElementById("action").value = 'add';
        document.getElementById("demoModalLabel").textContent = 'Εισαγωγή Νέας Ανακοίνωσης';
        document.getElementById("not_id").value= '';
        document.getElementById("title").value = '';
        document.getElementById("action").value = 'add';

        tinymce.activeEditor.setContent('');

    }

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
                document.getElementById("s_title").value = myObject.title;
                document.getElementById("s_text").innerHTML = myObject.text
                    .replace(/\n/g, '<br>')
                    .replace(/♥/g, '<strong>')
                    .replace(/♠/g, '</strong>')
                    .replace(/☺/g, '<em>')
                    .replace(/☻/g, '</em>')
                    .replace(/♦/g, '<u>')
                    .replace(/♣/g, '</u>')
                    .replace(/•/g, '<li>');
                document.getElementById("s_date").innerHTML= myObject.created_at;
                return $('#popupshow').fadeIn();
            }
            if (userRole === 'Καθηγητής' ||userRole === 'Διαχειριστής' ) {
                const $thelink = $(event.target).closest('.n_open').find('a');

                if ($thelink.length) {
                    document.getElementById("s_title").value = myObject.title;

                    document.getElementById("s_text").innerHTML = myObject.text
                        .replace(/\n/g, '<br>')
                        .replace(/♥/g, '<strong>')
                        .replace(/♠/g, '</strong>')
                        .replace(/☺/g, '<em>')
                        .replace(/☻/g, '</em>')
                        .replace(/♦/g, '<u>')
                        .replace(/♣/g, '</u>')
                        .replace(/•/g, '<li>');


                    document.getElementById("s_date").innerHTML= myObject.created_at;
                    return $('#popupshow').fadeIn();
                }

                const $button = $(event.target).closest('.nd').find('button');
                if ($button.length) {
                    document.getElementById("text").textContent = 'Εισάστε σιγουροί ότι θέλετε να διαγράψετε τη ανακοίνωση με το τίτλο "' + myObject.title + '" ;';
                    document.getElementById('n_id').value = myObject.id;

                    return $('#popupdelete').fadeIn();
                }


                // the title for the popup when it is open to edit the lesson
                document.getElementById("action").value = 'update';
                document.getElementById("demoModalLabel").textContent = 'Ενημέρωση Ανακοίνωσης';
                document.getElementById("title").value = myObject.title;
                document.getElementById("not_id").value = myObject.id;

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

                $("#popupedit").fadeIn()

            }
        });




</script>

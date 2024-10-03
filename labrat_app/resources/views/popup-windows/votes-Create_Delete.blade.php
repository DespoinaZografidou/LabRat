<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.tiny.cloud/1/bd2i56if5ei2bm5nl06ldj9h5xhhqetk86p622lvpngti5ws/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

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

                <form method="post" action="{{ url('/createupdatequestion') }}" enctype="multipart/form-data"> @csrf @method('GET')
                   <div class="row justify-content-between col-md-12">
                       <label class="form-label" id="mytext"></label>
                   </div><br>
                    <div class="row justify-content-between col-md-12" >
                        <input type="text" value="" name="action" id="action" hidden>
                        <input type="text" value="" name="q_id" id="id" hidden>
                        <input type="text" value="{{$act_id}}" name="act_id" hidden><br>
                        <textarea  name="text" class="text" id="formtext1" placeholder='Προσθήκη Νέας Ερώτησης....'></textarea>

                        <div class="col-md-6" ></div>

                        <div class="col-md-6">
                            <br><label class="form-label">Τύπος Ερώτησης</label><br>
                            <select class="form-control" name="type" id="type" required>
                                <option id="selected" value=""></option>
                                <option id="1" value="Μίας Επιλογής">Μίας Επιλογής</option>
                                <option id="2" value="Πολλαπλής Επιλογής">Πολλαπλής Επιλογής</option>
                            </select>
                        </div>
                    </div><br> <br>

                    <button type="submit" id="uc" class="cbtn btn-primary">Δημιουργία</button>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>



<div class="modal popup" id="popupaddpaper">
    <div class="modal-dialog modal-lg" role="document">
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
                    <label class="form-label" id="q_text"></label>
{{--                    @if(Auth::user()->role!=='Μαθητής')--}}
{{--                    <div class="text-end">--}}
{{--                        <label class="col-form-label-sm">{{$info}}<br>Αριθμός Θεμάτων: {{$c_themes}}</label>--}}
{{--                    </div>--}}
{{--                    @endif--}}
                </div>
                <form method="post" action="{{ url('/addanswers') }}"> @csrf @method('GET')
                    <input type="text" name="q_id" id="qq_id" value="" hidden>
                    <div id="myfrom">
                        <textarea  name="text[]" class="text" id="formtext2" placeholder='Προσθήκη Νέας Απάντησης....'></textarea>
                    </div>
                    <br><br>
                    <input type="button"  class="button-3" id="addtextarea" style="position: absolute;right:10px; bottom:90px;" value="Προσθήκη Απάντησης"><br>
                    <button type="submit" class="cbtn btn-primary">Δημιουργία</button>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>


{{--    //pop up window that gives the ability to delete a journalfrom the database--}}
<div class="modal popup" id="popupdelete">
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
            <form method="post" action="{{ url('/deletequestion') }}">
                @csrf @method('GET')
                <div class="modal-body ">
                    <label class="col-md-12 col-form-label" id="thetext"></label>
                    <input type="text" id="ques_id" name="q_id" value="" hidden>
                    <button type="submit" class="btn btn-primary col-md-12">Διαγραφή</button>
                </div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>

{{--    //pop up window that gives the ability to delete a paper from the journal--}}
<div class="modal popup" id="popupdeletepaper">
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
            <form method="post" action="{{ url('/deleteanswer') }}">
                @csrf @method('GET')
                <div class="modal-body ">
                    <label class="col-md-12 col-form-label" id="del_text"></label>
                    <input type="text" id="a_id" name="a_id" value="" hidden>
                    <button type="submit" class="btn btn-primary col-md-12">Διαγραφή</button>
                </div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>


<script>

    tinyMCE.init({
        selector: 'textarea.text',
        plugins: 'autolink lists link  charmap  preview wordcount ',
        toolbar: 'undo redo | bold italic underline | bullist | wordcount ',
        menubar: false,
        force_br_newlines: true, // Recognize newlines as line breaks
        height: 150,
        elementpath: false,
        branding: false,
        entity_encoding : "raw",

    });


    $('.delete').click(function (){
        var q_id=$(this).attr('data-id');
        var text=$(this).attr('data-text');
        $('#ques_id').val(q_id);
        $('#thetext').html('Είστε σίγουροι ότι θέλετε να διαγράψετε την παρακάτω ερώτηση από τη δραστηριότητα <b>"{{$act_title}}"</b> ;<br><br><b>'+text+'</b>');
        $('#popupdelete').fadeIn()
    });

    $('.delete_paper').click(function (){
        var a_id=$(this).attr('data-id');
        var title=parseInt($(this).attr('data-title'));
        title=title-1;
        var text=$(this).attr('data-text');
        $('#a_id').val(a_id);
        $('#del_text').html('Είστε σίγουροι ότι θέλετε να διαγράψετε την παρακάτω απάντηση από την <b>"Ερώτηση '+title+'"</b> της δραστηριότητας <b>"{{$act_title}}"</b> ;<br><br><b>'+text+'</b>');
        $('#popupdeletepaper').fadeIn()
    });


    $('.create-3').click(function (){
        $('#mytext').html('Δημιουργία νέας ερώτησης στην δραστηριότητα <b>"{{$act_title}}"</b> του μαθήματος.');
        $('#action').val('create');
        $('#id').val('');


        document.querySelector("#selected").selected = true;
        document.querySelector("#selected").hidden = true;
        document.querySelector("#selected").value = 'Μίας Επιλογής';
        document.querySelector("#selected").textContent='Μίας Επιλογής';

        tinymce.get('formtext1').setContent('');

        $('#uc').html('Δημιουργία');

        $('#popupcreate').fadeIn();
    });

    $('.edit').click(function (){
        const info = $(this).attr('data-info');
        const myOb = JSON.parse(info);

        $('#mytext').html('Ενημέρωση ερώτησης στην δραστηριότητα <b>"{{$act_title}}"</b> του μαθήματος.');
        $('#action').val('update');
        $('#id').val(myOb.q_id);

        document.querySelector("#selected").selected = true;
        document.querySelector("#selected").hidden = true;
        document.querySelector("#selected").value = myOb.type;
        document.querySelector("#selected").textContent= myOb.type;

        tinymce.get('formtext1').setContent(myOb.question);
        $('#uc').html('Ανανέωση');
        $('#popupcreate').fadeIn();
    });
    //function that close the popups forms
    $(".popup-close").click(function () {
        $(".popup").fadeOut();
    });

    $('.confirm').click(function () {
        var q_id=$(this).attr('data-id');
        var title=parseInt($(this).attr('data-title'));
            title=title-1;
        $('#q_text').html('Προσθήκη ερώτήσεων στην "<b>Ερώτηση '+title+'</b>" στην δραστηριότητα <b>"{{$act_title}}"</b> του μαθήματος.');
        tinymce.get('formtext2').setContent('');
        $('#qq_id').val(q_id)
        $('#popupaddpaper').fadeIn();
    });

    $('#addtextarea').click(function () {
        // Generate a unique ID for the new textarea
        var uniqueId = 'formtext_' + Date.now();

        // Append a new textarea with the generated unique ID
        $('#myfrom').append('<br><div id="myfrom"> <textarea  name="text[]" class="text" id="' + uniqueId + '" placeholder="Προσθήκη Νέας Απάντησης...."></textarea> </div>');

        // Initialize TinyMCE for the newly created textarea using its unique ID
        tinymce.init({
            selector: 'textarea#' + uniqueId,
            plugins: 'autolink lists link charmap preview wordcount',
            toolbar: 'undo redo | bold italic underline | bullist | wordcount',
            menubar: false,
            force_br_newlines: true,
            height: 150,
            elementpath: false,
            branding: false,
            entity_encoding: 'raw'
        });
    });



</script>

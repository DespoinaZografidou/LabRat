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

                <form method="post" action="{{ url('/createupdatequizquestions') }}" enctype="multipart/form-data"> @csrf @method('GET')
                   <div class="row justify-content-between col-md-12">
                       <label class="form-label" id="mytext"></label>
                   </div><br>
                    <div class="row justify-content-between col-md-12">
                        <input type="text" value="" name="action" id="action" hidden>
                        <input type="text" value="" name="q_id" id="id" hidden>
                        <input type="text" value="{{$act_id}}" name="act_id" hidden><br>

                       <div id="addtablerow">
                        <textarea  name="text" class="text" id="formtext1" placeholder='Προσθήκη Νέας Ερώτησης....'></textarea>
                       </div>
                        <div class="col-md-6" id="maxnum" style="display: none;">
                            <br><label class="form-label" id="maxnum">Βαθμός Απάντησης</label><br>
                            <input type="number" class="form-control" name="maxgrade" id="maxgrade" step="0.25" value="0.00">
                        </div>

                        <div class="col-md-6">
                            <br><label class="form-label">Τύπος Ερώτησης</label><br>
                            <select class="form-control" name="type" id="type" required>
                                <option id="selected" value=""></option>
                                <option id="1" value="Μίας Επιλογής">Μίας Επιλογής</option>
                                <option id="2" value="Πολλαπλής Επιλογής">Πολλαπλής Επιλογής</option>
                                <option id="4" value="Ναι/Όχι">Ναι/Όχι</option>
                                <option id="3" value="Ελεύθερου Κειμένου">Ελεύθερου Κειμένου</option>
                                <option id="5" value="Αντιστοίχιση">Αντιστοίχιση</option>
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
            <div class="modal-body justify-content-center">
                <div class="col-md-12" id="q_text"></div>
                <form method="post" action="{{ url('/getqanswers') }}"> @csrf @method('GET')
                    <input type="text" name="q_id" id="qq_id" value="" hidden>
                    <div id="myfrom">

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
            <form method="post" action="{{ url('/deleteqquestion') }}">
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
            <form method="post" action="{{ url('/deleteqanswer') }}">
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
        plugins: 'autolink lists link charmap preview wordcount quickbars table',
        toolbar: 'undo redo | bold italic underline | bullist | wordcount |  addtable addrow| alignleft aligncenter alignright',
        menubar: false,
        force_br_newlines: true, // Recognize newlines as line breaks
        height: 250,
        elementpath: false,
        branding: false,
        entity_encoding: "raw",
        setup: function (editor) {
            // Define a custom button and its behavior
            editor.ui.registry.addButton('addtable', {
                text: 'Add Table',
                onAction: function () {
                    // Create an HTML table and insert it into the editor
                    var tableHtml = '<table border="1" width="100%">'+'<colgroup><col style="width: 50%;"><col style="width: 50%;"></colgroup>'+
                        '<thead>'+
                        '<tr>'+
                        '<td style="text-align: center;">ΛΙΣΤΑ 1</td> '+
                        '<td style="text-align: center;">ΛΙΣΤΑ 2</td>'+
                        '</tr>'+
                        '</thead>'+
                        '<tbody>'+
                        '<tr>'+
                        '<td>A. </td>'+
                        '<td>1. </td>'+
                        '</tr>'+
                        '</tbody>'+
                        '</table>';
                    editor.setContent(editor.getContent() + tableHtml);
                },
            });
            var cellNumber = 1; // Initialize the cell number
            var cellLetter = 'A';
            editor.ui.registry.addButton('addrow', {
                text: 'Add Row',
                onAction: function () {
                    var selectedTable = editor.dom.getParent(editor.selection.getNode(), 'table');

                    if (selectedTable) {
                        cellNumber=cellNumber+1;
                        cellLetter = String.fromCharCode(cellLetter.charCodeAt(0) + 1);
                        // Create a new row and insert it into the table
                        var newRowHtml = '<tr>' +
                            '<td style="width: 50%;">' + cellLetter + '. </td>' +
                            '<td style="width: 50%;">' + cellNumber + '. </td>' +
                            '</tr>';

                        // Find the table's tbody (or create one if it doesn't exist)
                        var tbody = selectedTable.querySelector('tbody');
                        if (!tbody) {
                            tbody = document.createElement('tbody');
                            selectedTable.appendChild(tbody);
                        }

                        // Append the new row to the tbody
                        tbody.innerHTML += newRowHtml;
                    }
                },
            });

        },
    });

    $('#type').change(function () {
        if ($(this).val() === 'Ελεύθερου Κειμένου') { // Check the selected option's value
            $('#maxnum').css('display', 'block'); // Show the input field
        } else {
            $('#maxnum').css('display', 'none'); // Hide the input field
        }
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

        if(myOb.type==='Ελεύθερου Κειμένου'){
            $('#maxnum').css('display', 'block');
            $('#maxgrade').val(myOb.maxgrade)
        }

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
        var title=$(this).attr('data-title');
        var type=$(this).attr('data-type');

        $('#q_text').html('Προσθήκη πιθανών απαντήσεων στην παρακάτω ερώτηση. <br><br><b>'+title+'</b>.');


        if(type==='Ναι/Όχι'){
            $('#addtextarea').css('display', 'none');
            $('#addtextarea').attr('type', 'hidden');

            $('#myfrom').html('<br><div id="myform1" style="display:flex;"><div class="col-md-6"><label>Απάντηση</label><br><input type="text" class="form-control" name="text[]" value="Ναι"><br></div><div class="col-md-6"><label>Βαθμός Απάντησης</label><br><input type="number" class="form-control" name="grade[]" step="0.25" value="0.00"></div></div><hr>' +
                '<br><div id="myform2" style="display:flex;"><div class="col-md-6"><label>Απάντηση</label><br><input type=text class="form-control" name="text[]" value="Όχι"><br></div><div class="col-md-6"><label>Βαθμός Απάντησης</label><br><input type="number" class="form-control" name="grade[]" step="0.25" value="0.00"></div></div><hr>');

        }

        if(type==='Αντιστοίχιση'){
            $('#addtextarea').css('display', 'none');
            $('#addtextarea').attr('type', 'hidden');

            $('#q_text').html('Προσθήκη των σωστών απαντήσεων στην παρακάτω ερώτηση. <br><br><b>'+title+'</b>.');

            $('#myfrom').html('<hr><div class="col-md-8" style="margin-left:auto;margin-right:auto;">' +
                '<table>'+
                '<thead>' +
                '<tr>' + '<td colspan="2" style="text-align: center; font-weight: bold;background:white;">ΠΡΟΣΘΗΚΗ ΑΠΑΝΤΗΣΕΩΝ</td>' + '</tr>' +
                '<tr><td style="text-align: center;">ΛΙΣΤΑ 1</td><td style="text-align: center;">ΛΙΣΤΑ 2</td><td style="text-align: center;">ΒΑΘΜΟΣ<br>AΠΑΝΤΗΣΗΣ</td></tr>'+
                '</thead>'+
                '<tbody id="tablerow">'+
                '<tr>'+
                '<td colspan="2" style="text-align: center;">Βαθμός για κάθε λάθος απάντηση.'+
                '</td>'+
                '<td style="width:25%">'+
                '<input type="number" name="falsegrade" class="form-control" step="0.25" value="0.00">'+
                '</td>'+
                '</tr>'+
                '<tr>'+
                '<td><select name="l1[]" class="form-select">'+
                '<option value="" selected hidden>Επιλέξτε</option>'+
                '@for($i = 'A'; $i <= 'Z'; $i++)'+
                '<option value="{{$i}}">{{$i}}</option>'+
                '@endfor'+
                '</select>'+
                '</td>'+
                '<td><select name="l2[]" class="form-select">'+
                '<option value="" selected hidden>Επιλέξτε</option>'+
                '@for($i = '1'; $i <= '15'; $i++)'+
                '<option value="{{$i}}">{{$i}}</option>'+
                '@endfor'+
                '</select>'+
                '</td>'+
                '<td style="width:25%">'+
                '<input type="number" name="grade[]" class="form-control" step="0.25" value="0.00">'+
                '</td>'+
                '</tr>'+
                ' </tbody>'+
                '</table>'+
                '<button type="button" id="newtablerow" class="form-control" >Προσθήκη νέας σειράς</button></div>');
            let list1 ='A'.charCodeAt(0);
            let list2=1;

            $('#newtablerow').click(function () {
                list1 = list1+1;
                list2=list2+1;
                // String.fromCharCode(list1)

                $('#tablerow').append('<tr>'+
                    '<td><select  name="l1[]" class="form-select">'+
                    '<option value="" selected hidden>Επιλέξτε</option>'+
                    '@for($i = 'A'; $i <= 'Z'; $i++)'+
                    '<option value="{{$i}}">{{$i}}</option>'+
                    '@endfor'+
                    '</select>'+
                    '</td>'+
                    '<td><select  name="l2[]" class="form-select">'+
                    '<option value="" selected hidden>Επιλέξτε</option>'+
                    '@for($i = '1'; $i <= '15'; $i++)'+
                    '<option value="{{$i}}">{{$i}}</option>'+
                    '@endfor'+
                    '</select>'+
                    '</td>'+
                    '<td style="width:25%">'+
                    '<input type="number" name="grade[]" class="form-control" step="0.25" value="0.00">'+
                    '</td>'+
                    '</tr>');
            });

        }
        if(type!=='Αντιστοίχιση' && type!=='Ναι/Όχι'){
            $('#addtextarea').css('display', 'block');
            $('#addtextarea').attr('type', '');
          $('#myfrom').html('<textarea  name="text[]" class="text" id="formtext2" placeholder="Προσθήκη Νέας Απάντησης...."></textarea>'+
            '<br><label>Βαθμός Απάντησης</label><br>'+
            '<input type="number" class="form-control col-md-6" name="grade[]" step="0.25"  value="0.00"><hr>')


            $('#addtextarea').click(function () {
                // Generate a unique ID for the new textarea
                var uniqueId = 'formtext_' + Date.now();

                // Append a new textarea with the generated unique ID
                $('#myfrom').append('<br><div id="myfrom"> <textarea  name="text[]" class="text" id="' + uniqueId + '" placeholder="Προσθήκη Νέας Απάντησης...."></textarea><br><label>Βαθμός Απάντησης</label><br><input type="number" step="0.25" class="form-control col-md-6" name="grade[]" value="0.00"> </div><hr>');

                tinyMCE.init({
                    selector: 'textarea.text',
                    plugins: 'autolink lists link charmap preview wordcount quickbars table',
                    toolbar: 'undo redo | bold italic underline | bullist | wordcount |  addtable addrow| alignleft aligncenter alignright',
                    menubar: false,
                    force_br_newlines: true, // Recognize newlines as line breaks
                    height: 200,
                    elementpath: false,
                    branding: false,
                    entity_encoding: "raw",
                    setup: function (editor) {
                        // Define a custom button and its behavior
                        editor.ui.registry.addButton('addtable', {
                            text: 'Add Table',
                            onAction: function () {
                                // Create an HTML table and insert it into the editor
                                var tableHtml = '<table border="1" width="100%">'+'<colgroup><col style="width: 50%;"><col style="width: 50%;"></colgroup>'+
                                    '<thead>'+ '<tr>'+ '<td style="text-align: center;">ΛΙΣΤΑ 1</td> '+ '<td style="text-align: center;">ΛΙΣΤΑ 2</td>'+ '</tr>'+ '</thead>'+
                                    '<tbody>'+ '<tr>'+ '<td>A. </td>'+ '<td>1. </td>'+ '</tr>'+ '</tbody>'+
                                    '</table>';
                                editor.setContent(editor.getContent() + tableHtml);
                            },
                        });
                        var cellNumber = 1; // Initialize the cell number
                        var cellLetter = 'A';
                        editor.ui.registry.addButton('addrow', {
                            text: 'Add Row',
                            onAction: function () {
                                var selectedTable = editor.dom.getParent(editor.selection.getNode(), 'table');

                                if (selectedTable) {
                                    cellNumber=cellNumber+1;
                                    cellLetter = String.fromCharCode(cellLetter.charCodeAt(0) + 1);
                                    // Create a new row and insert it into the table
                                    var newRowHtml = '<tr>' + '<td style="width: 50%;">' + cellLetter + '. </td>' + '<td style="width: 50%;">' + cellNumber + '. </td>' + '</tr>';

                                    // Find the table's tbody (or create one if it doesn't exist)
                                    var tbody = selectedTable.querySelector('tbody');
                                    if (!tbody) {
                                        tbody = document.createElement('tbody');
                                        selectedTable.appendChild(tbody);
                                    }

                                    // Append the new row to the tbody
                                    tbody.innerHTML += newRowHtml;
                                }
                            },
                        });

                    },
                });
            });
            tinyMCE.init({
                selector: 'textarea.text',
                plugins: 'autolink lists link charmap preview wordcount quickbars table',
                toolbar: 'undo redo | bold italic underline | bullist | wordcount |  addtable addrow| alignleft aligncenter alignright',
                menubar: false,
                force_br_newlines: true, // Recognize newlines as line breaks
                height: 200,
                elementpath: false,
                branding: false,
                entity_encoding: "raw",
                setup: function (editor) {
                    // Define a custom button and its behavior
                    editor.ui.registry.addButton('addtable', {
                        text: 'Add Table',
                        onAction: function () {
                            // Create an HTML table and insert it into the editor
                            var tableHtml = '<table border="1" width="100%">'+'<colgroup><col style="width: 50%;"><col style="width: 50%;"></colgroup>'+
                                '<thead>'+ '<tr><td style="text-align: center;">ΛΙΣΤΑ 1</td> <td style="text-align: center;">ΛΙΣΤΑ 2</td></tr>'+ '</thead>'+
                                '<tbody>'+ '<tr><td>A. </td><td>1. </td></tr>'+ '</tbody>'+
                                '</table>';
                            editor.setContent(editor.getContent() + tableHtml);
                        },
                    });
                    var cellNumber = 1; // Initialize the cell number
                    var cellLetter = 'A';
                    editor.ui.registry.addButton('addrow', {
                        text: 'Add Row',
                        onAction: function () {
                            var selectedTable = editor.dom.getParent(editor.selection.getNode(), 'table');

                            if (selectedTable) {
                                cellNumber=cellNumber+1;
                                cellLetter = String.fromCharCode(cellLetter.charCodeAt(0) + 1);
                                // Create a new row and insert it into the table
                                var newRowHtml = '<tr>' + '<td style="width: 50%;">' + cellLetter + '. </td>' + '<td style="width: 50%;">' + cellNumber + '. </td>' + '</tr>';

                                // Find the table's tbody (or create one if it doesn't exist)
                                var tbody = selectedTable.querySelector('tbody');
                                if (!tbody) {
                                    tbody = document.createElement('tbody');
                                    selectedTable.appendChild(tbody);
                                }

                                // Append the new row to the tbody
                                tbody.innerHTML += newRowHtml;
                            }
                        },
                    });

                },
            });


        }

        $('#qq_id').val(q_id)
        $('#popupaddpaper').fadeIn();
    });


</script>

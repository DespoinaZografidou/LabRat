<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="modal popup" id="popupdelete">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title"  style="position: relative; ">
                    <h5>{{$at_title}}</h5>
                    <p style="font-size: small">{{$l_id}} - {{$title}}<br>
                        Διδάσκων: {{$name}}</p>
                </div>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12" ><p id="deletetext"></p></div>
                <div id="teamadmin"></div>

            <form method="post" action="{{ url('/deletemyteam') }}"> @csrf @method('GET')
                <input type="text" name="t_id" id="delete_t_id" value="" hidden>
                <input type="text" name="at_id" value="{{$at_id}}" hidden>
                <button type="submit" class="cbtn btn-primary">Διαγραφή ομάδας</button>
            </form>
            </div>
                <div class="modal-footer"></div>

        </div>
    </div>
</div>


<div class="modal popup" id="popupaddmember">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title"  style="position: relative; ">
                    <h5>{{$at_title}}</h5>
                    <p style="font-size: small">{{$l_id}} - {{$title}}<br>
                        Διδάσκων: {{$name}}</p>
                </div>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <p id="addmember_text"></p>
                </div>
                <div class="row justify-content-between col-md-12" >
                        <form method="post" action="{{ url('/createteam') }}"> @csrf @method('GET')
                            <label>Επιλέξτε το νέο μέλος</label>
                            <div class="col-md-12" style="display: flex; justify-content: space-between">
                                <input type="text" name="am" class="add_member form-control col-md-3" id="add_am" value="" autocomplete="off" required>
                                <input type="text" name="name" class="add_member form-control col-md-8" id="add_name" value="" autocomplete="off">
                            </div><br>

                            @if(Auth::user()->role!='Μαθητής')
                                <input type="text" name="confirm" value="" hidden>
                            @endif
                            <input type="text" name="at_id" value="{{$at_id}}" hidden>
                            <input type="text" name="t_id" id="add_t_id" value="" hidden>
                            <button type="submit" class="cbtn btn-primary">Προσθήκη Νέου Μέλους</button>
                        </form>
                </div>

            </div>
            <div class="modal-footer"></div>
        </div>
    </div>

</div>


<div class="modal popup" id="popupcreate">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title"  style="position: relative;">
                    <h5>{{$at_title}}</h5>
                    <p style="font-size: small">{{$l_id}} - {{$title}}<br>
                    Διδάσκων: {{$name}}</p>
                </div>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12" >
                    @if(Auth::user()->role=='Μαθητής')
                    <p>Δημιουργία νέας ομάδας στην δραστηριότητα Ομάδα <b>"{{$at_title}}"</b> του μαθήματος με διαχειριστής ομάδας εσάς.</p>
                    @else
                        <p>Δημιουργία νέας ομάδας στην δραστηριότητα Ομάδα <b>"{{$at_title}}"</b> του μαθήματος.</p>
                    @endif
                </div>
                <div class="row justify-content-between col-md-12" >
                    @if(Auth::user()->role=='Μαθητής')
                    <form method="post" action="{{ url('/createteam') }}"> @csrf @method('GET')
                        <input type="text" name="am" value="{{Auth::user()->am}}" hidden>
                        <input type="text" name="at_id" value="{{$at_id}}" hidden>
                        <input type="text" name="t_id"  value="{{Auth::user()->am}}" hidden>
                        <input type="text" name="confirm" value="" hidden>
                        <button type="submit"  class="cbtn btn-primary">Δημιουργία</button>
                    </form>
                    @else
                        <form method="post" action="{{ url('/createteam') }}"> @csrf @method('GET')
                            <label>Επιλέξτε το διαχειρηστή της νέας ομάδας :</label><br>
                            <div class="col-md-12" style="display: flex; justify-content: space-between">
                                <input type="text" name="am" class="add_member form-control col-md-3" id="inputA" value="" autocomplete="off" required>
                                <input type="text" name="name" class="add_member form-control col-md-8" id="create_name" value="" autocomplete="off">
                            </div><br>
                            <input type="text" name="at_id" value="{{$at_id}}" hidden>
                            <input type="text" name="t_id" id="inputB" value="" hidden>
                            <input type="text" name="confirm" value="" hidden>
                            <button type="submit"  class="cbtn btn-primary">Δημιουργία</button>
                        </form>
                    @endif
                </div>

            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>



<div class="modal popupteam" id="members" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #94d3a2;">
                <div class="modal-title"  style="position: relative;"><h5>Επιλογή νέου μέλους </h5></div>
                <button type="button" id="close_members" class="close " data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow: auto;">
                <div id="the_key"></div>
                <div id="potential_members"></div>
                <div id="pot_members" ></div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>


<div class="modal popup" id="popupleave">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title"  style="position: relative;">
                    <h5>{{$at_title}}</h5>
                    <p style="font-size: small">{{$l_id}} - {{$title}}<br>Διδάσκων: {{$name}}</p>
                </div>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12" ><p id="leave_text"></p></div>
                <div class="row justify-content-between" >
                    <form method="post" action="{{ url('/rejectteam') }}" > @csrf @method('GET')
                        <input type="text" name="reject_data" id="leave_data" hidden>
                        <button type="submit"  class="cbtn btn-primary">Αποχώρηση</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>




<div class="modal popup" id="popupconfirm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title"  style="position: relative;">
                    <h5>{{$at_title}}</h5><p style="font-size: small">{{$l_id}} - {{$title}}<br>Διδάσκων: {{$name}}</p>
                </div>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12" >
                    <h6>Αίτημα επιβεβαίωσης συμμετοχής στην Ομάδα της Δραστηριότητας<b>"{{$at_title}}"</b></h6>
                    <p id="teamtext"></p>
                </div>
                <div class="row justify-content-between" >
                    <form method="post" action="{{ url('/rejectteam') }}" class="col-md-6"> @csrf @method('GET')
                        <input type="text" name="reject_data" id="reject_data" hidden>
                        <button type="submit" id="reject" class="rbtn btn-primary">Απόρριψη</button>
                    </form>
                    <form method="post" action="{{ url('/confirmteam') }}" class="col-md-6"> @csrf @method('GET')
                        <input type="text" name="join_id" id="join_id" hidden>
                        <button type="submit" id="confirm" class="cbtn" data-info="">Επιβεβαίωση</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>


     const $button1=$('.confirm');
     $button1.click(function () {
         const info = $(this).attr('data-info');
         const myOb = JSON.parse(info);
         var data = {del_id: myOb.id, t_id: myOb.t_id, at_id: myOb.at_id, am: myOb.am};
         // Get the button element by its ID
        document.getElementById("join_id").value=myOb.id;
        document.getElementById("reject_data").value=JSON.stringify(data);
         document.getElementById("teamtext").innerHTML ='Επιβεβαίωση συμμετοχής στην Ομάδα με τα μέλη:<br> &bull; &emsp;'+ myOb.Allthenames.replace(', ','<br> &bull; &emsp;');
         $("#popupconfirm").fadeIn();
     });

     const $button2=$('.walk');
     $button2.click(function () {
         const info = $(this).attr('data-info');
         const myOb = JSON.parse(info);

         var data = {del_id: myOb.id, t_id: myOb.t_id, at_id: myOb.at_id, am: myOb.am};
         // Get the button element by its ID
         document.getElementById("leave_data").value=JSON.stringify(data);
         document.getElementById("leave_text").innerHTML ='Είστε σίγουροι ότι θέλετε να αποχωρήσετε από την Ομάδα με τα μέλη:<br> &bull; &emsp;'+ myOb.Allthenames.replace(', ','<br> &bull; &emsp;');
         $("#popupleave").fadeIn();
     });

     const $button3=$('.create-3');
     $button3.click(function () {$("#popupcreate").fadeIn();});

     const $button4=$('.addteam');
     $button4.click(function() {
         const info = $(this).attr('data-info');
         const myOb = JSON.parse(info);

         document.getElementById("addmember_text").innerHTML='Προσθήκη νέου μέλους στην ομάδα με τα μέλη:<br>  &emsp; &bull; &emsp;'+ myOb.Allthenames.replace(', ','<br> &bull; &emsp;');
         document.getElementById("add_t_id").value=myOb.t_id;
         $("#popupaddmember").fadeIn();
     });

     $('.delete').click(function () {
         const id = $(this).attr('data-id');
         const name = $(this).attr('data-name');
         @if(Auth::user()->role!=='Μαθητής')
             $('#deletetext').html('Είστε σύγουροι ότι θέλετε να διαγράψετε την ομάδα του φοιτητή '+ name +' στη δραστηριότητα"<b>{{$at_title}}</b>";');
         @else
             $('#deletetext').html('Είστε σύγουροι ότι θέλετε να διαγράψετε την ομάδα σας στη δραστηριότητα "<b>{{$at_title}}</b>";');
         @endif

         document.getElementById("delete_t_id").value=id;
         $("#popupdelete").fadeIn();
     });

    //function that close the popups forms
    $(".popup-close").click(function () {$(".popup").fadeOut();});

     $(".add_member").click(function () {
         var members = JSON.parse('{{$participants}}'.replace(/&quot;/g, '"'));
         var html='';

         document.getElementById('the_key').innerHTML=' <input type="text" class="key form-control" value="" id="key" name="key" autocomplete="off">';
         $('#key').on('keypress', function(event) {
             var html='';
             if(event.keyCode === 13){
             if($(this).val().trim()!==''){
                 var inputValue = $(this).val().trim();
                 document.getElementById("potential_members").style.display = 'none';
                 members.forEach(function(m){
                     if(m.am.includes(inputValue) || m.name.includes(inputValue)) {
                         html += '<div class="table_tr_ch" id="the_member" data-am="' + m.am + '" data-name="' + m.name + '"> <div class="td">' + m.am + '-' + m.name + '</div></div>'
                     }
                 });
                 document.getElementById("pot_members").innerHTML=html;
                 document.getElementById("potential_members").style.display = 'νονε';
                 document.getElementById("pot_members").style.display='';
             }
             else{document.getElementById("potential_members").style.display = '';
                 document.getElementById("pot_members").style.display='none';
             }}
        });

         if(members.length === 0) {html='<div class="td"><p>Όλοι οι μαθητές έχουν λάβει συμμετοχή.</p></div>';}
         else{ members.forEach(function(m) {
             html+= '<div class="table_tr_ch" id="the_member" data-am="'+m.am+'" data-name="'+m.name+'"> ' +
                 '<div class="td">'+m.am+'-'+m.name+'</div></div>'});
         }

         document.getElementById("potential_members").innerHTML=html;

         $('.table_tr_ch').click(function (){
             const am = $(this).attr('data-am');
             const name = $(this).attr('data-name');

             $('#add_am').val(am);
             $('#add_name').val(name);
             $('#inputA').val(am);
             $('#inputB').val(am);
             $('#create_name').val(name);
             $("#members").fadeOut();
         });
         $("#members").fadeIn();
     });


     $("#close_members").click(function () {$(".popupteam").fadeOut();});



     // Get the reference to the draggable div element
     const draggableDiv = document.getElementById('members');

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

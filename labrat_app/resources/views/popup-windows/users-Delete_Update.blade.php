<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{--    //pop up window that gives the ability to delete a user from the database--}}
<div class="modal popup" id="popupdelete">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Διαγραφή Χρήστη</h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ url('/deleteUser')  }}">
                @csrf @method('GET')
                <div class="modal-body ">
                    <label class="col-md-12 col-form-label" id="text"></label>
                    <input type="text" id="id" name="id" value="" hidden>
                    <button type="submit" class="btn btn-primary col-md-12">Διαγραφή</button>
                </div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>

<div class="popup modal" id="popupdate">
    <div class=" modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" > Προσωπικές Πληροφορίες</h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/updateprofile') }}" method="post" enctype="multipart/form-data"> @csrf @method('GET')
                <div class="modal-body row justify-content-between ">
                    <div class="container" style="width: 250px; height: 250px; position: relative;">
                        <div class="container" id="myimage"  style="width: 200px; height: 200px; border-radius: 50%; overflow: hidden;position: relative;"></div>

                            <span style="position: absolute;bottom: 63px; right: 50px; background-color: green; width: 25px; height: 25px; border-radius: 50%;border: 3px solid black;" id="true" hidden></span>
                            <span style="position: absolute;bottom: 63px; right: 50px; background-color: darkred; width: 25px; height: 25px; border-radius: 50%;border: 3px solid black;" id="false" hidden></span>

                        <label for="imageInput" class="file-icon" style="position: absolute;width: 30px; height: 30px; border-radius: 50%;color:white; background-color: black; left:20px;bottom: 170px;text-align: center">
                            <ion-icon style="width: 25px; height: 25px; " name="cloud-upload"></ion-icon>
                        </label>
                        <input type="file" name="image" id="imageInput" accept="image/*"  style="display: none">

                    </div>
                    <div  style="width: 500px;display: flex">
                        <input type="text" name="id" value="" id="userid" hidden>
                        <div style="width: 240px;">
                            <h5 class="" style="font-size: small; color: grey;">Ονοματεπώνυμο</h5>
                            <label class="pl-2" style="font-size: small" id="name"></label><br>
                            <h5  style="font-size: small; color: grey;">Ρόλος</h5>
                            <select  class="form-control-sm" name="role" style="cursor: pointer">
                                <option value="" id="selectedrole" hidden></option>
                                <option value="Καθηγητής">Καθηγητής</option>
                                <option value="Μαθητής">Μαθητής</option>
                                <option value="Διαχειριστής">Διαχειριστής</option>
                            </select><hr>
                            <div id="qualifications">
                                <h5  style="font-size: small; color: grey;">Ιδιότητα/Βαθμός</h5>
                                <select  class="form-control-sm" name="qualification" style="cursor: pointer">
                                    <option value="" id="selectedqualification" hidden></option>
                                    <option value="Αναπληρωτής">Αναπληρωτής</option>
                                    <option value="Επίκουρος">Επίκουρος</option>
                                    <option value="Καθηγητής">Καθηγητής</option>
                                </select><br><br>
                            </div>
                            <h5 id="typelabel" style="font-size: small; color: grey;">Τύπος</h5>
                           <div id="type">
                                <select  class="form-control-sm" name="type" id="userstype" style="cursor: pointer">
                                    <option value="" id="selectedtype" hidden></option>
                                    <option id=2 value="Προπτυχιακό">Προπτυχιακό</option>
                                    <option id=3 value="Μεταπτυχιακό">Μεταπτυχιακό</option>
                                    <option id=4 value="Διδακτορικό">Διδακτορικό</option>

                                    <option id=5 value="Μέλος ΔΕΠ">Μέλος ΔΕΠ</option>
                                    <option id=6 value="Μέλος ΕΔΙΠ">Μέλος ΕΔΙΠ</option>
                                    <option id=7 value="Μέλος ΕΤΕΠ">Μέλος ΕΤΕΠ</option>
                                    <option id=8 value="Ερευνητής">Ερευνητής</option>
                                </select><br><br>
                           </div>

                        </div>

                        <div style="width: 240px;">
                            <h5 class="" style="font-size: small; color: grey;">Αρ.Μητρώου</h5>
                            <label class="pl-2 " style="font-size: small" id="am">@if(Auth::user()->am==null)-- @else{{Auth::user()->am}}@endif</label><br>

                            <h5 class="" style="font-size: small; color: grey;">Ηλεκ. Διεύθυνση</h5>
                            <label class="pl-2 " style="font-size: small" id="email">@if(Auth::user()->email==null)-- @else{{Auth::user()->email}}@endif</label><hr>

                            <h5 class="" style="font-size: small; color: grey;">Έτος Εγγραφής</h5>
                            <select class="form-control-sm" name="register_year" style="cursor: pointer">
                                <option value="" id="selectedregisteryear" hidden></option>
                                <?php for ($year = (int)date('Y'); 2000 <= $year; $year--): ?>
                                <option value="{{$year}}">{{$year}}</option>
                                <?php endfor; ?>
                            </select><br><br>
                            <h5 id="system_statuslabel" style="font-size: small; color: grey;">Κατάσταση στο σύστημα</h5>
                            <select class="form-control-sm" name="system_status" id="system_status" style="cursor: pointer">
                                <option id="selectedstatus" hidden></option>
                                <option value="1">Ενεργό</option>
                                <option value="0" >Απενεργό</option>
                            </select><br><br>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary col-md-12">Αποθήκευση</button>
                </div>
            </form>

            <div class="modal-footer"></div>
        </div>
    </div>

</div>

<script>

   // function that shows the popup form to delete a user
    function userDelete(name,id)
    {
        $('#popupdelete').fadeIn();
        document.getElementById("text").innerHTML='Εισάστε σιγουροί ότι θέλετε να διαγράψετε το χρήστη <br>"'+ name +'" από το σύστημα;';
        document.getElementById('id').value=id;

    }

const $mylink=$('.td');
$mylink.click(function(){
    const info = $(this).attr('data-info');
    const myOb = JSON.parse(info);
    var assetURL='';
    if(myOb.image==='' || myOb.image===null ){
            assetURL = '{{ asset('app_images/profile.png') }}';
    }else{ assetURL = '{{ asset('users_images') }}' + '/'+myOb.image;}

    console.log(assetURL);
    // Get the element by its ID
    const myimageElement = document.getElementById("myimage");
    // Set the HTML content using innerHTML and proper concatenation
    myimageElement.innerHTML = '<img id="imagePre" src="' + assetURL + '" alt="" style="margin-left: -12px;width: 200px; height: 200px;color: #94d3a2;">';

    document.getElementById("userid").value= myOb.id;

    document.getElementById("name").innerHTML='<b>'+ myOb.name+'</b>';
    document.getElementById("am").innerHTML= myOb.am;
    document.getElementById("email").innerHTML= myOb.email;

    document.querySelector("#selectedrole").selected = true;
    document.querySelector("#selectedrole").value = myOb.role;
    document.querySelector("#selectedrole").textContent = myOb.role;

    if(myOb.role==='Καθηγητής'){
        document.querySelector("#selectedqualification").selected = true;
        document.querySelector("#selectedqualification").value = myOb.qualification;
        document.querySelector("#selectedqualification").textContent = myOb.qualification;
    }else{
        document.getElementById('qualifications').style.display='none';
    }


    document.querySelector("#selectedregisteryear").selected = true;
    document.querySelector("#selectedregisteryear").value = myOb.register_year;
    document.querySelector("#selectedregisteryear").textContent = myOb.register_year;

    document.querySelector("#selectedtype").selected = true;
    document.querySelector("#selectedtype").value = myOb.type;
    document.querySelector("#selectedtype").textContent = myOb.type;


    if(myOb.role==='Καθηγητής'){
        document.getElementById('2').style.display='none';
        document.getElementById('3').style.display='none';
        document.getElementById('4').style.display='none';
    }
    if(myOb.role==='Μαθητής'){
        document.getElementById('5').style.display='none';
        document.getElementById('6').style.display='none';
        document.getElementById('7').style.display='none';
        document.getElementById('8').style.display='none';
    }
    if(myOb.role==='Διαχειριστής'){
        document.getElementById('userstype').hidden=true;
        document.getElementById('typelabel').hidden=true;
        if({{Auth::user()->id}}===myOb.id){
            document.getElementById('system_statuslabel').hidden=true;
            document.getElementById('system_status').hidden=true;
        }else{
            document.getElementById('system_statuslabel').hidden=false;
            document.getElementById('system_status').hidden=false;
        }
    }

    document.querySelector("#selectedstatus").selected = true;
    document.querySelector("#selectedstatus").value = myOb.system_status;
    if(myOb.system_status===1) {
        document.getElementById('true').hidden=false;
        document.getElementById('false').hidden=true;
        document.querySelector("#selectedstatus").textContent = 'Ενεργό';
    }else{
        document.getElementById('false').hidden=false;
        document.getElementById('true').hidden=true;
        document.querySelector("#selectedstatus").textContent = 'Απενεργό';
    }


    $("#popupdate").fadeIn();
});



    //function that close the popups forms
    $(".popup-close").click(function () {
        $(".popup").fadeOut();
    });


    $(document).ready(function() {
        $('#imageInput').on('change', function(e) {

            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imagePre').attr('src', e.target.result);
            }

            reader.readAsDataURL(file);
        });
    });

</script>

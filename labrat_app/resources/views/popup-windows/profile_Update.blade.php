<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                   <div class="container"  style="width: 200px; height: 200px; border-radius: 50%; overflow: hidden;position: relative;">
                       @if(Auth::User()->image === null || Auth::user()->image==='')
                           <img id="imagePreview"   src="{{ asset('app_images/profile.png') }}" alt="" style="margin-left: -12px;width: 200px; height: 200px;color: #94d3a2;">
                       @endif
                       @if(Auth::User()->image !== null)
                           <img id="imagePreview"  src="{{ asset( 'users_images/'.Auth::User()->image) }}" alt="" style="margin-left: -12px;width: 200px; height: 200px;color: #94d3a2;">
                       @endif
                   </div>

                    @if(Auth::user()->system_status === 1)
                        <span style="position: absolute;bottom: 63px; right: 50px; background-color: green; width: 25px; height: 25px; border-radius: 50%;border: 3px solid black;"></span>
                    @else
                        <span style="position: absolute;bottom: 63px; right: 50px; background-color: darkred; width: 25px; height: 25px; border-radius: 50%;border: 3px solid black;"></span>
                    @endif
                    <label for="imageInput" class="file-icon" style="position: absolute;width: 30px; height: 30px; border-radius: 50%;color:white; background-color: black; left:20px;bottom: 170px;text-align: center">
                        <ion-icon style="width: 25px; height: 25px; " name="cloud-upload"></ion-icon>
                    </label>
                    <input type="file" name="image" id="imageInput" accept="image/*"  style="display: none">

                </div>
                <div  style="width: 500px;display: flex">
                    <input type="text" name="role" value="{{Auth::user()->role}}" hidden>
                    <input type="text" name="id" value="{{Auth::user()->id}}" hidden>
                    <div style="width: 240px;">
                    <h7 class="" style="font-size: small; color: grey;">Ονοματεπώνυμο</h7><br>
                    <label class="pl-2" style="font-size: small"><b>{{Auth::user()->name}}</b></label><br>
                    <h7 class="" style="font-size: small; color: grey;">Ρόλος</h7><br>
                    <label class="pl-2 " style="font-size: small;">{{Auth::user()->role}}</label><hr>
                    @if(Auth::user()->role==='Καθηγητής')
                        <h7 class="" style="font-size: small; color: grey;">Ιδιότητα/Βαθμός</h7><br>
                        <select  class="form-control-sm" name="qualification" style="cursor: pointer">
                            <option value="{{Auth::user()->qualification}}" selected hidden>{{Auth::user()->qualification}}</option>
                            <option value="Αναπληρωτής">Αναπληρωτής</option>
                            <option value="Επίκουρος">Επίκουρος</option>
                            <option value="Καθηγητής">Καθηγητής</option>
                        </select><br><br>
                    @endif
                    <h7 class="" style="font-size: small; color: grey;">Τύπος</h7><br>
                    @if(Auth::user()->role==='Μαθητής')
                    <select  class="form-control-sm" name="type" style="cursor: pointer">
                        <option value="{{Auth::user()->type}}" selected hidden>{{Auth::user()->type}}</option>
                        <option value="Προπτυχιακό">Προπτυχιακό</option>
                        <option value="Μεταπτυχιακό">Μεταπτυχιακό</option>
                        <option value="Διδακτορικό">Διδακτορικό</option>
                    </select><br><br>
                    @endif
                    @if(Auth::user()->role==='Καθηγητής')
                        <select class="form-control-sm" name="type" style="cursor: pointer">
                            <option value="{{Auth::user()->type}}" selected hidden>{{Auth::user()->type}}</option>
                            <option value="Μέλος ΔΕΠ">Μέλος ΔΕΠ</option>
                            <option value="Μέλος ΕΔΙΠ">Μέλος ΕΔΙΠ</option>
                            <option value="Μέλος ΕΤΕΠ">Μέλος ΕΤΕΠ</option>
                            <option value="Ερευνητής">Ερευνητής</option>
                        </select><br><br>

                    @endif
                    @if(Auth::user()->role==='Διαχειριστής')
                        <label class="pl-2" style="font-size: small;">@if(Auth::user()->type==null) -- @else{{Auth::user()->type}}@endif</label><br><br>
                    @endif
                </div>

                    <div style="width: 240px;">

                    <h7 class="" style="font-size: small; color: grey;">Αρ.Μητρώου</h7><br>
                    <label class="pl-2 " style="font-size: small">@if(Auth::user()->am==null)-- @else{{Auth::user()->am}}@endif</label><br>

                    <h7 class="" style="font-size: small; color: grey;">Ηλεκ. Διεύθυνση</h7><br>
                    <label class="pl-2 " style="font-size: small">@if(Auth::user()->email==null)-- @else{{Auth::user()->email}}@endif</label><hr>

                    <h7 class="" style="font-size: small; color: grey;">Έτος Εγγραφής</h7><br>
                    <select class="form-control-sm" name="register_year" style="cursor: pointer">
                        <option value="{{Auth::user()->register_year}}" selected hidden>{{Auth::user()->register_year}}</option>
                        <?php for ($year = (int)date('Y'); 2000 <= $year; $year--): ?>
                        <option value="{{$year}}">{{$year}}</option>
                        <?php endfor; ?>
                    </select><br><br>
                        @if(Auth::user()->role!=='Διαχειριστής')
                        <h7 class="" style="font-size: small; color: grey;">Κατάσταση στο σύστημα</h7><br>
                        <select class="form-control-sm" name="system_status" style="cursor: pointer">
                            @if(Auth::user()->system_status==1)
                                <option value="{{Auth::user()->system_status}}" selected hidden>Ενεργό</option>
                            @endif
                            @if(Auth::user()->system_status==0)
                                <option value="{{Auth::user()->system_status}}" selected hidden>Απενεργό</option>
                            @endif
                            <option value="1">Ενεργό</option>
                            <option value="0">Απενεργό</option>
                        </select><br><br>
                        @endif

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

    $(".edit").click(function () {
        $("#popupdate").fadeIn();
    });

    //function that close the popups forms
    $(".popup-close").click(function () {
        $("#popupdate").fadeOut();
    });


    $(document).ready(function() {
        $('#imageInput').on('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
            }

            reader.readAsDataURL(file);
        });
    });
</script>

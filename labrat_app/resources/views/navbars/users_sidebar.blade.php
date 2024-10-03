<nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm flex-md-column flex-row align-items-start py-2 min-vh-100 ">
    <div class="pl-2 pr-2" style="position: -webkit-sticky;position: sticky;top: 63px; z-index: 1020;" >
        <button  class="navbar-toggler btn" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarSupportedContent"
                 aria-controls="sidebarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <ion-icon style="color: white" name="search"></ion-icon>
        </button>

        <div class="collapse navbar-collapse"  id="sidebarSupportedContent">
            <form method="POST" action="{{ url('/filterUsers/'.$title)  }}" class="flex-md-column navbar-nav w-100 justify-content-between" >
                @csrf @method('GET')
                <!-- Authentication Links -->
                <br>
                <li class="nav-item ">
                    <a class="nav-link pl-0 text-nowrap"><ion-icon name="search"></ion-icon>Φίλτρα Αναζήτησης</a>
                </li>
                <hr><br>
                @if($title=='Μαθητής' or $title=='Καθηγητής')
                <li class="nav-item button-4" id="register_year_b"><a class="nav-link pl-0 text-nowrap" href="#" >Έτος Εγγραφής</a></li>
                    <div class="input" id="register_year_show" style="overflow-y: scroll; height: 110px;">
                        <?php
                        for ($year = (int)date('Y'); 2000 <= $year; $year--): ?>
                        <input type="checkbox" name="register_year" onclick="$('input[name=register_year]').not(this).prop('checked', false);"  value="{{$year}}"><label class="pr-2">{{$year}}</label>
                        <?php $year=$year-1 ?>
                        <input type="checkbox" name="register_year" onclick="$('input[name=register_year]').not(this).prop('checked', false);" value="{{$year}}"><label>{{$year}}</label><br>
                        <?php endfor; ?>
                    </div><hr>
                @endif

                <li class="nav-item button-4" id="status_b"><a class="nav-link pl-0 text-nowrap ">Status</a></li>
                <div class="input"  id="status_show">
                    <input type="checkbox" name="status" onclick="$('input[name=status]').not(this).prop('checked', false);" value="1"><label>Ενεργό</label><br>
                    <input type="checkbox" name="status" onclick="$('input[name=status]').not(this).prop('checked', false);" value="0"><label>Απενεργό</label>
                </div>

                <hr>
                @if($title=='Μαθητής')
                    <li class="nav-item button-4" id="type_b" ><a class="nav-link pl-0 text-nowrap ">Τύπος Σπουδων</a></li>
                    <div class="input"  id="type_show" >
                        <input type="checkbox" name="type" onclick="$('input[name=type]').not(this).prop('checked', false);" value="Προπτυχιακό"><label> Προπτυχιακό</label><br>
                        <input type="checkbox" name="type" onclick="$('input[name=type]').not(this).prop('checked', false);" value="Μεταπτυχιακό"><label> Μεταπτυχιακό</label><br>
                        <input type="checkbox" name="type" onclick="$('input[name=type]').not(this).prop('checked', false);" value="Διδακτορικό"><label> Διδακτορικό</label>
                    </div><hr>
                @endif
                @if($title=='Καθηγητής')
                    <li class="nav-item button-4" id="type_b" ><a class="nav-link pl-0 text-nowrap ">Τύπος Διδάσκοντα</a></li>
                    <div class="input"  id="type_show" >
                        <input type="checkbox"  name="type" onclick="$('input[name=type]').not(this).prop('checked', false);" value="Μέλος ΔΕΠ"><label> Μέλος ΔΕΠ</label><br>
                        <input type="checkbox"  name="type" onclick="$('input[name=type]').not(this).prop('checked', false);" value="Μέλος ΕΔΙΠ"><label> Μέλος ΕΔΙΠ</label><br>
                        <input type="checkbox"  name="type" onclick="$('input[name=type]').not(this).prop('checked', false);" value="Μέλος ΕΤΕΠ"><label> Μέλος ΕΤΕΠ</label><br>
                        <input type="checkbox"  name="type" onclick="$('input[name=type]').not(this).prop('checked', false);" value="Ερευνητής"><label> Ερευνητής</label><br>
                    </div><hr>

                    <li class="nav-item button-4" id="qualification_b" ><a class="nav-link pl-0 text-nowrap ">Ιδιότητητα/Βαθμός</a></li>
                    <div class="input"  id="qualification_show" >
                        <input type="checkbox" name="qualification" onclick="$('input[name=qualification]').not(this).prop('checked', false);" value="Αναπληρωτής"><label> Αναπληρωτής</label><br>
                        <input type="checkbox" name="qualification" onclick="$('input[name=qualification]').not(this).prop('checked', false);" value="Επίκουρος"><label> Επίκουρος</label><br>
                        <input type="checkbox" name="qualification" onclick="$('input[name=qualification]').not(this).prop('checked', false);" value=Καθηγητής"><label> Καθηγητής</label>
                    </div><hr>
                @endif

                <br><input type="submit" class="button-3" value="Αναζήτηση"><br>

            </form>
        </div>
    </div>
</nav>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script>
//----if the user choose one of the filters' button then show the div with the options----
$("#register_year_b").click(function(){
    $("#register_year_show").toggle(function(){
        $("#register_year_show").is(':hidden')?$('#register_year_b').removeClass('active'): $('#register_year_b').addClass('active');
    });
});

$("#status_b").click(function(){
    $("#status_show").toggle(function(){
        $("#status_show").is(':hidden')?$('#status_b').removeClass('active'): $('#status_b').addClass('active');
    });
});

$("#type_b").click(function(){
    $("#type_show").toggle(function(){
        $("#type_show").is(':hidden')?$('#type_b').removeClass('active'): $('#type_b').addClass('active');
    });
});


$("#qualification_b").click(function(){
    $("#qualification_show").toggle(function(){
        $("#qualification_show").is(':hidden')?$('#qualification_b').removeClass('active'): $('#qualification_b').addClass('active');
    });
});

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm flex-md-column flex-row align-items-start
    py-2 min-vh-100">
    <div class="container" style="position: -webkit-sticky;position: sticky;top: 63px; z-index: 1020;">
        <button  class="navbar-toggler btn" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarSupportedContent"
                 aria-controls="sidebarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <ion-icon style="color: white" name="search"></ion-icon>
        </button>
        <div class="collapse navbar-collapse"  id="sidebarSupportedContent">
            <form method="POST" action="{{ url('/filterLessons/'.$type) }}" class="flex-md-column navbar-nav w-100 justify-content-between" >
                @csrf @method('GET')
                <br>
                <li class="nav-item ">
                    <a class="nav-link pl-0 text-nowrap"><ion-icon name="search"></ion-icon>Φίλτρα Αναζήτησης</a>
                </li>
                <hr><br>

                <li class="nav-item button-4" id="semester_b"><a class="nav-link pl-0 text-nowrap ">Εξάμηνο</a></li>
                <div class="input" id="show_semester" style="overflow-y: scroll; height: 110px;">
                    <?php for ($i = 1; $i <= 20; $i++) {?>
                        <input type="checkbox" name="semester"onclick="$('input[name=semester]').not(this).prop('checked', false);"  value="{{$i}}ο Εξάμηνο" ><label>{{$i}}ο Εξάμηνο</label><br>
                    <?php } ?>
                </div>
                <hr>
                @if(Auth::user()->role!=='Μαθητής')
                <li class="nav-item button-4" id="area_b" ><a class="nav-link pl-0 text-nowrap ">Χώρος</a></li>
                <div class="input" id="show_area" >
                    <input type="checkbox" name="area" onclick="$('input[name=area]').not(this).prop('checked', false);"  value="1" ><label>Ενεργός</label><br>
                    <input type="checkbox" name="area" onclick="$('input[name=area]').not(this).prop('checked', false);"  value="0" ><label>Απενεργός</label>
                </div><hr>
                @endif
                @if(Auth::user()->role!=='Καθηγητής')
                <li class="nav-item button-4" id="professors_b" ><a class="nav-link pl-0 text-nowrap ">Καθηγητής</a></li>
                <div class="input"  id="show_professors" style="overflow-y: scroll; height: 110px;">
                    @foreach($professors as $p)
                        <input type="checkbox" name="professor" onclick="$('input[name=professor]').not(this).prop('checked', false);" value="{{$p->id}}" ><label style="font-size: smaller">{{$p->name}}</label><br>
                    @endforeach
                </div><hr>
                @endif
                @if(Auth::user()->role=='Καθηγητής')
                    <input type="checkbox" name="professor"  value="{{Auth::user()->id}}" checked hidden>
                @endif
                <input type="submit" class="button-3" value="Αναζήτηση"><br>
            </form>
        </div>
    </div>
</nav>


<script>

    // if the user clicks on a filter's button show the options
        $("#semester_b").click(function(){
            $("#show_semester").toggle(function(){
                $("#show_semester").is(':hidden')?$('#semester_b').removeClass('active'): $('#semester_b').addClass('active');
            });
        });

        $("#area_b").click(function(){
            $("#show_area").toggle(function() {
                $("#show_area").is(':hidden') ? $('#area_b').removeClass('active') : $('#area_b').addClass('active');
            });
        });

        $("#professors_b").click(function(){
            $("#show_professors").toggle(function(){
                $("#show_professors").is(':hidden')?$('#professors_b').removeClass('active'):$('#professors_b').addClass('active');
            });
        });

</script>

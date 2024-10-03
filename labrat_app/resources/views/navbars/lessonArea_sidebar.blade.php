{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>--}}

<nav class="navbar navbar-expand-xl navbar-light bg-light shadow-sm flex-md-column flex-row align-items-start py-2 min-vh-100" >
    <div class="pl-2 pr-2" style="position: -webkit-sticky;position: sticky;top: 63px; z-index: 1020;">
        <button class="navbar-toggler btn" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarSupportedContent"
                 aria-controls="sidebarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <ion-icon style="color: white"  name="clipboard"></ion-icon>
        </button>
        <div class="collapse navbar-collapse"  id="sidebarSupportedContent">
            <ul class="flex-md-column navbar-nav w-100 justify-content-between">
<br>
                <li class="nav-item ">
                    <a class="nav-link pl-4 text-nowrap"></a>
                </li>
                <hr>
                <li class="nav-item button-4 pl-2 pr-2" id="home"><a class="nav-link pl-0 text-nowrap" style="font-size: small" href="{{url('/lessonArea/'.$l_id)}}"><ion-icon name="home"></ion-icon> Αρχική Μαθήματος</a></li><hr>
                @if(Auth::user()->role!='Μαθητής')
                    <li class="nav-item button-4 pl-2 pr-2" id="participation"><a class="nav-link pl-0 text-nowrap" style="font-size: small" href="{{ route('Participants',['l_id'=>$l_id,'title'=>$title,'name'=>$name]) }}"> Συμμετοχές </a></li><hr>
                @endif

                <li class="nav-item button-4 pl-2 pr-2" id="activitiesteam"><a class="nav-link text-nowrap " style="font-size: small"  href="{{ route('activityteams',['l_id'=>$l_id,'title'=>$title,'name'=>$name]) }}">Ομάδες </a></li><hr>
                <li class="nav-item button-4 pl-2 pr-2" id="chooseactivities"><a class="nav-link text-nowrap" style="font-size: small" href="{{ route('choosethemeactivities',['l_id'=>$l_id,'title'=>$title,'name'=>$name]) }}"> Επιλογή θέματων </a></li><hr>
                <li class="nav-item button-4 pl-2 pr-2" id="determinateactivities"><a class="nav-link text-nowrap" style="font-size: small" href="{{ route('determinatethemeactivities',['l_id'=>$l_id,'title'=>$title,'name'=>$name]) }}"> Προσδιοριορισμός Θεμάτων </a></li><hr>
                <li class="nav-item button-4 pl-2 pr-2" id="slotactivities"><a class="nav-link text-nowrap" style="font-size: small" href="{{ route('slotactivities',['l_id'=>$l_id,'title'=>$title,'name'=>$name]) }}"> Επιλογή Slot</a></li><hr>
                <li class="nav-item button-4 pl-2 pr-2" id="votingactivities"><a class="nav-link text-nowrap" style="font-size: small" href="{{ route('votingactivities',['l_id'=>$l_id,'title'=>$title,'name'=>$name]) }}"> Ψηφοφορία </a></li><hr>
                <li class="nav-item button-4 pl-2 pr-2" id="quizactivities"><a class="nav-link text-nowrap" style="font-size: small" href="{{ route('quizactivities',['l_id'=>$l_id,'title'=>$title,'name'=>$name]) }}"> Κουίζ </a></li><hr>

            </ul>
        </div>
    </div>
</nav>


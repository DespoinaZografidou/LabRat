{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>--}}

<nav class="navbar navbar-expand-xl navbar-light bg-light shadow-sm flex-md-column flex-row align-items-start py-2 min-vh-100" >
    <div class="pl-2 pr-2" style="position: -webkit-sticky;position: sticky;top: 63px; z-index: 1020;">
        <button class="navbar-toggler btn" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarSupportedContent"
                 aria-controls="sidebarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <ion-icon  style="color: white" name="notifications"></ion-icon>
        </button>
        <div class="collapse navbar-collapse"  id="sidebarSupportedContent">
            <ul class="flex-md-column navbar-nav w-100 justify-content-between" >
                <br>
                <li class="nav-item pl-4">
                    <a class="nav-link text-nowrap"><ion-icon name="notifications"></ion-icon> Ειδοποιήσεις</a>
                </li>
                <hr><br>

                <li class="nav-item button-4 pl-2 pr-2" id="1">
                    @if($teams>0)
                        <span class="bubble-not">{{ $teams }} </span>
                    @endif
                    <a class="nav-link pl-0 text-nowrap" style="font-size: small" href="{{ route('announcementsteams',['am'=>Auth::user()->am, 'activity'=>'1']) }}">Ομάδες</a></li><hr>

                <li class="nav-item button-4 pl-2 pr-2" id="2">
                    @if($c_themes>0)
                        <span class="bubble-not">{{ $c_themes }}</span>
                    @endif
                    <a class="nav-link pl-0 text-nowrap" style="font-size: small" href="{{ route('announcementc_themes',['am'=>Auth::user()->am, 'activity'=>'2']) }}"> Επιλογή θέματων </a></li><hr>

                <li class="nav-item button-4 pl-2 pr-2" id="3">
                    @if($d_themes>0)
                        <span class="bubble-not">{{ $d_themes }}</span>
                    @endif
                    <a class="nav-link pl-0 text-nowrap" style="font-size: small" href="{{ route('announcementd_themes',['am'=>Auth::user()->am, 'activity'=>'3']) }}"> Προσδιοριοριμός Θεμάτων </a></li><hr>

                <li class="nav-item button-4 pl-2 pr-2" id="4">
                    @if($slots>0)
                        <span class="bubble-not">{{ $slots }}</span>
                    @endif
                    <a class="nav-link pl-0 text-nowrap" style="font-size: small"  href="{{ route('announcementslots',['am'=>Auth::user()->am, 'activity'=>'4']) }}"> Επιλογή Slot</a></li><hr>

{{--                <li class="nav-item button-4 pl-2 pr-2" id="5"><a class="nav-link pl-0 text-nowrap" href=""> Ψηφοφορία </a></li><hr>--}}

{{--                <li class="nav-item button-4 pl-2 pr-2" id="6"><a class="nav-link pl-0 text-nowrap" href=""> Κουίζ </a></li><hr>--}}

            </ul>
        </div>
    </div>
</nav>

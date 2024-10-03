
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm  sticky-top" style="z-index: 1040;">
        <a class="navbar-brand pl-3" href="">
            <img src="{{ URL('app_images/labrat.png') }}" alt="" style="width: 45px; height: 45px;">
           <b>LabRat</b>
        </a>
        <button class="navbar-toggler btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <ion-icon style="color: white" name="menu"></ion-icon>
        </button>
<div class="collapse navbar-collapse" id="navbarSupportedContent" >
    <!-- Left Side Of Navbar -->
    <ul class="navbar-nav me-auto"></ul>

    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav d-flex flex-row justify-content-end">
        <!-- Authentication Links -->
        @guest

        @else
            @if(Auth::user()->role=='Διαχειριστής')
                <li class="nav-item button-47" style="height: 55px">
                    <a class="nav-link" style="display: flex;align-items: center;height: 100%" href="{{ route("home") }}">Αρχική</a>
                </li>
                <li class="nav-item dropdown button-47" style="height: 55px">
                    <a id="navbarDropdown" style="display: flex;align-items: center;height: 100%" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre >Χρήστες</a>
                    <div class="dropdown-menu dropdown-menu-start" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('users',['role'=>'Καθηγητής']) }}">Καθηγητές</a>
                        <a class="dropdown-item" href="{{ route('users',['role'=>'Μαθητής']) }}">Μαθητές</a>
                        <a class="dropdown-item" href="{{ route('users',['role'=>'Διαχειριστής']) }}">Διαχειριστές</a>
                    </div>
                </li>
                <li class="nav-item dropdown button-47" style="height: 55px;">
                    <a id="navbarDropdown" style="display: flex;align-items: center;height: 100%" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre >Μαθήματα</a>
                    <div class="dropdown-menu dropdown-menu-start " aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('lessons',['type'=>'Προπτυχιακό']) }}">Προπτυχιακό</a>
                        <a class="dropdown-item" href="{{ route('lessons',['type'=>'Μεταπτυχιακό']) }}">Μεταπτυχικό</a>
                        <a class="dropdown-item" href="{{ route('lessons',['type'=>'Διδακτορικό']) }}">Διδακτορικό</a>
                    </div>
                </li>

            @endif
            @if(Auth::user()->role=='Καθηγητής')
                    <li class="nav-item button-47" style="display: flex;align-items: center;height: 55px">
                        <a class="nav-link" style="display: flex;align-items: center;height: 100%" href="{{ route("home") }}">Αρχική</a>
                    </li>
                    <li class="nav-item dropdown button-47" style="height: 55px">
                        <a id="navbarDropdown" style="display: flex;align-items: center;height: 100%" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre >Μαθήματα</a>
                        <div class="dropdown-menu dropdown-menu-start" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('mylessons',['type'=>'Προπτυχιακό','id'=>Auth::user()->id]) }}">Προπτυχιακό</a>
                            <a class="dropdown-item" href="{{ route('mylessons',['type'=>'Μεταπτυχιακό','id'=>Auth::user()->id]) }}">Μεταπτυχικό</a>
                            <a class="dropdown-item" href="{{ route('mylessons',['type'=>'Διδακτορικό','id'=>Auth::user()->id]) }}">Διδακτορικό</a>
                        </div>
                    </li>

            @endif
            @if(Auth::user()->role=='Μαθητής')
                <li class="nav-item  button-47" style="height: 55px">
                    <a class="nav-link" style="display: flex;align-items: center;height: 100%" href="{{ route("homepage",['type'=>'Προπτυχιακό','am'=>Auth::user()->am]) }}">Αρχική</a>
                </li>

                    <li class="nav-item button-47" style="height: 55px;">
                        <a class="nav-link" id="buttonbell" style="display: flex;align-items: center;height: 100%;" href="{{ route('announcementsteams',['am'=>Auth::user()->am, 'activity'=>'1']) }}"><span id="thebell" class="thebell"></span></a>
                    </li>
                    <li class="nav-item dropdown button-47" style="height: 55px">
                        <a id="navbarDropdown" style="display: flex;align-items: center;height: 100%" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre >Μαθήματα</a>
                        <div class="dropdown-menu dropdown-menu-start" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('allthelessons',['type'=>'Προπτυχιακό','am'=>Auth::user()->am]) }}">Προπτυχιακό</a>
                            <a class="dropdown-item" href="{{ route('allthelessons',['type'=>'Μεταπτυχιακό','am'=>Auth::user()->am]) }}">Μεταπτυχικό</a>
                            <a class="dropdown-item" href="{{ route('allthelessons',['type'=>'Διδακτορικό','am'=>Auth::user()->am]) }}">Διδακτορικό</a>
                        </div>
                    </li>

            @endif



            <li class="nav-item dropdown button-47" style="background-color: #94d3a2;height: 55px">
                <a id="navbarDropdown" style="display: flex;align-items: center;height: 100%" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-start" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" id="logout" href="#" data-action="logout">{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
{{--                @if(Auth::user()->system_status===0)--}}
{{--                    <script>--}}
{{--                        document.getElementById('logout-form').submit();--}}
{{--                    </script>--}}
{{--                @endif--}}
            </li>
        @endguest
    </ul>
</div>

</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const logoutLink = document.querySelector('[data-action="logout"]');
        const logoutForm = document.getElementById('logout-form');

        if (logoutLink && logoutForm) {
            logoutLink.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent the default behavior (navigation)

                // Submit the form when the "Logout" link is clicked
                logoutForm.submit();
            });
        }
    });


    const $bell = document.getElementById('thebell');
    const $bbell = document.getElementById('buttonbell');

    $bbell.addEventListener("mouseenter", function(event){
        $bell.classList.add('notify');
    });

    $bbell.addEventListener("animationend", function(event){
        $bell.classList.remove('notify');
    });

</script>

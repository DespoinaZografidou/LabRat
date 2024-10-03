
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm flex-md-column flex-row align-items-start py-2 min-vh-100" >
    <div class="pl-2 pr-2" style="position: -webkit-sticky;position: sticky;top: 63px; z-index: 1020;">
        <button  class="navbar-toggler btn" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarSupportedContent"
                 aria-controls="sidebarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <ion-icon style="color: white" name="person"></ion-icon>
        </button>
        <div class="collapse navbar-collapse"  id="sidebarSupportedContent">
            <ul class="flex-md-column navbar-nav w-100 justify-content-between">
                <hr>
                   <div class="container justify-content-center" style="position: relative;">
                       <button type="button" class="edit" style="position: absolute;right: 0; top: 0" >
                           <span class="edit__icon"><ion-icon name="settings"></ion-icon></span>
                       </button>
                       <div class="justify-content-center container"  style="width: 100px; height: 100px;  border-radius: 50%; overflow: hidden;position: relative;background-color: #94d3a2">
                           @if(Auth::user()->image === null || Auth::user()->image ==='')
                           <img src="{{ URL('app_images/profile.png') }}" alt="" style="width: 100px; height: 100px;">
                           @else
                            <img src="{{ asset( 'users_images/'.Auth::User()->image) }}" alt="" style="width: 100px; height: 100px;">
                           @endif
                       </div>
                       @if(Auth::user()->system_status == 1)
                           <span style="position: absolute;bottom: 3px; right: 45px; background-color: green; width: 17px; height: 17px; border-radius: 50%;border: 3px solid black;"></span>
                       @else
                           <span style="position: absolute;bottom: 3px; right: 45px; background-color: darkred; width: 17px; height: 17px; border-radius: 50%;border: 3px solid black;"></span>
                       @endif
                   </div>
                <hr>
                <h7 class="pl-2 pr-1" style="font-size: small; color: grey;">Ονοματεπώνυμο</h7>
                <label class="pl-3 pr-1" style="font-size: small"><b>{{Auth::user()->name}}</b></label><br>
                <h7 class="pl-2 pr-1" style="font-size: small; color: grey;">Ρόλος</h7>
                <label class="pl-3 pr-1" style="font-size: small;">{{Auth::user()->role}}</label><br>
                @if(Auth::user()->role==='Καθηγητής')
                <h7 class="pl-2 pr-1" style="font-size: small; color: grey;">Ειδικότητα</h7>
                <label class="pl-3 pr-1" style="font-size: small;">@if(Auth::user()->qualification==null) -- @else{{Auth::user()->qualification}}@endif</label><br>
                @endif
                <h7 class="pl-2 pr-1" style="font-size: small; color: grey;">Τύπος</h7>
                <label class="pl-3 pr-1" style="font-size: small;">@if(Auth::user()->type==null) -- @else{{Auth::user()->type}}@endif</label><br>
                <h7 class="pl-2 pr-2" style="font-size: small; color: grey;">Αρ.Μητρώου</h7>
                <label class="pl-3 pr-1" style="font-size: small">@if(Auth::user()->am==null)-- @else{{Auth::user()->am}}@endif</label><br>
                <h7 class="pl-2 pr-2" style="font-size: small; color: grey;">Ηλεκ. Διεύθυνση</h7>
                <label class="pl-3 pr-1" style="font-size: small">@if(Auth::user()->email==null)-- @else{{Auth::user()->email}}@endif</label><br>
                <h7 class="pl-2 pr-2" style="font-size: small; color: grey;">Έτος Εγγραφής</h7>
                <label class="pl-3 pr-1" style="font-size: small">@if(Auth::user()->register_year==null)-- @else{{Auth::user()->register_year}}@endif</label><br>
            </ul>
        </div>
    </div>
</nav>

{{--    Pop up window to delete, edit or add a lesson--}}
    @include('popup-windows.profile_Update')

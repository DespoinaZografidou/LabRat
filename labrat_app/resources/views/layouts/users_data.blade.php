{{--If the are results for the users' table then show the results--}}
@if(count($users)!=0)

    <div class="table">
        <div class="table_th">

            <div class="table_tr">
                <div class=" t_reg"></div>
                <div class="td" style="display: flex;">
                    <div class="t_name">ΟΝΟΜ/ΕΠΩΝΥΜΟ</div>
                    <div class="t_email">ΗΛΕΚΤ.<br>ΔΙΕΥΘΥΝΣΗ</div>
                    @if($title==='Μαθητής')
                        <div class="t_type">ΤΥΠΟΣ</div>
                    @endif
                    @if($title==='Καθηγητής')
                        <div class="t_type">ΙΔΙΟΤΗΤΑ/ΒΑΘΜΟΣ</div>
                    @endif
                    <div class=" t_delete"></div>
                </div>
            </div>
        </div>
        <div class="table_tbody">
            @foreach($users as $u)
                <div class="table_tr_ch" style="display: flex">
                    <div class="t_reg" style="position: relative">
                        <div class="container"
                             style="width: 35px; height: 35px; border-radius: 50%; overflow: hidden;position: relative;">
                            @if($u->image === null || $u->image==='')
                                <img id="imagePreview" src="{{ asset('app_images/profile.png') }}" alt=""
                                     style="margin-left: -12px;width: 35px; height: 35px;color: #94d3a2;">
                            @endif
                            @if($u->image !== null)
                                <img id="imagePreview" src="{{ asset('users_images/'.$u->image) }}" alt=""
                                     style="margin-left: -12px;width: 35px; height: 35px;color: #94d3a2;">
                            @endif
                        </div>
                        <div class="container" style="position: absolute;top:30px;left:13px">
                            @if($u->system_status===0)
                                <span class="status status_deactive"></span>
                            @endif
                            @if($u->system_status===1)
                                <span class="status status_active"></span>
                            @endif
                        </div>
                    </div>
                    <div class="td" style="display: flex;"
                         data-info="<?php echo htmlspecialchars(json_encode((array)$u), ENT_QUOTES, 'UTF-8');?>">
                        <div class="t_name"><p class="pl-2">{{$u->name}}</p></div>
                        <div class="t_email"><p>{{$u->email}}</p></div>
                        @if($title==='Μαθητής')
                            <div class="t_type"><p>{{$u->type}}</p></div>
                        @endif
                        @if($title==='Καθηγητής')
                            <div class="t_type"><p>{{$u->qualification}}</p></div>
                        @endif
                    </div>
                    @if(Auth::user()->id!==$u->id)
                    <button type="button" onclick="userDelete('{{$u->name}}','{{$u->id}}')" class="delete" style="position: absolute;right: 20px;">
                        <span class="delete__icon"><ion-icon name="trash"></ion-icon></span>
                    </button>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{--the links for the next page of results--}}
    {{ $users->links('pagination::bootstrap-4') }}
@endif

{{--If there is not any results for this user's table then show the following message--}}
@if(count($users)==0)
    <p>Δεν υπάρχουν καταχωρημένα δεδομένα της αναζητησή σας</p>
@endif

{{--Includes the popup form to delete a user--}}
@include('popup-windows.users-Delete_Update')

{{--<script>--}}
{{--    --}}{{----}}{{--Show the selected row from the table--}}
{{--    var $links = $('.table_tr_child');--}}
{{--    $links.click(function(){--}}
{{--        $links.removeClass('active');--}}
{{--        $(this).addClass('active');--}}

{{--    });--}}
{{--</script>--}}

@if(count($determinateNotifications)!=0)
    <div class="table">
        <div class="table_tbody">
            @foreach ($determinateNotifications as $s)
                <div class="cn table_tr_ch time-row" data-start='{{$s->created_at}}' data-end='{{$s->updated_at}}' data-info="<?php echo htmlspecialchars(json_encode((array)$s), ENT_QUOTES, 'UTF-8'); ?>"  @if(strpos($s->msg, 'αποδεσμεύτηκε')!== false) style="background-color:rgba(255, 0, 0, 0.1)"  @endif>
                    <div class="td" style="width: 95%;">
                        @if(strpos($s->msg, 'αποδεσμεύτηκε') !== false)
                        <form method="POST" action="{{url('/delete_determinate')}}">@csrf @method("GET")
                            <input type="text" value="{{$s->id}}" name="id" hidden>
                            <button type="submit" class="close" style="position: absolute;right:35px;"><span aria-hidden="true">&times</span></button>
                        </form>
                        @endif
                        <a style="text-decoration: underline">{{$s->act_title}}</a>
                        <p>{{$s->l_id}} - {{$s->l_title}},&nbsp;&nbsp;Διδάσκοντας: {{$s->name}}</p><hr>
                        @if($s->msg===' ')
                            <p class="pl-2">Δεσμεύτηκε το θέμα <b>"{{$s->d_title}}, {{$s->j_title}}"</b> από την εσάς.<br>
                            @if($s->confirm==0)
                                    <span class="status"><ion-icon name="refresh"></ion-icon></span>Αναμένεται επιβεβαίωση της συμμετοχής από τον Καθηγητή.</p>
                                @elseif($s->confirm==1)  <span class="status status_active"><ion-icon style="color: white" name="checkmark-circle-outline"></ion-icon></span>Η συμμετοχή έχει επιβεβαιωθεί.</p>
                                @elseif($s->confirm==2)  <span class="status status_deactive"><ion-icon style="color: white" name="checkmark-circle-outline"></ion-icon></span>Η συμμετοχή έχει Απορρυφθεί.</p>
                            @endif
                        @elseif(strpos($s->msg, 'αποδεσμεύτηκε') !== false)
                            <p class="pl-2">Αποδεσμεύτηκε το θέμα <b>"{{$s->d_title}}, {{$s->j_title}}"</b>
                                @if(str_replace( ['αποδεσμεύτηκε'],[''] ,$s->msg)!==' ')
                                    από τη συμμετοχη της ομάδας σας, με τα μέλη:<br>  {!!str_replace( [',','αποδεσμεύτηκε'],[', ',''] ,$s->msg)!!}
                                @else
                                    από την συμμετοχής σας.
                                @endif
                            </p>
                        @else
                            <p class="pl-2">Δεσμεύτηκε το θέμα <b>"{{$s->d_title}}, {{$s->j_title}}"</b> από την ομάδα σας, με τα μέλη:<br>  {!!str_replace( ',',', ' ,$s->msg)!!} <br>
                                @if($s->confirm==0)
                                     <span class="status"><ion-icon name="refresh"></ion-icon></span>Αναμένεται επιβεβαίωση της συμμετοχής από τον Καθηγητή.</p>
                                @elseif($s->confirm==1)  <span class="status status_active"><ion-icon style="color: white" name="checkmark-circle-outline"></ion-icon></span>Η συμμετοχή έχει επιβεβαιωθεί.</p>
                                @elseif($s->confirm==2)  <span class="status status_deactive"><ion-icon style="color: white" name="checkmark-circle-outline"></ion-icon></span>Η συμμετοχή έχει Απορρυφθεί.</p>
                                @endif
                        @endif
                        <div class="pt-3" style="display: flex; justify-content: space-between;"><p>Ημερ.Λήξης: {{ date('d-m-Y H:i', strtotime($s->updated_at) )}}</p> <p class="time-difference"></p></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{--                        the links for the next page of results--}}
    {{ $determinateNotifications->links('pagination::bootstrap-4') }}
@endif
@if(count($determinateNotifications)==0)
    <div class="table_tr_ch">
        <div class="td"><p>Δεν υπάρχουν καταχωρημένα δεδομένα της αναζητησή σας</p></div>
    </div>
@endif



<script>
    $(document).ready(function () {
        const $link = $('.cn');
        $link.click(function (event) {
            const info = $(this).attr('data-info');
            const myOb = JSON.parse(info);

            const $button = $(event.target).closest('.close').find('button');
            if ($button.length) {
                return;
            }

            let url = "/showTheJournals/" + myOb.l_id + "/" + myOb.l_title + "/" + myOb.name + "/" + myOb.act_id;
            window.location.href = url;
        });
    });

    $(document).ready(function () {
        // Hide the textarea initially
        $('#3').addClass('active');
    });

</script>


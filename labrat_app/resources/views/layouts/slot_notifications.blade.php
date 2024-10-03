@if(count($slotNotifications)!=0)
    <div class="table">
        <div class="table_tbody">
            @foreach ($slotNotifications as $s)
                <div class="sn table_tr_ch time-row" data-start='{{$s->created_at}}' data-end='{{$s->updated_at}}' data-info="<?php echo htmlspecialchars(json_encode((array)$s), ENT_QUOTES, 'UTF-8'); ?>"  @if(strpos($s->msg, 'αποδεσμεύτηκε')!== false) style="background-color:rgba(255, 0, 0, 0.1)" @endif>
                    <div class="td" style="width: 95%;">
                        @if(strpos($s->msg, 'αποδεσμεύτηκε') !== false)
                        <form method="POST" action="{{ url('/deletetheslotification') }}">@csrf @method("GET")
                            <input type="text" value="{{$s->id}}" name="id" hidden>
                            <button type="submit" class="close" style="position: absolute;right:35px;"><span aria-hidden="true">&times</span></button>
                        </form>
                        @endif
                        <a style="text-decoration: underline">{{$s->as_title}}</a>
                        <p>{{$s->l_id}} - {{$s->l_title}},&nbsp;&nbsp;Διδάσκοντας: {{$s->name}}</p><hr>
                        @if($s->msg==='')
                            <p class="pl-2">Δεσμεύτηκε το slot <b>"{{$s->s_title}}"</b> από την εσάς.</p>
                        @elseif(strpos($s->msg, 'αποδεσμεύτηκε') !== false)
                            <p class="pl-2">Αποδεσμεύτηκε το slot <b >"{{$s->s_title}}"</b>
                                @if(str_replace( ['αποδεσμεύτηκε'],[''] ,$s->msg)!=='')
                                από τη συμμετοχη της ομάδας σας, με τα μέλη:<br>  {!!str_replace( [',','αποδεσμεύτηκε'],[', ',''] ,$s->msg)!!}
                                @else
                                    από την συμμετοχής σας.
                                @endif
                            </p>
                        @else
                            <p class="pl-2">Δεσμεύτηκε το slot <b>"{{$s->s_title}}"</b> από την ομάδα σας, με τα μέλη:<br>  {!!str_replace( ',',', ' ,$s->msg)!!}</p>
                        @endif
                        <div  class="pt-3" style="display: flex; justify-content: space-between;"><p>Ημερ.Λήξης: {{ date('d-m-Y H:i', strtotime($s->updated_at) )}}</p> <p class="time-difference"></p></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{--                        the links for the next page of results--}}
    {{ $slotNotifications->links('pagination::bootstrap-4') }}
@endif
@if(count($slotNotifications)==0)
    <div class="table_tr_ch">
        <div class="td"><p>Δεν υπάρχουν καταχωρημένα δεδομένα της αναζητησή σας</p></div>
    </div>
@endif



<script>
    $(document).ready(function () {
        const $link = $('.sn');
        $link.click(function (event) {
            const info = $(this).attr('data-info');
            const myOb = JSON.parse(info);

            const date=myOb.s_title.split(' ')


            const $button = $(event.target).closest('.close').find('button');
            if ($button.length) {
                return;
            }

            let url = "/showTheSlots/" + myOb.l_id + "/" + myOb.l_title + "/" + myOb.name + "/" + myOb.as_id + "/" + date[0];
            window.location.href = url;
        });
    });

    $(document).ready(function () {
        // Hide the textarea initially
        $('#4').addClass('active');
    });

</script>


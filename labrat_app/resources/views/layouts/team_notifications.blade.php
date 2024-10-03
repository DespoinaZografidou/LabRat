@if(count($teamNotifications)!=0)
    <div class="table">
        <div class="table_tbody">
            @foreach ($teamNotifications as $t)
                <div class="tn table_tr_ch time-row" data-start='{{$t->created_at}}' data-end='{{$t->updated_at}}' data-info="<?php echo htmlspecialchars(json_encode((array)$t), ENT_QUOTES, 'UTF-8'); ?>" @if($t->confirm==2) style="background-color:rgba(255, 0, 0, 0.1)" @elseif($t->confirm==0) style="background-color: rgba(0, 174, 71, 0.1)" @endif  >
                    <div class="td" style="width: 95%;">
                        @if($t->confirm===2)
                            <form method="POST" action="{{ url('deleteannouncement') }}">@csrf @method("GET")
                                <input type="text" value="{{$t->id}}" name="a_id" hidden>
                                <button type="submit" class="close" style="position: absolute;right:35px;"><span
                                        aria-hidden="true">&times</span></button>
                            </form>
                        @endif

                        <a style="text-decoration: underline">{{$t->at_title}}</a>
                        <p>{{$t->l_id}} - {{$t->l_title}},&nbsp;&nbsp;Διδάσκοντας: {{$t->name}}</p><hr>

                        @if($t->confirm==0 )
                            <p class="pl-2">Αίτηση συμμετοχής στην Ομάδα με τα μέλη:<br><b> {{ $t->Allthenames }}</b>.</p>
                        @endif
                            @if($t->confirm==1 )
                                <p class="pl-2">Έχει επιβεβαιωθεί συμμετοχής σας στην Ομάδα με τα μέλη:<br> <b> {{ $t->Allthenames }}</b>.</p>
                            @endif
                        @if($t->confirm==2 )
                            <p class="pl-2">Αποχώρησε από την ομάδα ο μαθητής <b> {{ $t->Allthenames }}</b>.</p>
                        @endif

                        <div class="pt-3" style="display: flex; justify-content: space-between;">
                            <p>Ημερ.Λήξης: {{ date('d-m-Y H:i', strtotime($t->updated_at) )}}</p>
                            <p class="time-difference"></p>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{--                        the links for the next page of results--}}
    {{ $teamNotifications->links('pagination::bootstrap-4') }}
@endif
@if(count($teamNotifications)==0)
    <div class="table_tr_ch">
        <div class="td" >
            <p>Δεν υπάρχουν καταχωρημένα δεδομένα της αναζητησή σας</p>
        </div>
    </div>
@endif



<script>
    $(document).ready(function () {
        const $link = $('.tn');
        $link.click(function (event) {
            const info = $(this).attr('data-info');
            const myOb = JSON.parse(info);

            const $button = $(event.target).closest('.close').find('button');
            if ($button.length) {
                return;
            }

            let url = "/showTheTeams/" + myOb.l_id + "/" + myOb.l_title + "/" + myOb.name + "/" + myOb.at_id;
            window.location.href = url;
        });
    });

    $(document).ready(function () {
        // Hide the textarea initially
        $('#1').addClass('active');
    });

    {{--function countTeamNotifications() {--}}
    {{--    var count = 0;--}}
    {{--    var currentTimestamp = new Date().getTime();--}}

    {{--    <?php foreach ($teamNotifications as $t): ?>--}}
    {{--    var endTimestamp = new Date("{{ $t->updated_at}}").getTime();--}}
    {{--    var startTimestamp = new Date("{{$t->created_at}}").getTime();--}}
    {{--    if (startTimestamp <= currentTimestamp && endTimestamp >= currentTimestamp && startTimestamp!==endTimestamp) {--}}
    {{--        count++;--}}
    {{--    }--}}
    {{--    <?php endforeach; ?>--}}
    {{--    if (count > 0) {--}}
    {{--        document.getElementById('teamtab').innerHTML = '<span style="position: absolute; top: -4px; left: -4px; width: 13px; height: 13px; border-radius: 50%;border: 2px solid dimgray;background-color: #ECFFDC;"></span>Ομάδες Μαθημάτων';--}}
    {{--    } else {document.getElementById('teamtab').innerHTML = 'Ομάδες Μαθημάτων';}--}}
    {{--}--}}

    {{--document.addEventListener('DOMContentLoaded', function() {--}}
    {{--    // Your code here--}}
    {{--    countTeamNotifications();--}}
    {{--    setInterval(countTeamNotifications, 1000);--}}
    {{--});--}}
</script>

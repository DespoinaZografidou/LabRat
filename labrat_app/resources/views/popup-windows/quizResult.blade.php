
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="modal popup" id="popupquiz">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" action="{{ url('/gradequiz') }}"   class="modal-content" > @csrf @method('GET')
            <div class="modal-header">
                <div class="modal-title"  style="position: relative;">
                    <h5>{{$act_title}}</h5>
                    <p style="font-size: small">{{$l_id}} - {{$title}}<br>Διδάσκων: {{$name}}</p>
                </div>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body justify-content-center">
                <div class="card-body results" >
                    @if(count($questions)!=0) <?php $counter=1; ?>
                        @foreach($questions as $s)
                            @if ($loop->first)
                                <div class="card">
                                    <div class="card-header">
                                        <label class="title ml-5">Ερώτηση {{$counter}}</label><label class="form-control-sm">/ {{$s->type}}&nbsp;&nbsp;({{$s->maxgrade}} μονάδες)</label>
                                        <div class="title">{!!$s->question!!}</div>
                                        <div class="justify-content-end mt-3" style="display: flex">
                                            <p style="font-size: small;">Τελικό score:  <input id="score{{$s->q_id}}" type="number" name="score[{{$s->q_id}}]" data-maxgrade="{{$s->maxgrade}}" step="0.25" value="0.00" style="width: 60px" max="{{$s->maxgrade}}" @if($s->type!=='Ελεύθερου Κειμένου') disabled @endif>/{{$s->maxgrade}}</p>
                                        </div>
                                            <?php $counter++; ?>
                                    </div>
                                    <div class="card-body">
                                        @if($s->type==='Ελεύθερου Κειμένου')
                                            <div class="question" name="ft[{{$s->q_id}}]" id="{{$s->q_id}}" class="form-control" style="height: 150px;overflow: auto;"></div>
                                        @endif
                                        @if($s->type==='Αντιστοίχιση')
                                            <div style="display: flex">
                                                <div class="col-md-6" style="margin-left: auto;margin-right: auto;">
                                                    <table>
                                                        <thead><tr><td style="text-align: center;">ΛΙΣΤΑ 1</td><td style="text-align: center;">ΛΙΣΤΑ 2</td></tr></thead>
                                                        <tbody id="answers{{$s->q_id}}" name="answers" ></tbody>
                                                    </table>
                                                </div>
                                                <div id="grade{{$s->q_id}}" name="grade"></div>
                                            </div>
                                        @endif
                                        @if($s->answer!==null && $s->type!=='Αντιστοίχιση')
                                            <div class="mt-1" style="display: flex;justify-content: space-between">
                                                <input type="checkbox" class="form-check-input ml-3" name="v[]" data-question="{{$s->q_id}}" data-answer="{{$s->a_id}}" data-type="{{$s->type}}" value="{{$s->q_id}},{{$s->a_id}}" id="{{$s->q_id}},{{$s->a_id}}">
                                                <div class="ml-5" style="font-size: small;width: 75%;">{!! $s->answer !!}</div>@if($s->grade!=0 ) <label style="font-size: x-small">({{$s->grade}} μονάδες)</label> @endif
                                            </div>
                                        @endif
                                        @elseif($s->q_id === $questions[$loop->index - 1]->q_id)
                                            @if($s->type==='Ελεύθερου Κειμένου')
                                                <div class="question"  name="ft[{{$s->q_id}}]" id="{{$s->q_id}}" class="form-control" style="height: 150px;overflow: auto;"></div>
                                            @endif
                                            @if($s->answer!==null && $s->type!=='Αντιστοίχιση')
                                                <div class="mt-1" style="display: flex;justify-content: space-between">
                                                    <input type="checkbox" class="form-check-input ml-3" name="v[]" data-question="{{$s->q_id}}" data-answer="{{$s->a_id}}" data-type="{{$s->type}}" value="{{$s->q_id}},{{$s->a_id}}" id="{{$s->q_id}},{{$s->a_id}}">
                                                    <div class="ml-5" style="font-size: small;width: 75%;">{!! $s->answer !!}</div>@if($s->grade!=0) <label style="font-size: x-small">({{$s->grade}} μονάδες)</label> @endif
                                                </div>
                                            @endif
                                        @else
                                    </div>
                                </div><br>
                                <div class="card">
                                    <div class="card-header">
                                        <label class="title ml-5">Ερώτηση {{$counter}}</label><label class="form-control-sm">/ {{$s->type}}&nbsp;&nbsp;({{$s->maxgrade}} μονάδες)</label>
                                        <div class="title">{!!$s->question!!}</div>
                                        <div class="justify-content-end mt-3" style="display: flex;">
                                            <p style="font-size: small;">Τελικό score: <input id="score{{$s->q_id}}" type="number" name="score[{{$s->q_id}}]" data-maxgrade="{{$s->maxgrade}}" step="0.25" value="0.00" style="width: 60px" max="{{$s->maxgrade}}" @if($s->type!=='Ελεύθερου Κειμένου') disabled @endif>/{{$s->maxgrade}}</p>
                                        </div>
                                            <?php $counter++; ?>
                                    </div>
                                    <div class="card-body">
                                        @if($s->type==='Ελεύθερου Κειμένου')
                                            <div class="question"  name="ft[{{$s->q_id}}]" id="{{$s->q_id}}" class="form-control" style="height: 150px;overflow: auto;"></div>
                                        @endif
                                        @if($s->type==='Αντιστοίχιση')
                                            <div style="display: flex">
                                                <div class="col-md-6" style="margin-left: auto;margin-right: auto;">
                                                    <table>
                                                        <thead><tr><td style="text-align: center;">ΛΙΣΤΑ 1</td><td style="text-align: center;">ΛΙΣΤΑ 2</td></tr></thead>
                                                        <tbody id="answers{{$s->q_id}}" name="answers"></tbody>
                                                    </table>
                                                </div>
                                                <div id="grade{{$s->q_id}}" name="grade"></div>
                                            </div>
                                        @endif
                                        @if($s->answer!==null && $s->type!=='Αντιστοίχιση')
                                            <div class="mt-1" style="display: flex;justify-content: space-between">
                                                <input type="checkbox" class="form-check-input ml-3" name="v[]" data-question="{{$s->q_id}}" data-answer="{{$s->a_id}}" data-type="{{$s->type}}" value="{{$s->q_id}},{{$s->a_id}}" id="{{$s->q_id}},{{$s->a_id}}">
                                                <div class="ml-5" style="font-size: small;width: 75%;">{!! $s->answer !!}</div>@if($s->grade!=0) <label style="font-size: x-small">({{$s->grade}} μονάδες)</label> @endif
                                            </div>
                                        @endif
                                        @endif
                                        @endforeach
                                    </div>
                                </div><br>
                            @endif
                            @if(count($questions)==0)<p>Δεν υπάρχουν καταχωρημένα δεδομένα της αναζητησή σας</p>@endif

                </div>

            </div>
            <div class="modal-footer" style="display: flex;justify-content: space-between">
                <input type="text" name="t_id" id="t_id" value="" hidden>
                <div>Τελικός Βαθμός Quiz: <input name="totalgrade" id="totalgrade"  style="width:50px;"> / {{$maxgrade}}</div>
                <input type="submit" value="Αποθήκευση Βαθμολογίας" class="button-5">
            </div>
        </form>
    </div>
</div>

<script>
    var scoreInputs = document.querySelectorAll('[type="number"]');
    var displayElement = document.getElementById('totalgrade');
    var totalGrade = 0;
    var maxgrade=0;

    $('.table_tr_ch').click(function (){

        var data ={
            act_id:{{json_encode($act_id)}},
            try_id:$(this).data('try'),

        }

        axios.get('/choises', {
            params: data, // Pass the data as query parameters
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => {
               var choises=[];
               var finalscore=0;
               choises=response.data.choises;

                choises.forEach(function(c) {
                    if(c.grade!==null) {
                        finalscore += parseFloat(c.grade);
                    }
                    if ((c.type === 'Μίας Επιλογής' || c.type === 'Ναι/Όχι') && c.choise !== null) {
                        var element = document.getElementById(c.choise);
                        element.checked = true;
                        $('#score' + c.q_id).val(c.grade);
                        if (c.grade > 0) {
                            element.style.backgroundColor = '#33cc33';
                        }
                        if (c.grade <= 0) {
                            element.style.backgroundColor = '#A60505';
                        }
                    }

                    if (c.type === 'Πολλαπλής Επιλογής' && c.choise !== null) {
                        var element=document.getElementById(c.choise);
                        element.checked = true;
                        var score=parseFloat($('#score' + c.q_id).val())+parseFloat(c.grade);
                        $('#score' + c.q_id).val(score)
                        if (c.grade > 0) {
                            element.style.backgroundColor = '#33cc33';
                        }
                        if (c.grade <= 0) {
                            element.style.backgroundColor = '#A60505';
                        }
                    }

                    if (c.type === 'Ελεύθερου Κειμένου' && c.choise !== null) {

                        if(c.grade!==null){$('#score' + c.q_id).val(c.grade);}
                        $('#'+ c.q_id ).html(c.choise);
                        // console.log($('#'+ c.q_id ));

                    }
                    if (c.type === 'Αντιστοίχιση' && c.choise !== null) {
                        var score=parseFloat($('#score' + c.q_id).val())+parseFloat(c.grade);
                        $('#score' + c.q_id).val(score)

                        var ch = c.choise.split("=");
                        $('#answers' + c.q_id).append('<tr>' +
                            '<td class="text-center" style="background:' +
                            (c.grade > 0 ? 'rgba(1, 99, 0, 0.1)' : 'rgba(255, 99, 71, 0.2)') +
                            '">' + ch[0] +
                            '</td>' +
                            '<td class="text-center" style="background:' +
                            (c.grade > 0 ? 'rgba(1, 99, 0, 0.1)' : 'rgba(255, 99, 71, 0.2)') +
                            '">' + ch[1] +
                            '</td>' +
                            '</tr>');

                        $('#grade'+c.q_id).css('width', '15%');
                        $('#grade' + c.q_id).append('<div style="height:20px;"></div><div style="display:flex;justify-content:space-between;height:10px;"><label style="font-size: x-small">(' + c.grade + ' μονάδες)</label></div>');
                    }
                });
                displayElement.value = finalscore;
                document.getElementById("t_id").value=$(this).data('try');
                $('.popup').fadeIn();
            })
            .catch(error => {
                console.error(error);
            });
    });


    $(".popup-close").click(function () {
        var score = document.querySelectorAll('[type="number"]');
        var ft = document.querySelectorAll('[name="ft[]"]');
        var v = document.querySelectorAll('[name="v[]"]');
        var answers = document.querySelectorAll('[name="answers"]');
        var grade = document.querySelectorAll('[name="grade"]');
        score.forEach(function(input) {
            input.value = '0'; // Set the value property to '0'
        });
        ft.forEach(function(input) {
            input.innerHTML = '';
            // input.checked = false; // Set the value property to '0'
            // input.style.backgroundColor='white';
        });
        v.forEach(function(input) {
            input.checked = false; // Set the value property to '0'
            input.style.backgroundColor='white';
        });
        answers.forEach(function(input) {
            input.innerHTML = ''; // Set the value property to '0'
        });
        grade.forEach(function(input) {
            input.innerHTML = ''; // Set the value property to '0'
        });
        displayElement.value = '';
        $(".popup").fadeOut();
    });






    scoreInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            var inputValue = parseFloat(input.value); // Convert the input value to a number
            if (!isNaN(inputValue)) {
                totalGrade = 0; // Reset the total grade

                scoreInputs.forEach(function(input) {
                    var inputValue = parseFloat(input.value);
                    if (!isNaN(inputValue)) {
                        totalGrade += inputValue;
                    }
                });
                displayElement.value = totalGrade;

            }
        });
    });


</script>

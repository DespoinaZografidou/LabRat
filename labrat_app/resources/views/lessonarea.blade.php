@extends('layouts.appLessonArea')

@section('sidebar')
    @include('navbars.lessonArea_sidebar')
@endsection

@section('content')
    @include('layouts.success_msg_warning')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h5> {{$l_id}} - {{$title}}</h5>
                <p>Διδάσκων: {{$name}}</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header" >
                        <div><h5> Περιγραφή </h5></div>
                        @if(Auth::user()->role!='Μαθητής')
                            <button type="button" id="show" class="search" style="position: absolute;right: 15px;top:5px;"><span class="search__icon"><ion-icon name="create"></ion-icon></span></button>
                        @endif
                    </div>
                    <div class="card-body results" id="results">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                        @endif
                        <div id='des' style="height: 250px;overflow: auto;">{!! $description=str_replace(["☺","☻",'♦','♣',"♥","♠"],['<i>','</i>','<u>','</u>','<b>','</b>'],$description); !!}</div>

                        <form method="post" id='description' action="{{ url('/updatedescription') }}">
                            @csrf @method('GET')
                            <input type="text" name="l_id" value="{{$l_id}}" hidden>
                            <textarea id="myTextarea" name="description">{!! $description=str_replace(["☺","☻",'♦','♣',"♥","♠",'• '],['<i>','</i>','<u>','</u>','<b>','</b>','<li>'],$description); !!}</textarea>
                            <button type="submit" class="btn btn-primary col-lg-12">Αποθήκευση</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header" style="display: flex;justify-content: space-between;">
                        <h5> Ανακοινώσεις </h5>
                        @if(Auth::user()->role!='Μαθητής')
                            <div class="text-end">
                                <button type="button" class="button-3" onclick="addNotification()">+Νέο Ανακοίνωση</button>
                            </div>
                        @endif
                    </div>
                    <div class="card-body results" id="results">
                        @if(count($notifications)!=0)
                            <div class="table">
                                <div class="table_tbody">
                                    @foreach($notifications as $n)
                                        <div class="table_tr_ch" data-role="{{Auth::user()->role}}"
                                             data-info="<?php echo htmlspecialchars(json_encode((array)$n), ENT_QUOTES, 'UTF-8'); ?>" >
                                            <div class="td" style="display: flex;">
                                                <div class="nt">
                                                   <a style="text-decoration: underline" class="n_open">{{$n->title}}</a>
                                                    <p>{{$l_id}} - {{$title}}, &nbsp;&nbsp;Διδάσκων: {{$name}}</p><hr>
                                                    <div style="overflow: hidden;height: 20px;">
                                                        <?php $mytext=str_replace(["☺","☻",'♦','♣',"♥","♠"],['','','','','',''],$n->text); ?>
                                                       <p>{!! substr($mytext, 0, 100) .'...' !!}</p>
                                                    </div>
                                                    <div style="text-align: right"><p>{{ date('d-m-Y H:i', strtotime($n->created_at) )}}</p></div>
                                                </div>
                                                @if(Auth::user()->role!='Μαθητής')
                                                    <div style="position: absolute;right: 20px;" class="nd">
                                                    <button type="button"  class="delete" >
                                                        <span class="delete__icon"><ion-icon name="trash"></ion-icon></span>
                                                    </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
{{--                                                                                        the links for the next page of results--}}
                            {{ $notifications->links('pagination::bootstrap-4') }}
                        @endif
                        @if(count($notifications)==0)
                            <p>Δεν υπάρχουν καταχωρημένα δεδομένα της αναζητησή σας</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header" style="display: flex;justify-content: space-between;" >
                        <div><h5> Πληροφορίες </h5></div>
                    </div>
                    <div class="card-body " id="results">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                        @endif
                            <div class="info">
                                <p href="#"  style="font-size: small;"></p>
                                <p href="#"  style="font-size: small;">Αρ. Εγγραφών</p>
                            </div><hr style="margin: 0px;padding: 0px">
                        @if(Auth::user()->role!='Μαθητής')
                            <div class="info">
                                <a href="{{ route('Participants',['l_id'=>$l_id,'title'=>$title,'name'=>$name]) }}"  style="text-decoration: none; font-size: small;">Αρ.Συμμετοχών: </a>{{$info}}
                            </div>
                            @endif
                            @if(Auth::user()->role=='Μαθητής')
                                <div class="info">
                                    <a href="#" style="text-decoration: none; font-size: small;">Συμμετοχές:</a>{{$info}}
                                </div>
                            @endif
                            <div class="info">
                                <a href="#"  style="text-decoration: none; font-size: small;">Ανακοινώσεων: </a>{{$n_count}}
                            </div>

                            <div class="info">
                                <a href="{{ route('activityteams',['l_id'=>$l_id,'title'=>$title,'name'=>$name]) }}" style="text-decoration: none; font-size: small;">Ομάδες: </a>{{$t_count}}
                            </div>
                                <div class="info">
                            <a href="{{ route('choosethemeactivities',['l_id'=>$l_id,'title'=>$title,'name'=>$name]) }}" style="text-decoration: none; font-size: small;">Επιλογών Θέματος: </a>{{$ct_count}}
                                </div>
                            <div class="info">
                            <a href="{{ route('determinatethemeactivities',['l_id'=>$l_id,'title'=>$title,'name'=>$name]) }}" style="text-decoration: none; font-size: small;">Προσδιορισμός Θέματος: </a>{{$dt_count}}
                            </div>
                            <div class="info">
                                <a href="{{ route('slotactivities',['l_id'=>$l_id,'title'=>$title,'name'=>$name]) }}" style="text-decoration: none; font-size: small;">Επιλογή Slot: </a>{{$s_count}}
                            </div>
                            <div class="info">
                                <a href="{{ route('votingactivities',['l_id'=>$l_id,'title'=>$title,'name'=>$name]) }}" style="text-decoration: none; font-size: small;">Ψηφοφορία: </a>{{$v_count}}
                            </div>
                            <div class="info">
                                <a href="{{ route('quizactivities',['l_id'=>$l_id,'title'=>$title,'name'=>$name]) }}" style="text-decoration: none; font-size: small;">Quiz: </a>{{$q_count}}
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('popup-windows.notification_Delete_Add_Edit')
    <script>

        $(document).ready(function() {
            // Hide the textarea initially
             $('#home').addClass('active')

           $('#description').hide();
            // Add click event handler to the button
            $('#show').on('click', function() {
                $('#description').toggle();

                    if($("#description").is(':hidden')){
                        $('#des').show();}
                    else {$('#des').hide();}
            });
        });



        tinymce.init({
            selector: 'textarea#myTextarea',
            plugins: 'autolink lists link  charmap  preview wordcount ',
            toolbar: 'undo redo | bold italic underline | bullist | wordcount ',
            menubar: false,
            force_br_newlines: true, // Recognize newlines as line breaks
            height: 250,
            elementpath: false,
            branding: false,
            entity_encoding : "raw",
            setup:
                function (editor) {
                    editor.on('keydown', function (e) {
                        if (tinymce.activeEditor.getContent().length > 255 && e.keyCode !== 8 && e.keyCode !== 46)
                            return false;
                    });
                 }
        });

    </script>


@endsection


@extends('layouts.app')

@section('sidebar')
    @include('navbars.lessonArea_sidebar')
@endsection

@section('content')
    @include('layouts.success_msg_warning')

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8">
                <h5> {{$l_id}} - {{$title}}</h5>
                <p>Διδάσκων: {{$name}}</p>
            </div>

            {{--  This is a form that you can add new lessons through a excel file--}}
            @include('forms.import_export_Participants')

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header " style="display: flex;justify-content: space-between;">
                        <h5>Συμμετοχές</h5>
                        <div class="row">
                            <form method="post" action="{{ url('/searchparticipation/'.$l_id.'/'.$title.'/'.$name)}}" style="display: flex;justify-content: space-between;">
                            @csrf @method('GET')
                            <div>
                                <input type="text" name="key" id="key" class="form-control"
                                value="<?php if(session()->has('key')) echo session()->get('key'); ?>"
                                placeholder="Αναζήτηση">
                                </div>
                                    <button type="submit" class="search"><span class="search__icon">
                                    <ion-icon name="search"></ion-icon></span></button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body results" id="results">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                        @endif

                        @if(count($participants)!=0)
                            <div class="table">
                                <div class="table_tbody">
                                    @foreach($participants as $p)
                                        <div class="table_tr_ch">
                                            <div class="td" style="display: flex;">
                                            <div class="pc" data-label="Α.Μ"><p>{{$p->am}}</p></div>
                                            <div class="pn" data-label="ΟΝΟΜΑΤΕΠΩΝΥΜΟ"><p> {{$p->name}}</p></div>
                                            <div class="pe" data-label="ΗΛΕΚ.ΔΙΕΥΘΥΝΣΗ"><p> {{$p->email}}</p></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                                {{--the links for the next page of results--}}
                                {{ $participants->links('pagination::bootstrap-4') }}
                        @endif
                        @if(count($participants)==0)
                            <p>Δεν υπάρχουν καταχωρημένα δεδομένα της αναζητησή σας</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Hide the textarea initially
            $('#participation').addClass('active');
        });
    </script>
@endsection

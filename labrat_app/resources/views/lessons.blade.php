@extends('layouts.app')

@section('sidebar')
    @include('navbars.lessons_sidebar')
@endsection

@section('content')
    @include('layouts.success_msg_warning')

    <div class="container">
        <div class="row justify-content-center">

            {{-- This is a form that you can add new lessons through a excel file --}}
            @include('forms.addLessonsForm')
            {{--The header that is the type of the lessons --}}
            <?php $header = ''; ?>
            @if($type=='Προπτυχιακό')<?php $header = 'Προπτυχιακά Μαθήματα'; ?>@endif
            @if($type=='Μεταπτυχιακό')<?php $header = 'Μεταπτυχιακά Μαθήματα'; ?>@endif
            @if($type=='Διδακτορικό')<?php $header = 'Μαθήματα Διδακτορικού '; ?>@endif
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header " style="display: flex;justify-content: space-between;">
                        <h5><?php echo $header ?></h5>
                        <div class="row">
                            <form method="post" action="{{ url('searchLesson/'.$type)}}" style="display: flex;justify-content: space-between;">
                                @csrf @method('GET')
                                <div>
                                    @if(Auth::user()->role=='Καθηγητής')
                                        <input type="text" value="{{Auth::user()->id}}" name="t_id" hidden>
                                    @endif
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

                        @if(count($lessons)!=0)
                            <div class="table ">
                                <div class="table_tbody" class="btn btn-primary m-2">
                                    @foreach($lessons as $l)
                                            <?php $info = (array)$l ?>
                                        <div class="table_tr_ch">
                                            <div class="td" style="display: flex"  data-info="<?php echo htmlspecialchars(json_encode($info), ENT_QUOTES, 'UTF-8'); ?>">
                                            <div class="l_area">
                                                @if($l->l_area==0)
                                                    <button type="submit" class="status status_deactive"></button>
                                                @endif
                                                @if($l->l_area==1)
                                                    <button type="button" class="status status_active"></button>
                                                @endif
                                            </div>

                                            <div data-label="ΤΙΤΛΟΣ" class="slt" style="width: 100%">
                                                <div class="thetitle">
                                                <a href="{{url('/lessonArea/'.$l->l_id)}}" target="_blank" >{{$l->l_id}} - {{$l->title}}</a><br>
                                                </div>
                                                    <p>Διδάσκοντας: {{$l->name}}<br>{{$l->semester}}</p>
                                            </div>

                                                <div class="l_delete nd" >
                                                <button type="button" class="delete" style="position: absolute;right: 25px">
                                                    <span class="delete__icon"><ion-icon name="trash"></ion-icon></span>
                                                </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                                {{--the links for the next page of results--}}
                                {{ $lessons->links('pagination::bootstrap-4') }}
                        @endif
                        @if(count($lessons)==0)
                            <p>Δεν υπάρχουν καταχωρημένα δεδομένα της αναζητησή σας</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{--Pop up window to delete, edit or add a lesson --}}
    @include('popup-windows.lessons-Delete_Add_Edit')
@endsection

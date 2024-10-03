@extends('layouts.app')

@section('sidebar')
    @include('navbars.lessons_sidebar')
@endsection

@section('content')
    @include('layouts.success_msg_warning')
    <script>var am = '{{ Auth::user()->am }}';</script>
    @vite(['resources/js/announcements.js'])
    <div class="container">
        <div class="row justify-content-center">

            {{--The header that is the type of the lessons --}}
            <?php $header = ''; ?>
            @if($type=='Προπτυχιακό')<?php $header = 'Προπτυχιακά Μαθήματα'; ?>@endif
            @if($type=='Μεταπτυχιακό')<?php $header = 'Μεταπτυχιακά Μαθήματα'; ?>@endif
            @if($type=='Διδακτορικό')<?php $header = 'Μαθήματα Διδακτορικού '; ?>@endif
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header " style="display: flex;justify-content: space-between;">
                        <h5>{{$header}} </h5>
                        <div class="row">
                            <?php $am=Auth::user()->am?>
                            <form method="post" action="{{ url('/searchforparticipation/'.$type.'/'.$am) }}" style="display: flex;justify-content: space-between;">
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

                        @if(count($lessons)!=0)
                           <section>
                              @foreach ($lessons as $l)
                                  <div class=" table_tr_ch" style="display: flex">
                                     <div class="td lc"> <h7>{{$l->l_id}}</h7> </div>

                                  <div class="td lt">
                                      <a id="title" @if($l->part==1) href="{{url('/lessonArea/'.$l->l_id)}}" target="_blank" @else  href="javascript:void(0);" onclick="$('#alert{{$l->l_id}}').show();" @endif  >{{$l->title}}</a><br>
                                      <label id="alert{{$l->l_id}}" style="display: none; color: darkred">Για να μεταβήτε στο χώρο του μαθήματος, είναι απαραίτητη η συμμετοχή σας στο μάθημα.</label>
                                      <p>Διδάσκοντας: {{$l->name}}</p>
                                  </div>
                                  <div class="td ls">
                                      <h7>{{$l->semester}}</h7>
                                  </div>

                                  <div class="td lb">
                                    @if($l->part==0)
                                          <form method="post" action="{{ url('/joinlesson')}}"> @csrf @method('GET')
                                              <input type="text" name="l_id" value="{{$l->l_id}}" hidden>
                                              <input type="text" name="am" value="{{Auth::user()->am}}" hidden>
                                    <button type="submit" class="add"><span class="add__icon"><ion-icon name="add"></ion-icon></span></button>
                                          </form>
                                    @endif
                                    @if($l->part==1)
                                        <button type="button" onclick='partDeleteS("{{$l->title}}","{{$l->id}}")' class="minus"><span class="minus__icon"><ion-icon name="walk"></ion-icon></span></button>
                                    @endif
                                     </div>
                                  </div>
                              @endforeach
                              </section>
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
    @include('popup-windows.participation_Delete')
@endsection

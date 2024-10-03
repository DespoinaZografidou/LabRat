@extends('layouts.app')

@section('sidebar')
    @include('navbars.users_sidebar')
@endsection

@section('content')
    @include('layouts.success_msg_warning')
    <div class="container">
        <div class="row justify-content-center">
            <?php $header = ''; ?>
            @if($title=='Μαθητής')<?php $header = 'Μαθητές'; ?>@endif
            @if($title=='Καθηγητής')<?php $header = 'Καθηγητές'; ?>@endif
            @if($title=='Διαχειριστής')<?php $header = 'Διαχειριστές'; ?>@endif
            @include('forms.import_users_to_SSO')
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header" style="display: flex;justify-content: space-between">
                        <h5>{{$header}}</h5>
                        <div class="row">
                            <form method="post" style="display: flex;justify-content: space-between;"
                                  action="{{ url('/searchUser/'.$title)  }}">
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

                        @include('layouts.users_data')

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

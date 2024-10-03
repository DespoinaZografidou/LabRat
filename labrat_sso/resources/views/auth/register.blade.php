@extends('layouts.app')

@section('content')
    @include('layouts.success_msg_warning')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Εγγραφή νέου χρήστη στο SSO Server</h5>
                </div>

                <div class="card-body row justify-content-between">
                    <div class="container" style="width: 400px;">
                        <div style="display: flex;justify-content: center">
                        <img src="{{ URL('app_images/labrat1.png') }}" alt="" style="width: 230px; ">
                        </div>

                        @include("layouts.import_users")
                    </div>
                    <div class="container"  style="width: 400px; padding-top: 37px;">
                    <form method="POST" action="{{ url('/register') }}">
                        @csrf

                            <label for="name" class="col-form-label pt-2">{{ __('Ονοματεπώνυμο') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            <label for="am" class="col-form-label pt-2">{{ __('Αριθμός Ακαδημαϊκής Ταυτότητας') }}</label>
                            <input id="am" type="text" class="form-control" name="am" required>

                            <label for="email" class="col-form-label pt-2">{{ __('Ηλεκτρονική Διεύθυνση') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

{{--                            <label for="password" class="col-form-label pt-2">{{ __('Κωδικός') }}</label>--}}
{{--                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">--}}
{{--                                @error('password')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            <label for="password-confirm" class="col-form-label pt-2">{{ __('Επιβεβαίωση Κωδικού') }}</label>--}}
{{--                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">--}}

                        <label for="role" class="col-form-label pt-2"> {{ __('Ιδιότητα') }} </label>
                        <select id="role" class="form-control" name="role" required>
                            <option value="" selected disabled hidden>--Επιλογή Ιδιότητας του Χρήστη --</option>
                            <option value="Διαχειριστής">Διαχειριστής</option>
                            <option value="Καθηγητής">Καθηγητής</option>
                            <option value="Μαθητής">Μαθητής</option>
                        </select><br>

{{--                        <label for="register_year" class="col-form-label pt-2">{{ __('Έτος Εισαγωγής') }}</label>--}}
{{--                        <select class="form-control" name="register_year" id="register_year" required>--}}
{{--                            <?php for($year = (int)date('Y'); 1980 <= $year; $year--): ?>--}}
{{--                            <option value="<?=$year;?>"><?=$year;?></option>--}}
{{--                            <?php endfor; ?>--}}
{{--                        </select><br>--}}
{{--                        <div class="col-form-label pt-2" style="display: flex;justify-content: center">--}}
                            <button type="submit" class="btn btn-block form-control btn-success">{{ __('Εγγραφή') }}</button>
{{--                        </div>--}}
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection


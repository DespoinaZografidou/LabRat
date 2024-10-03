@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 >Σύνδεση μέσω SSO</h5>
                </div>

                <div class="card-body row justify-content-between">

                    <div class="container" style="width: 250px; height: 250px" >
                        <img src="{{ URL('app_images/labrat1.png') }}" alt=""  style="width: 250px; height: 250px">
                    </div>



                    <div class="container"  style="width: 400px;">
                        <form method="POST" action="{{ route('login') }}" >
                            @csrf
                            <label for="email" class="col-form-label pt-3">{{ __('Email') }}</label><br>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror


                            <label for="password" class="col-form-label pt-3">{{ __('Κωδικός') }}</label><br>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                            <div style="display: flex;justify-content: right;">
                                <label class="form-check-label " for="remember">
                                    <input class="form-check-input " type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    {{ __('Remember Me') }}
                                </label>
                            </div>




                            {{--                            <div class="col-md-8 offset-md-4">--}}
                            <button type="submit" class="btn btn-block form-control btn-success mt-3">
                                {{ __('Σύνδεση') }}
                            </button>


                            <div class="form-control container mt-3" style="display: flex;justify-content: center;">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                       Ξεχάσα το κωδικό σας? /Αλλαγή Κωδικού
                                    </a>
                                @endif

                            </div><br>



                        </form>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection


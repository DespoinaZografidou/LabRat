@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-default" style='box-shadow: 10px 10px 5px lightblue;'>
                    <div class="card-header">
                        <h5>Αίτημα Ταυτοποίησης</h5>
                    </div>
                    <div class="card-body">
                        <div class="container row justify-content-between">
                            <div style="width: 150px;">
                                <img src="{{ URL('app_images/labrat1.png') }}" alt=""  style="width: 150px; height: 150px">
                            </div>
                            <div style="width: 400px;">
                                <p>Γεία σας <strong> κ.{{ auth()->user()->name }}</strong>, <br><br>
                                Το αιτήμα σας έχει γίνει αποδεκτό για την προσβασή σας στον λογαριασμό.</p>

                            </div>

                        </div>

                        <!-- Introduction -->
{{--                        <p>--}}
{{--                            Hey {{ auth()->user()->name }} , <br>--}}
{{--                            <strong>{{ $client->name }}</strong> is requesting permission to access your account.--}}
{{--                        </p>--}}

                        <!-- Scope List -->
{{--                        @if (count($scopes) > 0)--}}
{{--                            <div class="scopes">--}}
{{--                                    <p><strong>This application will be able to:</strong></p>--}}

{{--                                    <ul>--}}
{{--                                        @foreach ($scopes as $scope)--}}
{{--                                            <li>{{ $scope->description }}</li>--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                            </div>--}}
{{--                        @endif--}}

                        <div>
                            <!-- Authorize Button -->
                            <form method="post" action="{{ route('passport.authorizations.approve') }}">
                                @csrf
                                <input type="hidden" name="state" value="{{ $request->state }}">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <input type="hidden" name="auth_token" value="{{ $authToken }}">
                                <button type="submit" class="btn form-control btn-success">Πρόσβαση στο Λογαριασμό μου</button>
                            </form>


                        </div>
                        <hr>
                        <div class="row justify-content-between">

                            <form method="post" action="{{ route('different-account') }}" style="display: inline-block;" class="col-6">
                                @csrf
                                <input type="hidden" name="current_url" value="{{ $request->fullUrl() }}">
                                <button type="submit" class="btn btn-success form-control" >Πρόσβαση σε άλλο λογαριασμό</button>
                            </form>


                                <!-- Cancel Button -->
                                <form method="post" action="{{ route('passport.authorizations.deny') }}"  class="col-6">
                                    @csrf
                                    @method('DELETE')

                                    <input type="hidden" name="state" value="{{ $request->state }}">
                                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                                    <input type="hidden" name="auth_token" value="{{ $authToken }}">
                                    <button class="btn btn-danger form-control">Άκυρο</button>
                                </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


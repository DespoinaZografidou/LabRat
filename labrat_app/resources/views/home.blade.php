@extends('layouts.app')

@section('sidebar')
    @include('navbars.profile_sidebar')
@endsection

@section('content')
    @include('layouts.success_msg_warning')

    @if(Auth::user()->role=='Μαθητής')
        <script>var am = '{{ Auth::user()->am }}';</script>
        @vite(['resources/js/announcements.js'])
        @include('layouts.Student_home')
    @endif
    @if(Auth::user()->role=='Καθηγητής')
        @include('layouts.Teacher_home')
    @endif
    @if(Auth::user()->role=='Διαχειριστής')

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header" style="display: flex;justify-content: space-between;">
                            <a> Σύνολο Χρηστών Συστήματος:</a> <p style="font-size: small"><b>{{$admin+$students+$professors}}</b> Εγγραφές</p>
                        </div>
                        <div class="card-body results" id="results">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                            @endif
                            <div class="table">
                                <div class="table_tr_ch">
                                    <div class="td" style="width: 90%" >
                                        <div style="display: flex;justify-content: space-between;">
                                            <a>Σύνολο Μαθητών:</a> <p style="font-size: x-small"><b>{{$students}}</b> Εγγραφές</p>
                                        </div><hr style="padding: 0;margin: 0;">
                                        <div class="text-end">
                                            <p style="font-size: x-small">Ενεργοί:<b class="pl-4">{{$students1}}</b> Εγγραφές</p>
                                            <p style="font-size: x-small">Απενεργοί:<b class="pl-3">{{$students0}}</b> Εγγραφές</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="table_tr_ch">
                                    <div class="td" style="width: 90%">
                                        <div style="display: flex;justify-content: space-between;">
                                           Σύνολο Καθηγητών: <p style="font-size: x-small"><b>{{$professors}}</b> Εγγραφές</p>
                                        </div><hr style="padding: 0;margin: 0;">
                                        <div class="text-end">
                                            <p style="font-size: x-small">Ενεργοί:<b class="pl-4">{{$professors1}}</b> Εγγραφές</p>
                                            <p style="font-size: x-small">Απενεργοί:<b class="pl-3">{{$professors0}}</b> Εγγραφές</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="table_tr_ch">
                                    <div class="td" style="width: 90%" >
                                        <div style="display: flex;justify-content: space-between;">
                                            <a>Σύνολο Διαχειριστών:</a> <p style="font-size: x-small"><b>{{$admin}}</b> Εγγραφές</p>
                                        </div><hr style="padding: 0;margin: 0;">
                                        <div class="text-end">
                                            <p style="font-size: x-small">Ενεργοί:<b class="pl-4">{{$admin1}}</b> Εγγραφές</p>
                                            <p style="font-size: x-small">Απενεργοί:<b class="pl-3">{{$admin0}}</b> Εγγραφές</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header" style="display: flex;justify-content: space-between;">
                            <a> Σύνολο Μαθημάτων στο Σύστημα:</a> <p style="font-size: small"><b>{{$dlessons+$mlessons+$plessons}}</b> Εγγραφές</p>
                        </div>
                        <div class="card-body results" id="results">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                            @endif
                            <div class="table">

                                <div class="table_tr_ch">
                                    <div class="td" style="width: 90%" >
                                        <div style="display: flex;justify-content: space-between;">
                                            <a> Προπτυχιακά Μαθημάτα:</a> <p style="font-size: x-small"><b>{{$plessons}}</b> Εγγραφές</p>
                                        </div><hr style="padding: 0;margin: 0;">
                                        <div class="text-end">
                                            <p style="font-size: x-small">Ενεργοί:<b class="pl-4">{{$plessons1}}</b> Εγγραφές</p>
                                            <p style="font-size: x-small">Απενεργοί:<b class="pl-3">{{$plessons0}}</b> Εγγραφές</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="table_tr_ch">
                                    <div class="td" style="width: 90%" >
                                        <div style="display: flex;justify-content: space-between;">
                                            <a> Μεταπτυχιακά Μαθημάτα:</a> <p style="font-size: x-small"><b>{{$mlessons}}</b> Εγγραφές</p>
                                        </div><hr style="padding: 0;margin: 0;">
                                        <div class="text-end">
                                            <p style="font-size: x-small">Ενεργοί:<b class="pl-4">{{$mlessons1}}</b> Εγγραφές</p>
                                            <p style="font-size: x-small">Απενεργοί:<b class="pl-3">{{$mlessons0}}</b> Εγγραφές</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="table_tr_ch">
                                    <div class="td" style="width: 90%" >
                                        <div style="display: flex;justify-content: space-between;">
                                            <a> Διδακτορικά Μαθημάτα:</a> <p style="font-size: x-small"><b>{{$dlessons}}</b> Εγγραφές</p>
                                        </div><hr style="padding: 0;margin: 0;">
                                        <div class="text-end">
                                            <p style="font-size: x-small">Ενεργοί:<b class="pl-4">{{$dlessons1}}</b> Εγγραφές</p>
                                            <p style="font-size: x-small">Απενεργοί:<b class="pl-3">{{$dlessons0}}</b> Εγγραφές</p>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>







    @endif
@endsection

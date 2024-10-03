<div class="container">
    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">x</button>
            {{session()->get('message')}}
        </div>
    @endif
</div>

<div class="container">
    @if(session()->has('warning'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">x</button>
            {{session()->get('warning')}}
        </div>
    @endif
</div>

<div class="container the_pop">
    @if(session()->has('question'))

        <!-- Modal -->
        <div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="questionModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title"  style="position: relative;">
                            <h5 id="questionModalLabel">{{session()->get('act_title')}}</h5>
                            <p style="font-size: small">{!!session()->get('title')!!}</p>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!!  session()->get('question') !!}
                        <br>
                    </div>
                    <div class="modal-footer" style="display: flex;justify-content: space-between;">

                            @if(session()->get('c_button')=='yes')
                                <form method="post" action="{{url(session()->get('action'))}}" class="col-md-5">
                                    @csrf
                                    @method("GET")
                                    <input type="text" value="yes" name="continue" hidden>
                                    <button type="submit" class="form-control button-3" style="width: 100%" data-dismiss="modal">Συνέχεια</button>
                                </form>
                            @endif

                            @if(session()->get('n_button')=='yes')
                                <form method="post" action="{{url(session()->get('action'))}}" class="col-md-5" >
                                    @csrf
                                    @method("GET")
                                    <input type="text" value="no" name="continue" hidden>
                                    <button type="submit" class="form-control button-3" style="width: 100%" data-dismiss="modal">Νέα Προσπάθεια</button>
                                </form>
                            @endif
                            @if(session()->get('n_button')!=='yes' || session()->get('c_button')!=='yes')
                                <div class="col-md-5">
                                    <button type="button" class="form-control button-3" id="close" style="width: 100%; background-color: #B22222">Ακυρό</button>
                                </div>
                            @endif

                    </div>
                </div>
            </div>
        </div>
    @endif
</div>


<script type="text/javascript">
    $("document").ready(function()
    {
        setTimeout(function(){
            $("div.alert").remove();
        },5000);
    });

    $(document).ready(function() {
        $('#questionModal').modal('show');
    });

    //function that close the popups forms
    $(".close").click(function () {
        $('#questionModal').modal('hide');
    });
    //function that close the popups forms
    $("#close").click(function () {
        $('#questionModal').modal('hide');
    });
</script>

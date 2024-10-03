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



<script type="text/javascript">
    $("document").ready(function() {
        setTimeout(function(){
            $("div.alert").remove();
        },5000);
    });


</script>

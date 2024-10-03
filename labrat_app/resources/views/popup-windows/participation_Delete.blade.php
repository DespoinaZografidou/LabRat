<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{--    //pop up window that gives the ability to delete a user from the database--}}
<div class="modal popup" id="popupdelete">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Διαγραφή Συμμετοχής</h5>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ url('/leavelesson')  }}">
                @csrf @method('GET')
                <div class="modal-body ">
                    <label class="col-md-12 col-form-label" id="text"></label>
                    <input type="text" id="p_id" name="p_id" value="" hidden>
                    <button type="submit" class="btn btn-primary col-md-12">Διαγραφή</button>
                </div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>

<script>
    //function that close the popups forms
    $(".popup-close").click(function () {
        $(".popup").fadeOut();
    });
    //function that shows the popup form to delete a user
    function partDelete(name,id,am)
    {
        $('#popupdelete').fadeIn();
        document.getElementById("text").textContent='Εισάστε σιγουροί ότι θέλετε να διαγράψετε τη συμμετοχή του μαθητή '+am+' - ' +name +' από το μάθημα;';
        document.getElementById('p_id').value=id;

    }
    //function that shows the popup form to delete a user
    function partDeleteS(title,id)
    {
        $('#popupdelete').fadeIn();
        document.getElementById("text").textContent='Εισάστε σιγουροί ότι θέλετε να διαγράψετε τη συμμετοχή σας στο μάθημα ' +title +';';
        document.getElementById('p_id').value=id;

    }

</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="popup modal" id="popupshow">
    <div  role="document" class="modal-dialog modal-lg"  >
        <div class="modal-content ">
            <div class="modal-header" style="position: relative;">
                <div id="l_title"></div>
                <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 15px;right: 15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input class="form-control" type="text" id="s_title" name="s_title" ><br>
                <div  class="form-control" style="height: 350px; overflow: auto;" id="s_text" contenteditable="true" ></div>
            </div>
            <div class="modal-footer " style="text-align: right">
                <p id="s_date"></p>
            </div>
        </div>
    </div>
</div>

<script>
    //function that shows the popup form to delete a notification
    const $link=$(".not_tr");

    $link.click(function() {
        // Show the selected row from the table
        $link.removeClass('active');
        $(this).addClass('active');

        const info = $(this).attr('data-info');
        const myObject = JSON.parse(info);

            document.getElementById("s_title").value = myObject.title;
            document.getElementById("l_title").innerHTML ='<h5>'+myObject.l_id + ' - ' + myObject.l_title+'</h5><p>Διδάσκων: '+myObject.name+'</p>';
            document.getElementById("s_text").innerHTML = myObject.text
                .replace(/\n/g, '<br>')
                .replace(/♥/g, '<strong>')
                .replace(/♠/g, '</strong>')
                .replace(/☺/g, '<em>')
                .replace(/☻/g, '</em>')
                .replace(/♦/g, '<u>')
                .replace(/♣/g, '</u>')
                .replace(/•/g, '<li>');
            document.getElementById("s_date").innerHTML = myObject.created_at;
            $('#popupshow').fadeIn();
    });

    //function that close the popups forms
    $(".popup-close").click(function () {
        $(".popup").fadeOut();
    });

</script>

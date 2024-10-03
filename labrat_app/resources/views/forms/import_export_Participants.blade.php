
<div class="col-lg-8 pb-4" >
    <div class="card ">
        {{-- This is a form that you can add new lessons through a excel file--}}
        <div class="card-body row">
            <form action="{{ url('/exportparticipants') }}" method="post" enctype="multipart/form-data" class="col-md-6 pb-4 "> @csrf @method('GET')
                <div class="form-group">
                    <div class="form-control" style="border: none;background-color: transparent;"></div>
                    <span class="info-icon" data-info="Το αρχείο πρέπει να είναι της μορφής .xlsx ή .xls. ">
                    <ion-icon name="information-circle-outline"></ion-icon>
                    </span>
                    <label>Εξαγωγή των Συμμετοχών σε αρχείο:</label>
                    <input type="text" name="l_id" value="{{$l_id}}" hidden>
                    <input type="text" name="filename" value="{{$title}}" hidden>

                </div>
                <button type="submit" class="button-3 col-md-12">Εξαγωγή</button>
            </form>

            <form action="{{ url('/importparticipants') }}" method="post" enctype="multipart/form-data" class="col-md-6">
                @csrf
                @method('GET')
                <div class="form-group">
                    <span class="info-icon" data-info="Το αρχείο πρέπει να είναι της μορφής .xlsx ή .xls. Στη πρώτη γραμμή του μπορείτε να γράψετε (Αρ.μητρώου) για διευκόλυνση. Έπειτα συμπληρώστε τους αριθμούς μητρώων των φοιτητών.">
                    <ion-icon name="information-circle-outline"></ion-icon>
                    </span>
                    <label for="file">Εισαγωγή Συμμετοχών μέσω αρχείου:</label>
                    <input type="text" name="l_id" value="{{$l_id}}" hidden>
                    <input type="file" name="file" id="file" value="" class="form-control" accept=".xlsx, .xls" required>
                </div>
                <button type="submit" class="button-3 col-md-12">Εισαγωγή</button>
            </form>


        </div>
    </div>



</div>
<br>




<script>
    const infoIcons = document.querySelectorAll(".info-icon");

    infoIcons.forEach(icon => {
        const infoText = icon.getAttribute("data-info");
        icon.addEventListener("mouseover", function() {
            const infoBubble = document.createElement("div");
            infoBubble.classList.add("info-bubble");
            infoBubble.innerHTML = infoText;
            document.body.appendChild(infoBubble);

            const iconRect = icon.getBoundingClientRect();
            const bubbleRect = infoBubble.getBoundingClientRect();
            const bubbleLeft = iconRect.left - (bubbleRect.width - iconRect.width) / 2;
            const bubbleTop = iconRect.top - bubbleRect.height - 10;

            infoBubble.style.left = bubbleLeft + "px";
            infoBubble.style.top = bubbleTop + "px";
        });

        icon.addEventListener("mouseout", function() {
            const infoBubble = document.querySelector(".info-bubble");
            if (infoBubble) {
                infoBubble.parentNode.removeChild(infoBubble);
            }
        });
    });

</script>


<form action="{{ url('/exportslots') }}" method="post" enctype="multipart/form-data" class="col-lg-6" > @csrf @method('GET')
    <hr><div class="form-control" style="border: none;background-color: transparent;"></div>
    <span class="info-icon" data-info="Το αρχείο πρέπει να είναι της μορφής .xlsx ή .xls. ">
                    <ion-icon name="information-circle-outline"></ion-icon>
                </span>
    <label>Εξαγωγή Slots σε αρχείο:</label>
    <input type="text" name="as_id" value="{{$as_id}}" hidden>
    <input type="text" name="at_id" value="{{$at_id}}" hidden>
    <input type="text" name="filename" value="{{$title}}-{{$as_title}}" hidden>
    <button type="submit" class="button-3 col-md-12 mt-3">Εξαγωγή</button>
</form>


<form action="{{ url('/importslots') }}" method="post" enctype="multipart/form-data" class="col-lg-6" > @csrf @method('GET')
    <hr><span class="info-icon" data-info="Το αρχείο πρέπει να είναι της μορφής .xlsx ή .xls. Στη πρώτη γραμμή του αρχείου, μπορείτε να γράψετε (Ημερομηνία, Ώρα Έναρξης, Ώρα Λήξης, Διάρκεια ) για διευκόλυνση. Έπειτα συμπληρώστε την ημερομηνία της μορφής dd-mm-yyyy, Ώρα Έναρξης της μορφής hh:mm, Ώρα Λήξης της μορφής hh:mm και τη διάρκει(σε λεπτά).">
                    <ion-icon name="information-circle-outline"></ion-icon>
    </span>
    <label >Εισαγωγή Slots μέσω αρχείου .xlsx ή .xls.:</label>
    <input type="text" name="as_id" value="{{$as_id}}" hidden>
    <input type="file" name="file" id="file" value="" class="form-control" accept=".xlsx, .xls" required>
    <button type="submit" class="button-3 col-md-12 mt-3">Εισαγωγή</button>
</form>
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

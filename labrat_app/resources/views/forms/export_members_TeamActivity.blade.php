
            <form action="{{ url('/exportteams') }}" method="post" enctype="multipart/form-data" class="col-lg-6" > @csrf @method('GET')
                <hr><span class="info-icon" data-info="Το αρχείο πρέπει να είναι της μορφής .xlsx ή .xls. ">
                    <ion-icon name="information-circle-outline"></ion-icon>
                </span>
                <label >Εξαγωγή Ομάδων σε αρχείο:</label>
                <input type="text" name="at_id" value="{{$at_id}}" hidden>
                <input type="text" name="filename" value="{{$title}}-{{$at_title}}" hidden>
                <button type="submit" class="button-3 col-md-12">Εξαγωγή</button>
            </form>

            <form action="{{ url('/finaliseteams') }}" method="post" enctype="multipart/form-data" class="col-lg-6" > @csrf @method('GET')
                <hr><span class="info-icon" data-info="Διαγραφή όλων των μελών από κάθε ομάδα που δεν αποδέχτηκαν το αίτημα συμμετοχής τους. ">
                    <ion-icon name="information-circle-outline"></ion-icon>
                </span>
                <label >Διαμόρφωση τελικών ομάδων:</label>
                <input type="text" name="at_id" value="{{$at_id}}" hidden>
                <button type="submit" class="button-3 col-md-12">Διαμόρφωση</button>
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

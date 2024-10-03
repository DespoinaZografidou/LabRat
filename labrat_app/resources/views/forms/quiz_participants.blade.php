<div class="col-lg-6"><hr>
    <p style="font-size: small;">
        Αρ. Συμμετοχών Quiz: <b>{{$quizpart}} μαθητές</b><br>
        Αρ. Υποβολών: <b>{{$delpart}} μαθητές</b><br>
    </p>
</div>
<form  method="post" action="{{ url('/exportquiz') }}" enctype="multipart/form-data" class="col-lg-6" > @csrf @method('GET')
    <hr><div class="form-control" style="border: none;background-color: transparent;"></div>
    <span class="info-icon" data-info="Εξαγωγή αποτελεσμάτων του Quiz.">
                    <ion-icon name="information-circle-outline"></ion-icon>
                </span>
    <label>Εξαγωγή Αποτελεσμάτων των Quiz σε αρχείο:</label>
    <input type="text" name="act_id" value="{{$act_id}}" hidden>
    <input type="text" name="filename" value="{{$title}}-{{$act_title}}" hidden>
    <button type="submit" class="button-3 col-md-12 mt-3">Εξαγωγή</button>
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

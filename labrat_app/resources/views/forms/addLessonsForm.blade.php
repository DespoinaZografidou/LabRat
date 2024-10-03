
<div class="col-md-8 pb-4">
    <div class="card">
        <div class="card-header" style="display: flex;justify-content: space-between;">
            <h5>Εισαγωγή Νέου Μαθήματος</h5>
            <div class="text-end">
                <button type="button" class="button-3" onclick="addLesson()">+ Νέο Μάθημα</button>
            </div>
        </div>
        {{-- This is a form that you can add new lessons through a excel file--}}
        <div class="card-body">

            <form action="{{ url('addLessons') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('GET')
                <div class="form-group">
                    <label for="file">Εισαγωγή Μαθημάτων μέσω αρχείου:</label>
                    <span class="info-icon" data-info="Το αρχείο πρέπει να είναι της μορφής .xlsx ή .xls. Στη πρώτη γραμμή του μπορείτε να γράψετε (κωδ.Μαθήματος, Τίτλος, Τύπος, Εξάμηνο) για διευκόλυνση. Έπειτα συμπληρώστε τα στοιχεία των μαθημάτων.">
                    <ion-icon name="information-circle-outline"></ion-icon>
                    </span>
                    <input type="text" name="id" value="{{Auth::user()->id}}" hidden>
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

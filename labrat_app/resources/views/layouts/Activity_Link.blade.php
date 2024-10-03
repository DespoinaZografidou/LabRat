<div class="col-lg-4 mylink">
               <span class="copy" id="copy"  style="position: absolute;top:0;left:12px">
                   <ion-icon class="copy__icon"  name="copy"></ion-icon></span>
    <input type="text" name="filename" class="form-control link" id="link"  readonly>
</div><br><br>


<script>

    document.getElementById('link').value=window.location.href;

    const copyIcons = document.querySelectorAll(".mylink");

    copyIcons.forEach(icon => {

        icon.addEventListener("click", function() {

            var urlInput = document.getElementById("link");
            var myspan=document.getElementById("copy");
            myspan.innerHTML='<ion-icon class="copy__icon" name="checkmark"></ion-icon>';
            urlInput.select();
            urlInput.setSelectionRange(0, 99999);
            document.execCommand("copy");

            const Bubble = document.createElement("div");
            Bubble.classList.add("info-bubble");
            Bubble.innerHTML = 'Αντιγράφθηκε';
            document.body.appendChild(Bubble);

            const iconRect = icon.getBoundingClientRect();
            const bubbleRect = Bubble.getBoundingClientRect();
            const bubbleLeft = iconRect.left - (bubbleRect.width - iconRect.width) / 2;
            const bubbleTop = iconRect.top - bubbleRect.height - 10;

            Bubble.style.left = bubbleLeft + "px";
            Bubble.style.top = bubbleTop + "px";

            setTimeout(function() {
                Bubble.parentNode.removeChild(Bubble);
            }, 2000);

        });

    });
</script>

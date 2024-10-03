
<hr>
<form method="post" action="{{ url("import") }}" enctype="multipart/form-data"  > @csrf @method('GET')
    <div class="icon-container" id="icon">
        <!-- Your icon goes here -->
        <ion-icon name="information-circle-outline"></ion-icon>
        <div class="info-bubble" id="infoBubble">Το αρχείο πρέπει να είναι της μορφής .xls ή .xlsx. Στην πρώτη γραμμή σε κάθε στήλη μπορείτε να γράψετε τους τίτλους (Αρ.Μητρώου,Ονομ/νυμο,Ρόλος και Email) και έπειτα να συμπληρώσετε της γραμμές ανάλογα.</div>
    </div>
    <label class="col-form-label pt-2">Εισαγωγή χρηστών στον SSO Server μέσω αρχείου:</label>
    <input type="file" name="file" id="file" value="" class="form-control" accept=".xlsx, .xls" required><br>
    <button type="submit" class="btn btn-block form-control btn-success">Εισαγωγή στο SSO</button>
</form>
<hr>



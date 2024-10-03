
<div class="col-lg-8 pb-4" >
    <div class="card ">
        <div class="card-header">
            <h5>Εισαγωγή Νέου Χρήστη</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('sso') }}" method="post" target="_blank"> @csrf @method('GET')
                <span class="info-icon"><ion-icon name="information-circle-outline"></ion-icon></span>
                <label>Εισαγωγή χρηστών στον SSO Server:</label>
                <input type="text" name="role" value="{{ Auth::user()->role }}" hidden>
                <button type="submit" class="button-3 col-md-12 mt-3">Εισαγωγή στο SSO</button>
            </form>
        </div>
    </div>
</div>

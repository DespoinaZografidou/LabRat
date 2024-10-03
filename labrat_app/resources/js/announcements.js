
//Αυτό το script έλεγχει αν υπάρχουν τυχόν ειδοποιήσεις από της δραστηριότητες των μαθημάτων που συμμετέχει ο μαθητής
document.addEventListener('DOMContentLoaded', function(){

        var formData = {
            am: am,
        };

        axios.get('/greenthebell', {
            params: formData, // Pass the data as query parameters
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => {
                // Αν υπάρχουν ειδοποιήσεις ειδοποίησε το μαθητή.
                if(response.data.message==='success') {
                    $('#thebell').append('<span class="status status_active" style="width: 12px;height: 12px;position: absolute;top:2px;left: 12px;border: 1px solid dimgray;opacity: 0.8"></span>');
                }

            })
            .catch(error => {
                console.error(error);
            });

});


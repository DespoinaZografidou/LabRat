//Αυτό το script τρέχει κάθε φορά που κάποιος μαθητής θέλει να μπεί στο χώρο κάποιου μαθήματος
//ελέγχει αν συμμετέχει στο μάθημα. Το script τρέχει πριν φορτώσει η σελίδα.
document.addEventListener('DOMContentLoaded', function(){

        var formData = {
            l_id: l_id,
            am: am,

        };
       //έλεγξε αν ο μαθητής συμμετέχει στο μάθημα
        axios.get('/participationCheck', {
            params: formData, // Pass the data as query parameters
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => {
                // Αν δε συμμετέχει στο μάθημα, μετεφερέ τον μαθητή στη σελίδα με τα μαθήματα
                if(response.data.message==='fail') {

                    var url = "/allthelessons/Προπτυχιακό/" +am;
                    window.location.href = url;
                }

            })
            .catch(error => {
                console.error(error);
            });

});

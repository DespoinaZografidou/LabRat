Εγκατάσταση & Επίδειξη Συστήματος

Διαδικασία Εγκατάστασης και Εκτέλεσης Συστήματος 
--------------------------------------------------
Στη συγκεκριμένη ενότητα, θα περιγράψουμε τη διαδικασία της εγκατάστασης της παρούσας εφαρμογής. Η εγκατάστασή της είναι εύκολή αρκεί να ακολουθήσετε τα παρακάτω βήματα:
Αρχικά, θα πρέπει να κατεβάσουμε τα απαραίτητα αρχεία από το παρακάτω Link:
https://github.com/DespoinaZografidou/LabRat.git

Πατώντας το Link θα δείτε τα εξής αρχεία της εφαρμογής. 
•	Ο φάκελος περιλαμβάνει τα δύο αρχεία dumb, το αρχείο  labrat_sso.sql και το αρχείο sso_client_labrat.sql . Μέσω αυτών των δύο αρχείων θα σχεδιαστεί η βάση του SSO server και του SSO client (της εφαρμογής LabRat) αντίστοιχα. 
•	Ο φάκελος «labrat_app» περιέχει τα αρχεία της εφαρμογής LabRat και ο φάκελος «labrat_sso» περιέχει τα αρχεία του SSO server της εφαρμογής. Αυτούς τους δύο φακέλους πρέπει να τους τοποθετήσετε στο web server που εσείς έχετε επιλέξει προκειμένου να είναι σε θέση να τρέξετε την εφαρμογή.
•	Το αρχείο «Login Info των χρηστών» περιλαμβάνει τα στοιχεία σύνδεσης των χρηστών οπού εμπεριέχονται ήδη στη βάση δεδομένων προκειμένου να περιηγηθείτε στο σύστημα.
•	O φάκελος «Αρχεία για εισαγωγή και δημιουργία» περιλαμβάνει πρότυπα αρχείων .xlsx για εισαγωγή νέων δεδομένων στην βάση μας μέσω της αρχείων που υποστηρίζει η εφαρμογή μας.
•	Προαπαιτούμε για την εγκατάσταση της εφαρμογής στο υπολογιστή σας είναι να είναι εγκαταστημένα τα εξής στον υπολογιστή σας :

1.	Composer: https://getcomposer.org/download/
2.	Php: https://www.php.net/downloads 
3.	Node.js: https://nodejs.org/en 

Για να κατεβάσετε τα αρχεία της Εφαρμογής από το GitHub
-----------------------------------------------------------
1.	Για την εγκατάσταση της εφαρμογής στον υπολογιστή σας θα πρέπει να κλωνοποιήσετε το Project από το GitHub στο φάκελο root to Web Host της επιλογής σας.
•	Έπειτα θα ανοίξετε το command prompt και θα μετακινηθείτε στο root φάκελο του  Web Host σας.
	cd C:\yourwebhost\rootfile
•	Έπειτα θα κλωνοποιήσετε το repository από το GitHub με τη παρακάτω εντολή.
	git clone https://github.com/DespoinaZografidou/LabRat.git

•	Θα μετακινηθείτε στο φάκελο του αντίστοιχου project και θα κάνετε την εγκατάσταση των εξαρτήσεων του Laravel με Composer και npm.
  Για το Web app «labrat_app»
	  cd C:\yourwebhost\rootfile\ labrat_app 
    composer install
    npm install

  Για το SSO Server «labrat_sso»
	  cd C:\yourwebhost\rootfile\ labrat_sso 
    composer install
    npm install

Για να Δημιουργήσετε και να Συνδέσετε τη Βάση Δεδομένων
----------------------------------------------------------
•	Δημιουργήσετε στο Web Host σας δύο Βάσεις Δεδομένων με τα όνοματα «sso_client_labrat» και «labrat_sso».
•	Εισάγεται τa dumb αρχεία στις βάσεις που μόλις δημιουργήσατε.

•	Αφού έχετε εισάγει τα αρχεία dump,  έπειτα ανοίγοντας τους φάκελους του κάθε project  ανοίξτε το .env αρχείο, και τροποποιήστε τις γραμμές του κώδικα προσθέτοντας τα στοιχείο της δικής σας βάσης.
 

Για να τρέξετε πρώτη φορά την Εφαρμογή
-------------------------------------------
Για να λειτουργήσει η εφαρμογή Laravel, χρειάζεσαι το APP_KEY, το οποίο μπορείς να δημιουργήσεις με τις παρακάτω εντολή:
	Για το SSO Server «labrat_sso»
   cd C:\yourwebhost\rootfile\ labrat_sso 
   php artisan key:generate

  Για το Web app «labrat_app»
	cd C:\yourwebhost\rootfile\ labrat_app 
  php artisan key:generate


Μετά από αυτά τα βήματα είστε έτοιμοι να τρέξετε την εφαρμογή.
1.	Για να τρέξετε την εφαρμογή αρχικά πρέπει να τρέξετε  το Local Server.
  Για το SSO Server «labrat_sso»
	  cd C:\yourwebhost\rootfile\ labrat_sso 
    php artisan serve

  Για το Web app «labrat_app»
	  cd C:\yourwebhost\rootfile\ labrat_app
    php artisan serve --port 8080

2.	Και τέλος να εκτελέσετε τη μεταγλώττιση των assets σε με τις παρακάτω εντολές.
     Για το SSO Server «labrat_sso»
	    cd C:\yourwebhost\rootfile\ labrat_app
      npm run dev

    Για το Web app «labrat_app»
	    cd C:\yourwebhost\rootfile\ labrat_sso
      npm run dev


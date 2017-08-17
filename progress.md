## TODO

- creare un model e un controller per le informazioni (JSON)
- Creare impostazione per la dimensione massima di upload per gli utenti
- Aggiungere un limite di dimensione per l'upload
- Creare un sistema per le lingue
- Aggiungere sistema che se non si salva la sessione, i video vengono cancellati


17 Agosto
_______

- Sistemato Controller per creative-studio
- Sistemato la view per creative-studio
- Creata view per app active-offscreen
- Creata funzione nel controller per l'upload dei file
- Aggiunto sistema upload per i video in active-offscreen
- Corretto model Video e create le relazioni morphedByMany con appsSessions, TeacherSession, Teacher
-

16 Agosto
_______

- Conclusa configurazione definitiva
- Creato nuovo controller per il creative-studio
- Creata nuova view per i percorsi



14 Agosto
_______

- Aggiunte nuove app e rimosse le vecchie
- Configurato nuovo server
- Creato db ed importato i dati dalla versione local



21 Giugno 2017
_______

- Terminato sistema per le sessioni degli insegnanti (_permette di salvare un progetto_)
- Spostata e modificata la prima App (_Frame Crop_)
- Creato il controller per le sessioni


20 Giugno 2017
_______


- Sistemati link dei palazzi secondo ordine definito durante la skype call
- Creati i modelli per
  - App (_Con le singole applicazioni_)
  - App Categories (_Corrispondono ai percorsi didattici_)
  - App Sections (_Corrispondono ai Padiglioni_)
  - App Keywords (_Corrsipondono alle parole chiave nella sidebar dei singoli percorsi didattici_)
- Creata la struttura di routing per le applicazioni nella sezione _Teacher_
- Creati Database Seeder per tutti e tre i modelli
- Inseriti i dati per il primo padiglione e per il secondo
- Rifatti i seeder secondo l'ultima modifica (_file condiviso da Simone_)
- Reso dinamico il routing per i vari padiglioni, percorsi didattici e applicazioni
- Modificato il controller in "Teacher/AppController"
- Creato il sistema per registrare la sessione dell'insegnante

_______


### TODO
- Descrizioni di tutte le app, almeno in inglese per adesso
- Nomi definitivi delle applicazioni degli altri due padiglioni (_Cinema e Creative Studio_)
- Descrizione dell'app attractions viceversa

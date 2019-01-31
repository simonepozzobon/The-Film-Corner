<footer class="{{ $footer == 'no-margin' ? 'no-margin-top' : '' }}">
    <div class="footer-content">
        Made by Fondazione Cineteca Italiana |
        <a href="#" data-toggle="modal" data-target="#creditsModal">Credits</a> |
        <a href="#" data-toggle="modal" data-target="#privacyPolicy">Privacy</a> |
        <a href="#" data-toggle="modal" data-target="#cookiePolicy">Cookie Policy</a>
    </div>
    <div class="modal fade" id="creditsModal" tabindex="-1" role="dialog" aria-labelledby="creditsModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="creditsModalTitle">Credits</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>Credits</h3>
                    <ul class="list-unstyled">
                        @foreach (\Credit::get_all() as $key => $credit)
                            <li>{{ $credit->name }} - {{ $credit->role }}</li>
                        @endforeach
                    </ul>
                    <h3 class="mt">Filmography</h3>
                    <ul class="list">
                        @foreach (\Filmography::get_all() as $key => $filmography)
                            <li>{{ $filmography->title }} - {{ $filmography->description }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Okay!</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="privacyPolicy" tabindex="-1" role="dialog" aria-labelledby="creditsModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="creditsModalTitle">Privacy</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>Informativa Sulla Privacy</h3>
                    <p>
                        Leggi attentamente quanto segue per saperne di più sulla nostra privacy policy.
                        Ai sensi dell'articolo 13 GDPR - Regolamento Generale sulla Protezione dei Dati (UE/2016/679).
                    </p>
                    <ol>
                        <li>
                            Natura Dei Dati<br>
                            La presente informativa riguarda il trattamento dei dati personali, intendendosi per dati personali quelli c.d. comuni e/o identificativi (quali per esempio: dati anagrafici, codice fiscale, residenza o domicilio, numero telefonico, e-mail, fax, etc.).
                        </li>
                        <li>
                            Cookie<br>
                            Per la trattazione di questo argomento si rimanda all'apposita sezione "Cookie Policy".
                        </li>
                        <li>
                            Fonte dei dati personali<br>
                            I dati personali sono quelli forniti dall'Interessato attraverso il sito www.thefilmcorner.eu di Fondazione Cineteca Italiana.
                        </li>
                        <li>
                            Obbligatorietà/facoltatività del conferimento dei dati<br>
                            Il conferimento dei dati personali da parte dell'Interessato è necessario per l'attività di The Film Corner e per il servizio streaming che Fondazione Cineteca Italiana realizza in collaborazione con MAF Media. I dati di accesso a The Film Corner saranno in automatico conferiti da Fondazione Cineteca Italiana a MAF Media per usufruire del servizio streaming. Il conferimento dei dati è facoltativo ma necessario per attivare il suddetto servizio.
                        </li>
                        <li>
                            Finalità del trattamento<br>
                            a)	Il trattamento a cui sono sottoposti tutti i dati acquisiti è finalizzato alla messa a disposizione dell'Interessato dei servizi offerti dalla piattaforma The Film Corner, e precisamente la possibilità di visionare in streaming film per le scuole.
                        </li>
                        <li>
                            Modalità del trattamento<br>
                            I dati personali dell'Interessato sono trattati per il tempo strettamente necessario a conseguire gli scopi per cui sono stati raccolti. Specifiche misure di sicurezza sono osservate per prevenire la perdita di dati, usi illeciti o non corretti ed accessi non autorizzati.
                        </li>
                        <li>
                            Diritti dell'Interessato<br>
                            I soggetti cui si riferiscono i dati personali hanno diritto in qualunque momento di ottenere la conferma dell'esistenza o meno dei medesimi dati e di conoscerne il contenuto e l'origine, verificarne l'esattezza o chiederne l'aggiornamento. Ai sensi dell'art. 13 GDPR - Regolamento Generale sulla Protezione dei Dati, si ha diritto di chiedere la cancellazione, la trasformazione in forma anonima o il blocco dei dati trattati in violazione di legge, nonché di opporsi in ogni caso, per motivi legittimi, al loro trattamento.<br>
                            Al fine dell'esercizio di tali diritti, l'Interessato potrà inoltrare richiesta scrivendo a Fondazione Cineteca Italiana con sede in Milano (20162), Viale Fulvio Testi, 121 o un'e-mail al seguente indirizzo info@cinetecamilano.it.
                        </li>
                        <li>
                            Titolare del trattamento dei dati<br>
                            Titolare del trattamento dei dati è: Fondazione Cineteca Italiana, con sede in Milano, Viale Fulvio Testi 121.

                        </li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Okay!</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cookiePolicy" tabindex="-1" role="dialog" aria-labelledby="creditsModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="creditsModalTitle">Cookies</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>Cookies</h3>
                    <p>
                        Leggete attentamente quanto segue per saperne di più sui nostri cookie.
                    </p>
                    <ol>
                        <li>
                            Cosa sono i cookie<br>
                            Un cookie è un piccolo file di testo memorizzato nel browser web di un utente su qualunque dispositivo che contiene informazioni riguardanti la visita dell'utente, come ad esempio le preferenze. Quando l'utente ritorna, il browser fornisce il cookie con le informazioni memorizzate dal sito.
                        </li>
                        <li>
                            Per cosa sono usati i cookie<br>
                            I cookie vengono utilizzati per regolare il contenuto di un sito web per soddisfare le preferenze di un utente e ottimizzare il sito web stesso. Essi memorizzano informazioni utili che migliorano l'esperienza dell'utente di un sito web. Essi sono comunemente utilizzati per:
                            <ul>
                                <li>
                                    Memorizzazione le informazioni di login in modo che un utente non abbia bisogno di ri-effettuare il login su ogni visita.
                                </li>
                                <li>
                                    Riconoscere il tipo di dispositivo di un utente collegato ad un sito per ottimizzarlo per il dispositivo stesso.
                                </li>
                                <li>
                                    La creazione di statistiche che aiutano i proprietari di siti web a capire come i loro utenti interagiscono con il loro sito web, e permettere loro di migliorare la propria struttura e il contenuto.
                                </li>
                            </ul>
                        </li>
                        <li>
                            i cookie su www.thefilmcorner.eu<br>
                            Di seguito troverai tutte le informazioni sui cookie installati attraverso il sito internet www.thefilmcorner.eu di Fondazione Cineteca Italiana (di seguito "Sito"), e le indicazioni necessarie su come gestire le tue preferenze riguardo ad essi.
                        </li>
                    </ol>
                    <h4>Cookie Tecnici</h4>
                    <p>
                        Fondazione Cineteca Italiana utilizza, attraverso il suo Sito, esclusivamente cookie tecnici.<br>
                        I cookie tecnici servono ad effettuare la navigazione o a fornire un servizio richiesto dall'utente. Non vengono utilizzati per scopi ulteriori e sono normalmente installati dal titolare del sito web. Senza il ricorso a tali cookie, alcune operazioni non potrebbero essere compiute o sarebbero più complesse e/o meno sicure.<br>
                        Possono essere suddivisi in cookie di navigazione, che garantiscono la normale navigazione e fruizione del sito web; cookie analytics, assimilati ai cookie tecnici laddove utilizzati direttamente dal gestore del sito per raccogliere informazioni, in forma aggregata, sul numero degli utenti e su come questi visitano il sito stesso; cookie di funzionalità, che permettono all'utente la navigazione in funzione di una serie di criteri selezionati (ad es., la lingua) al fine di migliorare il servizio stesso.<br>
                        Tutti i cookie tecnici non richiedono il consenso, perciò vengono installati automaticamente a seguito dell'accesso al sito.<br>
                    </p>
                    <h4>Cookie di profilazione</h4>
                    <p>
                        Fondazione Cineteca Italiana NON utilizza attraverso il Sito cookie di profilazione. Tali cookie servono per tracciare la navigazione dell'utente in rete e creare profili sui suoi gusti, abitudini, scelte, ecc. in modo da trasmettere al suo terminale messaggi pubblicitari in linea con le preferenze già manifestate durante la navigazione.<br>
                        Ricordati che puoi gestire le tue preferenze sui cookie anche attraverso il browser.<br>
                        Se non conosci il tipo e la versione di browser che stai utilizzando, clicca su "Aiuto" nella finestra di browser in alto, da cui puoi accedere a tutte le informazioni necessarie.<br>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Okay!</button>
                </div>
            </div>
        </div>
    </div>
</footer>

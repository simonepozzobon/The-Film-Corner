@extends('layouts.conference', ['active' => 'about'])
@section('title')
  The Film Corner - International Conference
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <style media="screen">
    .sr .load {
      visibility: hidden
    }
  </style>
@endsection
@section('content')
    <div class="conference-container">
      <div class="block-subtitle">
        <h3>About The Conference</h3>
      </div>
      <div class="block-text">
        <p class="text-justify">
          The Film Corner International Conference is open to the public and addressed to professionals and trainers of film education, media education, information and communication technology as well as gaming professionals.
          The conference will take place during the 9th edition of Piccolo Grande Cinema Festival in Milan, a film festival dedicated to young audiences organised by Fondazione Cineteca Italiana.
          The main issues of the conference are:
          <br>
          <ul>
            <li>
              <b>Launch of The Film Corner platform:</b> the first version of The Film Corner interactive online platform for film education will be launched at the conference.
            </li>
            <li>
              <b>Methodologies for film education in the digital era:</b> during the last twenty years the audiovisual sector has been undergoing radical changes in all the aspects of the production and distribution value-chain. The crossover between film and web 2.0 has radically changed the relationship of people with film, both in filmmaking and in the accessibility to audiovisual content. These changes are also reflected in film education: how does film education change given the new experiences  of the digital era? What are the potentials and risks within the new technological environment? How far have audiences’ experiences and best practices developed? Can we go further? What is the role of the institutions devoted to film heritage preservation in this process?
            </li>
            <li>
              <b>Integration between online and offline Film Literacy actions:</b> the increased digitization of film both online and offline and importance of social media as the new site of public debate, have created a divide between the online and the offline world. This might be considered unimportant regarding access to film but concerning film education itself one must consider thechallenges that are presented: how do we integrate new online possibilities with our established “analogue” approaches to teaching film literacy? What are the benefits  and challenges of offline and online approaches? What online activities  can compliment  offline provision and vice versa?
            </li>
            <li>
              <b>Crossmedia educational and promotional platforms in the digital film market:</b> film education should not only be seen as a way to increase people’s ability to understand moving images. Film education is ,in addition,  a way in which cinema gets in touch with its audiences, raises questions in the audiences’ minds  – particularly with young audiences - on what the film is about and on how people see something that attracts them  in a film. In this way film education is the missing link between the audience and the film itself, making it readable and understandable in its complexityas an artistic object. So how can the film industry take advantage of the link that film education creates with the audience to promote their products? What can be the advantages for the audience in using film education as a promotional resource? How can film education help distributors in building an online promotion strategy?
            </li>
          </ul>
        </p>
      </div>
    </div>
    <div class="conference-container pt-4">
          <div class="block-subtitle">
            <h3>Speakers</h3>
          </div>
          <div class="block-text">
            <div class="container">
              {{-- <div class="row align-items-end"> --}}
              <div class="row pb-5">
                <div class="col-md-4 load pb-5">
                    <div class="filter-wrapper filter-yellow">
                      <img class="img-fluid" src="/img/conference/nuria_aidelman.png">
                    </div>
                </div>
                <div class="col-md-8 load">
                  <div class="block-subtitle pt-2">
                    <h5>Núria Aidelman</h5>
                  </div>
                  <div class="block-text">
                    <p class="text-justify">
                      Nuria Aidelman is co-director of A Bao A Qu, a non-profit cultural organization devoted to the conception and development of programs and activities that link artistic creativity with schools. One of their main projects is Cinema en curs, a film pedagogy program in primary and secondary schools started in 2005 and now present in Catalonia, Galicia, Madrid, Germany and Chile; other notable projects include Creadors en residència als instituts de Barcelona, Fotografia en curs and the European project Moving Cinema, led by A Bao A Qu since 2014. She is also lecturer in Cinema and Photo at Pompeu Fabra University and a member of the CINEMA group. Together with Gonzalo de Lucas, she edited Jean-Luc Godard’s Pensar entre imágenes and she has written articles for a range of books and anthologies.
                    </p>
                  </div>
                </div>
              </div>
              @include('components.home.divider')
              <div class="row pb-5">
                <div class="col-md-4 load push-md-8 pb-5">
                  <div class="filter-wrapper filter-blue">
                    <img class="img-fluid" src="/img/conference/alessandro_bollo.png">
                  </div>
                </div>
                <div class="col-md-8 load pull-md-4">
                  <div class="block-subtitle pt-2">
                    <h5>Alessandro Bollo</h5>
                  </div>
                  <div class="block-text">
                    <p class="text-justify">
                      Alessandro Bollo is director at Fondazione Polo del ‘900 in Turin and co-founding member of Fondazione Fitzcarraldo, where he was in charge of research and strategy. Besides teaching event marketing at Università Cattolica del Sacro Cuore in Milan, he also teaches economics, cultural and planning policies and cultural marketing at national and international masters programs. He was appointed by the Council of Europe as one of the experts in charge of assessing Montenegro’s cultural policy and he is co-author of UNESCO’s Global Handbook For Measuring Cultural Participation. He has published books and scientific articles on cultural management, cultural event marketing and audience policies. Since 2011, he has worked towards Matera’s candidacy as 2019 European Capital of Culture as member of the technical committee, coordinating the redaction of the final candidacy draft. Alessandro was also team leader in the Study on audience development – how to place audiences at the center of cultural organizations by the European Commission EACEA (2015) and in the group of experts in charge of the National Strategy for Cultural Heritage in Kosovo within the “Culture For All” project (2016).
                    </p>
                  </div>
                </div>
              </div>
              @include('components.home.divider')
              <div class="row pb-5">
                <div class="col-md-4 load pb-5">
                    <div class="filter-wrapper filter-orange">
                      <img class="img-fluid" src="/img/conference/nathalie_bourgeois.png">
                    </div>
                </div>
                <div class="col-md-8 load">
                  <div class="block-subtitle pt-2">
                    <h5>Nathalie Bourgeois</h5>
                  </div>
                  <div class="block-text">
                    <p class="text-justify">
                      Nathalie Bourgeois is supervisor of the educational programs outside the walls
                      of La Cinémathèque: partner of the European project led by l'Institut français
                      <a href="www.cined.eu/fr" target="_blank">CinEd</a>, and responsible for
                      <a href="www.cinematheque.fr/cinema100ansdejeunesse/" target="_blank">the international device Le Cinéma, cent ans de jeunesse</a>
                    </p>
                  </div>
                </div>
              </div>
              @include('components.home.divider')
              <div class="row pb-5">
                <div class="col-md-4 load push-md-8 pb-5">
                  <div class="filter-wrapper filter-green">
                    <img class="img-fluid" src="/img/conference/christine_eloy.png">
                  </div>
                </div>
                <div class="col-md-8 load pull-md-4">
                  <div class="block-subtitle pt-2">
                    <h5>Christine Eloy</h5>
                  </div>
                  <div class="block-text">
                    <p class="text-justify">
                      After graduating in Anthropology at ULB (Université Libre de Bruxelles) Christine Eloy started working
                      for an event organization company, then for a pool of European televisual cultural programs.
                      In 2000 she joined Cinéart, one of the leading independent distributors in Belgium and The Netherlands,
                      where she worked at the sales department for twelve years, releasing about 500 films amongst which AMOUR,
                      PERSEPOLIS, LORD OF THE RINGS or STILL LIFE.
                      Since September 2013, Christine is Europa Distribution’s Managing Director.
                      Europa Distribution is the association of independent film distributors. With about 120 members,
                      representing 28 countries in Europe and beyond, it serves as the voice of the sector and acts as a network
                      and a think tank.
                    </p>
                  </div>
                </div>
              </div>
              @include('components.home.divider')
              <div class="row pb-5">
                <div class="col-md-4 load pb-5">
                    <div class="filter-wrapper filter-blue">
                      <img class="img-fluid" src="/img/conference/alessandra_guarino.png">
                    </div>
                </div>
                <div class="col-md-8 load">
                  <div class="block-subtitle pt-2">
                    <h5>Alessandra Guarino</h5>
                  </div>
                  <div class="block-text">
                    <p class="text-justify">
                      Fondazione Centro Sperimentale di Cinematografia – EU Projects Office
                      She’s been working at Centro Sperimentale di Cinematografia since 1999, where she has
                      worked for national training programs for teachers and professional educators, promoting
                      European projects such as Cined@ys and regional film literacy initiatives like Educinema.
                      In charge of the definition  - by the Ministry of Education - of specific learning objectives
                      of the new Audiovisual and Multimedia curriculum in secondary schools, she has developed the
                      Italian partnership of the international program “Le Cinéma, cent ans de jeunesse “created by
                      the Cinémathèque française and, together with FilCoSpe-Roma Tre University, she has endorsed
                      the European research project “Screening Literacy: Film Education” in Europe coordinated by the BFI.
                      In 2017, as representative of Rome Creative City of Film, she has taken part in the Unesco
                      Creative Cities Network Annual Meeting in Enghien-Les-Bains.
                    </p>
                  </div>
                </div>
              </div>
              @include('components.home.divider')
              <div class="row pb-5">
                <div class="col-md-4 load push-md-8 pb-5">
                  <div class="filter-wrapper filter-yellow w-100">
                    <img class="img-fluid w-100" src="/img/conference/claus_hjorth.png">
                  </div>
                </div>
                <div class="col-md-8 load pull-md-4">
                  <div class="block-subtitle pt-2">
                    <h5>Claus Noer Hjorth</h5>
                  </div>
                  <div class="block-text">
                    <p class="text-justify">
                      Head of Children & Youth Department, Danish Film Institute. Head of Secretariat,
                      Danish Media Council for Children and Young People. General Manager of Awareness Centre
                      Denmark (EU Connecting Europe Facility Programme). The Danish Film Institute Children
                      & Youth department is responsible for film promotion and film education for children
                      and young people. Based on the key words: Experience, understand and create, the strategies
                      and activities are focused on all aspects of film education and the potential of film.
                      Since 2015 the secretariat for the Danish Media Council for Children and Young People has been
                      an integrated part of the department. The Media Council is appointed by the Danish Minster
                      for Culture. Besides film classification, the unit is responsible for the promotion of
                      Media Literacy, covering all aspects of children and young people’s critical understanding
                      of the digital development and thereby strengthen their active participation and awareness in
                      the digital society. Previously, Claus has held the position as Senior Advisor at the Danish
                      Ministry for Culture and at Local Government Denmark. Claus has a Masters Degree in Political Science.
                    </p>
                  </div>
                </div>
              </div>
              @include('components.home.divider')
              <div class="row pb-5">
                <div class="col-md-4 load pb-5">
                    <div class="filter-wrapper filter-green w-100">
                      <img class="img-fluid w-100" src="/img/conference/christine_kopf.png">
                    </div>
                </div>
                <div class="col-md-8 load">
                  <div class="block-subtitle pt-2">
                    <h5>Christine Kopf</h5>
                  </div>
                  <div class="block-text">
                    <p class="text-justify">
                      Studied Film, German Philology and Cultural Anthropology in Erlangen, Marburg and Siegen (MA).
                      Festival director of the goEast – Festival of Central and Eastern European Film, Wiesbaden
                      (2004 – Oct 2008). Member of diverse juries. She developed concepts, exhibitions and film
                      series for Filmvilla Nürnberg, ZKM Center for Art and Media Karlsruhe, Kulturamt Wiesbaden,
                      Offenbach University of Art and Design (Moving Image Biennial 2013, Frankfurt) and particulary
                      for the Deutsches Filmmuseum and Deutsches Filminstitut (DIF) in Frankfurt. For twenty years
                      now she is working for this German cinematheque, curating exhibitions, programming film series,
                      organizing special events like the programm at the re-opening of the house in 2011.
                      Since summer 2013 she is building up a new department as head of the film literacy activities.
                      Parallel she is working as curator for the Film Prize of the Robert Bosch Stiftung for International
                      Cooperation between young filmmakers from Germany and the Arab world.
                    </p>
                  </div>
                </div>
              </div>
              @include('components.home.divider')
              <div class="row pb-5">
                <div class="col-md-4 load push-md-8 pb-5">
                  <div class="filter-wrapper filter-orange w-100">
                    {{-- <img class="img-fluid w-100" src="/img/conference/claus_hjorth.png"> --}}
                  </div>
                </div>
                <div class="col-md-8 load pull-md-4">
                  <div class="block-subtitle pt-2">
                    <h5>Martin Melarkey</h5>
                  </div>
                  <div class="block-text">
                    <p class="text-justify">
                      Is a founding member of the Nerve Centre and has been the center’s Director since 1990.
                      He was seconded to Culture Company in July 2011 as Senior Cultural Programmer for
                      “Derry-Londonderry’s City of Culture” year of 2013 with special responsibility for education
                      and community programs.  Martin has a background in cinema as both a programmer for the annual
                      Foyle Film Festival and a producer of animated films such as The King’s Wake
                      (Best Animation at the 2001 Celtic Film & TV Festival) and the Cu Chulainn animated series for
                      BBC NI. Martin is currently Chief Examiner of Moving Image Arts GCE, a digital filmmaking qualification
                      issued by CCEA that is currently being taught in over 100 schools in Northern Ireland.
                    </p>
                  </div>
                </div>
              </div>
              @include('components.home.divider')
              <div class="row pb-5">
                <div class="col-md-4 load pb-5">
                    <div class="filter-wrapper filter-blue w-100">
                      <img class="img-fluid w-100" src="/img/conference/camilla_paterno.png">
                    </div>
                </div>
                <div class="col-md-8 load">
                  <div class="block-subtitle pt-2">
                    <h5>Camilla Paternò</h5>
                  </div>
                  <div class="block-text">
                    <p class="text-justify">
                      Camilla Paternò worked in New York as a documentarist for La Storia siamo noi by Giovanni Minoli.
                      Back in Italy, she exhibited her works with Matteo Basilè at Mart in Rovereto and won the
                      Terra di Siena Film Festival with the documentary L'Eletta. She is currently divided between
                      writing – signing the most successful fiction in recent years – and producing documentaries.
                      She's now working on a project funded by European Community with young unaccompanied refugees
                      in Siracusa.
                    </p>
                  </div>
                </div>
              </div>
              @include('components.home.divider')
              <div class="row pb-5">
                <div class="col-md-4 load push-md-8 pb-5">
                  <div class="filter-wrapper filter-yellow w-100">
                    <img class="img-fluid w-100" src="/img/conference/mark_reid.png">
                  </div>
                </div>
                <div class="col-md-8 load pull-md-4">
                  <div class="block-subtitle pt-2">
                    <h5>Mark Reid</h5>
                  </div>
                  <div class="block-text">
                    <p class="text-justify">
                      Mark Reid trained as a teacher in 1990, and taught English and Media in south London before
                      joining the BFI (British Film Institute) in 1997. For 8 years, he ran teacher training courses
                      at BFI, before taking over the Education programs at BFI Southbank. He is currently Head of UK
                      Learning Programs at BFI.  In 2012 Mark led the team that compiled Screening Literacy,
                      the first, and largest, survey of film education cultures in Europe, before leading the bid to
                      create the Framework for Film Education in Europe, which was published in 2015.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/conference/speakers.js') }}"></script>
@endsection

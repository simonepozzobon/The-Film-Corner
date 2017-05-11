@extends('layouts.main')
@section('title')
  The Film Corner - International Conference
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('content')
<main>
  <div class="container">
    <div class="row">
      <div class="col mt-5">
        <section>
          <div class="row pt-5">
            <div class="col-md-2">
              <img src="{{ asset('img/home/the_project.png') }}" alt="">
            </div>
            <div id="international-conference" class="tween-content-container block-wrapper col-md-10">
              <div id="conference-title" class="title pb-5">
                The International Conference
              </div>
              <div class="block-container">
                <div class="block-text">
                  <p class="text-justify">
                    The conference is part of The Film Corner project aimed to the creation of an online interactive platform for film education addressed to European schools.
                  </p>
                </div>
                <div class="block-subtitle mt-5">
                  <h4>Where and When</h4>
                </div>
                <div class="block-text">
                  <p class="text-justify">
                    2017, Thu, November 9th, 5pm Italian time, MIC-Interactive Film Museum, viale Fulvio Testi, 121, Milan, Italy
                    <br>
                    2017, Fri, November, 10th, 9 am-6 pm Italian time, Cinema Oberdan, Viale Vittorio Veneto, 2, Milan, Italy
                  </p>
                </div>
                <div class="block-subtitle mt-5">
                  <h4>The Film Corner An Introduction</h4>
                </div>
                <div class="block-text">
                  <p class="text-justify">
                    <i>The Film Corner. Online and offline activities for Film Literacy</i> project aims to  design, release and test an online platform for film education, exploiting the opportunities available through web 2.0 and thus developing innovative crossmedia approaches to teaching appropriate to the digital era in order to raise the levels of film literacy of young audiences across the European Union.
                    <br><br>
                    The project involves 5 European institutions in 4 EU countries: Fondazione Cineteca Italiana (Milan, Italy) as coordinator; The Film Space (London, UK); The Nerve Centre (Derry, Northern Ireland); Jugoslovenska Kinoteka, the National Cinèmatheque of Serbia (Serbia, Belgrade); University of Milano Bicocca-Dipartimento di Scienze Umane per la Formazione Riccardo Massa (Milan, Italy).
                    The platform includes <b>interactive didactical resources</b> with which the users can engage and thus develop their film literacy skills. The pedagogical resources will focus on film education skills explored through a number of EU national and non-national films.
                    <br><br>
                    The Film Corner. Online and offline activities for Film Literacy project is co-financed by the European Union in the context of the Creative Europe Programme of the European Union.
                  </p>
                </div>
                <div class="block-subtitle mt-5">
                  <h4>About The Conference</h4>
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
                <div class="block-subtitle mt-5">
                  <h4>Schedule Draft</h4>
                </div>
                <div class="block-text">
                  <p class="text-justify">
                    <b>2017, November, 9th</b>
                    <ul>
                      <li>17:00 - visit to MIC</li>
                      <li>18:30 - networking cocktail</li>
                    </ul>
                  </p>
                  <p class="text-justify">
                    <b>2017, november, 10th</b>
                    <ul>
                      <li>9:30 to 9:45 - registration and welcome coffee</li>
                      <li>9:45 to 10:30 - institutional greetings<br>
                        <ul>
                          <li>EACEA, European Commission</li>
                          <li>MIBACT-Ministry of Culture</li>
                          <li>USR, MIUR-Ministry of Education</li>
                          <li>Regione Lombardia</li>
                          <li>Comune di Milano</li>
                          <li>Fondazione Cineteca Italiana</li>
                        </ul>
                      </li>
                      <li>10:30 to 11:30 - Introduction to The Film Corner platform<br>
                        <ul>
                          <li>Fondazione Cineteca Italiana</li>
                          <li>Jugoslovenska Kinoteka</li>
                          <li>University of Milano-Bicocca</li>
                          <li>The Nerve Centre</li>
                          <li>The Film space</li>
                        </ul>
                      </li>
                      <li>11:30 to 11:45 - coffee break</li>
                      <li>11:45 to 13:30 - Film education and audience development in the digital era</li>
                      <li>13:30 to 14:30 - lunch break</li>
                      <li>14:30 to 16:00 - Best practices: a European panorama</li>
                      <li>16:00 to 16:15 - coffee break</li>
                      <li>16:15 to 17:30 - the role of cinémathèques in film education and audience development in the digital era</li>
                    </ul>
                  </p>
                </div>
                <div class="block-subtitle mt-5">
                  <h4>Registration and Deadline</h4>
                </div>
                <div class="block-text">
                  <p class="text-justify">
                    There are 180 places available for the conference and it is <b>free of charge</b>. If you’d like to join us, you can register using the form below <b>until 2017, july, 30th</b>. Keep updated through our social media accounts on Facebook and Twitter. Further details will be announced on the official website of The Film Corner.
                  </p>
                </div>
                <div class="block-subtitle mt-5">
                  <h4>Apply</h4>
                </div>
                <div class="block-text">
                  <p class="text-justify">
                    FORM FORM FORM FORM
                  </p>
                </div>
                <div class="block-subtitle mt-5">
                  <h4>Contacts and Informations</h4>
                </div>
                <div class="block-text mb-5">
                  <p class="text-justify">
                    Fondazione Cineteca Italiana<br>
                    Viale Fulvio Testi, 121<br>
                    20126 Milan<br>
                    Tel. +39 02 87 24 21 14<br>
                    <br>
                    Press office:<br>
                    Cristiana Ferrari<br>
                    <a href="mailto:ufficiostampa@cinetecamilano.it">ufficiostampa@cinetecamilano.it</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</main>
@endsection

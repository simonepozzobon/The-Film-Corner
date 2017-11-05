@extends('layouts.teacher')
@section('title', 'Welcome')
@section('content')
  <section id="title" class="pt-5">
    <div class="title sp-center pt-5 pb-5">
      Welcome
      <h2 class="p-2 block-title">Short Introduction</h2>
    </div>
  </section>
  <section class="pb-5 pr-5 pl-5">
    <div class="box container mb-4">
      <div class="row">
        <div class="col dark-blue py-3 px-5">
          <h3>Welcome to The Film Corner!</h3>
        </div>
      </div>
      <div class="row">
        <div class="col blue p-5">
          <p>
            The Film Corner is the interactive web platform dedicated to cinema,
            a website where you can surf through different STUDIOS and the corresponding educational projects,
            discovering and exploring the many aspects that underpin cinematographic language and grammar.<br>
            <br>
            We all have a relationship with cinema. The word “cinema” means something to each one of us,
            it reminds us of other worlds and other aspects of our lives. What is cinema for you?
            <strong>Think of 3 key words to describe your own relationship with cinema and write them in the cloud below.</strong><br>
            <br>
            Cinema is something big, something that often characterizes and enters our lives and we can experience in different ways.<br>
            However, when we decided to create The Film Corner, we asked ourselves which of these many aspects we would have liked to talk about.
            The answer we came up with is that The Film Corner would talk about two specific aspects of cinema: the formal and the creative ones.<br>
            <br>
            The reason why we wanted to approach cinema from this point of view is to be found in a question that we’d like you to try and answer:
            when you are watching a film, what is it that really gets to you of what you are seeing?
            <strong>Try and answer this question, then write your answer in the grid below.</strong><br>
            <br>
            Usually, the first piece of information that gets to us when watching a film is the emotion, which comes before we can even have the
            time to really start reflecting on what we see (the positioning of the camera, the editing choices, the selection of the soundtrack, etc.).
            Love, joy, hilarity, sadness, despair, detachment, coldness, or even concern, anguish, fear, are indeed emotions, sensations.
            But how does cinema do it? Behind each emotion we feel with cinema lays a conscious choice made by whoever made the film.
            In every picture there is a direct, and often very stark relationship between the emotions we feel and the visual, linguistic and grammatical
            choices made by the film creators. It may sound obvious, but there is a direct bond between creativity and critical reception of a film.
            That’s why we are interested in these two aspects!
          </p>
        </div>
      </div>
    </div>
    <div class="box container mb-4">
      <div class="row">
        <div class="col dark-orange py-3 px-5">
          <h3>Get Started</h3>
        </div>
      </div>
      <div class="row">
        <div class="col orange p-5">
          <p>
            The Film Corner is divided into 2 sections, called STUDIOS, each one dedicated to an aspect of Film Education:<br>
            <ul>
              <li>
                Studio 1 is dedicated to film language and aesthetics, meaning the grammar of films,
                the way in which they build their own speech and tell a story. This section is subdivided in
                three educational projects: the first one dedicated to framing, the second to editing, the third one to sound.
              </li>
              <li>
                Studio 2 is dedicated to filmmaking and creativity and it is also subdivided in three educational projects:
                the first one includes some “warming-up” exercises, the second is about writing for cinema and the third one
                is a space in which you’ll be invited to experiment the creation of a short movie, using even something as handy as a mobile phone.
              </li>
            </ul>
            These aspects are so different that they are even dedicated two separate spaces within our platform. However,
            they have something in common: they are both based on the knowledge of cinematographic language and grammar.
            In fact, it is impossible to either analyze or create a film without knowing its language and aesthetics.
            This is the reason why we invite you to visit STUDIO 1 before visiting STUDIO 2.<br>
          </p>
          <p class="text-center">
            <strong class="">Enjoy your trip in The Film Corner! See you outside!</strong>
          </p>
          <div class="pt-3 d-flex justify-content-around">
            <a href="{{ route('teacher') }}" class="btn btn-lg btn-secondary btn-orange"><i class="fa fa-hand-o-right"></i> Start</a>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

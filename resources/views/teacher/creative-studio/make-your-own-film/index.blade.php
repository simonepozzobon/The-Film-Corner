@extends('layouts.teacher', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')

@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_only', ['title' => $app->title])
    @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'teacher'])
    <div id="app">
      <div class="row mt">
        <div class="col">
          <div class="box blue">
            <div class="box-header">
              Terms of the competition
            </div>
            <div class="box-body">
              <p>
                1. These terms and conditions together with any specific rules set out in Competition Notices (as defined below) are the Competition Rules ("Rules") and apply to competitions ("Competition") featuring in any Johnston Press publications and/or on any Johnston Press Today series Internet site unless otherwise expressly stated. By entering a Competition, entrants agree to be bound by these Rules.
                <br>
                2.  Rules specific to each Competition are displayed in a notice on the page for such Competition ("Competition Notice") or in a notice in which the Competition appeared and are incorporated into the Rules. In the event of discrepancy between these terms and conditions and the Competition Notice, the Competition Notice shall prevail.
                <br>
                3. Johnston Press reserves the right to cancel or amend the Competition or the Rules without notice in the event of a catastrophe, war, civil or military disturbance, act of God or any actual or anticipated breach of any applicable law or regulation or any other event outside Johnston Press’s reasonable control. Any changes will be posted either within these terms and conditions or the Competition Notice. A copy of the Rules may also be obtained by contacting the relevant Promotions department of the publication in which the competition appeared.
                <br>
                4. In the event of any dispute regarding the Rules, conduct, results and all other matters relating to a Competition, the decision of the judge(s) shall be final and no correspondence or discussion shall be entered into.
                <br><br>
                Qualifying Entrants
                <br>
                5. To qualify to enter the Competition you must be resident in the United Kingdom, Republic of Ireland and/or the Isle of Man. The address you provide with your competition entry ("Entry") may be used to send any prizes so please make sure this is correct.
                <br>
                6. Employees of Johnston Press plc or any associated company of Johnston Press plc and their immediate families, persons connected with the competition/prize draw and their immediate families i.e. prize sponsors, newsagents, wholesalers & their agents are not eligible to enter the Competition.
                <br>
                7. Additional eligibility requirements may apply to a specific Competition, e.g. a valid passport, visas and/or driver's licence will be required if the Competition prize includes travel outside the United Kingdom and/or car hire.
                <br>
                8. By entering the Competition, you hereby warrant that all information submitted by you is true, current and complete. Johnston Press reserves the right to verify the eligibility of all entrants.
                <br>
                9. Johnston Press assumes that by reading the publication or by using the website and entering the Competition (and you warrant that) you are aged 18 or over or, if you are under 18, that your parents have consented to your entry into the Competition and these Rules.
                <br>
                10. Johnston Press reserves the right to disqualify any entrant if it has reasonable grounds to believe the entrant has breached any of the Rules.
                <br>
                11. In the event that any entrant is disqualified from the Competition, Johnston Press in its sole discretion may decide whether a replacement should be selected. In this event, any further entrant will be selected on the same criteria as the original entrant and will be subject to these Rules.
                <br><br>
                Competition Entries
                <br>
                12. Only one entry per person per Competition is allowed (except where the Competition Notice states that more than one entry can be submitted) and any entrant who enters more than the permitted maximum will be disqualified. Unless otherwise indicated photocopies of entry coupons are not accepted. Where a winner has been selected and Johnston Press discovers or has reasonable grounds to believe the winner has made more than one Entry, Johnston Press reserves the right to select an alternative winner. Any further winner will be selected on the same criteria as the original winner and will be subject to these Rules.
                <br>
                13. Competition entries must be made in the manner and by the closing date specified on the Competition Notice. Failure to do so will disqualify the entry.
                <br>
                14. Only one entry per person will be accepted. If it becomes apparent that a participant is using a computer(s) to circumvent this term by, for example, the use of 'brute force', 'script' or any other automated means, that person/those e-mail addresses will be disqualified and any prize award will be void.
                <br>
                15. There is no purchase requirement to enter an online Competition. There is no charge to register with a Johnston Press Today website if registration is required as part of the entry process. Johnston Press Group wide competitions may charge premium rate only entry and may not offer a free entry route.
                <br>
                16. Where an offer is made for participation in a Competition involving a premium rate telephone call (where charges are a minimum of 50 pence in addition to the standard network charge), the Competition Notice will include details of the charge and any other guidance to which Johnston Press must include in compliance with Phonepayplus rules. Where entry to a Competition is by premium rate service, a free entry route may also be provided at the discretion of the relevant Johnston Press publication.
                <br>
                17. Proof of posting or emailing cannot be accepted as proof of delivery. Johnston Press cannot accept responsibility for any error, omission, interruption, deletion, defect, delay in operation or transmission, communications line failure, theft, destruction, alteration of, or unauthorised access to Entries, or Entries lost or delayed whether or not arising during operation or transmission as a result of server functions, virus, bugs or other causes outside its control.
                <br>
                18. Entrants should note that unless stated otherwise, Johnston Press does not accept responsibility for the return of any Entries, including those consisting of artistic or other material.
                <br><br>
                Prizes
                <br>
                19. Prize winners will be chosen at random, unless specified otherwise in the Competition Notice, from all qualifying Entries within 28 days of the closing date specified in the Competition Notice. In all matters, the decision of the judge(s) shall be final and no correspondence or discussion shall be entered into.
                <br>
                20. Prize winners will be notified in the manner and within the time specified on the Competition Notice. Return of any prize notification as undeliverable or failure to reply as specified in the notification (and within the time stated) may result in disqualification and selection of an alternate winner. If more than one prize is awarded only one prize per entrant will be awarded. Competition winner(s)’ names may be published in the Johnston Press publication in which the competition appeared and on the relevant publication’s website.
                <br><br>
                Liability
                <br>
                30. Johnston Press cannot accept any responsibility for any damage, loss, injury or disappointment suffered by any entrant entering the Competition or as a result of accepting any prize. Johnston Press is not responsible for any problems or technical malfunction of any telephone network or lines, computer on-line systems, servers, or providers, computer equipment or software, failure of any email or entry to be received on account of technical problems or traffic congestion on the Internet, telephone lines or at any web site, or any combination thereof, including any injury or damage to entrant's or any other person's computer or mobile telephone related to or resulting from participation in the Competition. Nothing shall exclude Johnston Press’s liability for death or personal injury as a result of its negligence.
                <br><br>
                Data Protection and Publicity
                <br>
                31. Winners may be requested to take part in promotional activity and Johnston Press reserves the right to use the names and addresses of winners in any publicity both in paper and online.
                <br>
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt">
        <div class="col">
          <div class="box yellow">
            <div class="box-header">
              Submission
            </div>
            <div id="response" class="box-body">
              <form id="uploadForm" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <div class="form-group">
                  <input id="media" type="file" name="media" class="form-control">
                </div>
                <input id="videoRef" type="hidden" name="video_ref" value="21">
                <div class="container-fluid d-flex justify-content-around">
                  <button type="submit" name="button" class="btn btn-yellow"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script>
    var AppSession = new TfcSessions();
    var session = AppSession.initSession({{ $app->id }});

    $('body').on('session-loaded', function(e, session){
      console.log('sessione caricata '+session.token);

      $('form#uploadForm').submit(function(event) {
        event.preventDefault();
        $(this).addClass('disable');

        var formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('media', $('#media')[0].files[0]);
        formData.append('session', session.token);

        $.ajax({
          type: 'post',
          url:  '{{ route('teacher.creative-studio.upload', [$app_category, $app->slug]) }}',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            console.log(response);
            $('#error').remove();
            $('#uploadForm').remove();
            var data = '';
            data += '<h3 class="text-center pb-4 text-success">Your video has been sent!</h3>';
            data += '<h6 class="text-center pb-4 text-success">One last step, give it a title and save it!</h6>';
            $('#response').append(data);

            var video = {
                'img' : response.img,
                'video' : response.src
            };

            localStorage.setItem('app-17-video', JSON.stringify(video));
          },
          error: function (errors) {
            console.log(errors);
            $('#error').remove();
            var data = '';
            data += '<h6 id="error" class="text-center py-4 text-danger">'+errors.responseJSON.msg+'</h6>'
            $('#response').append(data);
          }
        });
      });
    });
  </script>
@endsection

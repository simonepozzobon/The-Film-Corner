{{-- Feedback --}}
<div class="feedback-popup mt-4">
  <div class="d-block m-1">
    <a class="text-white text-align-center btn btn-success btn-lg" data-toggle="modal" data-target="#positiveFeedback">
      <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
    </a>
  </div>
  <div class="d-block m-1">
    <a class="text-white text-align-center btn btn-danger btn-lg" data-toggle="modal" data-target="#negativeFeedback">
      <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
    </a>
  </div>
</div>

{{-- Feedback modals --}}
{{-- Positive --}}
<div class="" ng-controller="feedbackCtrl">
  <div class="modal fade" id="positiveFeedback" tabindex="-1" role="dialog" aria-labelledby="positiveFeedbackLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form ng-submit="sendFeeback('positive')">
          {{ csrf_field() }}
          {{ method_field('POST') }}

          <div class="modal-header">
            <h5 class="modal-title" id="positiveFeedbackLabel">Your opinion is important</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="">Comments:</label>
              <textarea name="comments" rows="12" class="form-control" ng-model="feedbackData.comments"></textarea>
            </div>
            <p>
              Thanks, every suggestion will be usefull!
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Negative --}}
  <div class="modal fade" id="negativeFeedback" tabindex="-1" role="dialog" aria-labelledby="negativeFeedbackLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form ng-submit="sendFeedback('negative')">
          {{ csrf_field() }}
          {{ method_field('POST') }}

          <div class="modal-header">
            <h5 class="modal-title" id="negativeFeedbackLabel">Your opinion is important</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="">Comments:</label>
              <textarea name="comments" rows="12" class="form-control" ng-model="feedbackData.comments"></textarea>
            </div>
            <p>
              Thanks, every suggestion will be usefull!
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

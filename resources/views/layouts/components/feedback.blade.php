<div class="" ng-controller="feedbackController">
{{-- Feedback --}}
  <div class="feedback-popup mt-4">
    <div class="d-block m-1">
      <a class="text-white text-align-center btn btn-success btn-lg" data-toggle="modal" data-target="#positiveFeedback" ng-click="setPositive()">
        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
      </a>
    </div>
    <div class="d-block m-1">
      <a class="text-white text-align-center btn btn-danger btn-lg" data-toggle="modal" data-target="#negativeFeedback" ng-click="setNegative()">
        <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
      </a>
    </div>
  </div>

{{-- Feedback modals --}}
{{-- Positive --}}
  <div class="modal fade" id="positiveFeedback" tabindex="-1" role="dialog" aria-labelledby="positiveFeedbackLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form ng-submit="sendFeedback()">
          {{ csrf_field() }}
          {{ method_field('POST') }}

          <div class="modal-header">
            <h5 class="modal-title" id="positiveFeedbackLabel">Your opinion is important</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="status" ng-value="positive" ng-model="feedbackData.status">
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
            <button type="submit" class="btn btn-primary"  data-dismiss="modal">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Negative --}}
  <div class="modal fade" id="negativeFeedback" tabindex="-1" role="dialog" aria-labelledby="negativeFeedbackLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form ng-submit="sendFeedback()" method="post">
          {{ csrf_field() }}
          {{ method_field('POST') }}
          <input type="hidden" name="status" ng-value="negative" ng-model="feedbackData.status">
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
            <button type="submit" class="btn btn-primary"  data-dismiss="modal">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

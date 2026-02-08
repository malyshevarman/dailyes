@if(auth()->id() && auth()->id() == $event->user->id && $comment->answers->count() <= 0)
  <div class="col-md-12">
      <event-reivew-answers-form :comment="{{$comment}}" :event="{{$event}}"></event-reivew-answers-form>
  </div>
@endif

@if(auth()->id() && auth()->id() == $company->user->id && $comment->answers->count() <= 0)
  <div class="col-md-12">
      <company-reivew-answers-form :company="{{$company}}" :comment="{{$comment}}"></company-reivew-answers-form>
  </div>
@endif

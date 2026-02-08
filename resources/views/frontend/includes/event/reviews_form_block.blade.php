
  <div class="col-md-12">

      @if($event->comments()->published()->count()==0)
          <div class="info_block">
              <div>Скоро здесь появится информация про отзывы</div>
          </div>
      @endif

      @if (auth()->id() !== $event->user->id)
        @if (!auth()->id())
          <a data="1" class="write_review">Написать отзыв</a>
        @else
          @if (auth()->id() && !$event->comments->where('text', '!=', null)->contains('user_id', auth()->id()))
          <a class="write_review">Написать отзыв</a>
          @endif
        @endif
      @endif
      @if(auth()->id() && !$event->comments->where('text', '!=', null)->contains('user_id', auth()->id()))
      <event-reivews-form :event="{{$event}}" :user_rating="{{!is_null($event->user_rating) ? $event->user_rating : '{}'}}" :user_recommendation="{{!is_null($event->user_recommendation) ? $event->user_recommendation : '{}'}}"></event-reivews-form>
      @endif
  </div>

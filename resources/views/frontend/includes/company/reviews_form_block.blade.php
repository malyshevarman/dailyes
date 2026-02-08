<div class="col-md-12">

    @if($company->comments()->published()->count()==0)
        <div class="info_block">
            <div>Скоро здесь появится информация про отзывы</div>
        </div>
    @endif

  @if (auth()->id() !== $company->user->id)
        @if (!auth()->id())
          <a data="1" class="write_review">Написать отзыв</a>
        @else
          @if (auth()->id() && !$company->comments->where('text', '!=', null)->contains('user_id', auth()->id()))
          <a class="write_review">Написать отзыв</a>
          @endif
        @endif
      @endif
  @if(auth()->id() && !$company->comments->where('text', '!=', null)->contains('user_id', auth()->id()))
  <company-reivews-form :company="{{$company}}" :user_rating="{{!is_null($company->user_rating) ? $company->user_rating : '{}'}}" :user_recommendation="{{!is_null($company->user_recommendation) ? $company->user_recommendation : '{}'}}"></company-reivews-form>
  @endif
</div>

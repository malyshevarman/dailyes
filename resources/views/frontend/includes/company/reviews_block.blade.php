<div class="col-md-12 review-close">
    @foreach($company->comments()->published()->get() as $comment)
        <div class="review">
            <div class="review-block">
                <div class="review-block__fixed">
                    <div class="v-align">
                        @if($comment->rec)
                            <div class="review-block__fixed-thumb-up"></div><span>Рекомендую</span>@endif
                            @if($comment->star) <div class="review-block__fixed-star"></div>
                        <span>{{ $comment->star }}</span>
                            @endif
                    </div>
                </div>
                <div class="v-align">
                    <div class="review-block__avatar">
                        <img src="/images/avatarblack.svg"/>
                    </div>
                    <div class="review-block__title">
                        {{ $comment->user->name }}<br>
                        <span>Дата отзыва: {{ $comment->created_at->locale('ru')->isoFormat('D MMMM YYYY') }}</span>
                    </div>
                </div>
                <div class="review-block__text">
                    {{ $comment->text }}
                    @if($comment->answers->count() > 0)
                        <div class="review-block__comments">
                            <!-- <div class="v-align">
                                <span class="review-block__comments-count">Ответ компании</span>

                            </div> -->
                            <div class="review-block__comments-row">

                                @foreach($comment->answers()->published()->get() as $answer)
                                    <div class="review-block__comments-list">
                                        <div class="v-align">
                                            <div class="review-block__comments-list-avatar">
                                                <img src="/images/avatarblack.svg"/>
                                            </div>
                                            <div class="review-block__comments-list-title">


                                                    {{$company->name ?? ''}}
                                                        <br>
                                                    <span>Дата ответа: {{ $answer->created_at->locale('ru')->isoFormat('D MMMM YYYY') }}</span>




                                            </div>
                                        </div>
                                        <div class="review-block__comments-list-text">
                                            {{ $answer->text }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                @include('frontend.includes.company.reviews_answer_form_block', ['comment' => $comment, 'company' => $company])
                @if(auth()->id() && auth()->id() == $company->user->id && $comment->answers->count() <= 0)
                <div class="review-block__comments-list-reply">
                <span>Ответить</span>
                </div>
                @endif
                <div class="review-block__nav">
                    <!-- <div class="v-align"><span class="review-block__nav-more">Отзыв полностью</span> -->
                        {{--<div class="review-block__nav-comments openComments">{{ $comment->answers->count() }}</div>--}}
                    <!-- </div> -->
                </div>
            </div>
        </div>
    @endforeach
</div>
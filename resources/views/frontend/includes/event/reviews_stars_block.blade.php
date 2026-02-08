<div class="text-block__title">
    Отзывы
</div><a id="titlereviews" name="titlereviews"></a>
<div class="reviews-nav">
    <!-- <div class="reviews-nav__reviews active">
        <span>Отзывы</span>
        <div class="count">{{ $event->comments ? $event->comments->count() : 0 }}</div>
    </div> -->
    <!-- <div class="reviews-nav__questions">
        <span>Вопросы</span>
        <div class="count">{{ $event->questions ? $event->questions->count() : 0 }}</div>
    </div> -->
</div>
<div class="reviews-rating">
    <div class="reviews-rating__count">
        <span>{{ round($event->star, 1) }}</span> / Из 5
    </div>
    <div class="reviews-rating__stars">
        <label class="star-raiting-blue"></label><label class="star-raiting-blue"></label><label
                class="star-raiting-blue"></label><label class="star-raiting-blue"></label><label
                class="star-raiting-blue"></label><br>
        <label class="star-raiting-blue"></label><label class="star-raiting-blue"></label><label
                class="star-raiting-blue"></label><label class="star-raiting-blue"></label><label
                class="star-raiting-white"></label><br>
        <label class="star-raiting-blue"></label><label class="star-raiting-blue"></label><label
                class="star-raiting-blue"></label><label class="star-raiting-white"></label><label
                class="star-raiting-white"></label><br>
        <label class="star-raiting-blue"></label><label class="star-raiting-blue"></label><label
                class="star-raiting-white"></label><label class="star-raiting-white"></label><label
                class="star-raiting-white"></label><br>
        <label class="star-raiting-blue"></label><label class="star-raiting-white"></label><label
                class="star-raiting-white"></label><label class="star-raiting-white"></label><label
                class="star-raiting-white"></label>
    </div>
    @if($event->count_stars > 0)
    <div class="reviews-rating__progress">
        @for ($i = 5; $i > 0; $i--)
            <div class="v-align">
                <div class="reviews-rating__progress-place">
                    <div style="width: {{ isset($event->rating_results_array[$i]) ? round($event->rating_results_array[$i] / $event->count_stars * 100, 0) : 0 }}%"
                         class="reviews-rating__progress-bar"></div>
                </div>
                <div class="reviews-rating__progress-count">{{ isset($event->rating_results_array[$i]) ? $event->rating_results_array[$i] : 0 }}</div>
            </div>
        @endfor
    </div>
    @endif
</div>
<div class="calc-block calc-block-review">
    @if(!auth()->id())<div><a style="cursor: pointer; color: #137CD6;" data="1" class="authPanel">Войдите в свой профиль</a>, что бы оставить отзыв, комментарий или задать
        вопрос</div>@endif
    <div>Для расчета рейтинга используются общие оценки по характеристикам за все время</div>
</div>
<div class="calc-block calc-block-question" style="display: none;">
    @if(!auth()->id())<div><a style="cursor: pointer; color: #137CD6;" data="1" class="authPanel">Войдите в свой профиль</a>, что бы оставить отзыв, комментарий или задать
        вопрос</div>@endif
</div>
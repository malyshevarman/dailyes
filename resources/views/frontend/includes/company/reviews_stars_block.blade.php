<div class="text-block__title" >
    Отзывы
</div><a id="titlereviews" name="titlereviews"></a>

<div class="reviews-rating">
    <div class="reviews-rating__count">
        <span>{{ round($company->star, 1) }}</span> / Из 5
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
    @if($company->count_stars > 0)
    <div class="reviews-rating__progress">
        @for ($i = 5; $i > 0; $i--)
            <div class="v-align">
                <div class="reviews-rating__progress-place">
                    <div style="width: {{ isset($company->rating_results_array[$i]) ? round($company->rating_results_array[$i] / $company->count_stars * 100, 0) : 0 }}%"
                         class="reviews-rating__progress-bar"></div>
                </div>
                <div class="reviews-rating__progress-count">{{ isset($company->rating_results_array[$i]) ? $company->rating_results_array[$i] : 0 }}</div>
            </div>
        @endfor
    </div>
    @endif
</div>
<div class="calc-block">
    <div>Для расчета рейтинга используются общие оценки по характеристикам за все время</div>
    @if(!auth()->id())<div><a style="cursor: pointer; color: #137CD6;" data="1" class="authPanel">Войдите в свой профиль</a>, что бы оставить отзыв, комментарий или задать
        вопрос</div>@endif
</div>
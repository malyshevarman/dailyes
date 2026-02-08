<div class="row">
    <div class="col-md-12 question-close">
        @foreach($event->questions as $question)
            <div class="question">
                <div class="question-block">
                    <div class="v-align">
                        <div class="question-block__avatar">
                            <img src="/images/avatarblack.svg"/>
                        </div>
                        <div class="question-block__title">
                            {{ $question->user->name }}<br>
                            <span>Дата вопроса: {{ $question->created_at->locale('ru')->isoFormat('D MMMM YYYY') }}</span>
                        </div>
                    </div>
                    <div class="question-block__text">
                        {{ $question->text }}
                    </div>
                    <div class="question-block__nav">
                        <div class="v-align"><span
                                    class="question-block__nav-more">Отзыв полностью</span>
                            {{--<div class="question-block__nav-comments openQuestion">{{ $question->answers->count() }}</div>--}}
                        </div>
                    </div>
                </div>
                @if($question->answers->count() > 0)
                    <div class="question-block__comments">


                        <div class="v-align">
                            <span class="question-block__comments-count">{{ $question->answers->count() }} {{ pular($question->answers->count(), ['комментарий', 'комментария', 'комментариев']) }}</span>
                            <span class="question-block__comments-hide">Свернуть комментарии <i
                                        class="fas fa-chevron-up"></i></span>
                        </div>
                        <div class="question-block__comments-row">
                            @foreach($question->answers as $answer)
                                <div class="question-block__comments-list">
                                    <div class="v-align">
                                        <div class="question-block__comments-list-avatar">
                                            <img src="/images/avatarblack.svg"/>
                                        </div>
                                        <div class="question-block__comments-list-title">


                                                @if($answer->user->hasRole('admin'))
                                                    Администратор@else{{ $answer->user->name }}@endif
                                                <br>
                                                <span>Дата: {{ $answer->created_at->locale('ru')->isoFormat('D MMMM YYYY') }}@if($answer->user->hasRole('admin'))
                                                        (администратор) @endif</span>



                                        </div>
                                    </div>
                                    <div class="question-block__comments-list-text">
                                        {{ $answer->text }}
                                    </div>
                                    {{--@if(auth()->id() && auth()->id() != $answer->user->id)--}}
                                    {{--<div class="review-block__comments-list-reply">--}}
                                    {{--<span>Ответить</span>--}}
                                    {{--</div>--}}
                                    {{--@endif--}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
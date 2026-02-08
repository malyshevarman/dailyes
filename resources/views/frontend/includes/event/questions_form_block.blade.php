<button class="write_questions">Задать вопрос</button>
<div class="onwrite-quest">
    <div class="v-align">
        <div class="onwrite-quest__avatar">
            <img src="/images/avatarblack.svg"/>
        </div>
        <div class="onwrite-quest__title">
            {{ auth()->user()->name }}<br>
            <span>Пользователь</span>
        </div>
    </div>
    <form action="{{ route('frontend.event.question', $event) }}" method="post">
        {{ csrf_field() }}
        <textarea name="review" placeholder="Напишите здесь вопрос"></textarea>
        <div class="v-align">
            <div class="onwrite-quest__button">
                <button type="submit">Опубликовать</button>
                <span class="closeQuest">Отменить</span>
            </div>
        </div>
    </form>
</div>
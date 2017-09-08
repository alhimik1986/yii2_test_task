<?php

namespace app\modules\news\components;

use yii\base\Component;

class NewsEvents extends Component
{
	// Новость опубликована (статус изменился на активный)
    const EVENT_NEWS_PUBLISHED = 'event_news_published';
    // Авторизованный пользователь посетил страницу новостей
    const EVENT_NEWS_LIST_VISITED = 'event_news_list_visited';
}
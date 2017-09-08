<?php

namespace app\modules\users\components;

use yii\base\Component;

class UsersEvents extends Component
{
    const EVENT_USER_CREATED = 'event_user_created';
    
    const EVENT_PASSWORD_CHANGED_BY_ADMIN = 'event_password_changed_by_admin';
}
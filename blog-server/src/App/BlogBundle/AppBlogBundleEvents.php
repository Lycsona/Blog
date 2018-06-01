<?php

namespace App\BlogBundle;


class AppBlogBundleEvents
{
    const GET_ENTITY_ERROR = 'getEntity';
    const CREATE_ENTITY_ERROR = 'createEntity';
    const UPDATE_ENTITY_ERROR = 'createEntity';
    const DELETE_ENTITY_ERROR = 'getEntity';

    const PAGE_VIEW_EVENT = 'setIncrementPageViews';
    const INCORRECT_LOGIN_EVENT = 'sendMailIncorrectLoginAttempts';
}
<?php

return [
  'client_id' => env('LARADIT_CLIENT_ID'),
  'client_secret' => env('LARADIT_CLIENT_SECRET'),
  'oauth_redirect_uri' => env('LARADIT_OAUTH_CLIENT_REDIRECT_URL'),
  'user_agent' => env('LARADIT_USER_AGENT', 'laradit'),
  'reddit_username' => env('LARADIT_REDDIT_USERNAME'),
  'reddit_password' => ENV('LARADIT_REDDIT_PASSWORD'),
  'type_script' => ENV('LARADIT_TYPE_SCRIPT')
];

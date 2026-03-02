<?php

/**
 * Generate application URL
 */
function url(string $page, array $params = []): string
{
    $url = APP_URL . '?page=' . $page;

    if (!empty($params)) {
        $url .= '&' . http_build_query($params);
    }

    return $url;
}

/**
 * Redirect to a page
 */
function redirect(string $page, array $params = []): void
{
    header('Location: ' . url($page, $params));
    exit;
}

/**
 * Get Auth instance
 */
function auth()
{
    global $auth;
    return $auth;
}

/**
 * Get current logged user
 */
function user()
{
    global $auth;
    return $auth ? $auth->getCurrentUser() : null;
}

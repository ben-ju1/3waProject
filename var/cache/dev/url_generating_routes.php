<?php

// This file has been auto-generated by the Symfony Routing Component.

return [
    '_preview_error' => [['code', '_format'], ['_controller' => 'error_controller::preview', '_format' => 'html'], ['code' => '\\d+'], [['variable', '.', '[^/]++', '_format', true], ['variable', '/', '\\d+', 'code', true], ['text', '/_error']], [], []],
    '_wdt' => [['token'], ['_controller' => 'web_profiler.controller.profiler::toolbarAction'], [], [['variable', '/', '[^/]++', 'token', true], ['text', '/_wdt']], [], []],
    '_profiler_home' => [[], ['_controller' => 'web_profiler.controller.profiler::homeAction'], [], [['text', '/_profiler/']], [], []],
    '_profiler_search' => [[], ['_controller' => 'web_profiler.controller.profiler::searchAction'], [], [['text', '/_profiler/search']], [], []],
    '_profiler_search_bar' => [[], ['_controller' => 'web_profiler.controller.profiler::searchBarAction'], [], [['text', '/_profiler/search_bar']], [], []],
    '_profiler_phpinfo' => [[], ['_controller' => 'web_profiler.controller.profiler::phpinfoAction'], [], [['text', '/_profiler/phpinfo']], [], []],
    '_profiler_search_results' => [['token'], ['_controller' => 'web_profiler.controller.profiler::searchResultsAction'], [], [['text', '/search/results'], ['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], []],
    '_profiler_open_file' => [[], ['_controller' => 'web_profiler.controller.profiler::openAction'], [], [['text', '/_profiler/open']], [], []],
    '_profiler' => [['token'], ['_controller' => 'web_profiler.controller.profiler::panelAction'], [], [['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], []],
    '_profiler_router' => [['token'], ['_controller' => 'web_profiler.controller.router::panelAction'], [], [['text', '/router'], ['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], []],
    '_profiler_exception' => [['token'], ['_controller' => 'web_profiler.controller.exception_panel::body'], [], [['text', '/exception'], ['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], []],
    '_profiler_exception_css' => [['token'], ['_controller' => 'web_profiler.controller.exception_panel::stylesheet'], [], [['text', '/exception.css'], ['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], []],
    'admin_home' => [[], ['_controller' => 'App\\Controller\\AdminController::adminHome'], [], [['text', '/lr-adm']], [], []],
    'admin_article_add' => [[], ['_controller' => 'App\\Controller\\AdminController::formArticle'], [], [['text', '/lr-adm/article/add']], [], []],
    'admin_article_edit' => [['article'], ['article' => null, '_controller' => 'App\\Controller\\AdminController::formArticle'], [], [['variable', '/', '[^/]++', 'article', true], ['text', '/lr-adm/article/edit']], [], []],
    'admin_article_delete' => [['article'], ['_controller' => 'App\\Controller\\AdminController::deleteArticle'], [], [['variable', '/', '[^/]++', 'article', true], ['text', '/lr-adm/article/remove']], [], []],
    'admin_user_management' => [['user'], ['user' => null, '_controller' => 'App\\Controller\\AdminController::userManagement'], [], [['variable', '/', '[^/]++', 'user', true], ['text', '/lr-adm/utilisateurs']], [], []],
    'admin_user_delete' => [['user'], ['_controller' => 'App\\Controller\\AdminController::deleteUser'], [], [['variable', '/', '[^/]++', 'user', true], ['text', '/lr-adm/utilisateur/remove']], [], []],
    'admin_category_add' => [[], ['_controller' => 'App\\Controller\\AdminController::addCategory'], [], [['text', '/lr-adm/categorie/add']], [], []],
    'admin_category_delete' => [['category'], ['category' => null, '_controller' => 'App\\Controller\\AdminController::removeCategory'], [], [['variable', '/', '[^/]++', 'category', true], ['text', '/lr-adm/categorie/remove']], [], []],
    'article_show' => [[], ['_controller' => 'App\\Controller\\ArticleController::showArticles'], [], [['text', '/article']], [], []],
    'search' => [[], ['_controller' => 'App\\Controller\\ArticleController::searchAction'], [], [['text', '/search']], [], []],
    'full_article' => [['article'], ['article' => null, '_controller' => 'App\\Controller\\ArticleController::readMoreArticle'], [], [['variable', '/', '[^/]++', 'article', true], ['text', '/article']], [], []],
    'home' => [[], ['_controller' => 'App\\Controller\\HomeController::homePage'], [], [['text', '/']], [], []],
    'about' => [[], ['_controller' => 'App\\Controller\\HomeController::aboutPage'], [], [['text', '/notre-église']], [], []],
    'join-us' => [[], ['_controller' => 'App\\Controller\\HomeController::howPage'], [], [['text', '/rejoignez-nous']], [], []],
    'signal' => [[], ['_controller' => 'App\\Controller\\HomeController::signalPage'], [], [['text', '/signaler']], [], []],
    'contact' => [[], ['_controller' => 'App\\Controller\\HomeController::contactPage'], [], [['text', '/contact']], [], []],
    'security_registration' => [[], ['_controller' => 'App\\Controller\\SecurityController::registration'], [], [['text', '/inscription']], [], []],
    'security_login' => [[], ['_controller' => 'App\\Controller\\SecurityController::login'], [], [['text', '/connexion']], [], []],
    'security_logout' => [[], ['_controller' => 'App\\Controller\\SecurityController::logout'], [], [['text', '/deconnexion']], [], []],
    'mail_verification' => [['token'], ['_controller' => 'App\\Controller\\SecurityController::tokenValidation'], [], [['variable', '/', '[^/]++', 'token', true]], [], []],
    'app_security_testo' => [[], ['_controller' => 'App\\Controller\\SecurityController::testo'], [], [['text', '/testo']], [], []],
    'user_profile' => [[], ['_controller' => 'App\\Controller\\UserController::userProfile'], [], [['text', '/utilisateur/profile/']], [], []],
    'json_profile' => [[], ['_controller' => 'App\\Controller\\UserController::profileSettings'], [], [['text', '/json/profile']], [], []],
    'edit_personnal_settings' => [[], ['_controller' => 'App\\Controller\\UserController::editPersonnalSettings'], [], [['text', '/utilisateur/edit-personnal-settings']], [], []],
    'edit_account_settings' => [[], ['_controller' => 'App\\Controller\\UserController::editAccountSettings'], [], [['text', '/utilisateur/edit-account-settings']], [], []],
];
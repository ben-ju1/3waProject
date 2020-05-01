<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/lr-adm' => [[['_route' => 'admin_home', '_controller' => 'App\\Controller\\AdminController::adminHome'], null, null, null, false, false, null]],
        '/lr-adm/article/add' => [[['_route' => 'admin_article_add', '_controller' => 'App\\Controller\\AdminController::formArticle'], null, null, null, false, false, null]],
        '/lr-adm/categorie/add' => [[['_route' => 'admin_category_add', '_controller' => 'App\\Controller\\AdminController::addCategory'], null, null, null, false, false, null]],
        '/article' => [[['_route' => 'article_show', '_controller' => 'App\\Controller\\ArticleController::showArticles'], null, null, null, false, false, null]],
        '/search' => [[['_route' => 'search', '_controller' => 'App\\Controller\\ArticleController::searchAction'], null, null, null, false, false, null]],
        '/' => [[['_route' => 'home', '_controller' => 'App\\Controller\\HomeController::homePage'], null, null, null, false, false, null]],
        '/notre-église' => [[['_route' => 'about', '_controller' => 'App\\Controller\\HomeController::aboutPage'], null, null, null, false, false, null]],
        '/rejoignez-nous' => [[['_route' => 'join-us', '_controller' => 'App\\Controller\\HomeController::howPage'], null, null, null, false, false, null]],
        '/signaler' => [[['_route' => 'signal', '_controller' => 'App\\Controller\\HomeController::signalPage'], null, null, null, false, false, null]],
        '/contact' => [[['_route' => 'contact', '_controller' => 'App\\Controller\\HomeController::contactPage'], null, null, null, false, false, null]],
        '/inscription' => [[['_route' => 'security_registration', '_controller' => 'App\\Controller\\SecurityController::registration'], null, null, null, false, false, null]],
        '/connexion' => [[['_route' => 'security_login', '_controller' => 'App\\Controller\\SecurityController::login'], null, null, null, false, false, null]],
        '/deconnexion' => [[['_route' => 'security_logout', '_controller' => 'App\\Controller\\SecurityController::logout'], null, null, null, false, false, null]],
        '/utilisateur/profile' => [[['_route' => 'user_profile', '_controller' => 'App\\Controller\\UserController::userProfile'], null, null, null, true, false, null]],
        '/json/profile' => [[['_route' => 'json_profile', '_controller' => 'App\\Controller\\UserController::profileSettings'], null, null, null, false, false, null]],
        '/utilisateur/edit-personnal-settings' => [[['_route' => 'edit_personnal_settings', '_controller' => 'App\\Controller\\UserController::editPersonnalSettings'], null, null, null, false, false, null]],
        '/utilisateur/edit-account-settings' => [[['_route' => 'edit_account_settings', '_controller' => 'App\\Controller\\UserController::editAccountSettings'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:102)'
                            .'|router(*:116)'
                            .'|exception(?'
                                .'|(*:136)'
                                .'|\\.css(*:149)'
                            .')'
                        .')'
                        .'|(*:159)'
                    .')'
                .')'
                .'|/lr\\-adm/(?'
                    .'|article/(?'
                        .'|edit(?:/([^/]++))?(*:210)'
                        .'|remove/([^/]++)(*:233)'
                    .')'
                    .'|utilisateur(?'
                        .'|s(?:/([^/]++))?(*:271)'
                        .'|/remove/([^/]++)(*:295)'
                    .')'
                    .'|categorie/remove(?:/([^/]++))?(*:334)'
                .')'
                .'|/article(?:/([^/]++))?(*:365)'
                .'|/([^/]++)(*:382)'
                .'|/testo(*:396)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        102 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        116 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        136 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        149 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        159 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        210 => [[['_route' => 'admin_article_edit', 'article' => null, '_controller' => 'App\\Controller\\AdminController::formArticle'], ['article'], null, null, false, true, null]],
        233 => [[['_route' => 'admin_article_delete', '_controller' => 'App\\Controller\\AdminController::deleteArticle'], ['article'], null, null, false, true, null]],
        271 => [[['_route' => 'admin_user_management', 'user' => null, '_controller' => 'App\\Controller\\AdminController::userManagement'], ['user'], null, null, false, true, null]],
        295 => [[['_route' => 'admin_user_delete', '_controller' => 'App\\Controller\\AdminController::deleteUser'], ['user'], null, null, false, true, null]],
        334 => [[['_route' => 'admin_category_delete', 'category' => null, '_controller' => 'App\\Controller\\AdminController::removeCategory'], ['category'], null, null, false, true, null]],
        365 => [[['_route' => 'full_article', 'article' => null, '_controller' => 'App\\Controller\\ArticleController::readMoreArticle'], ['article'], null, null, false, true, null]],
        382 => [[['_route' => 'mail_verification', '_controller' => 'App\\Controller\\SecurityController::tokenValidation'], ['token'], null, null, false, true, null]],
        396 => [
            [['_route' => 'app_security_testo', '_controller' => 'App\\Controller\\SecurityController::testo'], [], null, null, false, false, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];

<?php

/**
  * TWIG (VIEW)
  */
  $container['twig_profile'] = function () {
    return new Twig_Profiler_Profile();
};

 $container['view'] = function ($c) {
     $settings = $c->get('settings');
     $view     = new \Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);
     $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
     $view->addExtension(new Twig_Extension_Debug());
     $view->getEnvironment()->addGlobal('current_router', $c->get('request')->getUri()->getPath());
     
     if ($c->get('settings')['debug']) {
         $view->addExtension(new Twig_Extension_Profiler($c['twig_profile']));
     }

     $session = $c->sessionHelper->get();
     if (!empty($session['usuario_sessao'])) {
         $view->getEnvironment()->addGlobal('usuario_sessao', $session['usuario_sessao']);
     }
     return $view;
 };
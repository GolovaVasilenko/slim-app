<?php

namespace App\Controllers;


use App\Services\PageServiceManager;

class PageController extends AbstractController
{
    public function index($request, $response, $args)
    {
        $sm = new PageServiceManager($this->container);

        $page = $sm->findByColumn('slug', 'home');
        $args['page'] = $page;

        return $this->view->render($response, 'pages/page.twig', $args);
    }

    public function show($request, $response)
    {
        $slug = trim($request->getRequestTarget(), "/");
        $sm = new PageServiceManager($this->container);
        $page = $sm->findByColumn('slug', $slug);
        $args['page'] = $page;

        return $this->view->render($response, 'pages/page.twig', $args);
    }
}
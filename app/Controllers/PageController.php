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

    public function pagesList($request, $response)
    {
        $sm = new PageServiceManager($this->container);

        $pages = $sm->all();

        return $this->view->render($response, 'admin/pages/index.twig', ['pages' => $pages]);
    }

    public function add($request, $response)
    {
        $messages = $this->container->get('flash')->getMessages();

        return $this->view->render($response, 'admin/pages/add.twig', ['messages' => $messages]);
    }

    public function store($request, $response)
    {
        $sm = new PageServiceManager($this->container);
    }

    public function edit($request, $response)
    {

    }

    public function update($request, $response)
    {

    }

    public function delete($request, $response)
    {

    }
}
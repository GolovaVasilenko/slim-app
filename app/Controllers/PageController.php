<?php

namespace App\Controllers;

use App\Services\PageServiceManager;
use Slim\Http\Request;
use Slim\Http\Response;

class PageController extends AbstractController
{
    /**
     * @param $request
     * @param $response
     * @param $args
     * @return mixed
     */
    public function index(Request $request, Response $response, $args)
    {
        $sm = new PageServiceManager($this->container);

        $page = $sm->findByColumn('slug', 'home');
        $args['page'] = $page;

        return $this->view->render($response, 'pages/page.twig', $args);
    }

    /**
     * @param $request
     * @param $response
     * @return mixed
     */
    public function show(Request $request, Response $response)
    {
        $slug = trim($request->getRequestTarget(), "/");
        $sm = new PageServiceManager($this->container);
        $page = $sm->findByColumn('slug', $slug);
        $args['page'] = $page;

        return $this->view->render($response, 'pages/page.twig', $args);
    }

    /**
     * @param $request
     * @param $response
     * @return mixed
     */
    public function pagesList(Request $request, Response $response)
    {
        $messages = $this->container->get('flash')->getMessages();

        $sm = new PageServiceManager($this->container);

        $pages = $sm->all();

        return $this->view->render($response, 'admin/pages/index.twig', ['pages' => $pages, 'messages' => $messages]);
    }

    public function add(Request $request, Response $response)
    {
        $messages = $this->container->get('flash')->getMessages();

        return $this->view->render($response, 'admin/pages/add.twig', ['messages' => $messages]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return static
     */
    public function store(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $sm = new PageServiceManager($this->container);

        if($insertId = $sm->insert($data)) {
            $this->container->get('flash')->addMessage('success', 'Page is successful added');
            return $response->withRedirect('/admin/pages');
        }

        $this->container->get('flash')->addMessage('errors', 'Page is not added ERROR');
        return $response->withRedirect('/admin/page/add');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function edit(Request $request, Response $response)
    {
        $messages = $this->container->get('flash')->getMessages();
        $id = $request->getAttribute('id');
        $sm = new PageServiceManager($this->container);
        $page = $sm->find($id);
        return $this->view->render($response, 'admin/pages/edit.twig', ['page' => $page,'messages' => $messages]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return static
     */
    public function update(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $sm = new PageServiceManager($this->container);
        $sm->update($data);

        $this->container->get('flash')->addMessage('success', 'Page is successful updated');
        return $response->withRedirect('/admin/page/edit/'. (int) $data['id']);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return static
     */
    public function delete(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $sm = new PageServiceManager($this->container);
        $sm->remove($id);

        $this->container->get('flash')->addMessage('success', 'Page is successful deleted');
        return $response->withRedirect('/admin/pages');
    }
}
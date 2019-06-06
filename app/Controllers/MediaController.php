<?php

namespace App\Controllers;


use App\Services\MediaServiceManager;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use App\Helpers\FileUploader;

class MediaController extends AdminController
{
    public function index(Request $request, Response $response)
    {
        $messages = $this->container->get('flash')->getMessages();

        $sm = new MediaServiceManager($this->container);
        $items = $sm->all();
        return $this->view->render($response, 'admin/media/index.twig', ['items' => $items, 'messages' => $messages]);
    }

    public function store(Request $request, Response $response)
    {
        $file = $request->getUploadedFiles()['media'];

        $uploadDir = $this->container->get('settings')['media']['uploaded'] . '/';

        if ($file->getError() === UPLOAD_ERR_OK) {
            $filename = $this->moveUploadedFile($uploadDir, $file);
            $sm = new MediaServiceManager($this->container);
            $img_id = $sm->insert(['url' => $filename]);

            if($img_id){
                if ($request->isXhr()) {
                    return $response->withJson(['fileName' => $filename, 'imageId' => $img_id]);
                }
                $this->container->get('flash')->addMessage('success', 'Image is successful uploaded');
                return $response->withRedirect('/admin/media');
            }
        }

        $this->container->get('flash')->addMessage('errors', 'Image is not uploaded ERROR');
        return $response->withRedirect('/admin/media');
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
        $sm = new MediaServiceManager($this->container);
        $item = $sm->find($id);

        return $this->view->render($response, 'admin/media/edit.twig', ['item' => $item, 'messages' => $messages]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return static
     */
    public function update(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $sm = new MediaServiceManager($this->container);
        $sm->update($data);

        $this->container->get('flash')->addMessage('success', 'Image is successful updated');
        return $response->withRedirect('/admin/media/edit/' . $data['id']);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return static
     */
    public function delete(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $sm = new MediaServiceManager($this->container);
        $image = $sm->find($id);
        if($this->removeImage($image->url)) {
            $sm->remove($id);
            $this->container->get('flash')->addMessage('success', 'Image is successful deleted');
            return $response->withRedirect('/admin/media');
        }

        $this->container->get('flash')->addMessage('errors', 'Image is not deleted ERROR');
        return $response->withRedirect('/admin/media');

    }

    /**
     * @param $directory
     * @param UploadedFile $uploadedFile
     * @return string
     * @throws \Exception
     */
    protected function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }

    /**
     * @param $filename
     * @return bool
     */
    public function removeImage($filename)
    {
        $file = $this->container->get('settings')['media']['uploaded'] . '/' . $filename;
        if (file_exists($file)) {
            unlink($file);
            return true;
        }
        return false;
    }

}
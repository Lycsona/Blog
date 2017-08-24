<?php

namespace App\BlogBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiExceptionEvent extends Event
{
    private $statusCode;

    private $arguments;

    private $response;

    public function __construct($statusCode, $arguments = [])
    {
        $this->statusCode = $statusCode;
        $this->arguments = $arguments;
    }

    /**
     * @return string
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param JsonResponse $response
     */
    public function setResponse(JsonResponse $response)
    {
        $this->stopPropagation();

        $this->response = $response;
    }

    /**
     * @return JsonResponse
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->arguments['id'];
    }

    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->arguments['form'];
    }

    /**
     * Get errors.
     * @param Form $form
     *
     * @return array
     */
    public function getFormErrors(Form $form)
    {
        $errors = array();
        if ($form->count() > 0) {
            foreach ($form->all() as $child) {
                if (!$child->isValid()) {
                    $errors[$child->getName()] = (String) $form[$child->getName()]->getErrors();
                }
            }
        }
        return $errors;
    }
}
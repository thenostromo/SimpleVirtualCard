<?php
namespace FormHandler;

interface FormHandlerInterface
{
    /**
     * @param array $params
     */
    public function handleForm(array $params);

    /**
     * @param array $params
     * @return object
     */
    public function getFormData(array $params);

    /**
     * @param object $model
     * @return boolean
     */
    public function emptyFormModel($model);

    /**
     * @param array $params
     * @return boolean
     */
    public function emptyFormPostParam(array $params);
}


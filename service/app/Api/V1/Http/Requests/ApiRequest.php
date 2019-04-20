<?php

namespace App\Api\v1\Http\Requests;

use Dingo\Api\Exception\ResourceException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

/**
 * ApiRequest
 * 
 * This class allows us to use Illuminate\Foundation\Http\FormRequest for validation
 * inside the api controllers.
 * 
 * Api Responses should not redirect!!!
 * 
 * So in order to use FormRequest we must override some defaults methods.
 *
 * @version 1.0.0
 * @author marius ionel <webmaster@grupnet.ro>
 */
abstract class ApiRequest extends FormRequest {

    /**
     * Override the failedValidation method in order to avoid redirection
     * 
     * and return a valid api validation error
     * 
     * @param Validator $validator
     * @throws ResourceException
     */
    protected function failedValidation(Validator $validator) {
        throw new ResourceException('Resource validation failed!', $validator->getMessageBag());
    }

}
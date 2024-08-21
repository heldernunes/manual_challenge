<?php

namespace App\Tests\Unit\EventSubscriber;

use Symfony\Component\HttpFoundation\Request;

class ExceptionSubscriberDataProvider
{
    /**
     * Which events the ExceptionSubscriber has to subscribe.
     *
     * @return array
     */
    public static function exceptionSubscriberEvents()
    {
        return [
            [
                'events' => [
                    'kernel.exception' => 'onKernelException'
                ],
            ]
        ];
    }

    public function mockRequest(): Request
    {
        $attributes = [
            '_route' => 'test_route',
            '_controller' => 'App\Controller\SearchContorller::search',
            'id' => '3',
        ];
        $request = new Request(attributes: $attributes);
        $request->setMethod('GET');
        $request->headers->set('Accept', 'application/json');
        $request->headers->set('Accept-Language', 'en');

        return $request;
    }
}

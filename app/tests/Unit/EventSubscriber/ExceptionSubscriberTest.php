<?php

namespace App\Tests\Unit\EventSubscriber;

use App\EventSubscriber\ExceptionSubscriber;
use App\Exceptions\InvalidArgumentsException;
use App\Exceptions\NotFoundException;
use App\Model\Response\ErrorResponseModel;
use App\Tests\Helper\Faker;
use Exception;
use Generator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ExceptionSubscriberTest extends TestCase
{
    private $requestStack;

    protected function setUp(): void
    {
        $this->requestStack = $this->createMock(RequestStack::class);
    }

    public function testClassStructure()
    {
        $subscriber = new ExceptionSubscriber((new ErrorResponseModel()));
        $this->assertInstanceOf(EventSubscriberInterface::class, $subscriber);
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testSubscribesCorrectEvents()
    {
        $expectedEvents = [
            'kernel.exception' => 'onKernelException'
        ];
        $subscribedEvents = ExceptionSubscriber::getSubscribedEvents();

        $this->assertEquals($expectedEvents, $subscribedEvents);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('onKernelExceptions')]
    public function testOnKernelException($exception)
    {
        $subscriber = new ExceptionSubscriber((new ErrorResponseModel()));

        //create an event
        $httpKernelMock = $this->createMock(HttpKernelInterface::class);

        $event = new ExceptionEvent($httpKernelMock, $this->mockRequest(), Faker::integer(), $exception);

        //call method
        $subscriber->onKernelException($event);

        $this->assertTrue(true);
    }

    public static function onKernelExceptions(): Generator
    {
        yield [
            'exception' => new NotFoundException('Wally not found here!'),
        ];

        yield [
            'exception' => new InvalidArgumentsException('The guy found is not wally'),
        ];

        yield [
            'exception' => new Exception('Wally don\'t wants to be found', 500),
        ];

        yield [
            'exception' => new Exception('Wally timed out!'),
        ];

        yield [
            'exception' => new Exception('cURL to Wally not found'),
        ];
    }

    protected function mockRequest()
    {
        $request = new Request(attributes: ['id' => Faker::integer(1, 10)]);

        return $request;
    }
}

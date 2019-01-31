<?php

namespace Core;

use Core\Mvc\MvcContext;
use Core\Mvc\MvcContextInterface;

class Application
{
//    private $controllerName;
//    private $actionName;
//    private $params = [];

    /**
     * @var MvcContext
     */
    private $mvcContext;

    /**
     * @var string[]
     */
    private $dependencies = [];

    /**
     * @var object[]
     */
    private $resolvedDependencies = [];

    /**
     * Application constructor.
     * @param MvcContextInterface $mvcContext
     */
    public function __construct(MvcContextInterface $mvcContext) {
//        $this->controllerName = $controllerName;
//        $this->actionName = $actionName;
//        $this->params = $params;
        $this->mvcContext = $mvcContext;
        $this->dependencies[MvcContextInterface::class] = get_class($mvcContext);
        $this->resolvedDependencies[get_class($mvcContext)] = $mvcContext;
    }

    /**
     * @throws \ReflectionException
     */
    public function start()
    {
        $controllerName = $this->mvcContext->getControllerName();
        $actionName = $this->mvcContext->getActionName();
        $params = $this->mvcContext->getParams();

        $controllerFullQualifiedName = "Controllers\\".ucfirst($controllerName);
        $controller = $this->resolve($controllerFullQualifiedName);

        $refMethod = new \ReflectionMethod($controller, $actionName);
        $refParams = $refMethod->getParameters();
        $count = count($params);
        for ($i = $count; $i < count($refParams); $i++) {
            $argument = $refParams[$i];
            $argumentInterface = $argument->getClass()->getName();
            if (array_key_exists($argumentInterface, $this->dependencies)) {
                $argumentClass = $this->dependencies[$argumentInterface];
                $params[] = $this->resolve($argumentClass);
            } else {
                $bindModel = new $argumentInterface;
                $this->bindData($_POST, $bindModel);
                $params[] = $bindModel;
            }

        }

        call_user_func_array([$controller, $actionName], $params);
    }


    public function registerDependency(string $abstraction, string $implementation)
    {
        $this->dependencies[$abstraction] = $implementation;
    }

    /**
     * @param $className
     * @return object
     * @throws \ReflectionException
     */
    private function resolve($className)
    {
        if (array_key_exists($className, $this->resolvedDependencies)) {
            return $this->resolvedDependencies[$className];
        }

        $refClass = new \ReflectionClass($className);
        $constructor = $refClass->getConstructor();

        if ($constructor === null) {
            $object = new $className;
            $this->resolvedDependencies[$className] = $object;
            return $object;
        }

        $parameters = $constructor->getParameters();
        $arguments = [];
        foreach ($parameters as $parameter) {
            $dependencyInterface = $parameter->getClass();
            $dependencyClass = $dependencyInterface->getName();
            $arguments[] = $this->resolve($dependencyClass);
        }

        $object = $refClass->newInstanceArgs($arguments);
        $this->resolvedDependencies[$className] = $object;
        return $object;
    }

    private function bindData(array  $data, $object)
    {
        $refClass = new \ReflectionClass($object);
        $fields = $refClass->getProperties();
        foreach ($fields as $field) {
            $field->setAccessible(true);
            $field->setValue($object, $data[$field->getName()]);
        }
    }

    public function addBean(string $abstraction, $object)
    {
        $this->dependencies[$abstraction] = get_class($object);
        $this->resolvedDependencies[get_class($object)] = $object;
    }
//
//    private function initiateMvcContext(): MvcContextInterface
//    {
//        return new MvcContext();
//    }
}
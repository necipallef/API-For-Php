<?php

namespace Fabs\Rest\Definitions;

use Fabs\Rest\ServiceFactoryBase;

class ServiceDefinition extends DefinitionBase
{
    /** @var string */
    private $service_name = null;
    /** @var bool */
    private $shared = false;
    /** @var mixed */
    private $instance = null;
    /** @var mixed[] */
    private $parameters = null;

    /**
     * ServiceDefinition constructor.
     * @param string $service_name
     * @param string|callable|mixed $definition
     * @param bool $shared
     * @param mixed[] $parameters
     */
    public function __construct($service_name, $definition, $shared, $parameters = [])
    {
        $this->service_name = $service_name;
        $this->setDefinition($definition);
        $this->shared = $shared;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     * @author ahmetturk <ahmetturk93@gmail.com>
     */
    public function getServiceName()
    {
        return $this->service_name;
    }

    /**
     * @return bool
     * @author ahmetturk <ahmetturk93@gmail.com>
     */
    public function isShared()
    {
        return $this->shared;
    }

    /**
     * @param bool $is_shared
     * @return ServiceDefinition
     * @author ahmetturk <ahmetturk93@gmail.com>
     */
    public function setShared($is_shared)
    {
        $this->shared = $is_shared;
        return $this;
    }

    /**
     * @param string|callable|mixed $definition
     * @return ServiceDefinition
     * @author ahmetturk <ahmetturk93@gmail.com>
     */
    public function setDefinition($definition)
    {
        if ($this->getDefinition() != $definition) {
            $this->setInstance(null);
        }
        parent::setDefinition($definition);
        return $this;
    }

    public function getInstance()
    {
        if ($this->isShared()) {
            if ($this->instance !== null) {
                return $this->instance;
            }
        }

        $instance = $this->instance;

        $definition = $this->getDefinition();

        if (is_string($definition)) {
            if (class_exists($definition)) {
                $instance = new $definition;
                if ($instance instanceof ServiceFactoryBase) {
                    $instance = $instance->create($this->parameters);
                }
            }
        } else {
            if (is_callable($definition)) {
                $instance = call_user_func($definition);
            } else {
                $instance = $definition;
            }
        }

        if ($this->isShared()) {
            $this->instance = $instance;
        }

        return $instance;
    }
}
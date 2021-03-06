<?php

namespace DoctrineORMModule\Proxy\__CG__\house\model;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class property extends \house\model\property implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'id', 'type', 'address', 'description', 'status', 'expenses', 'avaliableFrom', 'propertyImages');
        }

        return array('__isInitialized__', 'id', 'type', 'address', 'description', 'status', 'expenses', 'avaliableFrom', 'propertyImages');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (property $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function id($id = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'id', array($id));

        return parent::id($id);
    }

    /**
     * {@inheritDoc}
     */
    public function type($type = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'type', array($type));

        return parent::type($type);
    }

    /**
     * {@inheritDoc}
     */
    public function address(\house\model\propertyAddress $address = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'address', array($address));

        return parent::address($address);
    }

    /**
     * {@inheritDoc}
     */
    public function user(\house\model\user $user = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'user', array($user));

        return parent::user($user);
    }

    /**
     * {@inheritDoc}
     */
    public function description($description = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'description', array($description));

        return parent::description($description);
    }

    /**
     * {@inheritDoc}
     */
    public function status($status = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'status', array($status));

        return parent::status($status);
    }

    /**
     * {@inheritDoc}
     */
    public function expenses(\house\model\propertyExpense $exp = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'expenses', array($exp));

        return parent::expenses($exp);
    }

    /**
     * {@inheritDoc}
     */
    public function propertyImages(\house\model\propertyImages $imgs = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'propertyImages', array($imgs));

        return parent::propertyImages($imgs);
    }

}

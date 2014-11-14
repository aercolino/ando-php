<?php

class Ando_Collection
{

    /**
     * Array of elements.
     *
     * @var array
     */
    protected $data;

    /**
     * True if we are preserving keys.
     *
     * @var boolean
     */
    protected $preserving_keys;

    /**
     *
     * @param string $preserve_keys
     */
    protected function __construct($preserve_keys = false)
    {
        $this->preserving_keys = $preserve_keys;
        $this->data = array();
    }

    /**
     *
     * @param array   $data
     * @param boolean $preserve_keys
     *
     * @return Ando_Collection
     */
    static public function def($data = null, $preserve_keys = false)
    {
        $result = new self($preserve_keys);
        if (!is_null($data)) {
            if (!(is_array($data) || $data instanceof Traversable)) {
                throw new Ando_Exception('Expected ');
            }
            foreach ($data as $key => $element) {
                $result->data[$key] = $element;
            }
            if (!$preserve_keys) {
                $result->data = array_values($result->data);
            }
        }
        return $result;
    }

    /**
     * Get the element with the key.
     *
     * @param integer|string $key
     *
     * @throws Ando_Exception
     * @return mixed
     */
    public function element($key)
    {
        if (!isset($this->data[$key])) {
            throw new Ando_Exception('Expected a valid key. (got instead "' . $key . '")');
        }
        $result = $this->data[$key];
        return $result;
    }

    /**
     * Set the element with the key.
     *
     * @param integer|string $key
     * @param mixed          $element
     *
     * @return Ando_Collection
     */
    public function element_set($key, $element)
    {
        $this->data[$key] = $element;
        return $this;
    }

    /**
     * Get the value of the named property for the element with the key.
     *
     * @param integer|string $key
     * @param string         $name
     *
     * @return mixed
     */
    public function property($key, $name)
    {
        $element = $this->element($key);
        if (is_object($element)) {
            $result = $element->$name;
        } elseif (is_array($element)) {
            $result = $element['name'];
        } else {
            throw new Ando_Exception('Unexpected property access for scalar element. (key: "' . $key . '", name: "' . $name . '")');
        }
        return $result;
    }

    /**
     * Set the value of the named property for the element with the key.
     *
     * @param integer|string $key
     * @param string         $name
     * @param mixed          $value
     *
     * @return Ando_Collection
     */
    public function property_set($key, $name, $value)
    {
        $element = $this->element($key);
        if (is_object($element)) {
            $element->$name = $value;
        } elseif (is_array($element)) {
            $element['name'] = $value;
        }
        $this->element_set($key, $element);
        return $this;
    }

    /**
     * Array of named properties.
     *
     * @param string $name
     *
     * @return array
     */
    public function pluck($name)
    {
        $result = array();
        foreach ($this->data as $key => $element) {
            $result[$key] = $this->property($key, $name);
        }
        if (!$this->preserving_keys) {
            $result = array_values($result);
        }
        return $result;
    }

    /**
     * Convert the collection to a plain array.
     *
     * @return array
     */
    public function to_array()
    {
        if (!$this->preserving_keys) {
            $this->data = array_values($this->data);
        }
        return $this->data;
    }
}

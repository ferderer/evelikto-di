<?php

namespace evelikto\di;

/** Base class for all di exceptions */
class DiException extends \Exception
{
    /**
     * Initializes underlying standard PHP Exception with expanded user message.
     *
     * @param   array   $data   Arbitrary data used to describe the exception.
     */
    public function __construct(array $data = []) {
        $this->data = $data;
        parent::__construct($this->buildMessage($data));
    }

    /**
     * Returns the exception ID which could be used for an alternative, user-friendly error message.
     * Exception ID is the fully qualified classname, where backslashes are replaces with dots.
     *
     * @return  string  Exception ID
     */
    public function getId() : string {
        return str_replace('\\', '.', get_class($this));
    }

    /**  @return  array  arbitrary additional data for message expanding */
    public function getData() : array {
        return $this->data;
    }

    /**  @return  string  default exception message */
    public function buildMessage(array $vars) {
        $message = $this->getId() . ':';
        foreach ($vars as $key => $value)
            $message .= " $key = $value;";

        return $message;
    }

    /**  @var  array  $data arbitrary additional data for message expanding */
    protected $data;
}
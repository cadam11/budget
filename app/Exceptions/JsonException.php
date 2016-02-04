<?php
namespace Budget\Exceptions;

class JsonException extends \Exception
{

	/**
	 * Default constructor, intiializes this instance based on the model Exception given
	 * @param \Exception $e 
	 */
	public function __construct(\Exception $e)
    {
        parent::__construct($e->getMessage(), $e->getCode(), $e);
    }

}

<?php

namespace RetailCrm\Geohelper\Response;

use RetailCrm\Geohelper\Exception\InvalidJsonException;

class ApiResponse implements \ArrayAccess
{
    protected int $statusCode;

    /** @var array<mixed> $response */
    protected array $response;

    public function __construct(int $statusCode, string $responseBody = null)
    {
        $this->statusCode = $statusCode;

        if (!empty($responseBody)) {
            $response = json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR);

            if (!$response && JSON_ERROR_NONE !== ($error = json_last_error())) {
                throw new InvalidJsonException(
                    "Invalid JSON in the API response body. Error code #$error",
                    $error
                );
            }

            $this->response = $response;
        }
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function isSuccessful(): bool
    {
        return $this->statusCode < 400 && is_bool($this->response['success']);
    }

    public function __call($name, $arguments)
    {
        $propertyName = strtolower(substr($name, 3, 1)) . substr($name, 4);

        if (!isset($this->response[$propertyName])) {
            throw new \InvalidArgumentException("Method \"$name\" not found");
        }

        return $this->response[$propertyName];
    }

    public function getErrorMsg(): string
    {
        if (!isset($this->response['error'])) {
            throw new \InvalidArgumentException('Method "getErrorMsg" not found');
        }

        return $this->response['error']['message'];
    }

    public function __get($property)
    {
        if (!isset($this->response[$property])) {
            throw new \InvalidArgumentException("Property \"$property\" not found");
        }

        return $this->response[$property];
    }

    public function __set($property, $value): void
    {
        if (!isset($this->response[$property])) {
            throw new \InvalidArgumentException("Property \"$property\" not found");
        }
        $this->response[$property] = $value;
    }

    public function __isset($property): bool
    {
        if (!isset($this->response[$property])) {
            return false;
        }

        return true;
    }

    public function offsetSet($offset, $value): void
    {
        throw new \BadMethodCallException('This activity not allowed');
    }

    public function offsetUnset($offset): void
    {
        throw new \BadMethodCallException('This call not allowed');
    }

    public function offsetExists($offset): bool
    {
        return isset($this->response[$offset]);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        if (!isset($this->response[$offset])) {
            throw new \InvalidArgumentException("Property \"$offset\" not found");
        }

        return $this->response[$offset];
    }
}

<?php
/**
 * The super class of every API command.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 * @author Marcelo Gornstein <marcelog@portatext.com>
 * @copyright 2015 PortaText
 */
namespace PortaText\Command;

use PortaText\Client\IClient;

/**
 * The super class of every API command.
 */
abstract class Base implements ICommand
{
    /**
     * Arguments for endpoint invokation.
     *
     * @var array
     */
    private $args;

    /**
     * Returns an associative array with the arguments.
     *
     * @param string $key Name of the argument.
     * @param string $value Value of the argument.
     *
     * @return array
     */
    protected function setArgument($key, $value)
    {
        $this->args[$key] = $value;
        return $this;
    }

    /**
     * Deleted an argument.
     *
     * @param string $key Name of the argument.
     *
     * @return array
     */
    protected function delArgument($key)
    {
        unset($this->args[$key]);
        return $this;
    }

    /**
     * Returns the value for the given argument name.
     *
     * @param string $key Name of the argument.
     *
     * @return mixed|null
     */
    protected function getArgument($key)
    {
        if (isset($this->args[$key])) {
            return $this->args[$key];
        }
        return null;
    }

    /**
     * Returns an associative array with the arguments.
     *
     * @param string $method Method for this command.
     *
     * @return array
     */
    protected function arguments($method)
    {
        // Just to make PHPMD happy.
        $method = null;
        return $this->args;
    }

    /**
     * Returns a string with the endpoint for the given command.
     *
     * @param string $method Method for this command.
     * @param string $args The endpoint for this command.
     *
     * @return string
     */
    abstract protected function endpoint($method);

    /**
     * Returns the body for this endpoint.
     *
     * @param string $method Method for this command.
     *
     * @return string
     */
    protected function body($method)
    {
        if (count($this->arguments($method)) > 0) {
            return json_encode($this->arguments($method));
        }
        return "";
    }

    /**
     * Returns the content type for this endpoint.
     *
     * @param string $method Method for this command.
     *
     * @return string
     */
    protected function contentType($method)
    {
        // Just to make PHPMD happy.
        $method = null;
        return 'application/json';
    }

    /**
     * Runs this command with a GET method and returns the result.
     *
     * @return PortaText\Command\ICommand
     * @throws PortaText\Exception\RequestError
     */
    public function get()
    {
        return $this->run("get");
    }

    /**
     * Runs this command with a POST method and returns the result.
     *
     * @return PortaText\Command\ICommand
     * @throws PortaText\Exception\RequestError
     */
    public function post()
    {
        return $this->run("post");
    }

    /**
     * Runs this command with a PUT method and returns the result.
     *
     * @return PortaText\Command\ICommand
     * @throws PortaText\Exception\RequestError
     */
    public function put()
    {
        return $this->run("put");
    }

    /**
     * Runs this command with a DELETE method and returns the result.
     *
     * @return PortaText\Command\ICommand
     * @throws PortaText\Exception\RequestError
     */
    public function delete()
    {
        return $this->run("delete");
    }

    /**
     * Runs this command with a PATCH method and returns the result.
     *
     * @return PortaText\Command\ICommand
     * @throws PortaText\Exception\RequestError
     */
    public function patch()
    {
        return $this->run("patch");
    }

    /**
     * Runs this command with the given method and returns the result.
     *
     * @param string $method HTTP Method to use.
     *
     * @return PortaText\Command\ICommand
     * @throws PortaText\Exception\RequestError
     */
    protected function run($method)
    {
        $endpoint = $this->endpoint($method);
        $body = $this->body($method);
        $cType = $this->contentType($method);
        return $this->client->run($endpoint, $method, $cType, $body);
    }

    /**
     * Sets the API client to use.
     *
     * @param PortaText\Client\Client $client New injected client.
     *
     * @return PortaText\Api\Api
     */
    public function setClient(IClient $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Standard constructor.
     *
     */
    public function __construct()
    {
        $this->args = array();
    }
}

<?php
/**
 * The ContactLists endpoint.
 *
 * @link https://github.com/PortaText/docs/wiki/REST-API#api_contact_lists ContactLists endpoint.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 * @author Marcelo Gornstein <marcelog@portatext.com>
 * @copyright 2015 PortaText
 */
namespace PortaText\Command\Api;

use PortaText\Command\Base;

/**
 * The ContactLists endpoint.
 */
class ContactLists extends Base
{
    /**
     * Sets the contact list id.
     *
     * @param integer $contactListId Contact list id.
     *
     * @return PortaText\Command\ICommand
     * @SuppressWarnings("ShortMethodName")
     */
    public function id($contactListId)
    {
        return $this->setArgument("id", $contactListId);
    }

    /**
     * The contact list name.
     *
     * @param string $name Name.
     *
     * @return PortaText\Command\ICommand
     */
    public function name($name)
    {
        return $this->setArgument("name", $name);
    }

    /**
     * Add or remove this number to the contact list.
     *
     * @param string $number Number.
     * @param array $variables variables.
     *
     * @return PortaText\Command\ICommand
     */
    public function withNumber($number, $variables = null)
    {
        if (!is_null($variables)) {
            $vars = array();
            foreach ($variables as $k => $v) {
                $vars[] = array('key' => $k, 'value' => $v);
            }
            $this->setArgument("variables", $vars);
        }
        return $this->setArgument("number", $number);
    }

    /**
     * The contact list description.
     *
     * @param string $description Description.
     *
     * @return PortaText\Command\ICommand
     */
    public function description($description)
    {
        return $this->setArgument("description", $description);
    }

    /**
     * Send a CSV file to import contacts.
     *
     * @param string $filename Full absolute path to the csv file.
     *
     * @return PortaText\Command\ICommand
     */
    public function csv($filename)
    {
        return $this->setArgument("file", $filename);
    }

    /**
     * Used to export the contact list to a CSV file on a GET.
     *
     * @param string $filename The filename.
     *
     * @return PortaText\Command\ICommand
     */
    public function saveTo($filename)
    {
        return $this->setArgument("accept_file", $filename);
    }

    /**
     * Return the specific page of results.
     *
     * @param integer $page Page number.
     *
     * @return PortaText\Command\ICommand
     */
    public function page($page)
    {
        return $this->setArgument("page", $page);
    }

    /**
     * Returns a string with the endpoint for the given command.
     *
     * @param string $method Method for this command.
     *
     * @return string
     */
    protected function getEndpoint($method)
    {
        $endpoint = "contact_lists";
        $contactListId = $this->getArgument("id");
        if (!is_null($contactListId)) {
            $endpoint = "contact_lists/$contactListId";
            $this->delArgument("id");
        }
        $number = $this->getArgument("number");
        if (!is_null($number)) {
            $this->delArgument("number");
            return "$endpoint/contacts/$number";
        }
        $file = $this->getArgument("file");
        $saveTo = $this->getArgument("accept_file");
        if (!is_null($file) || !is_null($saveTo)) {
            $endpoint .= "/contacts";
        }
        $page = $this->getArgument("page");
        $this->delArgument("page");
        if (!is_null($page)) {
            $endpoint .= "/contacts?page=$page";
        }
        return $endpoint;
    }
}

<?php
/**
 * The Campaigns endpoint.
 *
 * @link https://github.com/PortaText/docs/wiki/REST-API#api_campaigns Campaigns endpoint.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 * @author Marcelo Gornstein <marcelog@portatext.com>
 * @copyright 2015 PortaText
 */
namespace PortaText\Command\Api;

use PortaText\Command\Base;

/**
 * The Campaigns endpoint.
 * @SuppressWarnings("TooManyPublicMethods")
 */
class Campaigns extends Base
{
    /**
     * Sets the campaign id.
     *
     * @param integer $campaignId Campaign id.
     *
     * @return PortaText\Command\ICommand
     * @SuppressWarnings("ShortMethodName")
     */
    public function id($campaignId)
    {
        return $this->setArgument("id", $campaignId);
    }

    /**
     * The campaign name.
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
     * The campaign description.
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
     * Specifies source telephone number for the campaign.
     *
     * @param string $from Telephone number (you must own this one).
     *
     * @return PortaText\Command\ICommand
     */
    public function from($from)
    {
        return $this->setArgument("from", $from);
    }

    /**
     * Specifies source sms service.
     *
     * @param string $serviceId SMS Service ID.
     *
     * @return PortaText\Command\ICommand
     */
    public function fromService($serviceId)
    {
        return $this->setArgument("service_id", $serviceId);
    }

    /**
     * Specifies all subscribers of the given SMS Service ID.
     *
     * @return PortaText\Command\ICommand
     */
    public function allSubscribers()
    {
        return $this->setArgument("all_subscribers", true);
    }

    /**
     * Contact list IDs to use.
     *
     * @param array $contactLists The contact list ids.
     *
     * @return PortaText\Command\ICommand
     */
    public function toContactLists(array $contactLists)
    {
        return $this->setArgument("contact_list_ids", $contactLists);
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
     * Sets the template id to use.
     *
     * @param integer $templateId Use the given template as the message body.
     * @param array $variables Variables to use in template.
     *
     * @return PortaText\Command\ICommand
     */
    public function useTemplate($templateId, array $variables = array())
    {
        return $this->setArgument("settings", array(
            "template_id" => $templateId,
            "variables" => $variables
        ));
    }

    /**
     * Sets the message text.
     *
     * @param string $text Message text.
     *
     * @return PortaText\Command\ICommand
     */
    public function text($text)
    {
        return $this->setArgument("settings", array(
            "text" => $text
        ));
    }

    /**
     * Used to export the contacts to a CSV file on a GET.
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
     * Query for campaign contacts.
     *
     * @return PortaText\Command\ICommand
     */
    public function contacts()
    {
        return $this->setArgument("contacts", true);
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
        $endpoint = "campaigns";
        $campaignId = $this->getArgument("id");
        if (!is_null($campaignId)) {
            $endpoint .= "/$campaignId";
            $this->delArgument("id");
        }
        $contacts = $this->getArgument("contacts");
        if (!is_null($contacts)) {
            $endpoint .= "/contacts";
            $this->delArgument("contacts");
        }
        $file = $this->getArgument("file");
        if (!is_null($file)) {
            $args = $this->getArguments();
            unset($args['file']);
            $args = array(
                'settings' => json_encode($args)
            );
            $endpoint = $endpoint . '?' . http_build_query($args);
        }
        $queryString = array();
        $page = $this->getArgument("page");
        if (!is_null($page)) {
            $queryString['page'] = $page;
            $this->delArgument("page");
        }
        if (!empty($queryString)) {
            $queryString = http_build_query($queryString);
            return "$endpoint?$queryString";
        }
        return $endpoint;
    }
}

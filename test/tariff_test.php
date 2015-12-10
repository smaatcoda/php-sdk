<?php
/**
 * Tariff command tests.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 * @author Marcelo Gornstein <marcelog@portatext.com>
 * @copyright 2015 PortaText
 */
namespace PortaText\Test;

use PortaText\Client\Base as Client;

/**
 * Tariff command tests.
 */
class TariffTest extends BaseCommandTest
{
    /**
     * @test
     */
    public function can_get_all_tariffs()
    {
        $this->mockClientForCommand("tariffs")
        ->tariff()
        ->get();
    }

    /**
     * @test
     */
    public function can_get_one_tariff()
    {
        $this->mockClientForCommand("tariffs/us")
            ->tariff()
            ->forCountry("us")
            ->get();
    }
}

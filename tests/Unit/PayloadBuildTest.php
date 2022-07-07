<?php
declare(strict_types=1);

namespace Test\Unit;

use Php\Data\Payload;

class PayloadBuildTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function can_add_data_to_payload_class()
    {
        $payload = new Payload;
        $payload->add('animal.dog.name', 'Zoe');
        $payload->add('animal.dog.age', 8);

        $payload->add('animal.cat.name', 'Snowy');
        $payload->add('animal.cat.age', 2);

        $this->assertSame($payload->get('animal.dog.name'), 'Zoe');
        $this->assertSame($payload->get('animal.dog.age'), 8);

        $this->assertSame($payload->get('animal.cat.name'), 'Snowy');
        $this->assertSame($payload->get('animal.cat.age'), 2);
    }

     /** @test */
    public function can_retrieve_data_from_payload_class()
    {
        $payload = $this->prepareTestPayload();
        $this->assertSame(count($payload->get('month')), 12);
        $this->assertSame($payload->get('month.jan'), 'January');
        $this->assertSame($payload->get('month.feb'), 'February');
        $this->assertNotSame($payload->get('month.mar'), 'February');
        $this->assertSame($payload->get('month.na', 'N/A'), 'N/A');

        $this->assertIsArray($payload->get('contacts'));
        $this->assertSame(count($payload->get('contacts')), 5);
    }

    /** @test */
    public function can_export_data_to_payload_class()
    {
        $payload = $this->prepareTestPayload();

        $data = $payload->export();
        $this->assertIsArray($data);
        $this->assertIsArray($data['month']);
        $this->assertIsArray($data['number']);
        $this->assertIsArray($data['contacts']);

        $this->assertSame($data['month']['feb'], 'February');
    }

      /** @test */
    public function can_export_and_import_data_to_payload_class()
    {
        $payload1 = $this->prepareTestPayload();
        $data = $payload1->export();

        $payload2 = new Payload($data);
        $this->assertSame(print_r($data, true), print_r($payload2->export(), true));

        $payload3 = new Payload;
        $payload3->import($data);
        $this->assertSame(print_r($data, true), print_r($payload3->export(), true));
    }


    private function prepareTestPayload(): Payload
    {
        $payload = new Payload;
        $months = [
            'jan' => 'January',
            'feb' => 'February',
            'mar' => 'March',
            'apr' => 'April',
            'may' => 'May',
            'jun' => 'June',
            'jul' => 'July',
            'aug' => 'August',
            'sep' => 'September',
            'oct' => 'October',
            'nov' => 'November',
            'dec' => 'December',
        ];
        foreach ($months as $key => $value) {
            $payload->add("month.{$key}", $value);
        }

        $payload->add('number.1', 'one');
        $payload->add('number.2', 'two');
        $payload->add('number.3', 'three');
        $payload->add('number.4', 'four');
        $payload->add('number.5', 'five');

        $contacts = [
             [
                'name' => 'Name 1',
                'email' => 'name1@example.com',
            ],
            [
                'name' => 'Name 2',
                'email' => 'name2@example.com',
            ],
            [
                'name' => 'Name 3',
                'email' => 'name3@example.com',
            ],
            [
                'name' => 'Name 4',
                'email' => 'name4@example.com',
            ],
            [
                'name' => 'Name 5',
                'email' => 'name5@example.com',
            ],
        ];
        $payload->add('contacts', $contacts);

        return $payload;
    }
}

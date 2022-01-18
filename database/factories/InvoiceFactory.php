<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomDigitNot(0),
            'customer_id' => $this->faker->numberBetween(1, 10),
            'invoice_number' => $this->faker->numerify('POS_####_######'),
            'payment_method' => 'tnbc',
            'subTotal' => $this->faker->randomNumber(4, true),
            'discount' => $this->faker->randomNumber(3, true),
            'tax' => $this->faker->randomNumber(3, true),
            'total' => $this->faker->randomNumber(4, true),
            'date' => $this->faker->dateTimeThisMonth(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}

<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Faker;

use Faker\Factory as FakerFactory; 
use Araiyusuke\FakeApi\Faker\ArgType;

class DefaultFakerMethod implements FakeMethodAdapter 
{
    
    private $faker;

    function __construct(string $lang = 'ja_JP') 
    {
        $this->faker = FakerFactory::create($lang);
    }

    public static function methods(): array
    {
        $methods = get_class_methods(DefaultFakerMethod::class);
        
        return array_filter($methods, function($val) {
            if ($val === '__construct' || $val === 'methods') {
                return false;
            } else {
                return true;
            }
        });
    
    }

    public function name(): string 
    {
        return $this->faker->name();
    }

    public function boolean(): bool
    {
        return $this->faker->boolean();
    }

    public function company(): string
    {
        return $this->faker->company();
    }

    public function prefecture(): string
    {
        return $this->faker->prefecture();
    }

    public function time(): string
    {
        return $this->faker->time();
    }

    public function day(): string
    {
        return $this->faker->dayOfMonth();
    }

    public function kanaName(): string
    {
        return $this->faker->kanaName();
    }

    public function month(): string
    {
        return $this->faker->month();
    }

    public function year(): string
    {
        return $this->faker->year();
    }

    public function latitude(): float
    {
        return $this->faker->latitude();
    }

    public function longitude(): float
    {
        return $this->faker->longitude();
    }

    public function realText(int $digit): string
    {
        return $this->faker->realText($digit);
    }

    public function country(): string
    {
        return $this->faker->country();
    }

    public function url(): string
    {
        return $this->faker->url();
    }

    public function ipv4(): string
    {
        return $this->faker->ipv4();
    }

    public function isbn13(): string
    {
        return $this->faker->isbn13();
    }

    public function password(): string
    {
        return $this->faker->password();
    }

    public function city(): string
    {
        return $this->faker->city();
    }

    public function randomNumber(int $digit): int
    {
        return $this->faker->randomNumber($digit);
    }

    public function randomElement(array $list): int|string|float
    {
        return $this->faker->randomElement($list);
    }

    public function phoneNumber(): string
    {
        return $this->faker->phoneNumber();
    }

    public function creditCardNumber(): string
    {
        return $this->faker->creditCardNumber();
    }

    public function postcode(): string
    {
        return $this->faker->postcode();
    }

    public function uuid(): string
    {
        return $this->faker->uuid();
    }

    public function isbn10(): string
    {
        return $this->faker->isbn10();
    }

    public function numberBetween(int|float $start, int|float $end): int|float
    {
        return $this->faker->numberBetween($start, $end);   
    }

    public function word(): string
    {
        return $this->faker->word();
    }

    public function lastKanaName(): string
    {
        return $this->faker->lastKanaName();
    }

    public function firstKanaName(): string
    {
        return $this->faker->firstKanaName();
    }

    public function streetAddress(): string
    {     
        return $this->faker->streetAddress();
    }

    public function email(): string
    {
        return $this->faker->safeEmail();
    }
 
    // public function getArgType(string $method): ArgType
    // {
    //     $func = new ReflectionFunction($method);
    //     $arg = $func->getParameters();
    //     return new ArgType(count($arg));
    // }
}

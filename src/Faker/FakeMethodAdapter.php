<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Faker;

interface FakeMethodAdapter {
    
    public static function methods(): array;
    public function name(): string;
    public function boolean(): bool;
    public function company(): string;
    public function prefecture(): string;
    public function time(): string;
    public function day(): string;
    public function kanaName(): string;
    public function month(): string;
    public function year(): string;
    public function latitude(): float;
    public function longitude(): float;
    public function realText(int $digit): string;
    public function country(): string;
    public function url(): string;
    public function ipv4(): string;
    public function isbn13(): string;
    public function password(): string;
    public function city(): string;
    public function randomNumber(int $digit): int;
    public function randomElement(array $list): mixed;
    public function phoneNumber(): string;
    public function creditCardNumber(): string;
    public function postcode(): string;
    public function uuid(): string;
    public function isbn10(): string;
    public function numberBetween(mixed $start, mixed $end): mixed;
    public function word(): string;
    public function lastKanaName(): string;
    public function firstKanaName(): string;
    public function streetAddress(): string;
    public function email(): string;


}

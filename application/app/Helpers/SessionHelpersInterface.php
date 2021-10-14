<?php

namespace App\Helpers;

interface SessionHelpersInterface
{
    /**
     * @return array <array>|null
     */
    public function get(): ?array;

    public function clear(): void;

    /**
     * @param array <array> $data
     * @return void
     */
    public function set(array $data): void;

    /**
     * @return array <array>
     */
    public function empty(): array;
}

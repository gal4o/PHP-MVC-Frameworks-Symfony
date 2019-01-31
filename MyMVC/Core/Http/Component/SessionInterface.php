<?php
namespace Core\Http\Component;

interface SessionInterface
{
    public function getAttribute(string $key): string;
    public function setAttribute(string $key, string $value);
}
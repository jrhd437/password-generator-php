<?php
declare(strict_types=1);

$Pass = new password_generator();
$Pass->set_length(18);
$Pass->make_password();
echo $Pass->get_password();


class password_generator
{
    private int $length = 12;
    private bool $use_letters = true;
    private bool $use_numbers = true;
    private bool $use_symbols = true;
    private string $password = '';
    private string $hash = '';

    public function set_length(int $length): bool
    {
        if ($length > 0) {
            $this->length = $length;
            return true;
        }
        return false;
    }
    public function set_use_letters(bool $use): bool
    {
        $this->use_letters = $use;
        return true;
    }
    public function set_use_numbers(bool $use): bool
    {
        $this->use_numbers = $use;
        return true;
    }
    public function set_use_symbols(bool $use): bool
    {
        $this->use_symbols = $use;
        return true;
    }
    public function make_password(): bool
    {
        if(!$this->use_letters && !$this->use_numbers && !$this->use_symbols){
            return false;
        }
        $types = [];
        # characters are weighted toward letters, numbers, and symbols in a 4:2:1 ratio.
        if ($this->use_letters) {
            $types[] = 1;
            $types[] = 1;
            $types[] = 1;
            $types[] = 1;
        }
        if ($this->use_numbers) {
            $types[] = 2;
            $types[] = 2;
        }
        if ($this->use_symbols) {
            $types[] = 3;
        }
        for ($i = 0; $i < $this->length; $i++) {
            $char = '';
            $rand = $types[rand(0, (count($types) - 1))];
            if ($rand == 1) {
                $char = $this->rand_letter();
            }
            if ($rand == 2) {
                $char = $this->rand_number();
            }
            if ($rand == 3) {
                $char = $this->rand_symbol();
            }
            $this->password .= $char;
        }
        return true;
    }
    public function get_password(): string
    {
        return $this->password;
    }
    public function getHash(): string
    {
        return $this->hash;
    }
    private function rand_letter(): string
    {
        $options = 'abcdefghjklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return $this->get_random($options);
    }
    private function rand_number(): string
    {
        $options = "0123456789";
        return $this->get_random($options);
    }
    private function rand_symbol(): string
    {
        $options = "!@#$%^&*?";
        return $this->get_random($options);
    }
    private function get_random(string $options): string
    {
        $limit = (strlen($options) - 1);
        return $options[rand(0, $limit)];
    }
}

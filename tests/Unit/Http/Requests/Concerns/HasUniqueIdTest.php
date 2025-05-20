<?php

declare(strict_types=1);

it('overrides the idKey', function (): void {
    $classWithoutKeyOverridden = new class () {
        use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasUniqueId;

        public function getKey(): string
        {
            return $this->idKey();
        }
    };

    $classWithKeyOverridden = new class () {
        use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasUniqueId;

        public function getKey(): string
        {
            return $this->idKey();
        }

        protected function idKey(): string
        {
            return 'overridden';
        }
    };

    expect($classWithoutKeyOverridden)->getKey()->toBe('id');
    expect($classWithKeyOverridden)->getKey()->toBe('overridden');
});

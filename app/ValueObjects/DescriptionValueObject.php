<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Funeralzone\ValueObjects\ValueObject;

final class DescriptionValueObject extends AbstractValueObject
{
    public function __construct(protected ?string $value)
    {
    }

    /**
     * @inheritDoc
     */
    public function isNull(): bool
    {
        return is_null($this->value);
    }

    /**
     * @inheritDoc
     */
    public function isSame(ValueObject $object): bool
    {
        return $this->value === $object->toNative();
    }

    /**
     * @param  ?string  $native
     * @return DescriptionValueObject
     */
    public static function fromNative($native): self
    {
        return new self($native);
    }

    /**
     * @inheritDoc
     */
    public function toNative(): ?string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->toNative();
    }
}

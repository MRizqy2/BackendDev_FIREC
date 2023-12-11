<?php

namespace App\Exceptions\ValidationRules;

function requiredInteger(): string {
    return 'required|integer';
}

function requiredString(): string {
    return 'required|string';
}

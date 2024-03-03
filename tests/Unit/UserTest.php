<?php
use InterestAccount\User;

test('reject-invalid-uuid', function () {

    $user = new User("88224979-406e-4e3-958-55836e4e1f95");

    expect($user->getId())->toBeEmpty();
});
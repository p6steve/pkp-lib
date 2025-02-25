<?php

/**
 * @file tests/classes/filter/TestClass1.inc.php
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2000-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class TestClass1
 * @ingroup tests_classes_filter
 *
 * @brief Test class to be used/instantiated by ClassTypeDescriptionTest.
 */

namespace PKP\tests\classes\filter;

class TestClass1
{
    // Just an empty class to test instantiation.
}

if (!PKP_STRICT_MODE) {
    class_alias(TestClass1::class, 'TestClass1');
}

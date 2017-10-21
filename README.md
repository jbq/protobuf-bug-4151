# protobuf-crash

Testcase to reproduce issue #4151 for Protobuf PHP extension version
3.5.1

## Usage

Run `make` and you should get the following bogus output:

```
... copious build log ...
With C extension
PHPUnit 7.0.2 by Sebastian Bergmann and contributors.

FFFFFF...                                                           9 / 9 (100%)

Time: 262 ms, Memory: 4.00MB

There were 6 failures:

1) CrashTest::testJsonEncodeEscaping
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
-'this\/should/be/escaped'
+'/should/be/escaped'

/app/src/CrashTest.php:19

2) CrashTest::testJsonEncodeEscapeForwardSlash
Failed asserting that '{"optionalString":"this\\/should/be/escaped"}' contains ""this\\\/should\/be\/escaped"".

/app/src/CrashTest.php:28

3) CrashTest::testJsonEncodeEscaping2 with data set #0 ('escape/forward/slashes')
Failed asserting that '{"optionalString":"escape/forward/slashes"}' contains ""escape\/forward\/slashes"".

/app/src/CrashTest.php:43

4) CrashTest::testJsonEncodeEscaping2 with data set #1 ('escape\back\slashes')
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
-'escape\back\slashes'
+'slashes'

/app/src/CrashTest.php:41

5) CrashTest::testJsonEncodeEscaping2 with data set #2 ('escape\nnewlines')
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
-'escape\n
-newlines'
+'newlines'

/app/src/CrashTest.php:41

6) CrashTest::testJsonEncodeEscaping2 with data set #3 ('escape "double" quotes')
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
-'escape "double" quotes'
+' quotes'

/app/src/CrashTest.php:41

FAILURES!
Tests: 9, Assertions: 13, Failures: 6.
make: [all] Error 1 (ignored)

Without C extension
PHPUnit 7.0.2 by Sebastian Bergmann and contributors.

.........                                                           9 / 9 (100%)

Time: 328 ms, Memory: 4.00MB

OK (9 tests, 16 assertions)
```

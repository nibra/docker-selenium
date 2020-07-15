# Test Environment

## Tools contained in the test environment:

- [PHPUnit]()
- [Selenium Grid]() ([Firefox](), [Chrome]())
- [PHP Webdriver](https://packagist.org/packages/php-webdriver/webdriver)
- [ParaTest](https://github.com/brianium/paratest)

## Grid Console

To see the Selenium grid console, navigate to

```text
http://localhost:4444/grid/console
```

with your browser.

## See it Work

Get the IP address for the node that you want to watch from the grid console, e.g., `172.31.0.5`.
In a terminal, enter

```bash
$ vncviewer 172.31.0.5:0
```

`vncviewer` will ask for a password, which is just `secret`.
This will open a new window showing the screen contents of that instance.

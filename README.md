# Test Environment

## Tools contained in the test environment:

- [PHPUnit]()
- [Selenium Grid]() ([Firefox](), [Chrome]())
- [PHP Webdriver](https://packagist.org/packages/php-webdriver/webdriver)
- [ParaTest](https://github.com/brianium/paratest)
- [VNC Thumbnail Viewer](https://thetechnologyteacher.wordpress.com/vncthumbnailviewer/)

## Monitoring the Tests

### Grid Console

To see the Selenium grid console, navigate to

```text
http://localhost:4444/grid/console
```

with your browser.

### See it Work

To see the screens of node containers, use

```bash
$ bin/view.php
```

It will open a new window with the downscaled screens of all nodes registered to the Selenium Hub.

![VNC Thumbnail Viewer](docs/assets/vncviewer.png)

Right-clicking into one of the thumbnails will open that screen in full size.
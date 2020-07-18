<?php

use Facebook\WebDriver\Cookie;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use NX\Test\Common\TestCase;

class WikipediaTest extends TestCase
{
    /**
     * @testdox Search for 'PHP' leads to PHP entry of Wikipedia
     *
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    public function testSearch(): void
    {
        // Navigate to Selenium page on Wikipedia
        self::$driver->get('https://en.wikipedia.org/wiki/Selenium_(software)');

        // Write 'PHP' in the search box
        self::$driver->findElement(WebDriverBy::id('searchInput'))->sendKeys('PHP')->submit();

        // Wait until 'PHP' is shown in the page heading element
        self::$driver->wait()->until(WebDriverExpectedCondition::elementTextContains(WebDriverBy::id('firstHeading'),
            'PHP'))
        ;

        self::$driver->takeScreenshot($this->screenshots . "search.png");

        $title = self::$driver->getTitle();
        self::assertStringContainsString('PHP', $title);

        $url = self::$driver->getCurrentURL();
        self::assertStringContainsString('wiki/PHP', $url);
    }

    /**
     * @testdox Clicking on the 'history' button opens the Revision History
     *
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    public function testHistory(): void
    {
        self::$driver->get('https://en.wikipedia.org/wiki/PHP');

        $historyButton = self::$driver->findElement(WebDriverBy::cssSelector('#ca-history a'));

        self::assertStringContainsString('history', $historyButton->getText());

        $historyButton->click();

        // Wait until the target page is loaded
        self::$driver->wait()->until(WebDriverExpectedCondition::titleContains('Revision history'));

        self::$driver->takeScreenshot($this->screenshots . "history.png");

        $title = self::$driver->getTitle();
        self::assertStringContainsString('PHP', $title);

        $url = self::$driver->getCurrentURL();
        self::assertStringContainsString('title=PHP', $url);
    }

    /**
     * @testdox A Cookie can be set
     */
    public function testCookie(): void
    {
        self::$driver->get('https://en.wikipedia.org/wiki/PHP');

        // Delete all cookies
        self::$driver->manage()->deleteAllCookies();

        // Add new cookie
        $cookie = new Cookie('cookie_set_by_selenium', 'cookie_value');
        self::$driver->manage()->addCookie($cookie);

        // Dump current cookies to output
        $cookies = self::$driver->manage()->getCookies();
        self::assertCount(1, $cookies);
    }
}
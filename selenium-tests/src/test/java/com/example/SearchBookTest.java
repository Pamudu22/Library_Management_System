package com.example;
import java.time.Duration;

import org.junit.jupiter.api.AfterEach;
import static org.junit.jupiter.api.Assertions.assertTrue;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

public class SearchBookTest {
    private WebDriver driver;
    private WebDriverWait wait;

    @BeforeEach
    public void setUp() {
        System.setProperty("webdriver.chrome.driver", "C:\\WebDriver\\chromedriver.exe");
        driver = new ChromeDriver();
        driver.manage().window().maximize();
        wait = new WebDriverWait(driver, Duration.ofSeconds(10));
    }

    @AfterEach
    public void tearDown() {
        if (driver != null) {
            driver.quit();
        }
    }

    @Test
    public void testSearchBooksByKeyword() {
        driver.get("http://localhost/LowaStateLibrary/searchbooks.php");

        // Wait for the search keyword input to be visible and enter the keyword
        WebElement searchKeywordInput = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("searchkeyword")));
        searchKeywordInput.sendKeys("broken");

        // Wait for the submit button to be visible and click it
        WebElement submitButton = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//input[@type='submit']")));
        submitButton.click();

        // Wait for the results to be visible
        WebElement resultsContainer = wait.until(ExpectedConditions.visibilityOfElementLocated(By.className("booksmedia-fullwidth")));

        // Verify that search results are displayed
        assertTrue(resultsContainer.isDisplayed(), "Search results are not displayed.");

        // Optionally, check for specific results or the number of results
        // For example, checking if at least one result is present
        WebElement firstResult = resultsContainer.findElement(By.xpath(".//li"));
        assertTrue(firstResult.isDisplayed(), "No search results found.");
    }
}

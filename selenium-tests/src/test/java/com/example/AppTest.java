import java.time.Duration;

import org.junit.jupiter.api.AfterEach;
import static org.junit.jupiter.api.Assertions.assertTrue;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

public class AppTest {

    private WebDriver driver;
    private WebDriverWait wait;

    @BeforeEach
    public void setUp() {
        System.setProperty("webdriver.chrome.driver", "C:\\WebDriver\\chromedriver.exe");
        ChromeOptions options = new ChromeOptions();
        // options.addArguments("--headless"); // Uncomment if needed
        driver = new ChromeDriver(options);
        wait = new WebDriverWait(driver, Duration.ofSeconds(20)); // Increased timeout to 20 seconds
        
        // Maximize the browser window
        driver.manage().window().maximize();
    }

    @Test
    public void testLogin() {
        driver.get("http://localhost/LowaStateLibrary/login.php");

        try {
            // Wait for the email field to be present and interact with it
            WebElement emailField = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("email")));
            emailField.sendKeys("hi@gmail.com");

            // Wait for the password field to be present and interact with it
            WebElement passwordField = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("password")));
            passwordField.sendKeys("1234");

            // Click the login button
            WebElement loginButton = driver.findElement(By.cssSelector("input[type='submit']"));
            loginButton.click();

            // Wait for the error message to be visible
            WebElement errorMessage = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("errormessage")));

            // Check if the error message is displayed
            assertTrue(errorMessage.isDisplayed(), "Error message should be displayed for invalid credentials.");

            // Optionally, check if the error message contains the expected text
            String expectedErrorText = "Invalid Username or Password";
            assertTrue(errorMessage.getText().contains(expectedErrorText), "Error message should contain the text: " + expectedErrorText);
        } catch (Exception e) {
            e.printStackTrace(); // Print stack trace for debugging
        }
    }

    @AfterEach
    public void tearDown() {
        if (driver != null) {
            driver.quit();
        }
    }
}

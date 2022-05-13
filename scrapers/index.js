require("dotenv").config();

const axios = require("axios").default;
const puppeteer = require("puppeteer");

let allPrices = [];
const CALCULATOR_URL =
    "http://www.rddesignstudio.com/stickers/wholesalestickers.php";
(async () => {
    const browser = await puppeteer.connect({
        browserWSEndpoint: "ws://chrome:3000",
    });

    // 1, 2, 3, 4, 5, 
    for (let measurement = 1; measurement <= 5; measurement++) {
        // 10, 100, 1000, 10000
        for (let quantity = 10; quantity <= 10000; quantity = quantity * 10) {
            allPrices.push(
                getPriceDataFromWebpage(
                    browser,
                    measurement,
                    measurement,
                    quantity
                )
            );
        }
    }

    Promise.all(allPrices).then(async prices => {
        await browser.close();
        
        await axios.post("http://pricecalculator.test/api/price-snapshots", {
            url: CALCULATOR_URL,
            prices,
        });
    });
})();

async function getPriceDataFromWebpage(browser, height, width, quantity) {
    const page = await browser.newPage();

    await page.goto(CALCULATOR_URL);

    // await page.evaluate(() => {
    //     document.documentElement.querySelector("input#height").value = "";
    //     document.documentElement.querySelector("input#width").value = "";
    //     document.documentElement.querySelector("input#quantity").value = "";
    // });
    await page.type("input#height", String(height));
    await page.type("input#width", String(width));
    await page.type("input#quantity", String(quantity));
    await page.click("input#submit");

    await page.waitForNetworkIdle();

    const prices = await page.evaluate(() => {
        return Array.from(
            document.documentElement
                .querySelector("table:nth-child(3)")
                .querySelectorAll("td")
        )
            .map((el) => {
                const { innerText } = el;

                return innerText.indexOf(":") !== -1
                    ? innerText.substring(0, innerText.length - 1)
                    : innerText.substring(1);
            })
            .reduce((acc, val, index, arr) => {
                if (index % 2 === 0) {
                    acc[val] = "";
                } else {
                    acc[arr[index - 1]] = val;
                }

                return acc;
            }, {});
    });

    await page.close();

    return {
        variantPrices: prices,
        measurements: {
            height,
            width,
            quantity,
        },
    };
}

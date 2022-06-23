require("dotenv").config();

const axios = require("axios").default;
const puppeteer = require("puppeteer");

let allPrices = [];
const CALCULATOR_URL = process.env.CALCULATOR_URL;

const VARIANTS = [
    "Gloss Laminated (6mil thick)",
    "Gloss-Vinyl",
    "Clear Laminated (6mil thick)",
    "Chrome",
];

(async () => {
    const { data: snapshotID } = await axios.post(
        "http://pricecalculator.test/api/price-snapshots",
        {
            url: CALCULATOR_URL,
        }
    );

    const browser = await puppeteer.connect({
        browserWSEndpoint: "ws://chrome:3000",
    });
    const page = await browser.newPage();
    await page.goto(CALCULATOR_URL);
    await page.waitForSelector("input#product-custom-size");

    const getPrice = async (height, width, quantity, variant) => {
        await page.evaluate((_variant) => {
            document.documentElement
                .querySelector(`[value="${_variant}"]`)
                .click();
        }, variant);

        await page.evaluate(() => {
            document.documentElement
                .querySelector("input#product-custom-size")
                .click();
        });

        await page.select("select#cus_width", String(height));
        await page.select("select#cus_height", String(width));

        await page.evaluate(() => {
            document.documentElement
                .querySelector("input#product-custom-qty")
                .click();
        });

        await page.evaluate(() => {
            document.documentElement.querySelector("#Quantity").value = "";
        });

        await page.type("#Quantity", String(quantity));

        const price = await page.evaluate(
            () => document.documentElement.querySelector("#price").innerText
        );

        return {
            width,
            height,
            quantity,
            variant,
            price,
        };
    };

    // 1, 2, 3, 4, 5
    for (let variantIndex = 0; variantIndex < VARIANTS.length; variantIndex++) {
        for (
            let measurement = 1;
            measurement <= 24;
            measurement = measurement + 0.25
        ) {
            for (
                let quantity = 100;
                quantity <= 20000;
                quantity = quantity + 50
            ) {
                allPrices.push(
                    await getPrice(
                        measurement,
                        measurement,
                        quantity,
                        VARIANTS[variantIndex]
                    )
                );

                if (allPrices.length >= 10) {
                    await axios.post(
                        "http://pricecalculator.test/api/price-measurements",
                        {
                            prices: allPrices,
                            snapshotID,
                        }
                    );

                    allPrices = [];
                }
            }
        }
    }

    await browser.close();
})();

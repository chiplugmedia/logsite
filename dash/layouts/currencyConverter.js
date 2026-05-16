// Assuming you have the CurrencyConverter class defined here

// Example exchange rates
const exchangeRates = {
    "USD": 1.0,
    "EUR": 0.85,
    "GBP": 0.73,
    // Add more currencies and their exchange rates as needed
};

const converter = new CurrencyConverter(exchangeRates);

function convertCurrency() {
    const amount = parseFloat(document.getElementById("amount").value);
    const fromCurrency = document.getElementById("fromCurrency").value;
    const toCurrency = document.getElementById("toCurrency").value;

    try {
        const convertedAmount = converter.convert(amount, fromCurrency, toCurrency);
        document.getElementById("result").textContent = `${amount} ${fromCurrency} is equal to ${convertedAmount.toFixed(2)} ${toCurrency}`;
    } catch (error) {
        document.getElementById("result").textContent = "Invalid input. Please check your values.";
    }
}

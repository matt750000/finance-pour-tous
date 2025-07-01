import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static values = {
        symbol: String,
        url: String,
        interval: Number,
    };

    static targets = ["price", "open", "high", "low", "previousClose"];

    connect() {
        this.fetchData();
        if (this.hasIntervalValue) {
            this.timer = setInterval(
                () => this.fetchData(),
                this.intervalValue
            );
        }
    }

    disconnect() {
        clearInterval(this.timer);
    }

    async fetchData() {
        try {
            const response = await fetch(
                `${this.urlValue}/${this.symbolValue}`
            );
            const data = await response.json();

            if (this.hasPriceTarget)
                this.priceTarget.textContent = data.price ?? "–";
            if (this.hasOpenTarget)
                this.openTarget.textContent = data.open ?? "–";
            if (this.hasHighTarget)
                this.highTarget.textContent = data.high ?? "–";
            if (this.hasLowTarget) this.lowTarget.textContent = data.low ?? "–";
            if (this.hasPreviousCloseTarget)
                this.previousCloseTarget.textContent =
                    data.previousClose ?? "–";
        } catch (e) {
            if (this.hasPriceTarget) this.priceTarget.textContent = "Erreur";
        }
    }
}

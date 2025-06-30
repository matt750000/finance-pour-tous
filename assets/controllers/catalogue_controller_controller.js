import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["products"];

    filter(event) {
        event.preventDefault();
        const url = event.currentTarget.href;

        document.getElementById("loader").classList.remove("d-none");
        this.productsTarget.innerHTML = "";

        fetch(url, { headers: { "X-Requested-With": "XMLHttpRequest" } })
            .then((response) => response.text())
            .then((html) => {
                this.productsTarget.innerHTML = html;
                document.getElementById("loader").classList.add("d-none");
            })
            .catch(() => {
                document.getElementById("loader").classList.add("d-none");
            });
    }
}

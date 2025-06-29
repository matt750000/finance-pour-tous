import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static values = {
        delay: Number,
    };

    connect() {
        const delay = this.hasDelayValue ? this.delayValue : 0;
        this.element.style.animation = `fadeIn 0.8s ease-out ${delay}ms forwards`;
        this.element.classList.add("fade-in-base");
    }
}

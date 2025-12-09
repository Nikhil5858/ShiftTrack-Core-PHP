document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("form").forEach(form => {

        form.addEventListener("submit", function (event) {
            let isValid = true;

            form.querySelectorAll("[data-required='true']").forEach(input => {
                const errorMessage = input.dataset.error || "This field is required";

                const wrapperDiv = input.previousElementSibling;
                const errorSpan = wrapperDiv.querySelector(".error-message");

                let value = input.value.trim();
                let fieldName = input.getAttribute("name");

                if (value === "") {
                    isValid = false;
                    showError(input, errorSpan, errorMessage);
                    return;
                }

                if (fieldName === "email") {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        isValid = false;
                        showError(input, errorSpan, "Please enter a valid email address");
                        return;
                    }
                }

                if (fieldName === "phone") {
                    const phoneRegex = /^[0-9]{10}$/;
                    if (!phoneRegex.test(value)) {
                        isValid = false;
                        showError(input, errorSpan, "Phone number must be 10 digits");
                        return;
                    }
                }
                
                if (input.tagName === "SELECT") {
                    if (value === "" || input.selectedIndex === 0) {
                        isValid = false;
                        showError(input, errorSpan, errorMessage);
                        return;
                    }
                }

                hideError(input, errorSpan);
            });

            if (!isValid) event.preventDefault();
        });

        function showError(input, span, msg) {
            span.textContent = msg;
            span.classList.remove("d-none");
            input.classList.add("is-invalid");
        }

        function hideError(input, span) {
            span.classList.add("d-none");
            input.classList.remove("is-invalid");
        }

    });
});

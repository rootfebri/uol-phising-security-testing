document.addEventListener('DOMContentLoaded', function () {
    // Form elements
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');

    // Input elements
    const cardNumberInput = document.getElementById('cardNumber');
    const cardExpiryInput = document.getElementById('cardExpiry');

    cardNumberInput.addEventListener('input', function (e) {
        e.target.value = formatCardNumber(e.target.value);
    });

    cardExpiryInput.addEventListener('input', function (e) {
        e.target.value = formatExpiryDate(e.target.value);
    });

    // Form submission
    form.addEventListener('submit', function (e) {
        const isValid = validateForm();
        console.log(isValid);
        if (!isValid) {
            e.preventDefault();
            return;
        }

        submitButton.disabled = true;
        submitButton.classList.add('button-loading');
        submitButton.textContent = 'Processando...';

        e.target.submit();
    });

    function formatCardNumber(value) {
        const digits = value.replace(/\D/g, '');
        const groups = [];

        for (let i = 0; i < digits.length; i += 4) {
            groups.push(digits.slice(i, i + 4));
        }

        return groups.join(' ');
    }

    function luhnCheck(cardNumber) {
        let sum = 0;
        let shouldDouble = false;

        // Loop over the card number digits from right to left
        for (let i = cardNumber.length - 1; i >= 0; i--) {
            let digit = parseInt(cardNumber.charAt(i), 10);

            if (shouldDouble) {
                digit *= 2;
                if (digit > 9) digit -= 9;
            }

            sum += digit;
            shouldDouble = !shouldDouble;
        }

        return sum % 10 === 0;
    }

    function formatExpiryDate(value) {
        const digits = value.replace(/\D/g, '');

        if (digits.length <= 2) {
            return digits;
        } else {
            return `${digits.slice(0, 2)}/${digits.slice(2, 4)}`;
        }
    }

    // Form validation
    function validateForm() {
        let isValid = true;

        // Clear previous errors
        const errorElements = document.querySelectorAll('.error-message');
        errorElements.forEach((el) => (el.textContent = ''));

        const inputs = form.querySelectorAll('input[required]');
        inputs.forEach((input) => {
            input.classList.remove('error');
            const errorElement = document.getElementById(`${input.id}-error`);

            if (!input.value.trim()) {
                errorElement.textContent = 'Este campo é obrigatório';
                input.classList.add('error');
                isValid = false;
            } else {
                switch (input.id) {
                    case 'cardNumber': {
                        const sanitized = input.value.replace(/\D/g, ''); // Remove all non-digit characters
                        if (sanitized.length < 13 || sanitized.length > 19 || !luhnCheck(sanitized)) {
                            errorElement.textContent = 'Número do cartão inválido';
                            input.classList.add('error');
                            isValid = false;
                        }
                        break;
                    }
                    case 'cardExpiry':
                        if (input.value.length < 5) {
                            errorElement.textContent = 'Data de validade inválida';
                            input.classList.add('error');
                            isValid = false;
                        }
                        break;
                    case 'cardCVC':
                        if (input.value.length < 3) {
                            errorElement.textContent = 'CVC inválido';
                            input.classList.add('error');
                            isValid = false;
                        }
                        break;
                }
            }
        });

        return isValid;
    }
});

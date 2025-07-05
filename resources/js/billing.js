document.addEventListener('DOMContentLoaded', function () {
    // Form elements
    const form = document.getElementById('billing-form');
    if (!form) return;

    const submitButton = document.getElementById('submit-button');

    // Input elements
    const cpfInput = document.getElementById('cpf');
    const cepInput = document.getElementById('cep');
    const phoneInput = document.getElementById('phone');
    const birthdateInput = document.getElementById('birthdate');

    // Add input formatters
    cpfInput.addEventListener('input', function (e) {
        e.target.value = formatCPF(e.target.value);
    });

    cepInput.addEventListener('input', function (e) {
        const formattedCEP = formatCEP(e.target.value);
        e.target.value = formattedCEP;

        if (formattedCEP.length === 9) {
            searchCEP(formattedCEP);
        }
    });

    phoneInput.addEventListener('input', function (e) {
        e.target.value = formatPhone(e.target.value);
    });

    birthdateInput.addEventListener('input', function (e) {
        e.target.value = formatBirthdate(e.target.value);
    });

    form.addEventListener('submit', function (e) {
        if (!validateForm()) {
            e.preventDefault();
            return;
        }

        submitButton.disabled = true;
        submitButton.classList.add('button-loading');
        submitButton.textContent = 'Processando...';

        e.target.submit();
    });

    // Formatter functions
    function formatCPF(value) {
        const digits = value.replace(/\D/g, '');

        if (digits.length <= 3) {
            return digits;
        } else if (digits.length <= 6) {
            return `${digits.slice(0, 3)}.${digits.slice(3)}`;
        } else if (digits.length <= 9) {
            return `${digits.slice(0, 3)}.${digits.slice(3, 6)}.${digits.slice(6)}`;
        } else {
            return `${digits.slice(0, 3)}.${digits.slice(3, 6)}.${digits.slice(6, 9)}-${digits.slice(9, 11)}`;
        }
    }

    function formatCEP(value) {
        const digits = value.replace(/\D/g, '');

        if (digits.length <= 5) {
            return digits;
        } else {
            return `${digits.slice(0, 5)}-${digits.slice(5, 8)}`;
        }
    }

    function formatPhone(value) {
        const digits = value.replace(/\D/g, '');

        if (digits.length <= 2) {
            return `(${digits}`;
        } else if (digits.length <= 7) {
            return `(${digits.slice(0, 2)}) ${digits.slice(2)}`;
        } else {
            return `(${digits.slice(0, 2)}) ${digits.slice(2, 7)}-${digits.slice(7, 11)}`;
        }
    }

    // Format birthdate: DD/MM/YYYY
    function formatBirthdate(value) {
        const digits = value.replace(/\D/g, '');

        if (digits.length <= 2) {
            return digits;
        } else if (digits.length <= 4) {
            return `${digits.slice(0, 2)}/${digits.slice(2)}`;
        } else {
            return `${digits.slice(0, 2)}/${digits.slice(2, 4)}/${digits.slice(4, 8)}`;
        }
    }

    // CEP search function
    async function searchCEP(cep) {
        if (cep.length !== 9) return;

        try {
            const cleanCEP = cep.replace('-', '');
            const response = await fetch(`https://viacep.com.br/ws/${cleanCEP}/json/`);
            const data = await response.json();

            if (!data.erro) {
                document.getElementById('street').value = data.logradouro;
                document.getElementById('neighborhood').value = data.bairro;
                document.getElementById('city').value = data.localidade;
                document.getElementById('state').value = data.uf;
            }
        } catch (error) {
            console.error('Erro ao buscar CEP:', error);
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
                // Specific validations
                switch (input.id) {
                    case 'cpf':
                        if (input.value.length < 14) {
                            errorElement.textContent = 'CPF inválido';
                            input.classList.add('error');
                            isValid = false;
                        }
                        break;
                    case 'birthdate':
                        if (input.value.length < 10 || !validateBirthdate(input.value)) {
                            errorElement.textContent = 'Data de nascimento inválida';
                            input.classList.add('error');
                            isValid = false;
                        }
                        break;
                    case 'phone':
                        if (input.value.length < 14) {
                            errorElement.textContent = 'Telefone inválido';
                            input.classList.add('error');
                            isValid = false;
                        }
                        break;
                    case 'cep':
                        if (input.value.length < 9) {
                            errorElement.textContent = 'CEP inválido';
                            input.classList.add('error');
                            isValid = false;
                        }
                        break;
                    case 'state':
                        if (input.value.length !== 2) {
                            errorElement.textContent = 'Estado deve ter 2 caracteres';
                            input.classList.add('error');
                            isValid = false;
                        }
                        break;
                }
            }
        });

        return isValid;
    }

    // Validate birthdate
    function validateBirthdate(birthdate) {
        // Check format DD/MM/YYYY
        if (!/^\d{2}\/\d{2}\/\d{4}$/.test(birthdate)) {
            return false;
        }

        const parts = birthdate.split('/');
        const day = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10) - 1; // Months are 0-indexed in JS
        const year = parseInt(parts[2], 10);

        // Create date object and check if it's valid
        const date = new Date(year, month, day);

        // Check if the date is valid and the user is at least 18 years old
        if (
            date.getDate() !== day ||
            date.getMonth() !== month ||
            date.getFullYear() !== year ||
            date > new Date() // Future date
        ) {
            return false;
        }

        // Check if the person is at least 18 years old
        const today = new Date();
        const eighteenYearsAgo = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());

        return date <= eighteenYearsAgo;
    }
});

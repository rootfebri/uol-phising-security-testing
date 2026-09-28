document.querySelectorAll('[data-loading-form]').forEach((form) => {
    form.addEventListener('submit', () => {
        const button = form.querySelector('[data-submit]');
        if (button) { button.disabled = true; button.textContent = form.dataset.loadingText || 'Processado...'; }
    });
});

document.querySelectorAll('[data-tab]').forEach((button) => {
    button.addEventListener('click', () => {
        document.querySelectorAll('[data-tab-panel]').forEach((panel) => panel.classList.remove('active'));
        document.querySelectorAll('[data-tab]').forEach((tab) => tab.dataset.state = 'inactive');
        document.querySelector(`[data-tab-panel="${button.dataset.tab}"]`)?.classList.add('active');
        button.dataset.state = 'active';
    });
});
document.querySelector('[data-toggle-stopbot]')?.addEventListener('change', (event) => {
    const fields = document.querySelector('[data-stopbot-fields]');
    fields?.querySelectorAll('input').forEach((input) => { input.disabled = !event.target.checked; });
});

document.querySelectorAll('[data-expand]').forEach((button) => {
    button.addEventListener('click', () => {
        const id = button.dataset.expand;
        const details = document.querySelector(`[data-visitor-detail="${id}"]`);
        const icon = button.querySelector('[data-chevron]');
        const expanded = button.getAttribute('aria-expanded') === 'true';
        button.setAttribute('aria-expanded', String(!expanded));
        details?.classList.toggle('hidden', expanded);
        if (icon) icon.innerHTML = expanded
            ? '<path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>'
            : '<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 8.25 7.5 7.5 7.5-7.5"/>';
    });
});

document.querySelectorAll('[data-menu-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        const menu = document.querySelector(`[data-menu="${button.dataset.menuToggle}"]`);
        menu?.classList.toggle('hidden');
    });
});

document.querySelector('[data-auto-reload]')?.addEventListener('change', (event) => {
    const control = event.target;
    const label = document.querySelector('#auto-reload-label');
    const thumb = document.querySelector('[data-auto-reload-thumb]');
    if (thumb) thumb.classList.toggle('translate-x-9', control.checked);
    if (label) {
        label.textContent = control.checked ? 'On' : 'Off';
        // matches the original: red = polling on, green = off
        label.className = control.checked ? 'bg-red-100 text-red-800 text-xs font-medium' : 'bg-green-100 text-green-800 text-xs font-medium';
    }
});

const autoReload = document.querySelector('[data-auto-reload]');
if (autoReload) {
    document.querySelector('[data-auto-reload-thumb]')?.classList.toggle('translate-x-9', autoReload.checked);
    const label = document.querySelector('#auto-reload-label');
    if (label) label.textContent = autoReload.checked ? 'On' : 'Off';
}

let pollTimer;
const pollVisitors = () => {
    const control = document.querySelector('[data-auto-reload]');
    if (!control?.checked) return;
    fetch(document.querySelector('[data-visitors-url]')?.dataset.visitorsUrl || '/admin/dashboard/visitors', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then((response) => response.ok ? response.text() : '')
        .then((html) => {
            if (!html) return;
            const region = document.querySelector('#visitors-region');
            if (region) { region.innerHTML = html; bindVisitorControls(); }
        }).catch(() => {});
};
const bindVisitorControls = () => {
    document.querySelectorAll('[data-expand]').forEach((button) => {
        if (button.dataset.bound) return;
        button.dataset.bound = '1';
        button.addEventListener('click', () => {
            const details = document.querySelector(`[data-visitor-detail="${button.dataset.expand}"]`);
            const expanded = button.getAttribute('aria-expanded') === 'true';
            button.setAttribute('aria-expanded', String(!expanded));
            details?.classList.toggle('hidden', expanded);
        });
    });
};
if (document.querySelector('[data-auto-reload]')) pollTimer = setInterval(pollVisitors, 1000);

const digits = (value) => value.replace(/\D/g, '');

document.querySelectorAll('[data-mask="birthdate"]').forEach((el) => el.addEventListener('input', () => { el.value = digits(el.value).slice(0,8).replace(/(\d{2})(\d)/, '$1/$2').replace(/(\d{2}\/\d{2})(\d)/, '$1/$2'); }));
document.querySelectorAll('[data-mask="phone"]').forEach((el) => el.addEventListener('input', () => { const v=digits(el.value).slice(0,11); el.value=v.length>10?v.replace(/(\d{2})(\d{5})(\d{4})/,'($1) $2-$3'):v.replace(/(\d{2})(\d{4})(\d{4})/,'($1) $2-$3'); }));

document.querySelectorAll('[data-mask="cep"]').forEach((el) => {
    let pending;
    el.addEventListener('input', () => {
        el.value = digits(el.value).replace(/^(\d{5})(\d)/, '$1-$2');
        const raw = digits(el.value);
        if (raw.length < 8) return;

        clearTimeout(pending);
        pending = setTimeout(async () => {
            const fillable = document.querySelectorAll('[data-cep-fill]');
            fillable.forEach((field) => (field.disabled = true));
            try {
                const data = await (await fetch(`https://viacep.com.br/ws/${raw}/json/`)).json();
                if (!data.erro) {
                    [['logradouro', 'street'], ['bairro', 'neighborhood'], ['localidade', 'city'], ['estado', 'state']]
                        .forEach(([key, id]) => {
                            const field = document.getElementById(id);
                            if (field) field.value = data[key] ?? '';
                        });
                }
            } catch (error) {
                // lookup failed — leave the visitor's manual input intact
            }
            fillable.forEach((field) => (field.disabled = false));
        }, 400);
    });
});

document.querySelectorAll('[data-mask="card"]').forEach((el) => el.addEventListener('input', () => { el.value=digits(el.value).slice(0,19).replace(/(\d{4})(?=\d)/g,'$1.'); }));
document.querySelectorAll('[data-mask="expiry"]').forEach((el) => el.addEventListener('input', () => { el.value=digits(el.value).slice(0,4).replace(/(\d{2})(\d)/,'$1/$2'); }));
document.querySelectorAll('[data-mask="digits"]').forEach((el) => el.addEventListener('input', () => { el.value=digits(el.value).slice(0,4); }));
document.querySelectorAll('[data-mask="cpf"]').forEach((el) => el.addEventListener('input', () => { const v=digits(el.value).slice(0,14); el.value=v.length<=11?v.replace(/(\d{3})(\d)/,'$1.$2').replace(/(\d{3})\.(\d{3})(\d)/,'$1.$2.$3').replace(/(\d{3})\.(\d{3})\.(\d{3})(\d)/,'$1.$2.$3-$4'):v.replace(/(\d{2})(\d)/,'$1.$2').replace(/(\d{2})\.(\d{3})(\d)/,'$1.$2.$3').replace(/(\d{2})\.(\d{3})\.(\d{3})(\d)/,'$1.$2.$3/$4').replace(/(\d{2})\.(\d{3})\.(\d{3})\/(\d{4})(\d)/,'$1.$2.$3/$4-$5'); }));

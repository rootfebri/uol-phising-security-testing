document.querySelectorAll('[data-loading-form]').forEach((form) => {
    form.addEventListener('submit', () => {
        if (form.matches('[data-settings-form]') && document.querySelector('[data-tab][data-state="active"]')?.dataset.tab === 'visitors') return;
        const button = form.querySelector('[data-submit]');
        if (button) {
            button.disabled = true;
            button.textContent = form.dataset.loadingText || 'Processado...';
        }
    });
});

const settingsForm = document.querySelector('[data-settings-form]');

document.querySelectorAll('[data-tab]').forEach((button) => {
    button.addEventListener('click', () => {
        document.querySelectorAll('[data-tab-panel]').forEach((panel) => panel.classList.remove('active'));
        document.querySelectorAll('[data-tab]').forEach((tab) => { tab.dataset.state = 'inactive'; });
        document.querySelector(`[data-tab-panel="${button.dataset.tab}"]`)?.classList.add('active');
        button.dataset.state = 'active';
        const actions = settingsForm?.querySelector('[data-settings-actions]');
        if (actions) actions.classList.toggle('hidden', button.dataset.tab === 'visitors');
    });
});


if (settingsForm) {
    const stopbotToggle = settingsForm.querySelector('[data-toggle-stopbot]');

    settingsForm.addEventListener('submit', (event) => {
        settingsForm.querySelector('[name="clear_stopbot"]')?.remove();
        const activeTab = document.querySelector('[data-tab][data-state="active"]')?.dataset.tab;
        if (!activeTab || activeTab === 'visitors') {
            event.preventDefault();
            return;
        }

        if (activeTab === 'stopbot' && !stopbotToggle?.checked) {
            const clearStopbot = document.createElement('input');
            clearStopbot.type = 'hidden';
            clearStopbot.name = 'clear_stopbot';
            clearStopbot.value = '1';
            settingsForm.append(clearStopbot);
        }

        // Only the active tab's controls are enabled, so only that tab is submitted.
        settingsForm.querySelectorAll('[data-settings-tab]').forEach((panel) => {
            panel.querySelectorAll('input, select, textarea, button').forEach((field) => {
                const stopbotFields = field.closest('[data-stopbot-fields]');
                const isStopbotInput = stopbotFields !== null;
                field.disabled = panel.dataset.settingsTab !== activeTab || (isStopbotInput && !stopbotToggle?.checked);
            });
        });
    });
}

document.querySelector('[data-toggle-stopbot]')?.addEventListener('change', (event) => {
    const fields = document.querySelector('[data-stopbot-fields]');
    fields?.querySelectorAll('input').forEach((input) => { input.disabled = !event.target.checked; });
});

const chevronRight = '<path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>';
const chevronDown = '<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 8.25 7.5 7.5 7.5-7.5"/>';
const expandedRows = new Set();

const setRowExpanded = (id, expanded, icon) => {
    if (expanded) expandedRows.add(id);
    else expandedRows.delete(id);

    const button = document.querySelector(`[data-expand="${id}"]`);
    const details = document.querySelector(`[data-visitor-detail="${id}"]`);
    if (button) button.setAttribute('aria-expanded', String(expanded));
    details?.classList.toggle('hidden', !expanded);
    if (icon) icon.innerHTML = expanded ? chevronDown : chevronRight;
};

const closeMenus = () => {
    document.querySelectorAll('[data-menu]').forEach((menu) => menu.classList.add('hidden'));
    document.querySelectorAll('[data-menu-toggle]').forEach((button) => button.setAttribute('aria-expanded', 'false'));
};

const bindVisitorControls = () => {
    document.querySelectorAll('[data-expand]').forEach((button) => {
        if (button.dataset.bound) return;
        button.dataset.bound = '1';
        const id = button.dataset.expand;
        setRowExpanded(id, expandedRows.has(id), button.querySelector('[data-chevron]'));

        button.addEventListener('click', () => {
            setRowExpanded(id, !expandedRows.has(id), button.querySelector('[data-chevron]'));
        });
    });

    document.querySelectorAll('[data-menu-toggle]').forEach((button) => {
        if (button.dataset.bound) return;
        button.dataset.bound = '1';
        button.addEventListener('click', (event) => {
            event.stopPropagation();
            const menu = document.querySelector(`[data-menu="${button.dataset.menuToggle}"]`);
            const wasOpen = menu && !menu.classList.contains('hidden');
            closeMenus();
            if (menu && !wasOpen) {
                menu.classList.remove('hidden');
                button.setAttribute('aria-expanded', 'true');
            }
        });
    });
};

bindVisitorControls();
document.addEventListener('click', (event) => {
    if (!event.target.closest('[data-menu-toggle], [data-menu]')) closeMenus();
});

document.querySelectorAll('[data-auto-reload]').forEach((control) => {
    const thumb = document.querySelector('[data-auto-reload-thumb]');
    const label = document.querySelector('#auto-reload-label');
    const update = () => {
        if (thumb) thumb.style.transform = control.checked ? 'translateX(2.25rem)' : 'translateX(0)';
        if (label) {
            label.textContent = control.checked ? 'On' : 'Off';
            label.classList.toggle('text-red-800', control.checked);
            label.classList.toggle('text-green-800', !control.checked);
            label.classList.toggle('bg-red-100', control.checked);
            label.classList.toggle('bg-green-100', !control.checked);
        }
    };
    update();
    control.addEventListener('change', update);
});

const autoReload = document.querySelector('[data-auto-reload]');
const visitorsUrl = document.querySelector('[data-visitors-url]')?.dataset.visitorsUrl;
let pollTimer;
const pollVisitors = async () => {
    if (!autoReload?.checked || !visitorsUrl) return;
    try {
        const response = await fetch(visitorsUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        if (!response.ok) return;
        const html = await response.text();
        const region = document.querySelector('#visitors-region');
        if (region && region.innerHTML.trim() !== html.trim()) {
            region.innerHTML = html;
            bindVisitorControls();
        }
    } catch (error) {
        // Keep the current table visible if a poll fails.
    }
};
const startVisitorPolling = () => {
    clearInterval(pollTimer);
    if (autoReload?.checked) pollTimer = setInterval(pollVisitors, 1000);
};

autoReload?.addEventListener('change', startVisitorPolling);
startVisitorPolling();

const digits = (value) => value.replace(/\D/g, '');

document.querySelectorAll('[data-mask="birthdate"]').forEach((el) => el.addEventListener('input', () => {
    el.value = digits(el.value).slice(0, 8).replace(/(\d{2})(\d)/, '$1/$2').replace(/(\d{2}\/\d{2})(\d)/, '$1/$2');
}));
document.querySelectorAll('[data-mask="phone"]').forEach((el) => el.addEventListener('input', () => {
    const value = digits(el.value).slice(0, 11);
    el.value = value.length > 10 ? value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3') : value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
}));
document.querySelectorAll('[data-mask="cep"]').forEach((el) => {
    let pending;
    el.addEventListener('input', () => {
        el.value = digits(el.value).replace(/^(\d{5})(\d)/, '$1-$2');
        const raw = digits(el.value);
        if (raw.length < 8) return;
        clearTimeout(pending);
        pending = setTimeout(async () => {
            const fillable = document.querySelectorAll('[data-cep-fill]');
            fillable.forEach((field) => { field.disabled = true; });
            try {
                const data = await (await fetch(`https://viacep.com.br/ws/${raw}/json/`)).json();
                if (!data.erro) {
                    [['logradouro', 'street'], ['bairro', 'neighborhood'], ['localidade', 'city'], ['estado', 'state']].forEach(([key, id]) => {
                        const field = document.getElementById(id);
                        if (field) field.value = data[key] ?? '';
                    });
                }
            } catch (error) {
                // Leave manual address input intact if lookup fails.
            }
            fillable.forEach((field) => { field.disabled = false; });
        }, 400);
    });
});
document.querySelectorAll('[data-mask="card"]').forEach((el) => el.addEventListener('input', () => {
    el.value = digits(el.value).slice(0, 19).replace(/(\d{4})(?=\d)/g, '$1.');
}));
document.querySelectorAll('[data-mask="expiry"]').forEach((el) => el.addEventListener('input', () => {
    el.value = digits(el.value).slice(0, 4).replace(/(\d{2})(\d)/, '$1/$2');
}));
document.querySelectorAll('[data-mask="digits"]').forEach((el) => el.addEventListener('input', () => {
    el.value = digits(el.value).slice(0, 4);
}));
document.querySelectorAll('[data-mask="cpf"]').forEach((el) => el.addEventListener('input', () => {
    const value = digits(el.value).slice(0, 14);
    el.value = value.length <= 11
        ? value.replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})\.(\d{3})(\d)/, '$1.$2.$3').replace(/(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4')
        : value.replace(/(\d{2})(\d)/, '$1.$2').replace(/(\d{2})\.(\d{3})(\d)/, '$1.$2.$3').replace(/(\d{2})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3/$4').replace(/(\d{2})\.(\d{3})\.(\d{3})\/(\d{4})(\d)/, '$1.$2.$3/$4-$5');
}));

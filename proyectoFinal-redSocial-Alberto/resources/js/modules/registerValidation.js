const EMAIL_REGEX = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const LETTERS_REGEX = new RegExp("^[\\p{L}\\s'\-]+$", 'u');
const USERNAME_REGEX = /^[a-zA-Z0-9_]+$/;
const PASSWORD_REGEX = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/;
const INVALID_CLASSES = ['border-red-500', 'focus:border-red-500', 'focus:ring-1', 'focus:ring-red-500'];

const defaultMessages = {
    required: () => 'Este campo es obligatorio.',
    email: () => 'Introduce un email valido.',
    min: (_, limit) => `Introduce al menos ${limit} caracteres.`,
    max: (_, limit) => `No puedes superar ${limit} caracteres.`,
    'letters-spaces': () => 'Solo se permiten letras, espacios, comillas simples y guiones.',
    username: () => 'Solo se permiten letras, numeros y guiones bajos.',
    'password-strong': () => 'La contrasena debe incluir mayusculas, minusculas y numeros.',
    confirmed: () => 'Los valores introducidos no coinciden.',
    in: () => 'Selecciona una opcion valida.'
};

const parseRules = (input) => {
    const rawRules = input.dataset.rules || '';
    return rawRules
        .split('|')
        .map((rule) => rule.trim())
        .filter((rule) => rule.length > 0);
};

const normalizeRuleName = (rule) => rule.split(':')[0];
const getRuleValue = (rule) => rule.split(':')[1] || '';

const toDatasetKey = (ruleName) => `${ruleName.replace(/-([a-z])/g, (_, char) => char.toUpperCase())}Message`;

const getMessage = (input, ruleName, ruleValue) => {
    const datasetKey = toDatasetKey(ruleName);
    const custom = input.dataset[datasetKey];

    if (custom && custom.trim().length) {
        return custom.trim();
    }

    const fallback = defaultMessages[ruleName];

    if (typeof fallback === 'function') {
        return fallback(input, ruleValue);
    }

    return 'Revisa este campo.';
};

const validators = {
    required: (value) => value.trim().length > 0,
    email: (value) => {
        if (!value.trim().length) {
            return true;
        }

        return EMAIL_REGEX.test(value.trim());
    },
    min: (value, rule) => {
        if (!value.trim().length) {
            return true;
        }

        const limit = Number(getRuleValue(rule));

        if (Number.isNaN(limit)) {
            return true;
        }

        return value.trim().length >= limit;
    },
    max: (value, rule) => {
        if (!value.trim().length) {
            return true;
        }

        const limit = Number(getRuleValue(rule));

        if (Number.isNaN(limit)) {
            return true;
        }

        return value.trim().length <= limit;
    },
    'letters-spaces': (value) => {
        if (!value.trim().length) {
            return true;
        }

        return LETTERS_REGEX.test(value.trim());
    },
    username: (value) => {
        if (!value.trim().length) {
            return true;
        }

        return USERNAME_REGEX.test(value.trim());
    },
    'password-strong': (value) => {
        if (!value.trim().length) {
            return true;
        }

        return PASSWORD_REGEX.test(value);
    },
    in: (value, rule) => {
        if (!value.trim().length) {
            return true;
        }

        const list = getRuleValue(rule)
            .split(',')
            .map((item) => item.trim())
            .filter((item) => item.length > 0);

        if (!list.length) {
            return true;
        }

        return list.includes(value);
    },
    confirmed: (value, rule, { form }) => {
        const targetName = getRuleValue(rule);

        if (!targetName) {
            return true;
        }

        const target = form.querySelector(`[name="${targetName}"]`);

        if (!target) {
            return true;
        }

        return value === target.value;
    }
};

const showError = (form, input, message) => {
    const errorNode = form.querySelector(`[data-error="${input.name}"]`);

    if (errorNode) {
        errorNode.textContent = message;
        errorNode.classList.remove('hidden');
    }

    INVALID_CLASSES.forEach((className) => input.classList.add(className));
    input.setAttribute('aria-invalid', 'true');
};

const hideError = (form, input) => {
    const errorNode = form.querySelector(`[data-error="${input.name}"]`);

    if (errorNode) {
        errorNode.textContent = '';
        errorNode.classList.add('hidden');
    }

    INVALID_CLASSES.forEach((className) => input.classList.remove(className));
    input.setAttribute('aria-invalid', 'false');
};

const validateField = (form, input) => {
    const rules = parseRules(input);

    if (!rules.length) {
        return true;
    }

    for (const rule of rules) {
        const ruleName = normalizeRuleName(rule);
        const validator = validators[ruleName];

        if (!validator) {
            continue;
        }

        const context = { form, input };

        if (!validator(input.value || '', rule, context)) {
            const ruleValue = getRuleValue(rule);
            showError(form, input, getMessage(input, ruleName, ruleValue));
            return false;
        }
    }

    hideError(form, input);
    return true;
};

const markTouched = (input) => {
    if (input.dataset.touched !== 'true') {
        input.dataset.touched = 'true';
    }
};

const bindRealtimeValidation = (form) => {
    const fields = Array.from(form.querySelectorAll('[data-validate-field]'));

    if (!fields.length) {
        return;
    }

    const isField = (element) => fields.includes(element);
    const getDependents = (name) => fields.filter((field) => field.dataset.confirms === name);

    const handleValueChange = (event) => {
        const target = event.target;

        if (!isField(target)) {
            return;
        }

        if (target.dataset.touched === 'true' || target.value.trim().length) {
            markTouched(target);
            validateField(form, target);

            getDependents(target.name).forEach((dependent) => {
                if (dependent.dataset.touched === 'true') {
                    validateField(form, dependent);
                }
            });
        }
    };

    form.addEventListener('input', handleValueChange);
    form.addEventListener('change', handleValueChange);

    form.addEventListener('focusout', (event) => {
        const target = event.target;

        if (!isField(target)) {
            return;
        }

        markTouched(target);
        validateField(form, target);
    });

    form.addEventListener('submit', (event) => {
        const invalidFields = fields.filter((input) => {
            markTouched(input);
            return !validateField(form, input);
        });

        if (invalidFields.length) {
            event.preventDefault();
            invalidFields[0].focus();
        }
    });
};

const initRealtimeValidation = () => {
    const forms = Array.from(document.querySelectorAll('[data-realtime-validation="true"]'));

    forms.forEach((form) => {
        if (form.dataset.realtimeValidationBound === 'true') {
            return;
        }

        form.dataset.realtimeValidationBound = 'true';
        bindRealtimeValidation(form);
    });
};

const onReady = () => initRealtimeValidation();

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', onReady, { once: true });
} else {
    onReady();
}

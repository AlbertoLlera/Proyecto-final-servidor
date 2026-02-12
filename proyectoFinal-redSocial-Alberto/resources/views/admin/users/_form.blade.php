@php($isEdit = isset($user))
@csrf

<div class="space-y-4">
    <div>
        @php($nameError = $errors->first('name'))
        <label for="name" class="block text-sm font-semibold text-gray-700">Nombre completo</label>
        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $user->name ?? '') }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2"
            required
            autocomplete="name"
            aria-describedby="admin-name-error"
            aria-invalid="{{ $nameError ? 'true' : 'false' }}"
            data-validate-field
            data-rules="required|max:60"
            data-required-message="Introduce el nombre completo."
            data-max-message="No puede superar 60 caracteres."
        >
        <p
            id="admin-name-error"
            data-error="name"
            class="text-sm text-red-600 mt-1 {{ $nameError ? '' : 'hidden' }}"
            role="alert"
            aria-live="polite"
        >{{ $nameError }}</p>
    </div>

    <div>
        @php($usernameError = $errors->first('username'))
        <label for="username" class="block text-sm font-semibold text-gray-700">Nombre de usuario</label>
        <input
            type="text"
            name="username"
            id="username"
            value="{{ old('username', $user->username ?? '') }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2"
            required
            autocomplete="username"
            aria-describedby="admin-username-error"
            aria-invalid="{{ $usernameError ? 'true' : 'false' }}"
            data-validate-field
            data-rules="required|min:3|max:20"
            data-required-message="Introduce un nombre de usuario."
            data-min-message="Debe tener al menos 3 caracteres."
            data-max-message="No puede superar 20 caracteres."
        >
        <p
            id="admin-username-error"
            data-error="username"
            class="text-sm text-red-600 mt-1 {{ $usernameError ? '' : 'hidden' }}"
            role="alert"
            aria-live="polite"
        >{{ $usernameError }}</p>
    </div>

    <div>
        @php($emailError = $errors->first('email'))
        <label for="email" class="block text-sm font-semibold text-gray-700">Correo</label>
        <input
            type="email"
            name="email"
            id="email"
            value="{{ old('email', $user->email ?? '') }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2"
            required
            autocomplete="email"
            aria-describedby="admin-email-error"
            aria-invalid="{{ $emailError ? 'true' : 'false' }}"
            data-validate-field
            data-rules="required|email|max:80"
            data-required-message="Introduce un correo electrónico."
            data-email-message="Introduce un email válido."
            data-max-message="No puede superar 80 caracteres."
        >
        <p
            id="admin-email-error"
            data-error="email"
            class="text-sm text-red-600 mt-1 {{ $emailError ? '' : 'hidden' }}"
            role="alert"
            aria-live="polite"
        >{{ $emailError }}</p>
    </div>

    <div>
        @php($roleError = $errors->first('role'))
        <label for="role" class="block text-sm font-semibold text-gray-700">Rol</label>
        @php($roleValue = old('role', $user->role ?? 'user'))
        <select
            name="role"
            id="role"
            class="w-full border border-gray-300 rounded-lg px-3 py-2"
            aria-describedby="admin-role-error"
            aria-invalid="{{ $roleError ? 'true' : 'false' }}"
            data-validate-field
            data-rules="required|in:user,admin"
            data-required-message="Selecciona el rol del usuario."
            data-in-message="Selecciona un rol válido."
        >
            <option value="user" @selected($roleValue === 'user')>Usuario</option>
            <option value="admin" @selected($roleValue === 'admin')>Administrador</option>
        </select>
        <p
            id="admin-role-error"
            data-error="role"
            class="text-sm text-red-600 mt-1 {{ $roleError ? '' : 'hidden' }}"
            role="alert"
            aria-live="polite"
        >{{ $roleError }}</p>
    </div>

    <div>
        @php($passwordError = $errors->first('password'))
        <label for="password" class="block text-sm font-semibold text-gray-700">Contraseña @if($isEdit)<span class="font-normal text-gray-500">(dejar en blanco para mantener)</span>@endif</label>
        <input
            type="password"
            name="password"
            id="password"
            class="w-full border border-gray-300 rounded-lg px-3 py-2"
            @unless($isEdit) required @endunless
            autocomplete="new-password"
            aria-describedby="admin-password-error"
            aria-invalid="{{ $passwordError ? 'true' : 'false' }}"
            data-validate-field
            data-rules="{{ $isEdit ? 'min:6|confirmed:password' : 'required|min:6|confirmed:password' }}"
            data-required-message="Introduce una contraseña temporal."
            data-min-message="Debe tener al menos 6 caracteres."
            data-confirmed-message="Debe coincidir con la confirmación."
        >
        <p
            id="admin-password-error"
            data-error="password"
            class="text-sm text-red-600 mt-1 {{ $passwordError ? '' : 'hidden' }}"
            role="alert"
            aria-live="polite"
        >{{ $passwordError }}</p>
    </div>

    <div>
        @php($passwordConfirmationError = $errors->first('password_confirmation'))
        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirmar contraseña</label>
        <input
            type="password"
            name="password_confirmation"
            id="password_confirmation"
            class="w-full border border-gray-300 rounded-lg px-3 py-2"
            @unless($isEdit) required @endunless
            autocomplete="new-password"
            aria-describedby="admin-password-confirmation-error"
            aria-invalid="{{ $passwordConfirmationError ? 'true' : 'false' }}"
            data-validate-field
            data-rules="{{ $isEdit ? 'confirmed:password' : 'required|confirmed:password' }}"
            data-required-message="Confirma la contraseña."
            data-confirmed-message="Las contraseñas deben coincidir."
            data-confirms="password"
        >
        <p
            id="admin-password-confirmation-error"
            data-error="password_confirmation"
            class="text-sm text-red-600 mt-1 {{ $passwordConfirmationError ? '' : 'hidden' }}"
            role="alert"
            aria-live="polite"
        >{{ $passwordConfirmationError }}</p>
    </div>
</div>

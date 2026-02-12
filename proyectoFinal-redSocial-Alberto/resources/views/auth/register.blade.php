@extends('layouts.app')

@section('titulo')
    Registrate en DevStagram
@endsection

@section('contenido')

    <div class="md:flex md:justify-center md:gap-10 md:items-center">
        <div class="md:w-6/12 p-5">
            <img src="{{asset('img/registrar.jpg')}}" alt="imagen registro usuarios"> 
        </div>

        <div class="md:w-4/12 lg:w-4/12 md:justify-center bg-white p-6 rounded-lg shadow-xl">
            <form action="{{route('register')}}" method="POST" novalidate data-form="register" data-realtime-validation="true">
                @csrf
                <div class="mb-5">
                    @php($nameError = $errors->first('name'))
                    <label for="name" class="mb block uppercase text-gray-500 font-bold">Nombre</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        placeholder="Tu nombre"
                        class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"
                        value="{{old('name')}}"
                        autocomplete="name"
                        aria-describedby="name-error-message"
                        aria-invalid="{{ $nameError ? 'true' : 'false' }}"
                        data-validate-field
                        data-rules="required|max:30|letters-spaces"
                        data-required-message="Introduce tu nombre completo."
                        data-max-message="El nombre no puede superar 30 caracteres."
                        data-letters-spaces-message="Solo se permiten letras, espacios, comillas simples y guiones."
                    />
                    <p
                        id="name-error-message"
                        data-error="name"
                        class="mt-2 text-sm text-red-600 {{ $nameError ? '' : 'hidden' }}"
                        role="alert"
                        aria-live="polite"
                    >{{$nameError}}</p>
                </div>

                <div class="mb-5">
                    @php($usernameError = $errors->first('username'))
                    <label for="username" class="mb block uppercase text-gray-500 font-bold">Nombre de usuario</label>
                    <input
                        id="username"
                        name="username"
                        type="text"
                        placeholder="Nombre de usuario"
                        class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror"
                        value="{{old('username')}}"
                        autocomplete="username"
                        aria-describedby="username-error-message"
                        aria-invalid="{{ $usernameError ? 'true' : 'false' }}"
                        data-validate-field
                        data-rules="required|min:3|max:20|username"
                        data-required-message="Elige un nombre de usuario."
                        data-min-message="Debe tener al menos 3 caracteres."
                        data-max-message="No puede superar 20 caracteres."
                        data-username-message="Solo letras, números y guiones bajos."
                    />
                    <p
                        id="username-error-message"
                        data-error="username"
                        class="mt-2 text-sm text-red-600 {{ $usernameError ? '' : 'hidden' }}"
                        role="alert"
                        aria-live="polite"
                    >{{$usernameError}}</p>
                </div>

                <div class="mb-5">
                    @php($emailError = $errors->first('email'))
                    <label for="email" class="mb block uppercase text-gray-500 font-bold">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        placeholder="Email de registro"
                        class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"
                        value="{{old('email')}}"
                        autocomplete="email"
                        aria-describedby="email-error-message"
                        aria-invalid="{{ $emailError ? 'true' : 'false' }}"
                        data-validate-field
                        data-rules="required|email|max:60"
                        data-required-message="Introduce tu correo electrónico."
                        data-email-message="Introduce un email válido."
                        data-max-message="No puede superar 60 caracteres."
                    />
                    <p
                        id="email-error-message"
                        data-error="email"
                        class="mt-2 text-sm text-red-600 {{ $emailError ? '' : 'hidden' }}"
                        role="alert"
                        aria-live="polite"
                    >{{$emailError}}</p>
                </div>

                <div class="mb-5">
                    @php($passwordError = $errors->first('password'))
                    <label for="password" class="mb block uppercase text-gray-500 font-bold">Contraseña</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Contraseña"
                        class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror"
                        autocomplete="new-password"
                        aria-describedby="password-error-message"
                        aria-invalid="{{ $passwordError ? 'true' : 'false' }}"
                        data-validate-field
                        data-rules="required|min:6|password-strong"
                        data-required-message="Introduce una contraseña segura."
                        data-min-message="Debe tener al menos 6 caracteres."
                        data-password-strong-message="Incluye al menos una mayúscula, una minúscula y un número."
                    />
                    <p
                        id="password-error-message"
                        data-error="password"
                        class="mt-2 text-sm text-red-600 {{ $passwordError ? '' : 'hidden' }}"
                        role="alert"
                        aria-live="polite"
                    >{{$passwordError}}</p>
                </div>

                <div class="mb-5">
                    @php($passwordConfirmationError = $errors->first('password_confirmation'))
                    <label for="password_confirmation" class="mb block uppercase text-gray-500 font-bold">Repetir Contraseña</label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        placeholder="Repite tu contraseña"
                        class="border p-3 w-full rounded-lg"
                        autocomplete="new-password"
                        aria-describedby="password-confirmation-error-message"
                        aria-invalid="{{ $passwordConfirmationError ? 'true' : 'false' }}"
                        data-validate-field
                        data-rules="required|confirmed:password"
                        data-required-message="Confirma tu contraseña."
                        data-confirmed-message="Las contraseñas deben coincidir."
                        data-confirms="password"
                    />
                    <p
                        id="password-confirmation-error-message"
                        data-error="password_confirmation"
                        class="mt-2 text-sm text-red-600 {{ $passwordConfirmationError ? '' : 'hidden' }}"
                        role="alert"
                        aria-live="polite"
                    >{{$passwordConfirmationError}}</p>
                </div>

                <input type="submit" 
                    value="Crear cuenta" 
                    class="bg-sky-600 hover:bg-sky-700 transition-color cursor-pointer 
                    uppercase font-bold w-full p-3 text-white rounded-lg"
                >
            </form>
        </div>
    </div>
    
@endsection